<?php

namespace backend\models\series;

use Yii;
use backend\models\series\AdminShop;
use backend\models\series\Series;
use backend\models\series\Menu;
use backend\models\series\Image;
use backend\models\market\Discount;
use backend\models\shop\Shop;

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
            [['menu_id', 'shop_id', 'menu_stock', 'is_show', 'discount_id', 'created_at', 'updated_at',"updated_id"], 'integer'],
            [['menu_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'menu_id' => '菜品id',
            'shop_id' => '门店id',
            'menu_stock' => '库存量',
            'is_show' => '上下架',
            'discount_id' => '折扣id',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'menu_desc' => '售卖说明',
            'updated_id' => '修改用户',
            
        ];
    }   
        //查找对于店铺
      public function shopid($usernameid){

        return $info = AdminShop::find()->where(["admin_id"=>$usernameid])->one();

        }
    public function shopallid($usernameid){

        $info = AdminShop::find()->where(["admin_id"=>$usernameid])->all();
        if ($info) {
          foreach ($info as $key => $value) {

            $allid[] = $value->shop_id;

        }

        //return $info = AdminShop::find()->select(["zss_shop.shop_id","zss_shop.shop_name"])
          //                              ->innerJoin("`zss_shop` on `zss_shop`.`shop_id`=`zss_admin_shop`.`shop_id`")
            //                            ->where(["zss_admin_shop.admin_id"=>$usernameid])->all();

          foreach ($allid as $key => $value) {

            $all[] = Shop::find()->select(["zss_shop.shop_id","zss_shop.shop_name"])->where(["shop_id"=>$value])->asArray()->one(); 
            
            }
             return $all;
        
        }else{

            return false;
        }
           

            }
        
    //查找店铺已有菜品
     public function findAllMenuId($info){

      return  $allinfo =  ShopMenu::find()->where(["shop_id"=>$info])->asArray()->all();      

     } 

     public function shoplist($username,$search="",$shop_id){
         
        $series = new Series();
        $shop = new Shop();
        $menu = new Menu();
        $image = new Image();
        $discount = new Discount();
        $shopmenu = new ShopMenu();
        $info = $this->shopid($username);
        if ($info) {
            $allinfo =  $this->findAllMenuId($shop_id);
        foreach ($allinfo as $key => $value) {
            $value["menu"] = $menu->find()
                ->select(["*"])
                ->leftJoin("`zss_image` on `zss_image`.`model_id` = `zss_menu`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                //->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_menu`.`updated_id`")
                ->where(['zss_menu.menu_id'=>$value['menu_id']])
                ->andwhere(['or',"menu_name like '%$search%'","menu_code LIKE '%$search%'","menu_introduce LIKE '%$search%'","series_name LIKE '%$search%'"])
                ->asArray()
                ->all();
            
        $value["created_at"] = date("y-m-d",$value["created_at"]);
        $value["updated_at"] = date("y-m-d",$value["updated_at"]);

                if ($value["discount_id"]!="") {
                     $discount_num = $discount->find()->select(["discount_num"]) ->where(['discount_id'=>$value["discount_id"]])->asArray()->one();      
                     $value["discount_num"] = $discount_num["discount_num"];
                     $newAllInfo["list"][$key] = $value;
                 }else{
                    $value["discount_num"] = "";
                    $newAllInfo["list"][$key] = $value;
                 }

                  if (!empty($search)) {
                if (!$value["menu"] ) {
                    
                     unset($newAllInfo["list"][$key]); 

                    }
                    
                    }     
             }

        }else{
                $newAllInfo["list"]="";

        }
          

            $newAllInfo["discount"] = $discount->find()->select(["discount_id","discount_num"]) ->asArray()->all(); //所有折扣
           
             $newAllInfo["series"] = $series->showall();//所有类别
            
            return  $newAllInfo;
        }

        //delete
        public function DelShopMenu($id){
            $allid = explode(",",$id);

           return  ShopMenu::deleteAll(["id"=>$allid]);

        }

        
        //查询其他menu

        public function othermenu($username,$shopid){

        $menu = new Menu();
        $image = new Image();
        $discount = new Discount();
        $shopmenu = new ShopMenu();
        $series = new Series();
        //$info = $this->shopid($username);

        $allinfo =  $this->findAllMenuId($shopid);
        if ($allinfo) {
          foreach ($allinfo as $key => $value) {
            
            $allMenuId[] = $value["menu_id"];

             }
        }else{

           $allMenuId[] = "";
        }
         
         $newallinfo= $menu->find()
                ->select(["menu_id","menu_name","series_name"])
                ->leftJoin("`zss_image` on `zss_image`.`model_id` = `zss_menu`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                ->where(["zss_menu.shop_show"=>1])
                ->asArray()
                ->all();

          foreach ($newallinfo as $mid => $val) {
        
                      if (!in_array($val["menu_id"], $allMenuId)) {

                            $endInfo["list"][] = $val; 
                     }
                                              
                }
            
        $endInfo["series"] = $series->showall();//所有类别

                return  $endInfo;      
        }

        //类别=>find menu
       function Menusearch($id,$username,$shopid){
            $menu = new Menu();

            $newallinfo= $menu->find()
                ->select(["*"])
                ->leftJoin("`zss_image` on `zss_image`.`model_id` = `zss_menu`.`menu_id`")
                ->innerJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
                 ->innerJoin("`zss_admin` on `zss_admin`.`id` = `zss_menu`.`updated_id`")
                ->where(["zss_menu.series_id"=>$id,"zss_menu.shop_show"=>1])
                ->asArray()
                ->all();

       // $info = $this->shopid($username);//获取店shop_id

        $allinfo =  $this->findAllMenuId($shopid);  

        foreach ($allinfo as $key => $value) {
                
                $nweMenuId[] = $value["menu_id"];
            }  

          //移除已经拥有的类别下的菜品
          foreach ($newallinfo as $ke => $val) {
                    if (!in_array($val["menu_id"],$nweMenuId)) {
                        
                        $endInfo[] = $val; 
                    }
                 }       
            return $endInfo;
        }

         //添加店面菜品       
        function ShopMenuAddInfo($username,$id,$shopid){

for ($i=0; $i < count($id) ; $i++) { 
        
         $model = new ShopMenu();
         $model->menu_id = $id[$i];
         $model->shop_id = $shopid;
         $model->menu_stock = 0;
         $model->is_show = 1;
         $model->discount_id =""; 
         $model->created_at = time();
         $model->updated_at = time();
         $model->menu_desc ="7:00-9:00";
         $model->updated_id = $username;

        $model->save();
}
    if ($model->save()) {
      return true;
    }else{

      return false; 
    }

        }
        //单个类别全部打折
        public function SeriesShoutDiscount($seriesid,$username,$discount,$shopid){

        //$info = $this->shopid($username);//获取店shop_id

        $allinfo =  $this->findAllMenuId($shopid); //获取menu_id 
        
        foreach ( $allinfo as $ke => $val) {
         $id[] = $val["menu_id"]; 
        }

        $menu = new Menu();
        
        $allMenuId = $menu->find()->leftJoin("`zss_series` on `zss_series`.`series_id` = `zss_menu`.`series_id`")->select(["zss_menu.menu_id"])->where(["zss_menu.series_id"=>$seriesid,"zss_menu.menu_id"=>$id])->asArray()->all();
       
        foreach ($allMenuId as $vt => $va) {
            $allFixId[] = $va["menu_id"]; 
        }

         $time = time();
            
       return  ShopMenu::updateall(array("discount_id"=>$discount,"updated_id"=>$username,"updated_at"=>$time),array("menu_id"=>$allFixId,"shop_id"=>$shopid));
 
        }  
        //全店打折
        public function ShopShoutDiscount($username,$discount,$shopid){

             //$info = $this->shopid($username);//获取店shop_id

              $time = time();
             
            return  ShopMenu::updateall(array("discount_id"=>$discount,"updated_id"=>$username,"updated_at"=>$time),array("shop_id"=>$shopid));

        }  
        //批量打折
        public function MoreShoutDiscount($username,$discount,$allinfo,$shopid){

             //$info = $this->shopid($username);//获取店shop_id
             
             $time = time();
             $allnum = explode(",",$allinfo);
             foreach ($allnum as $key => $value) {
                return  ShopMenu::updateall(array("discount_id"=>$discount,"updated_id"=>$username,"updated_at"=>$time),array("shop_id"=>$shopid,"id"=>$value));
             }

        } 

        //查找所有折扣

        public function FindDiscountInfo(){

        $discount = new Discount();

        return $discount->find()->all();   

        }
        //店员修改菜品
        public function Shopmenufixinfo($arrinfo,$id,$username){
            $arrinfo["updated_id"] = $username;

            if ($arrinfo['discount_id']=="") {
                return false;
            }else{

              return  ShopMenu::updateall($arrinfo,array("id"=>$id));
            
            }
        }
        //判断数据是否可以执行
        public function isOk($value)
        {
            
            $model = new Menu();

            $allind= explode(",",$value);

         return  $model->find()->select("menu_id")->where(["series_id"=>$$allind])->one();
        }
        //修改状态
        public function fixnow($id,$status)
        {       if ($status==1) {   
                    $stri = 0;
                }else{
                     $stri = 1;
                }
               return ShopMenu::updateall(array("is_show"=> $stri),array("id"=>$id));

        }


}
