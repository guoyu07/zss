<?php

namespace backend\models\user;

use Yii;
use backend\models\user\User;

/**
 * This is the model class for table "{{%vip}}".
 *
 * @property integer $vip_id
 * @property string $vip_name
 * @property integer $vip_discount
 * @property string $vip_subtract
 * @property integer $gift_id
 * @property integer $vip_status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $vip_price
 */
class Vip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vip}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_discount', 'gift_id', 'vip_status', 'created_at', 'updated_at', 'vip_experience'], 'integer'],
            [['vip_subtract', 'vip_price'], 'number'],
            [['vip_name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vip_id' => '自增ID  ',
            'vip_name' => 'vip名称',
            'vip_discount' => '折扣百分比',
            'vip_subtract' => '减多少',
            'gift_id' => '赠品的id',
            'vip_status' => '是否使用 0禁用    1使用',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'vip_price' => '满多少',
        ];
    }

    /**
     * 与赠品表关联
     * @params $cid 会员id
     * @return type array
     */
    public function getgift($cid){
         $gifts = $this->find()
                            ->select('*')
                            ->leftJoin('`zss_gift` on `zss_vip`.`gift_id` = `zss_gift`.`gift_id`')
                            ->addSelect(['zss_vip.created_at as ccreated'])
                            ->addSelect(['zss_vip.updated_at as cupdated'])
                            ->where(['vip_id' => $cid])
                            ->asArray()
                            ->one();
	return $gifts;
    }

    /**
     * 根据vip_id搜索修改人
     * @params $cid 会员等级id
     * @return type array
     */
    public function getupdated($cid)
    {
        $username = $this->find()
                            ->select('zss_admin.username')
                            ->innerJoin("`zss_admin` on `zss_vip`.`updated_id` = `zss_admin`.`id`")
                            ->where(['zss_vip.vip_id' => $cid])
                            ->asArray()->one();
        return $username;
    }

    /**
     * 查询vip表相关信息
     * @return type array
     */
    public function getdetail()
    {
        return $this->find()
                        ->select('zss_admin.username,zss_vip.updated_at,zss_vip.vip_status,zss_vip.created_at,zss_vip.vip_id,zss_vip.vip_name,zss_vip.vip_discount,zss_vip.vip_subtract,zss_vip.vip_price,zss_vip.vip_experience')
                        ->leftJoin("`zss_admin` on `zss_vip`.`updated_id` = `zss_admin`.`id`")
                        ->asArray()->all();
    }

    /**
     * 根据vip_id搜索修改人
     * @params $cid 会员等级id
     * @return type array
     */
    public function get_vip_level()
    {
        $vip = $this->find()
                    ->select('vip_name,vip_experience')
                    ->asArray()
                    ->all();
        return $vip;
    }

    /**
     * 获取各vip等级优惠
     */
    public function get_discount()
    {
        $discount = $this->find()
                    ->select(['vip_name','vip_discount','vip_price','vip_subtract','gift_name'])
                    ->leftJoin('`zss_gift` on `zss_vip`.`gift_id` = `zss_gift`.`gift_id`')
                    ->asArray()
                    ->all();
        return $discount;
    }

    /**
     * 提升用户会员等级
     * @param
     * @return
     */
    public function vip_level_up($id,$user_experience)
    {
        $vip = $this->find()->select(['vip_id','vip_name','vip_experience'])->where(['>','vip_experience',$user_experience])->orderBy(['vip_experience'=>SORT_ASC])->asArray()->one();
        if(empty($vip)){
          $vip = $this->find()->select(['vip_id','vip_name','vip_experience'])->orderBy(['vip_experience'=>SORT_DESC])->asArray()->one();
        }
        $user = new User();
        $re = $user->upd_vip_level($id,$vip['vip_id']);
        if($re) return $vip;
        else return false;
    }

    /**
     * 获取最低vip等级信息
     */
    public function vip_low()
    {
        $vipinfo = $this->find()->select(['vip_id','vip_name','vip_experience'])->orderBy(['vip_experience'=>SORT_ASC])->asArray()->one();
        return $vipinfo;
    }

}
