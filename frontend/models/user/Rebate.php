<?php

namespace frontend\models\user;

use Yii;

/**
 * This is the model class for table "{{%rebate}}".
 *
 * @property integer $rebate_id
 * @property integer $rebate_price
 * @property integer $rebate_send
 * @property integer $created_at
 */
class Rebate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rebate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       /* return [
            [['rebate_price', 'rebate_send', 'created_at'], 'integer']
        ];*/
         return [
            [['rebate_price', 'rebate_send'], 'number'],
            [['created_at', 'updated_at', 'updated_id'], 'integer'],
            [['rebate_price', 'rebate_send'], 'required'],
            ['rebate_price', 'unique', 'message' => '该充值金额已经存在,您可以修改'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rebate_id' => 'Rebate ID',
            'rebate_price' => 'Rebate Price',
            'rebate_send' => 'Rebate Send',
            'created_at' => 'Created At',
        ];
    }
    
    /**
     * 根据充值类型金钱查取,充多少,返多少这两个字段的值
     * $params $lastsend 钱
     */
    public function selectaction($lastsend){
        return $this->find()->select('rebate_price,rebate_send')->where(['rebate_price' => $lastsend])->asArray()->one();
    }
    
    /*
     * 充值满赠查询
     * */
    public function findAllRecharge(){
        return $this->find()
        ->select(['rebate_id','rebate_price','rebate_send','zss_rebate.created_at','zss_rebate.updated_at','username'])
        ->innerJoin("`zss_admin` on `zss_rebate`.`updated_id` = `zss_admin`.`id`")
        ->asArray()
        ->all();
    }
    
    /*
     * 充值满赠删除
     * */
    public function RechargeDelById($rid){
        $recharge_find_one = $this->find()->where("rebate_id = $rid")->one();
        
        if(!$recharge_find_one){
            return -1;
        }
        return $recharge_find_one->delete()?1:0;
    }
    
     /*
     * 充值搜索
     * */
    public function searchByName($search){
        $result_search=$this->find()
        ->select(array('rebate_id','rebate_price','rebate_send','zss_rebate.created_at','zss_rebate.updated_at','username'))
        ->innerJoin("`zss_admin` on `zss_rebate`.`updated_id` = `zss_admin`.`id`")
        ->where( array('like', 'rebate_price', "$search"))
        ->asArray()
        ->all();
        
        if($result_search){
            foreach ($result_search as $k=>$v){
                $result_search[$k]['created_at'] = date('Y-m-d H:i:s',$v['created_at']);
                $result_search[$k]['updated_at'] = date('Y-m-d H:i:s',$v['updated_at']);
            }
            return $result_search;
        }else{
            return 0;
        }
    }
    
     /*
     * 充值添加
     * */
    public function RechargeAdd($rechargeadd){
            $updated_id = Yii::$app->user->identity->id;
            $recharge_price = $rechargeadd['Rebate']['rebate_price'];
            $recharge_add = $rechargeadd['Rebate']['rebate_send'];
            
            if($recharge_add >= $recharge_price){
                return -1;//赠送金额不能超出充值金额
            }
            $time = time();
            $this->rebate_price = $recharge_price;
            $this->rebate_send = $recharge_add;
            $this->created_at = $time;
            $this->updated_at = $time;
            $this->updated_id = $updated_id;
            return $this->save()?1:0;
    }
    
     /*
     * 充值修改
     * */
    public function SelectRechargeById($rid){
        return $this->find()->select(['rebate_id','rebate_price','rebate_send'])->where("rebate_id = $rid")->one();
    }
    
    /*
     * 充值修改
     * */
    public function RechargeUp($rechargeupdate){
        
        $recharge_price = $rechargeupdate['Rebate']['rebate_price'];
        $recharge_add = $rechargeupdate['Rebate']['rebate_send'];
        if($recharge_add >= $recharge_price){
            return -1;
        }
        
        
        if($this->validate()){
            $is_update = 1;
        }else{
            $error = $this->getErrors();
           
           if(isset($error['rebate_price'])){
               foreach($error['rebate_price'] as $rk=>$rv){
                   if($rv == '该充值金额已经存在,您可以修改'){
                       $unique_status = 1;
                   }else{
                       $unique_status = 0;
                   }
               }
           }
           
           $is_update = $unique_status?1:0;
        }
        
        if($is_update == 1){
            $recharge_id = $rechargeupdate['rebate_id'];
            $time = time();
            $updated_id = Yii::$app->user->identity->id;
            
            $up_data = Rebate::find()->where("rebate_id = $recharge_id")->one();
            
            $up_data->rebate_price = $rechargeupdate['Rebate']['rebate_price'];
            $up_data->rebate_send = $rechargeupdate['Rebate']['rebate_send'];
            $up_data->created_at = $time;
            $up_data->updated_at = $time;
            $up_data->updated_id = $updated_id;

            return $up_data->save()?1:0;
        }
    }
    
}
