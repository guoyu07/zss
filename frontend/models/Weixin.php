<?php

namespace frontend\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%weixin}}".
 *
 * @property integer $wx_id
 * @property integer $user_id
 * @property string $wx_name
 */
class Weixin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weixin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['wx_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wx_id' => 'Wx ID',
            'user_id' => 'User ID',
            'wx_name' => 'Wx Name',
        ];
    }
    
    /*
     * 判断是否是微信用户
     * */
    public function Isuser($openid){
        if($openid){
            $vip_status = Weixin::find()
            ->select(['vip_name','zss_weixin.user_id'])
            ->innerJoin("`zss_user` on `zss_weixin`.`user_id` = `zss_user`.`user_id`")
            ->innerJoin("`zss_vip` on `zss_user`.`vip_id` = `zss_vip`.`vip_id`")
            ->where("wx_name = '".$openid."'")->asArray()->one();
            
            if($vip_status['user_id']){
                setcookie("user_id",$vip_status['user_id'],time()+360000000,"/","$www",0);
                //$www = $_SERVER['HTTP_HOST'];
                //$session = Yii::$app->session;
                //$session->set('user_id',$vip_status['user_id'],3600,"/");
            }
            
            $vip_level = $vip_status['vip_name'];
            return $vip_level?(($vip_level == '小白')?"小白用户可申请开通VIP":"[VIP]尊敬的".$vip_level."用户您好,您在本店享有专属优惠."):"注册即可享受VIP特惠";//如果存在则返回VIP级别,否则返回0(是未注册用户)
        }else{
            return "请您重新关注本服务号,由此带来的不便敬请详解";//openid不存在   
        }
    }
}
