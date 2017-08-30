<?php

namespace backend\models\series;

use Yii;
use backend\models\series\ShopMenu;


/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $menu_id
 * @property string $menu_name
 * @property integer $menu_code
 * @property integer $series_id
 * @property string $menu_price
 * @property string $menu_introduce
 * @property integer $menu_status
 * @property integer $shop_show
 * @property integer $menu_sort
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $image_url
 * @property string $image_wx
 * @property string $image_pc
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series_id', 'menu_status', 'shop_show', 'menu_sort', 'created_at', 'updated_at',"updated_id"], 'integer'],
            [['menu_price'], 'number'],
            [['menu_name'], 'string', 'max' => 150],
            [['menu_code'], 'string'],
            [['menu_introduce'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'menu_name' => 'Menu Name',
            'menu_code' => 'Menu Code',
            'series_id' => 'Series ID',
            'menu_price' => 'Menu Price',
            'menu_introduce' => 'Menu Introduce',
            'menu_status' => 'Menu Status',
            'shop_show' => 'Shop Show',
            'menu_sort' => 'Menu Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_id' => 'Updated Id',
            
        ];
    }
    //数据读取  3表联查
    public function showall()
    {   
       //return  $re=Yii::$app->db->createCommand("select menu_code,menu_name,menu_id,image_wx,username,series_name,menu_price,menu_introduce,menu_status,shop_show,menu_sort,zss_menu.created_at,zss_menu.updated_at from (zss_menu inner join zss_image on zss_menu.menu_id=zss_image.model_id) inner join zss_series on zss_menu.series_id=zss_series.series_id inner join zss_admin on zss_menu.updated_id = zss_admin.id")->queryAll();
            
            $menu = new Menu();
         return   $newallinfo= $menu->find()
                ->select(["menu_code","menu_name","menu_id","image_wx","username","series_name","menu_price","menu_introduce","menu_status","shop_show","menu_sort","zss_menu.created_at","zss_menu.updated_at"])
                ->leftJoin("`zss_image` on `zss_image`.`model_id` = `zss_menu`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                 ->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_menu`.`updated_id`")
                ->asArray()
                ->all();
    }

     //delete
    public function delone($id)
    {  
            $allid = explode(",",$id);

            
            ShopMenu::deleteAll(["menu_id"=>$allid]);


           return  Menu::deleteAll(["menu_id"=>$allid]);




    }

    //查找添加类别是否存在
    public function oneinfo($id)
    {  
     return  $arr = Menu::find()->where(["menu_id"=>$id])->asArray()->one();

    }
    //修改
    public function fixinfo($menuid,$variable){
        
      return Menu::updateAll($variable,array("menu_id"=>$menuid));
                     
     }
    //菜品搜索
      public function search($key){

      // return  $re=Yii::$app->db->createCommand("select menu_code,menu_name,menu_id,image_wx,username,series_name,menu_price,menu_introduce,menu_status,shop_show,menu_sort,zss_menu.created_at,zss_menu.updated_at from (zss_menu inner join zss_image on zss_menu.menu_id=zss_image.model_id) inner join zss_series on zss_menu.series_id=zss_series.series_id inner join zss_admin on zss_menu.updated_id = zss_admin.id where menu_name like '%$key%'")->queryAll();

          $menu = new Menu();
         return   $newallinfo= $menu->find()
                ->select(["menu_code","menu_name","menu_id","image_wx","username","series_name","menu_price","menu_introduce","menu_status","shop_show","menu_sort","zss_menu.created_at","zss_menu.updated_at"])
                ->leftJoin("`zss_image` on `zss_image`.`model_id` = `zss_menu`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                 ->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_menu`.`updated_id`")
                 ->where(["like","menu_name","$key"])
                ->asArray()
                ->all();

     }
     //根据类别搜索菜品
     public function seriesch($id){
        $menu = new Menu();
  // return  $re=Yii::$app->db->createCommand("select menu_code,menu_name,menu_id,image_wx,username,series_name,menu_price,menu_introduce,menu_status,shop_show,menu_sort,zss_menu.created_at,zss_menu.updated_at from (zss_menu inner join zss_image on zss_menu.menu_id=zss_image.model_id) inner join zss_series on zss_menu.series_id=zss_series.series_id inner join zss_admin on zss_menu.updated_id = zss_admin.id where zss_menu.series_id=$id")->queryAll();
     return   $newallinfo= $menu->find()
                ->select(["menu_code","menu_name","menu_id","image_wx","username","series_name","menu_price","menu_introduce","menu_status","shop_show","menu_sort","zss_menu.created_at","zss_menu.updated_at"])
                ->leftJoin("`zss_image` on `zss_image`.`model_id` = `zss_menu`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                 ->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_menu`.`updated_id`")
                 ->where(["zss_menu.series_id"=>$id])
                ->asArray()
                ->all();

     }
     //菜品信息添加
     public function infoadd($variable){
        $model = new Menu();
        
        foreach ($variable as $key => $value) {

            $model->$key = $value;
        }
         $true = $model->save();

         if ($true) {
             return $model->attributes["menu_id"];
         }
        
     }

     //菜品信息存在判断
    public function ckinfo($id,$name)
    {  
     return   Menu::find()->where(["series_id"=>$id,"menu_name"=>"$name"])->asArray()->one();

    }


}


