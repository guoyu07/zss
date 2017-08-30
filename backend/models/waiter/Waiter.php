<?php

namespace backend\models\waiter;

use Yii;
use backend\models\order\Order;
use backend\models\distribution\Orderadmin;

use backend\models\order\Orderinfo;
use backend\models\series\AdminShop;
use backend\models\admin\Admin;


/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $role
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $login_time
 * @property string $login_ip
 */
class Waiter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%waiter}}';
    }

//查找门店
    public function findinfo($uid)
    {
    	$model = new AdminShop;   
            $info = $model->find()
                            ->select(["zss_admin_shop.shop_id","shop_name"])
                            ->leftjoin("`zss_shop` on `zss_shop`.`shop_id`=`zss_admin_shop`.`shop_id`")
                            ->where(["admin_id"=>$uid])
                            ->asArray()
                            ->all();

               if ($info) {
                           return  $info;
                            }else{

                              return $info = "";      

                            }             


    	
    	

    	

    }

    //门店服务员查询
    public function mywaiter($id){


        $list =  Waiter::find()->where(["shop_id"=>$id])->asArray()->all();

        $allwaiter  = Admin::find()->select(["id","username"])->where(["type"=>5])->asArray()->all();//所有服务员

        $restlist = Waiter::find()->where(['<>','shop_id',$id])->asArray()->all();
        if ($restlist) {
           
           foreach ($restlist as $ke => $val) {
                   
                   $newrest[] = $val["wat_id"];
               }  
        }else{

            $newrest[] = array();
        }


         

        foreach ($allwaiter as $key => $value) {
                
                if (!in_array($value["id"],$newrest)) {
                   
                   $newallinfo[] =  $value;
                }

            }    


        if (!$list) {


             if ($allwaiter) {

                $alllist["allinfo"] = $newallinfo;
             }else{

                $alllist["allinfo"] = ""; 
             }

             $alllist["alllist"] = array();

             return  $alllist;

        }else{

            foreach ($list as $key => $value) {
               $newarray[] = $value["wat_id"];
            }

             if ($allwaiter) {

                $alllist["allinfo"] = $newallinfo;
             }else{

                $alllist["allinfo"] = ""; 
             }
            $alllist["alllist"] = $newarray;

            return  $alllist;
        }      

    }

    //门店服务员添加
    public function insertwat($value,$shopid)
    {
       $isnumber = Waiter::find()->where(["shop_id"=>$shopid])->asArray()->all();
        if($isnumber){

            Waiter::deleteAll(["shop_id"=>$shopid]);

        }
        
        foreach ($value as $key => $value) {


                      $model = new Waiter;
           
                     $model->shop_id = $value["shop_id"];
                     $model->wat_id = $value["wat_id"];           
                    
                    $model->save();

         }
          
          if ( $model->save()) {

             return true;

           } else{

            return false;

           }
    }

    //服务员门店下订单 1堂食 2 自提 3 外卖
    public function waiterorder($id)
    {
       $isnumber = Waiter::find()->where(["wat_id"=>$id])->asArray()->one(); 

       $shopid = $isnumber["shop_id"];//所属门店

       $allid =  Order::find()->select(["order_id"])
                    ->where(["IN","delivery_type",[1,2]])
                    ->andwhere(["shop_id"=>$shopid])
                    ->andWhere(['NOT', ['confirm_time' => null]])
                    ->asArray()
                    ->all();
             foreach ($allid as $key => $value) {
                    
                    $new[] = $value["order_id"];

                }  

                if (empty($allid)) {
                  return $allid=array();
              }
              
              $backinfo = Orderinfo::find()
                            ->select(["info_id","order_sn","menu_name","series_id","seat_number","delivery_type","zss_order.order_id","zss_order.meal_number"])
                            ->leftjoin("`zss_menu` on `zss_menu`.`menu_id`=`zss_order_info`.`menu_id`")
                            ->leftjoin("`zss_order` on `zss_order`.`order_id`=`zss_order_info`.`order_id`")
                            ->orderBy('info_id DESC')
                            ->where(["in","zss_order.order_id",$new])
                            ->andwhere(["is_make"=>1,"is_pai"=>null])        
                            ->asArray()
                            ->all();  

                 if (!$backinfo) {
                                return $backinfo = "";
                             }else{

                                return $backinfo;
                             }            

    }

//修改数据
    public function fixendtype($id)
    {
        
        Orderinfo::updateAll(array("is_pai"=>1),array("info_id"=>$id));

         $info = Orderinfo::find()->select(["order_id"])->where(["info_id"=>$id])->asArray()->one(); 
   

         $orderid = $info["order_id"];

         $allinfo=Orderinfo::find()->select(["is_pai"])->where(["order_id"=>$orderid])->asArray()->all();

         $number = 0;

         foreach ($allinfo as $key => $value) {
                $number = $number+$value["is_pai"];
         }

         if (count($allinfo)==$number) {

             $time = time();
           
             Order::updateAll(array("order_success"=>$time,"order_status"=>3 ),array("order_id"=>$orderid));

             return  0;  
         }else{

           return count($allinfo)- $number;

         }
    }


    public function shopid($id)
    {

         $isnumber = Waiter::find()->where(["wat_id"=>$id])->asArray()->one(); 

        $shopid = $isnumber["shop_id"];//所属门店

        return $shopid;
    }
//店内所有配送订单（完成）
    public function Shopoverorde($shopid)
    {
        
       // $info =  Order::find()->select(["order_sn","meal_number","order_success","order_id"])
       //                      ->where(["shop_id"=>$shopid])
       //                      ->andWhere(['NOT', ['order_success' => null]])
       //                      ->limit(25)
       //                      ->asArray()
       //                      ->all();

        $allid =  Order::find()->select(["order_id"])
                    ->where(["IN","delivery_type",[1,2]])
                    ->andwhere(["shop_id"=>$shopid])
                    ->andWhere(['NOT', ['confirm_time' => null]])
                    ->asArray()
                    ->all();
             foreach ($allid as $key => $value) {
                    
                    $new[] = $value["order_id"];

                }  

                if (empty($allid)) {
                  return $allid=array();
              }
              
              $backinfo = Orderinfo::find()
                            ->select(["info_id","order_sn","menu_name","series_id","seat_number","delivery_type","zss_order.order_id","zss_order.meal_number"])
                            ->leftjoin("`zss_menu` on `zss_menu`.`menu_id`=`zss_order_info`.`menu_id`")
                            ->leftjoin("`zss_order` on `zss_order`.`order_id`=`zss_order_info`.`order_id`")
                            ->orderBy('info_id DESC')
                            ->where(["in","zss_order.order_id",$new])
                            ->andwhere(["is_make"=>1,"is_pai"=>1])        
                            ->asArray()
                            ->all();  

               if($backinfo){

               return $backinfo;

               }else{

                return $backinfo="";
               }             
    }



    

}