<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\shop\Shop;
use backend\models\shop\ShopForm;
use backend\models\shop\ShopeditForm;
use backend\models\shop\Admin;
use backend\models\shop\ShopinfoForm;
use backend\models\series\Menu;
use backend\models\series\ShopMenu;
/**
 * 门店功能模块
 * @author 王文秀
 */
class ShopController extends BaseController
{
	/**    
	 * @inheritdoc  门店列表
	 */
	public function actionList()
	{
		$session = Yii::$app->session;
		$Shop = new Shop();
		$models = $Shop->shop_list();
		return $this->render('list',[
			'models' => $models,
		]);
	}
	
	/**
	 * @inheritdoc  门店删除
	 * @param  $id 门店ID
	 */
	public function actionDelete()
	{
		$request = \Yii::$app->request;
		$id = $request->get('id');
		$Shop = new Shop();
		$rs = $Shop->shop_delete($id);
		if($rs){
			return  $this->ajaxSuccess(1);
		}else{
			return  $this->ajaxError(0);
		}
	}

	/**
	 * @inheritdoc  门店批量删除
	 */
	 function actionDeleteAll()
	{
		$request = \Yii::$app->request;
		if($request->isAjax){
			$str = $request->get('str');
			$model = new Shop();
			$re = $model -> DeleteAll_shop($str);
			if($re){
				return  $this->ajaxSuccess(1);
			}else{
				return  $this->ajaxError(0);
			}
		}
	 }
	
	/**
	 * @inheritdoc  门店添加
	 */
	public function actionAdd()
	{
		$model = new ShopForm;
		$obj = new Shop;
		$zj = $obj -> zj(); //取得增减表数据
		$admin = $obj -> admin();//取得身份为店长的人
		if ($model->load(Yii::$app->request->post())  && $model->validate()){
			$data = Yii::$app->request->post();
			$obj = new Shop();
			$result = $obj -> add($data['ShopForm']);
			if($result){
				$this->success("门店添加成功",['shop/list']);
			}else{
				$this->error("门店添加失败",['shop/add']);
			}
        }
	    return $this->render('add',[
			'model' => $model,	
			'admin' => $admin,
			"zj" => $zj,
		]);
	}

	/**
	 * @inheritdoc  门店编辑
	 */
	public function actionEdit()
	{
		$request = Yii::$app->request;
		$id = $request->get('id');
		$model = new Shop();
		$admin = $model -> admin();
		$result = $model -> shop_edit($id); //取得门店的信息
		$modelForm = new ShopeditForm;
		if ($modelForm->load(Yii::$app->request->post())  && $modelForm->validate()){
			$data = Yii::$app->request->post();
			$model = new Shop();
			$re = $model -> shop_update($data['ShopeditForm']);
			if($re){
				$this->success("修改成功",['shop/list']);
			}else{
				$this->error("修改失败",['shop/list']);
			}
		}
	    return $this->render('edit',[
			'id' => $id,
			'result' => $result,	
			'model' => $modelForm,
			'admin' => $admin,
		]);
	}

	/**
	 * @inheritdoc  检查门店名称
	 */
	function actionCheck()
	{
		$request = Yii::$app->request;
		$data = $request->get();
		$model = new Shop;
		$re = $model -> check($data);
		if($re){
			return  $this->ajaxSuccess(1);
		}else{
			return  $this->ajaxError(0);
		}
	}

	/**
	 * @inheritdoc  门店营业状态修改
	 */
	function actionShopStatus()
	{
		$request = Yii::$app->request;
		$data = $request->post();
		if ($request->isAjax && $data){
			$model = new Shop;
			$re = $model -> shop_status($data);
			if($re){
				return  $this->ajaxSuccess(1);
			}else{
				return  $this->ajaxError(0);
			}
		}	
	}

	/**
	 * @inheritdoc  Admin 查看店铺
	 */
	function actionShop()
	{
		$request = Yii::$app->request;
		$id = $request->get('id');
		$model = new Shop;
		$shop = $model->shop($id);
		$type = $model -> type();	//获取就餐类型
		return $this->render('hisshop',[
			"shop" => $shop,
			"type" => $type,
		]);
	 }

	/**
	 * @inheritdoc  我的门店
	 */
	function actionMyshop()
	{
		$id = Yii::$app->user->identity->id;
		$model = new Admin;
		$num = $model -> shopnum($id); //取得门店数量
		if($num > 1){
			$shop = $model -> shop_list($id); //门店列表
			return $this->render('shop_list',[
				"models" => $shop,
				 "id" => $id,
			]);
		}else{
			$obj = new Shop;
			$type = $obj -> type();	//获取就餐类型
			$shop_id = $obj -> userShopId($id);
			if(!$shop_id){
				return $this->render('noshop');
			}else{
				$shop = $obj->shop($shop_id['shop_id']);
				$username = $model -> username($id);
				return $this->render('shop',[
					"shop" => $shop,
					"type" => $type,
					"username" => $username['username'],
				]);
			}
		}
	}

	/**
	 * @inheritdoc  店长进入门店详情
	 */
	 function actionShoperShop()
	{
		$request = Yii::$app->request;
		$id = $request->get('id');
		$user_id = $request->get('user_id');
		$model = new Admin;
		$username = $model -> username($user_id);
		$obj = new Shop;
		$type = $obj -> type();	//获取就餐类型
		$shop = $obj->shop($id);
		return $this->render('shop',[
			"shop" => $shop,
			"type" => $type,
			"username" => $username['username'],
		]);
	}

	/**
	 * @inheritdoc  修改门店信息
	 */
	function actionUpdateShop()
	{
		$request = Yii::$app->request;
		$id = $request->get('id');//门店id
		$model = new ShopinfoForm;
		$obj = new Shop;
		if ($model->load(Yii::$app->request->post()) && $model->validate()){
			$data = Yii::$app->request->post();
			$re = $obj -> update_shop($data['ShopinfoForm']);
			if($re){
				$this->success("修改成功",['shop/myshop']);
			}else{
				 $this->error("修改失败",['shop/myshop']);
			}
        }
		$models = $obj -> shop_info($id);
		$zj = $obj -> zj(1);
		$type = $obj -> type();	//获取就餐类型
		return $this->render('update_shop',[
			"model" => $model,
			"shop" => $models,
			"type" => $type,
			"id" => $id,
			"zj" => $zj,
		]);
	}
	
	/**
	 * @inheritdoc  搜索门店
	 * @param  $word 检索关键字
	 */
	 function actionSearchShop() 
	{
		if (\Yii::$app->request->isAjax){
			$word = \Yii::$app->request->get('word');
			$model = new Shop;
			$models = $model -> SearchShop($word);
			return $this->render('search',[
				'models' => $models,
			]);
		}
	}

	/**
	 * @inheritdoc  获取满增满减信息
	 * @param  $id 满增满减表id
	 * @param  $type 类型(1满增 0满减)
	 */
	function actionSelectGift()
	{
		$request = Yii::$app->request;
		$get = $request->get(); 
		$model = new Shop;
		$result = $model -> SelectGift($get);
		if(!$result){
			return $this->ajaxError("执行失败");
		}else{
			return $this->ajaxSuccess($result);
		}
	}

	/**
	*@Action 档口管理
	*@Des管理相对应的门店的档口
	*
	*@Rule 
	*/
	function actionDangkou()
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
	*@Action 团餐管理
	*
	*/
	function actionTuancan()
	{
		$id = Yii::$app->user->identity->id;//获取门店id
		$model = new ShopMenu();
		$allinfo = $model->shopallid($id);
		if ($allinfo) {
			return  $this->render("tuancan",["allinfo"=>$allinfo]);
		}else{
			return  $this->render("tuancan",["allinfo"=>""]);
		}
	}

	
	/**
	*@Action 团餐管理
	*
	*/
	function actionShopmeal()
	{
		$shop_id=Yii::$app->request->get('shop_id');
		$username = Yii::$app->user->identity->id;//获取session
      	$model = new ShopMenu();
     	$allinfo = $model -> shoplist($username,'',$shop_id);
     	$data= [];
     	if ($allinfo) {
     		foreach ($allinfo['list'] as $key => $value) {
	     		foreach ($value['menu'] as $k => $v) {
	     			$data[$key]['menu_id'] = $v['menu_id']; 
	     			$data[$key]['menu_name'] = $v['menu_name'];
	     			$data[$key]['menu_price'] = $v['menu_price'];
	     		}
	     	}
     	}
     	if ($data) {
			return  $this->render("shopmeal",["data"=>$data,'shop_id' => $shop_id]);
		}else{
			return  $this->render("shopmeal",["data"=>""]);
		}
	}

	/**
	*@Action 团餐订单
	*
	*/
	function actionShoporder()
	{
		$post=Yii::$app->request->get();
		$data = $post['data'];
		
	}

	

}