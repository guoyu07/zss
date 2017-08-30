<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\web\Request;
use yii\base\Widget;
use yii\jui\DatePicker;
use backend\models\order\Order;
use backend\models\order\Orderinfo;
use backend\models\shop\Shop;

/**
 * 订单功能模块
 * @author 王文秀
 */
class OrderController extends BaseController
{
	/**
	 * @inheritdoc  订单管理
	 */
	public function actionIndex(){
		$model = new Order();
		$order_list = $model -> order_list();
		//print_r($order_list);die;
		$obj = new Shop();
		$type = $obj->type();
        return $this->render('index', [
            'models' => $order_list,
			'type' => $type,
        ]);
        return $this->render('index');
	}

	/**
	 * @inheritdoc  查询订单详细信息
	 */
	function actionSeeOrder(){
		$db = \Yii::$app->db;
		$request = Yii::$app->request;
		$getData = $request->get();
		$model = new Order();
		$list = $model -> personal_order($getData);//查询个人订单

		$Info = new Orderinfo();
		$inter = $Info -> order_info($getData);//查询订单详细信息

		$arr = array();
		$arr['order'] = $list;
		$arr['info'] = $inter;

		if(empty($list)){
			die("0");
		}
		$view =  $this->renderPartial('info',[
			'list'=>$arr,	
		]);
		return $this->ajaxSuccess($view);
	}

	/**
	 * @action 根据条件查询订单
	 * @parameter  pay_type 支付方式
	 * @parameter  order_status 订单状态
	 * @parameter  delivery_type 派送类型
	 */
	function actionSearchOrder(){
		$request = \Yii::$app->request;
		$data = $request->get();
		$admin = $request->get('admin');  
		$model = new Order();
		$arr = $model -> search_order($data,$admin);
		$view = $this->render('search',[
			'models'=>$arr,	
		]);
		return $this->ajaxSuccess($view);
	}

	/**
	 * @inheritdoc  模糊查询订单详细信息
	 */
	 function actionLikeOrder(){
		$data =  \Yii::$app->request->get();
		$admin = \Yii::$app->request->get('admin');  
		$model = new Order();
		$arr = $model -> like_order($data,$admin);
		$view = $this->render('search',[
			'models'=>$arr,	
		]);
		return $this->ajaxSuccess($view);
	 }
	 
	 /**
	 * @inheritdoc  取得用户门店
	 */
	function actionShoporder()
	{
		$id = \Yii::$app->user->identity->id;
		//$id = 4;/*我现在这里模拟一个店长的ID*/
		$model = new Order();
		$shop_id = $model -> shop_id($id);//取得门店id
		$shop = $model->shop_list($shop_id);
        return $this->render('shop_list',[
			"shop" => $shop,	
		]);
	 }
	 //取得门店的订单
	function actionShopOrderinfo()
	{
		$shop_id = \Yii::$app->request->get('shop_id');
		// $this->p($shop_id);
		$model = new Order();
		$order_list = $model ->order_list($where = array("zss_order.shop_id"=>$shop_id));
		$obj = new Shop();
		$type = $obj->type();
        return $this->render('shoporder', [
            'models' => $order_list,
			'type' => $type,
			'shop_id'=>$shop_id,
        ]);
	}


	
	/**
	 * 检测订单播放音乐
	 *@property integer $order_id=1(1未打印)
	 */
	public function actionGetOrder(){
		// 门店id
		$arr['shop_id'] = \Yii::$app->request->get('shop_id');
		//未打印状态
		$arr['order_status']=1;
		$model = new Order();
		$order_status = $model ->order_status($arr);
		return $this->ajaxSuccess($order_status);
	}


	/**
	*@Action 打印订单
	*/
	// public function actionPrinter()
	// {
	// 	$id = \Yii::$app->request->get('id');
	// 	$model = new Order;
	// 	$result = $model -> printer($id);
	// 	if($result)
	// 	{
	// 		return  $this->ajaxSuccess(1);
	// 	}
	// 	else
	// 	{
	// 		return  $this->ajaxError(0);
	// 	}
	// }

	/**
	 * @inheritdoc  打印订单信息
	 */
	function actionPrintOrder(){
		$db = \Yii::$app->db;
		$request = Yii::$app->request;
		$getData= $request->get();
		$model = new Order();
		$list = $model -> personal_order($getData['order_id']);//查询当前订单

		$Info = new Orderinfo();
		$inter = $Info -> order_info($getData);//查询订单详细信息
		$dangkou= $Info ->order_series_info($getData);//查询各档口详细信息
		$arr = array();
		$arr['order'] = $list;
		$arr['info'] = $inter;
		$arr['dangkou'] = $dangkou;
		// var_dump($arr);die;
		// $result = $model -> printer($getData['order_id']);

		// if($result)
		// {
			return json_encode($arr);
			// return $this->ajaxSuccess($arr);
		// }
	
	}




}
