<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\series\Series;
use backend\models\prints\Prints;
use backend\models\order\Order;

/**
 * 打印机管理控制器
 * @author
 */
class PrintController extends BaseController
{
	/**
	 * @inheritdoc  打印机列表
	 */
	public function actionIndex(){
		$model=new Prints;
		
		$shop_id=Yii::$app->request->get();

		$model=$model->getPrints($shop_id);
        return $this->render('index',['shop_id'=>$shop_id,'model'=>$model]);
	}

	/**
	 * 添加打印机
	 * @return [type] [description]
	 */
	public function actionAdd(){

		$shop_id=Yii::$app->request->get();

		$model = new Series();

    	$showAll = $model->showall();

		return $this->render('add',['showAll'=>$showAll,'shop_id'=>$shop_id]);
	}

	/**
	 * 设置打印机
	 * @return [type] [description]
	 */
	public function actionSetPrint(){

		$data=Yii::$app->request->post();
		// $this->p($data);die;

		$model=new Prints;
		// $res=$model->getPrintsRes($data);
		// if($res){
		// echo "string";
		// }
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {

			if($model->save()){

				return $this->redirect(["index",'shop_id'=>$model->shop_id]);

			}
		}
		
	}

	/**
	 * 选择门店
	 */
	public function actionGetShopPrint(){

		$id = \Yii::$app->user->identity->id;

		$model = new Order();

		$shop_id = $model -> shop_id($id);//取得门店id

		$shop = $model->shop_list($shop_id);

        return $this->render('shop_list',[

			"shop" => $shop,	

		]);

	}

	/**
	 * 删除打印机
	 */

	public function actionDel(){
		$print_id=Yii::$app->request->get('print_id');
		$model=new Prints;

		$res=$model->delPrint($print_id);
		if($res){
			return $this->redirect(["get-shop-print",'shop_id'=>$model->shop_id]);
		}
	}




}
