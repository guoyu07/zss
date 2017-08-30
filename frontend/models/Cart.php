<?php

namespace frontend\models;

use Yii;
use yii\helpers;
use yii\helpers\VarDumper;
use app\models\Series;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property integer $cart_id
 * @property integer $menu_id
 * @property integer $menu_num
 * @property integer $user_id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'menu_num', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cart_id' => 'Cart ID',
            'menu_id' => 'Menu ID',
            'menu_num' => 'Menu Num',
            'user_id' => 'User ID',
        ];
    }
    
    /*
     * 购物车批量入库
     * */
    public function insertAll($getcart){
        
        $uid = isset($_COOKIE['user_id'])?$_COOKIE['user_id']:0;
        $sid = isset($_COOKIE['shop_idinfo'])?$_COOKIE['shop_idinfo']:0;

        if($uid && $sid){
            self::deleteAll('user_id = :user_id and shop_id = :shop_id',[':user_id'=>$uid,':shop_id'=>$sid]);
            return Yii::$app->db->createCommand()->batchInsert(Cart::tableName(), ['menu_id','menu_num','series_id','user_id','shop_id'], $getcart)->execute();
        }else{
            die('缺少必要参数');
        }
    }
    
    /*
     * 用户购物车查询
     * */
    public function findByUser($uid,$best_shop){
        $cart_all = $this->find()
        ->select(['menu_name','menu_price','menu_num','zss_cart.series_id','zss_menu.menu_id'])
        ->innerJoin("`zss_menu` on `zss_cart`.`menu_id` = `zss_menu`.`menu_id`")
        ->where(['zss_cart.user_id'=>$uid,'shop_id'=>$best_shop])
        ->asArray()
        ->all();
        
        $series_all = Series::find()->select('series_id')->asArray()->all();
        $series_all[]['series_id'] = 0;
        $series_all[]['series_id'] = -1;

        foreach($series_all as $sk=>$sv){
            foreach ($cart_all as $ck=>$cv){
                if($sv['series_id'] == $cv['series_id']){
                    $cart_data[$sv['series_id']][] = $cv; 
                }
            }
        }
        
        return (isset($cart_data) && is_array($cart_data))?$cart_data:0;
    }
    
    /*
     * 商店商品和购物车商品融合
     * */
    public function ShopCart($shop,$cart){
        $num = 0;
        foreach($shop as $sk=>$sv){
            foreach($cart as $ck=>$cv){
                $url = 'http://www.profect.site:82/add/menu/'.$sv['image_wx'];
                if(!file_exists($url)){
                    $shop[$sk]['image_wx'] = 'default.jpg';
                }
                if($sv['menu_id'] == $cv['menu_id']){
                    $shop[$sk]['menu_num'] = $cv['menu_num'];
                }
            }
        }
        return $shop;
    }
    
    /*
     * 删除购物车
     * */
    public function clearByUid($uid){
       return self::deleteAll('user_id = :user_id',[':user_id'=>$uid]);
    }
}
