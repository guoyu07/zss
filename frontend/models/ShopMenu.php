<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%shop_menu}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $shop_id
 * @property integer $menu_stock
 * @property integer $is_show
 * @property integer $discount_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $menu_desc
 * @property integer $updated_id
 */
class ShopMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'shop_id', 'menu_stock', 'is_show', 'discount_id', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['menu_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'shop_id' => 'Shop ID',
            'menu_stock' => 'Menu Stock',
            'is_show' => 'Is Show',
            'discount_id' => 'Discount ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'menu_desc' => 'Menu Desc',
            'updated_id' => 'Updated ID',
        ];
    }
    
    /*
     * 门店菜品
     * */
    public function GetShopMenu($shop_id){
        $shop_data = $this->find()
            ->select(['zss_menu.menu_id','menu_name','menu_stock','menu_price','image_wx','menu_introduce','img1','img2'])
            ->innerJoin("`zss_menu` on `zss_shop_menu`.`menu_id` = `zss_menu`.`menu_id`")
            ->innerJoin("`zss_image` on `zss_menu`.`menu_id` = `zss_image`.`model_id`")
            ->innerJoin("`zss_series` on `zss_menu`.`series_id` = `zss_series`.`series_id`")
            ->where("shop_id = $shop_id && `zss_shop_menu`.`is_show` = 1")
            ->asArray()->all();
        if($shop_data){
            foreach ($shop_data as $sk=>$sv){
                $serimg[$sk]['series_img1'] = $sv['img1'];
                $serimg[$sk]['series_img2'] = $sv['img2'];
                
                $shop_data[$sk]['series_name'] = '新品';
            }
            $shop[0] = $shop_data;
            $shop[1] = $serimg;
            return $shop;
        }
        return 0;
        
    }
    
    /*
     * 查看门店下是否存在菜品
     * */
    public function GetShopCount($best_shop){
        return $this->find()
        ->select(['zss_menu.menu_id'])
        ->innerJoin("`zss_menu` on `zss_shop_menu`.`menu_id` = `zss_menu`.`menu_id`")
        ->innerJoin("`zss_image` on `zss_menu`.`menu_id` = `zss_image`.`model_id`")
        ->innerJoin("`zss_series` on `zss_menu`.`series_id` = `zss_series`.`series_id`")
        ->where("shop_id = $best_shop && `zss_shop_menu`.`is_show` = 1")
        ->count();
    }
    
    /*
     * 门店分类菜品
     * */
    public function GetMenuAll($shop_id,$cart_data = 0){
        $menu = $this->find()
        ->select(['zss_menu.menu_id','menu_name','menu_stock','menu_price','image_wx','menu_introduce','zss_menu.series_id','series_name'])
        ->innerJoin("`zss_menu` on `zss_shop_menu`.`menu_id` = `zss_menu`.`menu_id`")
        ->innerJoin("`zss_image` on `zss_menu`.`menu_id` = `zss_image`.`model_id`")
        ->innerJoin("`zss_series` on `zss_menu`.`series_id` = `zss_series`.`series_id`")
        ->where("zss_series.series_status = 1 && shop_id = $shop_id && `zss_shop_menu`.`is_show` = 1")
        ->orderBy('menu_sort')
        ->asArray()
        ->all();

        $series = Series::find()->select(['zss_series.series_id','series_name','img1','img2','img3','series_name2','series_desc'])
        ->innerJoin("`zss_menu` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
        ->innerJoin("`zss_shop_menu` on `zss_shop_menu`.`menu_id` = `zss_menu`.`menu_id`")
        ->orderBy('series_sort desc')
        ->where(['shop_id'=>$shop_id,'is_show'=>1])
        ->asArray()
        ->all();
        
        foreach($series as $sk=>$sv){
            foreach($menu as $mk=>$mv){
                if(!empty($cart_data)){
                    foreach ($cart_data as $ck=>$cv){
                        if($mv['menu_id'] == $cv['menu_id']){
                            $mv['menu_num'] = $cv['menu_num'];
                        }
                    }
                }
               
                
                if($mv['series_id'] == $sv['series_id']){
                    $menudata[$sk]['series_id'] = $sv['series_id'];
                    $menudata[$sk]['series_name'] = $sv['series_name'];
                    $menudata[$sk]['series_img1'] = $sv['img1'];
                    $menudata[$sk]['series_img2'] = $sv['img2'];
                    $menudata[$sk]['series_img3'] = $sv['img3'];
                    $menudata[$sk]['series_name2'] = $sv['series_name2'];
                    $menudata[$sk]['series_desc'] = $sv['series_desc'];
                    $menudata[$sk]['series_data'][] = $mv;
                }
            }
        }
        return $menudata;
    }
    
    function check_remote_file_exists($url) {
        $curl = curl_init($url);
        // 不取回数据
        curl_setopt($curl, CURLOPT_NOBODY, true);
        // 发送请求
        $result = curl_exec($curl);
        $found = false;
        // 如果请求没有发送失败
        if ($result !== false) {
            // 再检查http响应码是否为200
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $found = true;
            }
        }
        curl_close($curl);
    
        return $found;
    }
}
