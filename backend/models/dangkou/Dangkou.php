<?php

namespace backend\models\dangkou;

use Yii;
use backend\models\order\Order;
use backend\models\distribution\Orderadmin;

use backend\models\order\Orderinfo;
use backend\models\admin\Admin;
use backend\models\series\Series;


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
class Dangkou extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dangkou}}';
    }


    public function findinfo($uid)
    {
    	
    	$info = Dangkou::find()->where(["d_dang"=>$uid])->asArray()->one();
    	
    	$dianid = $info["d_dian"];

    	$d_serice = $info["d_serice"];

    	if ($d_serice=="") {
    		//判断该档口下存在类别选择

    		$allinfo = "";

    		return $allinfo;
    	}else{

    		//该档口下存在类别选择
    		$backinfo = Orderinfo::find()
    						->select(["info_id","order_sn","menu_name","series_id","meal_number"])
    						->leftjoin("`zss_menu` on `zss_menu`.`menu_id`=`zss_order_info`.`menu_id`")
    						->leftjoin("`zss_order` on `zss_order`.`order_id`=`zss_order_info`.`order_id`")
    						->orderBy('info_id DESC')
    						->where(["zss_order.shop_id"=>$dianid,"is_make"=>0,"zss_order.order_status"=>2])        
  						    ->asArray()
    		  				->all();
                           
               if (!$backinfo) {

                        return $allinfo = "";

                            } else{            

                		$array = explode(",",$d_serice);	
                		
                		foreach ($backinfo as $key => $value) {
            								
            			if (in_array($value["series_id"], $array)) {
            				
            				$newallinfo[] = $value;
            			}

            				}

            				return $newallinfo;
                            }

    	}

    }


    public function fixstatus($id){

               $time = time(); 

               $info = Orderinfo::find()->select(["order_id"])->where(["info_id"=>$id])->asArray()->one(); 

                $oid = $info["order_id"];   


	    Orderinfo::updateAll(array("over_time"=>$time,"is_make"=>1),array("info_id"=>$id));	

         $orderid = $info["order_id"];
         $allinfo=Orderinfo::find()->select(["is_make"])->where(["order_id"=>$orderid])->asArray()->all();
         $number = 0;

         foreach ($allinfo as $key => $value) {
                $number = $number+$value["is_make"];
         }

         if (count($allinfo)==$number) {
             
           
           return  Order::updateAll(array("confirm_time"=> $time),array("order_id"=>$orderid)); 
         }else{

           return  0;  

         }


    }

//完成订单
    public function Overmenu($uid)
    {
    	
    	$info = Dangkou::find()->where(["d_dang"=>$uid])->asArray()->one();
    	
    	$dianid = $info["d_dian"];

    	$d_serice = $info["d_serice"];

    	if ($d_serice=="") {
    		//判断该档口下存在类别选择

    		$allinfo = "";

    		return $allinfo;
    	}else{

    		//该档口下存在类别选择
    		$backinfo = Orderinfo::find()
    						->select(["info_id","order_sn","menu_name","series_id","is_make","over_time","meal_number"])
    						->leftjoin("`zss_menu` on `zss_menu`.`menu_id`=`zss_order_info`.`menu_id`")
    						->leftjoin("`zss_order` on `zss_order`.`order_id`=`zss_order_info`.`order_id`")
    						->orderBy('info_id DESC')
    						->where(["zss_order.shop_id"=>$dianid,"zss_order.order_status"=>2,"is_make"=>1])
    						->limit(25)
                            ->asArray()
    						->all();

    		$array = explode(",",$d_serice);	
    		
    		foreach ($backinfo as $key => $value) {
    								
    			if (in_array($value["series_id"], $array)) {
    				
    				$newallinfo[] = $value;
    			}

    				}

    				return $newallinfo;
    	}

    }


    // public function fixmake($id)
    // {
    //      $time = time(); 
    //       Orderinfo::updateAll(array("over_time"=> $time,"is_make"=>1),array("info_id"=>$id)); 
    //      $info=Orderinfo::find()->select(["order_id"])->where(["info_id"=>$id])->asArray()->one();
    //      $orderid = $info["order_id"];
    //      $allinfo=Orderinfo::find()->select(["is_make"])->where(["order_id"=>$orderid])->asArray()->all();
    //      $number = 0;

    //      foreach ($allinfo as $key => $value) {
    //             $number = $number+$value["is_make"];
    //      }

    //      if (count($allinfo)==$number) {
             
           
    //        return  Order::updateAll(array("confirm_time"=> $time),array("order_id"=>$orderid)); 
    //      }else{

    //        return  0;  

    //      }

       
    // }


    public function mydangkou($id)
    {
       $list =  Dangkou::find()->where(["d_dian"=>$id])->asArray()->all();

        $allwaiter  = Admin::find()->select(["id","username"])->where(["type"=>4])->asArray()->all();//所有服务员

        $restlist = Dangkou::find()->where(['<>','d_dian',$id])->asArray()->all();

        

        if ($restlist) {
           
           foreach ($restlist as $ke => $val) {
                   
                   $newrest[] = $val["d_dang"];
               }  
        }else{

            $newrest[] = array();
        }

        foreach ($allwaiter as $key => $value) {
                
                if (!in_array($value["id"],$newrest)) {
                   
                    $newallinfo[] =  $value;

                    $sid = $value["id"];
                    
                    $seda = Dangkou::find()->select(["d_serice"])->where(['d_dang'=>$sid])->asArray()->one();
                    
                    if ($seda) {
                        $alllist["series"][] = $seda;
                    }else{

                       $alllist["series"][] = "";        
                    }
                         
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
               $newarray[] = $value["d_dang"];
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

    //类别查找
    public function Showserise()
    {
         

        return Series::find()->select(["series_id","series_name"])->asArray()->all();
    }

    public function Addserise($val,$shopid)
    {   
        if (Dangkou::find()->where(["d_dian"=>$shopid])->asArray()->one()) {
            Dangkou::deleteAll(["d_dian"=>$shopid]);
        }

        if (!empty($val)) {   

        foreach ($val as $key => $value) {
            
            $model = new Dangkou;
            $model->d_dian = $value["shopid"];
            $model->d_serice = $value["se"];
            $model->d_dang = $value["wa"];
            $model->save();
        }

        if ($model->save()) {
            return true;
        }else{
            return false;

        }

           }else{

             return true;
           }
    }



}