<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\market\Wallet;
use backend\models\market\Coupon;
use backend\models\market\Add;
use backend\models\market\Subtract;
use backend\models\market\Discount;
use backend\models\market\DiscountForm;
use backend\models\market\WalletForm;
use backend\models\market\WalletupForm;
use backend\models\market\AddForm;
use backend\models\market\CouponForm;
use backend\models\market\SubtractForm;
use backend\models\market\Gift;
use backend\models\market\GiftForm;
use backend\models\market\GiftupForm;
use backend\models\series\Series;
use backend\models\market\Menu;

/**
 * 营销功能模块
 * @author 王文秀
 */
class MarketController extends BaseController
{

	/**
	 * @inheritdoc  红包管理
	 */
	public function actionWallet()
	{
		$wallet = new Wallet();
		$wallet = $wallet->select();
		return $this->render('wallet',[
         'wallet' => $wallet,
		]);
	}

	/**
	*	条件搜索红包
	*/
	public function actionSeawallet()
	{
		$sea=Yii::$app->request->get("sea");
		if(isset($sea)){
			$wallet = new Wallet();
			$wallet = $wallet->selectwhere($sea);
			$data = $this->renderpartial('seawallet',[
			 'wallet' => $wallet,
			]);
			return $this->ajaxSuccess($data);
		}
	}
		/**
		*	删除红包
		*/
	public function actionDelwallet()
	{
		$wallet = new Wallet();
		if($wallet->delOne(Yii::$app->request->get("id"))){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}
	/**
	*	修改红包
	*/
	public function actionUpd_wallet()
	{
		$walletForm = new WalletupForm();//实例化表单
		$wallet = new Wallet();
		$oneInfo = $wallet->getOne(Yii::$app->request->get());
		$data = Yii::$app->request->get();
		$id = $data['id'];
		if($walletForm->load(Yii::$app->request->post()) && $walletForm->validate())
		{
			$updre = $wallet->update_wallet(Yii::$app->request->post(),$id);
			if($updre){
				$this->success("修改成功","?r=market/wallet");
			}else{
				$this->success("修改失败","?r=market/wallet");
			}
		}
		return $this->render("upd_wallet",[
			'model' => $walletForm,	
			'oneInfo' => $oneInfo,
			"id"=>$id,
		]);
	}

	/**
	 * @inheritdoc  验证红包名称
	 */
	 function actionCheckName()
	{
		$data = Yii::$app->request->get();
		$model = new Wallet();
		$re = $model -> checkname($data);
		if($re){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	 }

	/**
	 * @inheritdoc  添加红包
	 */	
	public function actionAdd_wallet()
	{
		$walletForm = new WalletForm();
		if($walletForm->load(Yii::$app->request->post()) && $walletForm->validate())
		{
			//通过之后进行添加
			$data = Yii::$app->request->post();
			$wallet = new Wallet();
			if($wallet->add_wallet(Yii::$app->request->post())){	
				$this->success("添加成功","?r=market/wallet");
			}else{
				$this->error("添加失败","?r=market/add_wallet");
			}
		}
		return $this->render("add_wallet",[
			'model'=>$walletForm	
		]);
	 }

	 /**
	 * @inheritdoc  点击更改单行红包数据的显示状态
	 */	
	public function actionChangeshows()
	{
		$wallet = new Wallet();
		$updre = $wallet->ChangeOneShow(Yii::$app->request->get());
		if($updre){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	点击查询单条红包数据的详情
	*/
	public function actionGetonewallet()
	{
		$wallet = new Wallet();
		$onewallet = $wallet->getOneinfo(Yii::$app->request->get());
		$data = $this->renderpartial("getonewallet",[
			"model"=>$onewallet
		]);
		return $this->ajaxSuccess($data);
	}

	/**
	*	批量删除红包
	*/
	public function actionDellallwallet()
	{
		$wallet = new Wallet();
		$a = rtrim($_GET['str'],",");
		$str = explode(",",$a);
		$upddel = $wallet->delmore($str);
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}


	/**
	 * @inheritdoc  折扣管理
	*/
	public function actionDiscount()
	{
		//查找已用的折扣
		$discount = new Discount();
		$discounts = $discount->getAll();
	    return $this->render('discount',[
			'use' => $discounts,
		]);
	}

	/**
	 * @inheritdoc  删除折扣
	 */
	public function actionDeldiscount()
	{
		$discount = new Discount();
		if($discount->delOne(Yii::$app->request->get("id"))){
			return $this->ajaxSuccess(1);
		} else {
			return $this->ajaxError(0);
		}
	}

	/**
	 * @inheritdoc  修改折扣
	 */
	public function actionUpd_discount()
	{
		$data = Yii::$app->request->get();
		$id = $data['id'];
		$discountForm = new DiscountForm();//实例化表单
		$discount = new Discount();
		$oneInfo = $discount->getOne($id);//获取要修改的数据信息
		if($discountForm->load(Yii::$app->request->post()) && $discountForm->validate()){
			$updre = $discount->update_discount(Yii::$app->request->post(),$id);
			if($updre){
				$this->success("修改成功","?r=market/discount");
			}else{
				$this->error("修改失败","?r=market/discount");
			}
		}
		return $this->render("upd_discount",[
			'model' => $discountForm,
			'oneInfo' => $oneInfo
		]);
	}

	/**
	*	添加折扣
	*/
	public function actionAdddiscount()
	{
		$discountForm = new DiscountForm();
		if($discountForm->load(Yii::$app->request->post()) && $discountForm->validate()){
			$discount = new Discount();
			if($discount->add_discount(Yii::$app->request->post())){	
				$this->success("添加成功","?r=market/discount");
			}else{
				$this->error("添加失败","?r=market/discount");die;
			}
		}
		return $this->render("add_discount",[
			'model'=>$discountForm	
		]);
	}

	/**
	*	单击修改折扣的状态
	*/
	public function actionChangedisocunt()
	{
		$discount = new Discount();
		$updre = $discount->ChangeOneShow(Yii::$app->request->get());
		if($updre){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	获取单条折扣数据的详细信息
	*/
	public function actionGetonediscount()
	{
		$discount = new Discount();
		$onediscount = $discount->getOneinfo(Yii::$app->request->get());
		$data = $this->renderpartial("getonediscount",[
			"model"=>$onediscount
		]);
		return $this->ajaxSuccess($data);
	}

	/**
	*	批量删除折扣
	*/
	public function actionDellalldiscount()
	{
		$discount = new Discount();
		$a = rtrim($_GET['str'],",");
		$str = explode(",",$a);
		$upddel = $discount->delmore($str);
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	 * @inheritdoc  满减管理
	 */
	public function actionSubtract()
	{
		$subtract = new Subtract();
		$subtractList = $subtract->select();
	    return $this->render('subtract',[
			'models'=>$subtractList	
		]);
	}
	/**
	*	删除满减
	*/
	public function actionDelsubtrace()
	{
		$subtract = new Subtract();
		if($subtract->delOne(Yii::$app->request->get("id"))){
			return $this->ajaxSuccess(1);
		} else {
			return $this->ajaxError(0);
			}	
	}

	/**
	*	添加满减
	*/
	public function actionAdd_subtract()
	{
		$subtractForm = new SubtractForm();
		$subtract = new Subtract();			//实例化模型（表单模型）
		if($subtractForm->load(Yii::$app->request->post()) && $subtractForm->validate()){
			if($subtract->add_subtract(Yii::$app->request->post())){
				$this->success("添加成功","?r=market/subtract");
			}else{
				$this->error("添加失败","?r=market/subtract");
			}
		}
		return $this->render('add_subtract',[
			'model'=>$subtractForm,
		]);
	}

	/**
	 * @inheritdoc  修改满减
	 */
	 public function actionUpd_subtract()
	{
		$subtractForm = new SubtractForm();
		$subtract = new Subtract();			//实例化模型（表单模型）
		$data = Yii::$app->request->get();
		$id = $data['id'];
		$oneInfo = $subtract->getOne($id);//获取要修改的数据信息
		if($subtractForm->load(Yii::$app->request->post()) && $subtractForm->validate()){	
			$updre = $subtract->update_subtract(Yii::$app->request->post(),$id);
			if($updre){
				$this->success("修改成功","?r=market/subtract");
			}else{
				$this->error("修改失败","?r=market/subtract");
			}
		}
		return $this->render('upd_subtract',[
			'model'=>$subtractForm,
			'oneInfo'=>$oneInfo
		]);
	}

	/**
	 * @inheritdoc  修改单条满减信息的显示状态
	 */
	 public function actionChangesubtract()
	{
		$subtract = new Subtract();
		$updre = $subtract->ChangeOneShow(Yii::$app->request->get());
		if($updre){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
    }

	/**
	*	获取单条满减的详情
	*/
	public function actionGetonesubtract()
	{
		$subtract = new Subtract();
		$onesubtract = $subtract->getOneinfo(Yii::$app->request->get());
		$data =  $this->renderpartial("getonesubtract",[
			"model"=>$onesubtract	
		]);
		return $this->ajaxSuccess($data);
	}
	 
	/**
	*	批量删除满减
	*/
	public function actionDellallsubtract()
	{
		$subtract = new Subtract();
		$a = rtrim($_GET['str'],",");
		$str = explode(",",$a);
		$upddel = $subtract->delmore($str);
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}
	 
	 /**
	 * @inheritdoc  满赠管理
	 */
	public function actionAdd()
	{	
		$add = new Add();//实例化model
		$addList = $add->select();
	    return $this->render('add',[
			'models'=>$addList,
		]);
	}

	/**
	 * @inheritdoc  删除满赠
	 */
	public function actionDel_add()
	{
		$add = new Add();
		if($add->delOne(Yii::$app->request->get("id"))){
			return $this->ajaxSuccess(1);
		} else {
			return $this->ajaxError(0);
		}	
	}

	/**
	*	@inheritdoc  修改满赠
	*/
	public function actionUpd_add()
	{
		$addForm = new AddForm();
		$gift = new Gift();
		$add = new Add();			//实例化模型（表单模型）
		$giftList= $gift->select();//查询赠品表数据
		$data = Yii::$app->request->get();
		$id = $data['id'];
		$oneInfo = $add->getOne($id);//获取要修改的数据信息
		if($addForm->load(Yii::$app->request->post()) && $addForm->validate()){
			$updre = $add->update_add(Yii::$app->request->post(),$id);
			if($updre){
				$this->success("修改成功","?r=market/add");
			}else{
				$this->error("修改失败","?r=market/add");
			}
		}
		return $this->render('upd_add',[
			'model'=>$addForm,
			'oneInfo'=>$oneInfo,
			'giftList'=>$giftList
		]);
	}

	/**
	*	@inheritdoc  添加满赠
	*/
	public function actionAdd_add()
	{
		$addForm = new AddForm();
		$gift = new Gift();
		$add = new Add();	//实例化模型（表模型）
		$giftList= $gift->select();//查询赠品表数据
		if($addForm->load(Yii::$app->request->post()) && $addForm->validate()){
			if($add->add_add(Yii::$app->request->post())){	
				$this->success("添加成功","?r=market/add");
			}else{
				$this->error("添加失败","?r=market/add");
			}
		}
		return $this->render("add_add",[
			'model' => $addForm,
			'giftList'=>$giftList
		]);
	}
	
	/**
	*	@inheritdoc 修改单条满赠数据的显示状态
	*/
	public function actionChangeadd()
	{
		$add = new Add();
		$updre = $add->ChangeOneShow(Yii::$app->request->get());
		if($updre){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	@inheritdoc  查询满赠的单条数据详情
	*/
	public function actionGetoneadd()
	{
		$add = new Add();
		$oneadd = $add->getOneinfo(Yii::$app->request->get());
		$data = $this->renderpartial("getoneadd",[
				"model"=>$oneadd
		]);
		return $this->ajaxSuccess($data);
	}

	/**
	*	批量删除满赠
	*/
	public function actionDellalladd()
	{	
		$add = new Add();
		$a = rtrim($_GET['str'],",");
		$str = explode(",",$a);
		$upddel = $add->delmore($str);
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	条件搜索满赠
	*/
	public function actionSeagift()
	{
		$sea=Yii::$app->request->get("sea");
		if($sea){
			$add = new Add();
			$addlist = $add->selectwhere($sea);
			return $this->renderpartial("seaadd",[
				'models'=>$addlist	
			]);
		}
	}

	/**
	 * @inheritdoc  优惠券管理
	 */
	public function actionCoupon()
	{
		$coupon = new Coupon();
		$couponList = $coupon->select();
	    return $this->render('coupon',[
			'coupon'=>$couponList
			]);
	}

	/**
	*	@inheritdoc  删除优惠券
	*/
	public function actionDelcoupon()
	{
		$coupon = new Coupon();
		if($coupon->delOne(Yii::$app->request->get("id"))){
			return $this->ajaxSuccess(1);
		} else {
			return $this->ajaxError(0);
		}	
	}

	/**
	*	@inheritdoc  添加优惠券
	*/
	public function actionAdd_coupon()
	{
		//查询所有菜单
		$menu = new Menu();
		$menuInfo = $menu->select();
		//查询所有菜单分类
		$series = new Series();
		$seriesInfo = $series->showall();
		$couponForm = new CouponForm();//实例化表单模型
		if($couponForm->load(Yii::$app->request->post()) && $couponForm->validate()){
			$coupon = new Coupon();
			if($coupon->addCoupon(Yii::$app->request->post())){

				$this->success("添加成功","?r=market/coupon");
			}else{

				$this->success("添加失败","?r=market/coupon");
			}
		}
		return $this->render("add_coupon",[
			'model'=>$couponForm,
			'menuList'=>$menuInfo,
			'seriesList'=>$seriesInfo
		]);
	}

	/**
	*	@inheritdoc  修改选中的优惠券数据
	*/
	public function actionUpd_coupon()
	{
		$data = Yii::$app->request->get();
		$id = $data['id'];				//获取提交数据
		$couponForm = new CouponForm();
		$coupon = new Coupon();			//实例化模型
		//查询所有菜单
		$menu = new Menu();
		$menuInfo = $menu->select();
		//查询所有菜单分类
		$series = new Series();
		$seriesInfo = $series->showall();
		$oneInfo = $coupon->getOne($id);//获取要修改的数据信息
		if($couponForm->load(Yii::$app->request->post()) && $couponForm->validate()){
			$updre = $coupon->update_coupon(Yii::$app->request->post(),$id);
			if($updre){
				$this->success("修改成功","?r=market/coupon");
			}else{
				$this->error("添加失败","?r=market/coupon");
			}
		}
		return $this->render('upd_coupon',[
			'model'=>$couponForm,
			'oneInfo'=>$oneInfo,
			'menuList'=>$menuInfo,
			'seriesList'=>$seriesInfo
		]);
	}

	/**
	*	@inheritdoc  单击修改单条优惠券的显示状态
	*/
	public function actionChangecoupon()
	{
		$coupon = new Coupon();
		$updre = $coupon->ChangeOneShow(Yii::$app->request->get());
		if($updre){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	@inheritdoc  单击获取选中的优惠详情
	*/
	public function actionGetonecoupon()
	{
		$coupon = new Coupon();
		$onecoupon = $coupon->getOneinfo(Yii::$app->request->get());
		$data = $this->renderpartial("getonecoupon",[
			"model"=>$onecoupon	
		]);
		return $this->ajaxSuccess($data);
	}

	/**
	*	@inheritdoc  批量删除优惠券
	*/
	public function actionDellallcoupon()
	{	
		$coupon = new Coupon();
		$a = rtrim($_GET['str'],",");
		$str = explode(",",$a);
		$upddel = $coupon->delmore($str);
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	@inheritdoc  条件搜索
	*/
	public function actionSeacoupon()
	{
		$sea=Yii::$app->request->get("sea");
		if($sea){
			$coupon = new Coupon();
			$coupon = $coupon->selectwhere($sea);
			$data = $this->renderpartial('seacoupon',[
			 'coupon' => $coupon,
			]);
			return $this->ajaxSuccess($data);
		}
	}

	/*
	*	@inheritdoc  赠品管理
	*/
	public function actionGift()
	{
		$gift = new Gift();
		$gift = $gift->select();
		return $this->render('gift',[
         'model' => $gift,
		]);
	}

	/**
	*	@inheritdoc  修改赠品显示状态
	*/
	public function actionChangegiftshows()
	{
		$gift = new Gift();
		$updre = $gift->ChangeOneShow(Yii::$app->request->get());
		if($updre){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/**
	*	@inheritdoc  删除赠品
	*/
	public function actionDelgift()
	{
		$gift = new Gift();
		$upddel = $gift->delone(Yii::$app->request->get());
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/*
	*	@inheritdoc  添加赠品
	*/
	public function actionAddgift()
	{
		$giftForm = new GiftForm();	
		if($giftForm->load(Yii::$app->request->post()) && $giftForm->validate())
		{
			//通过之后进行添加
			$gift = new Gift();
			if($gift->add_gift(Yii::$app->request->post())){
				$this->success("添加成功","?r=market/gift");
			}else{
				$this->error("添加失败","?r=market/addgift");
			}
		}
		return $this->render("add_gift",[
			'model'=>$giftForm	
		]);				
	}

	/**
	*	@inheritdoc  查询单条的详情
	*/
	public function actionGetonegift()
	{
		$gift = new Gift();
		$onegift = $gift->getOneinfo(Yii::$app->request->get());
		$data = $this->renderpartial("getonegift",[
			"model"=>$onegift	
		]);
		return $this->ajaxSuccess($data);
	}

	/**
	*	@inheritdoc  批量删除赠品
	*/
	public function actionDellallgift()
	{
		$gift = new Gift();
		$a = rtrim($_GET['str'],",");
		$str = explode(",",$a);
		$upddel = $gift->delmore($str);
		if($upddel){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	}

	/*
	*	@inheritdoc  修改选中的赠品
	*/
	public function actionUpdgift()
	{
		$data = Yii::$app->request->get();
		$id = $data['id'];				//获取提交数据
		$giftForm = new GiftupForm();
		$gift = new Gift();			//实例化模型
		$oneInfo = $gift->getOne($id);//获取要修改的数据信息
		if($giftForm->load(Yii::$app->request->post()) && $giftForm->validate()){
			$updre = $gift->update_gift(Yii::$app->request->post(),$id);
			if($updre){
				$this->success("修改成功","?r=market/gift");
			}else{
				$this->error("修改失败","?r=market/wallet");
			}
		}
		return $this->render("upd_gift",[
			'model' => $giftForm,	
			'oneInfo' => $oneInfo,
			"id"=>$id,
		]);
	}

	/*
	*	@inheritdoc  搜索满赠物品
	*/
	public function actionSeagiftinfo()
	{
		$sea=Yii::$app->request->get("sea");
		if($sea){
			$gift = new Gift();
			$gift = $gift->selectwhere($sea);
			$data = $this->renderpartial('seagift',[
			 'model' => $gift,
			]);
			return $this->ajaxSuccess($data);
		}
	}

	/**
	 * @inheritdoc  验证赠品名称
	 */
	 function actionCheckGift()
	{
		$data = Yii::$app->request->get();
		$model = new Gift();
		$re = $model -> checkname($data);
		if($re){
			return $this->ajaxSuccess(1);
		}else{
			return $this->ajaxError(0);
		}
	 }

}
