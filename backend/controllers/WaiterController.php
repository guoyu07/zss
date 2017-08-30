<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\common\Common;
use backend\models\waiter\Waiter;


/**
 * 服务员功能模块
 * @author 王文秀
 */
class WaiterController extends BaseController
{
  /*
	* 查看门店
  */

  	public function actionIndex()
  	{
  		$userid = $this->getUserid();
		
  		$models = new Waiter();
  		
  		$info = $models->findinfo($userid);	


		return $this->render("index",["allinfo"=>$info]);
  	}

  	//门店对应的服务员
  	public function actionMywaiter()
  	{
		 $shop_id =  yii::$app->request->get("shop_id");

		 $models = new Waiter();
  		
  		$info = $models->mywaiter($shop_id);	

  		if (yii::$app->request->post()) {

  			$allinfo = yii::$app->request->post();

  			$wid = $allinfo["waiter"];

  			$shopid = $allinfo["shopid"];

  			foreach ($wid as $key => $value) {
  				
  				$newinfo[$key]["wat_id"] = $value;

  				$newinfo[$key]["shop_id"] = $shopid;
  			}


  				if ($models->insertwat($newinfo,$shopid)) {
  					
  					 Yii::$app->session->setFlash('success', '添加成功');

              		 return $this->redirect(['index']);

  				}else{

  					Yii::$app->session->setFlash('error', '添加失败');

              		 return $this->redirect(['index']);
  				}
  		}

  		return $this->render("mywaiter",["allinfo"=>$info,"shopid"=>$shop_id]);

  	}
  //服务员订单配送
  	public function actionWaiterorder()
  	{
  		$userid = $this->getUserid();

  		$models = new Waiter();
  		
  		$info = $models->waiterorder($userid);	

  		$shopid = $models->shopid($userid);
  		
  		$infot = $models->Shopoverorde($shopid);
      
  		return $this->render("list",["allinfo"=>$info,"shopid"=>$shopid,"allinfot"=>$infot]);
  	}

  	//修改配送状态
  	public function actionFixendtype()
  	{
  		$id = yii::$app->request->get("id");

  		$models = new Waiter();
  		
  		$info = $models->fixendtype($id);

  		return  $info;
  	}
  	//店内所有配送订单
  	public function actionShopoverorder()
  	{
  		$shopid = yii::$app->request->get("shopid");

  		$models = new Waiter();
  		
  		$info = $models->Shopoverorde($shopid);

  		 return $this->render("overorder",["allinfo"=>$info]);

  	}

}