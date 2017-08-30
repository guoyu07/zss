<?php 
namespace frontend\controllers;

use yii;

use frontend\controllers\BaseController;
use frontend\models\Zssuser;



/*
 * 个人红包模块 代金券
 * */
class MywalletController extends BaseController{

	/*
	*我的红包首页
	*/
	public function actionIndex(){

	
		 //$cookies = $this->cookies();
		
		// $session = $this->session();

		//$openid = $cookies->get("username");

		// print_r($_SESSION);die;

		// echo $openid;die;

		$models =  new Zssuser(); 

		$userid = $_COOKIE["username"];
		
		$info = $models->mywallet($userid);

		$time =time();
		
		return $this->render("hongbao",["info"=>$info,"time"=>$time]);
	}


	/*
	*添加红包 
	*/
	public function actionAddwallet(){
		//获取session 取的用户id
		
		//$session = $this->session();

		//$openid = $session->get("username");	

		$models =  new Zssuser(); 

		//$userid = $models->userid($openid);
		$userid = $_COOKIE["username"];
		$number = yii::$app->request->get("number");

		

		if ($models->insertwallet($number,$userid)>0) {

			echo "<script> alert('添加成功');location.href='/web/index.php?r=mywallet/index'</script>";
			
			//header("location:/web/index.php?r=mywallet/index");


			//return $this->redirect(['index']);die;
		}else{

			echo "<script> alert('串码不存在或已过期');location.href='/web/index.php?r=mywallet/index'</script>";


			//Yii::$app->session->setFlash('error', '添加失败');

			//header("location:/web/index.php?r=mywallet/index");
		}

		
	}

	/*
	*我的代金券首页
	*/
	public function actionCoupon(){

			
		//获取session 取的用户id
		//$session = $this->session();

		//$openid = $session->get("username");	

		$models =  new Zssuser(); 

		//$userid = $models->userid($openid);

		$userid = $_COOKIE["username"];
		
		
		$info = $models->mycoupon($userid);

		$time =time();
		
		return $this->render("coupon",["info"=>$info,"time"=>$time]);
	}


	/*
	*添加代金券 
	*/
	public function actionAddcoupon(){
		//获取session 取的用户id
		
		//$session = $this->session();

		//$openid = $session->get("username");	

		$models =  new Zssuser(); 

		//$userid = $models->userid($openid);

		$userid = $_COOKIE["username"];
		$number = yii::$app->request->get("number");

		 

		if ($models->insertcoupon($number,$userid)>0) {
			
			echo "<script> alert('添加成功');location.href='/web/index.php?r=mywallet/coupon'</script>";

			//Yii::$app->session->setFlash('success', '添加成功');

			//header("location:/web/index.php?r=mywallet/coupon");
			//return $this->redirect(['coupon']);die;
		}else{

			echo "<script> alert('串码不存在或已过期');location.href='/web/index.php?r=mywallet/coupon'</script>";

			//Yii::$app->session->setFlash('error', '添加失败');

			//header("location:/web/index.php?r=mywallet/coupon");
		}

		
	}




}