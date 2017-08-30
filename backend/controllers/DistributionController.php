<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\web\Request;
use yii\base\Widget;
use yii\jui\DatePicker;
use yii\helpers\Url;
use backend\models\distribution\Admines;
use backend\models\distribution\Orderadmin;
use backend\models\order\Order;
use backend\models\shop\Admin;
use backend\models\shop\Shop;

/**
 *配送员功能模块
 * @author 王文秀
 */
class DistributionController extends BaseController
{
	/**
	*@Admin 查看所有抢到的单
	*/
	function actionAllOrder()
	{
		$model = new Orderadmin;
		$data = $model -> AllOrder();
		return $data;
		/*
		Return $this->render('all_order',[
				"data" => $data,
		]);
		*/
	}

	/**
	*@Des 取得相对应的门店的订单
	*@return array
	*/
    public function actionIndex()
    {
		$userid = Yii::$app->user->identity->id;
		//$userid = 37; //模拟id
		$model = new Admines;
		$shop = $model->AdminShop($userid);//取得配送员对应的店铺信息
		$meorder = $this->actionMe(); //抢到的单
		if($shop)
		{
			$data = $model->AdminOrder($userid,$shop['shop_id']);//取得该店没被抢的单

			Return $this->render('takeawayt',[
				"shop" => $shop,
				"data" => $data,
				"userid" => $userid,
				"meorder" => $meorder,
			]);
		}
		else
		{
			Return $this->render('error',[
				"msg" => "您不是配送员  ~~~",	
			]);
		}
		
    }

	/**
	*@Des 抢到的单
	*@return array
	*/
	public function actionMe()
	{
		$userid = Yii::$app->user->identity->id;
		$model = new Orderadmin;
		$data = $model -> meorder(["admin_id" => $userid,'status'=>1]);
		return $data;
		/*
		Return $this->render('order',[
			"data" => $data,
		]);
		*/
	}

	/**
	*@Des 抢单
	*@return status
	*/
	public function actionAddorder()
	{
		$request = Yii::$app->request;
		$order_id = $request->get('id');
		$userid = $request->get('userid');
		$data = $request->get();
		$model = new Admines;
		$result = $model -> AddOrder($order_id,$userid);
		//抢单失败
		if(!$result)
		{
			$url = Url::to(['distribution/index']);
			Return $this->render('error',[
				"msg" => "很遗憾, 抢单失败  ~~~  <a href=".$url.">点击此处继续抢</a>",	
			]);
		}
		//抢单成功
		else
		{
			$this->success("抢单成功",['distribution/index']);
		}
	}
	
	/**
	*@Action 订单送达 
	*@Des改变状态
	*@Param $id 订单的order_id
	*/
	function actionDao()
	{
		$request = Yii::$app->request;
		$order_id = $request->get('id');
		$model = new Order;
		$result = $model->dao($order_id);
		if($result)
		{
			return  $this->ajaxSuccess(1);
		}
		else
		{
			return  $this->ajaxError(0);
		}
	}

	/**
	*@Action 获取门店列表
	*/
	public function actionShop()
	{
		$id = Yii::$app->user->identity->id;
		$model = new Admin;
		$shop = $model -> shop_list($id); //门店列表
		return $this->render('shop_list',[
			"models" => $shop,
			 "id" => $id,
		]);
	}

	/**
	*@Action 配送员列表
	*/
	public function actionDistr()
	{
		$request = Yii::$app->request;
		$id = $request->get('id');
		$obj = new Shop;
		$all_deli = $obj ->all_deli($id); //取得所有的外卖员
		$in_deli = $obj ->in_deli($id); //自家店外卖员
		return $this->render('distr',[
			 "id" => $id,
			"all_deli" => $all_deli,
			"in_deli" => $in_deli,
		]);
	}

	/**
	*@Action 添加配送员
	*/
	public function actionAdd()
	{
		$data = Yii::$app->request->post();
		//print_r($data);die;
		$obj = new Shop;
		$re = $obj -> adddis($data);
		if($re)
		{
			$this->success("修改成功",['distribution/shop']);
		}
		else
		{
			 $this->error("修改失败",['distribution/shop']);
		}
	}



}
