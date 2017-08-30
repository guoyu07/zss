<?php

namespace backend\models\user;

use Yii;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property integer $company_discount
 * @property string $company_price
 * @property string $company_subtract
 * @property integer $gift_id
 * @property integer $company_status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_discount', 'gift_id', 'company_status', 'created_at', 'updated_at'], 'integer'],
            [['company_price', 'company_subtract'], 'number'],
            [['company_name'], 'string', 'max' => 30],
            [['company_name','company_discount','company_price','company_subtract'],'required','message' => '不能为空'],
            ['company_name','string','length' => [1, 30],'message'=>'长度至少在1到30个字符之间'], 
            //['company_name','unique','targetClass' => 'backend\models\user\Company','message'=>'字段唯一性'], 
            ['company_discount','string','length' => [1, 2],'message'=>'数字在1-100之间'],
            ['company_price','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'长度过长,请输入1到8金钱'],
            ['company_subtract','match','pattern'=>'/^((\d{1,8})|(\d{1,8}\.\d{0,2}))$/','message'=>'长度过长,请输入1到8金钱'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'company_name' => '公司名称',
            'company_discount' => '折扣百分比',
            'company_price' => '满多少',
            'company_subtract' => '减多少',
            'gift_id' => '赠品的id',
            'company_status' => '是否使用 0禁用    1使用',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
    
     /**
     * 与赠品表关联
     * @params $cid 公司id
     * @return type array
     */
    public function getgift($cid){
        $gifts = $this->find()
        ->select('*')
        ->leftJoin('`zss_gift` on `zss_company`.`gift_id` = `zss_gift`.`gift_id`')
        ->addSelect(['zss_company.created_at as ccreated'])
        ->addSelect(['zss_company.updated_at as cupdated'])
        ->where(['company_id' => $cid])    
        ->asArray()
        ->one();
	return $gifts;
    }
    
    /**
     * 查询公司表相关信息
     * @return type array
     */
    public function getdetail()
    {
        return $this->find()
                        ->select('zss_admin.username,zss_company.company_status,zss_company.updated_at,zss_company.created_at,zss_company.company_id,zss_company.company_name,zss_company.company_discount,zss_company.company_subtract,zss_company.company_price')
                        ->leftJoin("`zss_admin` on `zss_company`.`updated_id` = `zss_admin`.`id`")
                        ->asArray()->all();
    }
    
    /**
     * 判断修改时名字是否可靠
     * @params $newname 现在输入的名字
     * @params $oldname 原来的名字
     */
    public function checkname($newname,$oldname)
    {
        //$err = $this->vip_name; 
        $only = Company::find()->where(['company_name' => $newname])->asArray()->one();
        if($only){
            $all = Company::find()->asArray()->all();
            foreach($all as $kk => $vv){
                if($vv['company_name'] == $oldname){
                    unset($all[$kk]);
                }else{
                    $arr[]=$vv['company_name'];
                }            
            }
            if(in_array($newname, $arr)){
                 $this->addError('company_name', '不可重复'); 
                 return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
        
    }
    
    /**
     * 修改状态
     * @params $cid 公司id
     * @params $status 公司即将修改的id
     */
    public function updstatus($cid,$status){
        $connection = \Yii::$app->db;
        $command = $connection->createCommand("UPDATE zss_company SET company_status=$status WHERE company_id=$cid");
        return  $command->execute();
        /*$this->find()->where(['company_id' => $cid])->one();
        $this->company_status = $status;
        $this->updated_at = time();*/
        
    }
}
