<?php

namespace backend\models\system;

use Yii;

/**
 * This is the model class for table "{{%recharge}}".
 *
 * @property integer $recharge_id
 * @property string $recharge_price
 * @property string $recharge_add
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
 */
class Recharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recharge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recharge_price', 'recharge_add'], 'number'],
            [['created_at', 'updated_at', 'updated_id'], 'integer'],
            [['recharge_price', 'recharge_add'], 'required'],
            ['recharge_price', 'unique', 'message' => '该充值金额已经存在,您可以修改'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recharge_id' => '充值满赠自增ID',
            'recharge_price' => '充值金额',
            'recharge_add' => '充值赠送金额',
            'created_at' => '充值满赠创建时间',
            'updated_at' => '充值满赠修改时间',
            'updated_id' => '上次修改人',
        ];
    }
    
    /*
     * 充值满赠查询
     * */
    public function findAllRecharge(){
        return $this->find()
        ->select(['recharge_id','recharge_price','recharge_add','zss_recharge.created_at','zss_recharge.updated_at','username'])
        ->innerJoin("`zss_admin` on `zss_recharge`.`updated_id` = `zss_admin`.`id`")
        ->asArray()
        ->all();
    }
    
    /*
     * 充值满赠删除
     * */
    public function RechargeDelById($rid){
        $recharge_find_one = $this->find()->where("recharge_id = $rid")->one();
        
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
        ->select(array('recharge_id','recharge_price','recharge_add','zss_recharge.created_at','zss_recharge.updated_at','username'))
        ->innerJoin("`zss_admin` on `zss_recharge`.`updated_id` = `zss_admin`.`id`")
        ->where( array('like', 'recharge_price', "$search"))
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
            $recharge_price = $rechargeadd['Recharge']['recharge_price'];
            $recharge_add = $rechargeadd['Recharge']['recharge_add'];
            
            if($recharge_add >= $recharge_price){
                return -1;//赠送金额不能超出充值金额
            }
            $time = time();
            $this->recharge_price = $recharge_price;
            $this->recharge_add = $recharge_add;
            $this->created_at = $time;
            $this->updated_at = $time;
            $this->updated_id = $updated_id;
            return $this->save()?1:0;
    }
    
    /*
     * 充值修改
     * */
    public function SelectRechargeById($rid){
        return $this->find()->select(['recharge_id','recharge_price','recharge_add'])->where("recharge_id = $rid")->one();
    }
    
    /*
     * 充值修改
     * */
    public function RechargeUp($rechargeupdate){
        
        $recharge_price = $rechargeupdate['Recharge']['recharge_price'];
        $recharge_add = $rechargeupdate['Recharge']['recharge_add'];
        if($recharge_add >= $recharge_price){
            return -1;
        }
        
        
        if($this->validate()){
            $is_update = 1;
        }else{
            $error = $this->getErrors();
           
           if(isset($error['recharge_price'])){
               foreach($error['recharge_price'] as $rk=>$rv){
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
            $recharge_id = $rechargeupdate['recharge_id'];
            $time = time();
            $updated_id = Yii::$app->user->identity->id;
            
            $up_data = Recharge::find()->where("recharge_id = $recharge_id")->one();
            
            $up_data->recharge_price = $rechargeupdate['Recharge']['recharge_price'];
            $up_data->recharge_add = $rechargeupdate['Recharge']['recharge_add'];
            $up_data->created_at = $time;
            $up_data->updated_at = $time;
            $up_data->updated_id = $updated_id;

            return $up_data->save()?1:0;
        }
    }
}
