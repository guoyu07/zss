<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\series\Series;
use backend\models\series\Menu;
use backend\models\series\Image;
use backend\models\series\MenuForm;
use backend\models\series\UploadForm;
use backend\models\common\Common;
use backend\models\dangkou\Dangkou;
use backend\models\waiter\Waiter;


/**
 * 档口功能模块
 * @author 王文秀
 */
class DangkouController extends BaseController
{
  /**/

  	public function actionIndex()
  	{
  		//获取useid
  		$userid = $this->getUserid();
		
  		$models = new Dangkou();
  		
  		$info = $models->findinfo($userid);	

      $infot = $models->Overmenu($userid); 
    
    //return $this->render("list",["allinfot"=>$infot]);

     
		return $this->render("takeawayt",["allinfo"=>$info,"allinfot"=>$infot]);


  	}
    //修改状态
  	public function actionFixstatus()
  	{
  		$id = yii::$app->request->get("id");
  		
  		$models = new Dangkou();
  		
  		$info = $models->fixstatus($id);	

  		return $info;

  	}
//已经完成订单
  	public function actionOvermenu()
  	{
  		$userid = $this->getUserid();
		
  		$models = new Dangkou();
  		
  		$info = $models->Overmenu($userid);	
  	
		return $this->render("list",["allinfo"=>$info]);
  		

  	}
    //开始制作 修改状态
    public function actionFixmake()
    {
      $id = yii::$app->request->get("id");
      
      
      $models = new Dangkou();
      
      $info = $models->fixmake($id);  

      return $info;

    }
    //门店档口 门店列表
     public function actionShopdangkou()
    {
      $userid = $this->getUserid();
      
      $models = new Waiter();
      
      $info = $models->findinfo($userid); 


    return $this->render("myshop",["allinfo"=>$info]);

    }
    //我的档口
    public function actionMydangkou()
    {
        $models = new Dangkou();

        $shopid = yii::$app->request->get("shop_id");

       $info = $models->mydangkou($shopid);  

       $seinfo = $models->Showserise();//所有类别
      //print_r($info);die;
      return $this->render("mydangkou",["allinfo"=>$info,"shopid"=>$shop_id,"seinfo"=>$seinfo,"shopid"=>$shopid]);

    }

     //类别判断 是否重复选择
    public function actionShowserise()
    {
       $id = yii::$app->request->get("id");
       $arr = explode(",",$id);
       $num = 0;
       $newarr = array_count_values($arr);
       foreach ($newarr as $key => $value) {
          if ($value>1) {
              $num = 1;
              break;
          }
       }

       if ($num==0) {
        return true;
       }else{

        return false;
       }
    }
    //类别添加
    public function actionAddserise()
    {
     $allinfo = yii::$app->request->post();
     // $this->p( $allinfo);die;
     $shopid = yii::$app->request->post("shopid");
     $models = new Dangkou();
      foreach ($allinfo as $key => $value) {
          
          $newkey = substr($key,0,6);

          if ($newkey=="serice") {
            $searr[$key] = $value;
          }
          if ($newkey=="waiter") {
            $dkarr[$key] = $value;
          }
      }
  if (empty($searr)||empty($dkarr)) {
    
    if ($models->Addserise($arrt=array(),$shopid)) {
     Yii::$app->session->setFlash('success', '修改成功');

        return $this->redirect(['shopdangkou']);
    }else{

        Yii::$app->session->setFlash('error', '修改失败');

        return $this->redirect(['shopdangkou']);

      }
  }

    $i=0;
    foreach ($searr as $key => $value) {
      $i++;
    foreach ($dkarr as $ke => $val) {  
                
            if(substr($key,6)==substr($ke,6)){
                   
                     $arrt[$i]["se"] = implode(",",$value);
                     $arrt[$i]["wa"] = implode(",",$val);
                     $arrt[$i]["shopid"] = $shopid; 

               }     
           }

        }  


      
      
      if ($models->Addserise($arrt,$shopid)) {
        
        Yii::$app->session->setFlash('success', '修改成功');

        return $this->redirect(['shopdangkou']);
      }else{

        Yii::$app->session->setFlash('error', '修改失败');

        return $this->redirect(['shopdangkou']);

      }



    }



}