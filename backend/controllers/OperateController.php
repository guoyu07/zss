<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\order\Order;
use backend\models\menu\Menu;
use backend\models\shop\Shop;
use backend\models\series\Series;
use backend\models\operate\StatShop;
use backend\models\operate\StatMenu;
use backend\models\operate\StatSeries;
use app\assets\PHPExcel;
use common\components\CreateExcel;
use yii\data\Pagination;
use yii\web\UploadedFile;

/**
 * 运营功能模块
 * @author 王文秀
 */

class OperateController extends BaseController
{
	/**
	 * @inheritdoc  财务统计管理
	 */
	public function actionIndex()
	{
	    //判断昨天是否生成记录
		$date = date("Y-m-d",strtotime("-1 day"));
	    $statshop = new StatShop();
	    $status = $statshop->find_one(['created_at'=>$date]);
	    //未生成 生成至门店财务统计表中
	    if(empty($status)){
			$order = new Order();
	    	$order->stat_shop($date);
	    }
    	$list = $statshop->find_all('*',['>','created_at',date("Y-m-d",strtotime("-8 day"))]);
		//折线图
		$data = $statshop->line_chart($list);
		$data['stat_shop'] = $list;
		$data['date'] = $date;
		return $this->render('shop_list',$data);
	}
    /**
	 * @inheritdoc  门店统计搜索
	 */
  	public function actionShopSearch(){
    	$start_time = \Yii::$app->request->post('start_time');
    	$end_time = \Yii::$app->request->post('end_time');
		$word = \Yii::$app->request->post('word','');
		//验证
		if(strlen($word) > 30){
			return "<script>alert('搜索内容过长！');location.href=document.referrer;</script>";
		}
    	$statshop = new StatShop();
		$list = $statshop->search($start_time,$end_time,$word);
		//折线图
		$data = $statshop->line_chart($list);
		$data['stat_shop'] = $list;
    	return $this->renderPartial('shop_search',$data);
  	}

	/**
	* @inheritdoc  门店Excel导出
	*/
	public function actionExcelShop(){
		$excel = \Yii::$app->request->post('excel');
		$data = json_decode($excel,true);
		if(empty($data)){
			return "<script>alert('无导出内容！');location.href=document.referrer;</script>";
		}
		$filename = '门店财务统计';
		$th = array('序号','门店','门店地址','门店电话','销售额','赠品支出','营业额','统计时间');
		$excel = new CreateExcel();
		$excel->createByArray($data,$filename,$th);
	}

	/**
	* @inheritdoc  门店财务数据更新
	*/
	public function actionShopCreat(){
		$start_time = \Yii::$app->request->post('start_time');
		$end_time = \Yii::$app->request->post('end_time');
		//验证
		if(!strtotime($start_time) || !strtotime($end_time)){
			return "<script>alert('请输入正确的时间格式！');location.href=document.referrer;</script>";
		}
		$order = new Order();
		//循环进行逐天更新
		for($i = strtotime($start_time);$i <= strtotime($end_time);$i += 60*60*24){
			$result = $order->stat_shop(date('Y-m-d',$i));
		}
		if(!$result){
			echo "<script>layer.msg('更新成功')</script>";
		}
		//查询 显示
		$statshop = new StatShop();
		$list = $statshop->find_all();
		//折线图
		$data = $statshop->line_chart($list);
		$data['stat_shop'] = $list;
		return $this->renderPartial('shop_search',$data);
	}

	/**
	* @inheritdoc  门店本日详情
	*/
  	public function actionShopDetail(){
    	$shop_name = \Yii::$app->request->get('shop_name');
		$date = \Yii::$app->request->get('date');
		//搜索当前门店信息
		$shop = new Shop();
		$shop_id = $shop->find_id($shop_name);
		$shop_info = $shop->shop_infos(['*'],['shop_id'=>$shop_id]);
		//当前门店类型
		$types = $shop->type($shop_id);

		//本日本店各分类营业额饼图
		$statseries = new StatSeries();
		$pie_series_chart = $statseries->pie_shop_series_chart($shop_id,$date);

		//本日本店各菜品营业额饼图
		$statmenu = new StatMenu();
		$pie_menu_chart = $statmenu->pie_shop_menu_chart($shop_id,$date);
		//同意赋值传递
		$data['pie_series_chart'] = $pie_series_chart;
		$data['pie_menu_chart'] = $pie_menu_chart;
		$data['shop'] = $shop_info;
		$data['types'] = $types;
		$data['date'] = $date;
		return $this->render('shop_detail',$data);
  	}

  	/**
	 * @inheritdoc  菜单数据统计
	 */
  	public function actionStatMenu(){
		//判断昨天是否生成记录
		$date = date("Y-m-d",strtotime("-1 day"));
	    $statmenu = new StatMenu();
	    $status = $statmenu->find_one(['created_at'=>$date]);
	    //未生成 生成至门店财务统计表中
	    if(empty($status)){
			$order = new Order();
	    	$order->stat_menu($date);
	    }
	    $list = $statmenu->find_all(['*'],['>','created_at',date("Y-m-d",strtotime("-8 day"))]);
		//折线图
		$data = $statmenu->line_chart($list);
		$data['stat_menu'] = $list;
		$data['date'] = $date;
    	return $this->render('menu_list',$data);
	}

	/**
   	* @inheritdoc  菜单数据更新
   	*/
  	public function actionMenuCreat()
  	{
		$start_time = \Yii::$app->request->post('start_time');
		$end_time = \Yii::$app->request->post('end_time');
		//验证
		if(!strtotime($start_time) || !strtotime($end_time)){
			return "<script>alert('请输入正确的时间格式！');location.href=document.referrer;</script>";
		}
		$order = new Order();
		//循环进行逐天更新
		for($i = strtotime($start_time);$i <= strtotime($end_time);$i += 60*60*24){
			$result = $order->stat_menu(date('Y-m-d',$i));
		}
		if(!$result){
			echo "<script>layer.msg('更新成功')</script>";
		}
		//查询 显示
		$statmenu = new StatMenu();
		$list = $statmenu->find_all();
		//折线图
		$data = $statmenu->line_chart($list);
		$data['stat_menu'] = $list;
    	return $this->renderPartial('menu_search',$data);
	}

	/**
	 * @inheritdoc  菜品搜索
	 */
	public function actionMenuSearch(){
	    $start_time = \Yii::$app->request->post('start_time');
		$end_time = \Yii::$app->request->post('end_time');
		//赋初值
		$word = \Yii::$app->request->post('word','');
		//验证
		if(strlen($word) > 30){
			return "<script>alert('搜索内容过长！');location.href=document.referrer;</script>";
		}
		$statmenu = new StatMenu();
		$list = $statmenu->search($start_time,$end_time,$word);
		//折线图
		$data = $statmenu->line_chart($list);
		$data['stat_menu'] = $list;
		return $this->renderPartial('menu_search',$data);
	}

	/**
   * @inheritdoc  菜单Excel导出
   */
	public function actionMenuExcel(){
		$excel = \Yii::$app->request->post('excel');
		$data = json_decode(htmlspecialchars_decode($excel),true);
		if(empty($data)){
			return "<script>alert('无导出内容！');location.href=document.referrer;</script>";
		}
		$filename = '菜品数据统计';
		$th = array('序号','菜品名称','厨师名称','菜品单价','售出数量','菜品销量总额','菜品评价','销售状态','统计时间');
		$excel = new CreateExcel();
		$excel->createByArray($data,$filename,$th);
	}

	/**
   * @inheritdoc  菜品本日详情
   */
	public function actionMenuDetail(){
		$menu_name = \Yii::$app->request->get('menu_name');
		$series_name = \Yii::$app->request->get('series_name');
		$date = \Yii::$app->request->get('date');
		//搜索当前菜品信息
		$menu = new Menu();
		$menu_info = $menu->menu_infos(['menu_id','menu_name','menu_code','menu_price','series_name'],['menu_name'=>$menu_name,'series_name'=>$series_name]);
		$statshop = new StatShop();
		//该菜品各门店营业额分析饼图
		$pie_menu_chart = $statshop->pie_menu_shop_chart($menu_info['menu_id'],$date);
		//该菜品配送类型营业额分析饼图
		$pie_menu_type_chart = $statshop->pie_menu_type_chart($menu_info['menu_id'],$date);
		print_r($pie_menu_type_chart);die;
		$data['pie_menu_chart'] = $pie_menu_chart;
		$data['menu_info'] = $menu_info;
		$data['pie_menu_type_chart'] = $pie_menu_type_chart;
		$data['date'] = $date;
		return $this->render('menu_detail',$data);
	}

	/**
	 * @inheritdoc  分类统计管理
	 */
	public function actionSeries(){
		//判断昨天是否生成记录
		$date = date("Y-m-d",strtotime("-1 day"));
		$statseries = new StatSeries();
		$status = $statseries->find_one(['created_at'=>$date]);
		//未生成 生成至分类统计表中
		if(empty($status))
		{
			$order = new Order();
			$order->stat_series($date);
		}
		$list = $statseries->find_all('*',['>','created_at',date("Y-m-d",strtotime("-8 day"))]);
		$data = $statseries->line_chart($list);
		//折线图
		$data['stat_series'] = $list;
		$data['date'] = $date;
		return $this->render('series_list',$data);
	}

	/**
	 * @inheritdoc  分类统计搜索
	 */
	public function actionSeriesSearch(){
		$start_time = \Yii::$app->request->post('start_time');
		$end_time = \Yii::$app->request->post('end_time');
		$word = \Yii::$app->request->post('word','');
		//验证
		if(strlen($word) > 30){
			return "<script>alert('搜索内容过长！');location.href=document.referrer;</script>";
		}
		$statseries = new StatSeries();
		$list = $statseries->search($start_time,$end_time,$word);
		//折线图
		$data = $statseries->line_chart($list);
		$data['stat_series'] = $list;
		return $this->renderPartial('series_search',$data);
	}

  /**
   * @inheritdoc  分类Excel导出
   */
	public function actionExcelSeries(){
		$excel = \Yii::$app->request->post('excel');
		$data = json_decode($excel,true);
		if(empty($data)){
			return "<script>alert('无导出内容！');location.href=document.referrer;</script>";
		}
		$filename = '分类统计';
		$th = array('序号','分类名称','营业额','统计时间');
		$excel = new CreateExcel();
		$excel->createByArray($data,$filename,$th);
	}

	/**
   * @inheritdoc  分类数据更新
   */
	public function actionSeriesCreat()
	{
		$start_time = \Yii::$app->request->post('start_time');
		$end_time = \Yii::$app->request->post('end_time');
		//验证
		if(!strtotime($start_time) || !strtotime($end_time)){
			return "<script>alert('请输入正确的时间格式！');location.href=document.referrer;</script>";
		}
		$order = new Order();
		//循环进行逐天更新
		for($i = strtotime($start_time);$i <= strtotime($end_time);$i += 60*60*24){
			$result = $order->stat_series(date('Y-m-d',$i));
		}
		if(!$result){
			echo "<script>layer.msg('更新成功')</script>";
		}
		//查询 显示
		$statseries = new StatSeries();
		$list = $statseries->find_all();
		//折线图
		$data = $statseries->line_chart($list);
		$data['stat_series'] = $list;
		return $this->renderPartial('series_search',$data);
  }

	/**
   * @inheritdoc  菜品本日详情
   */
	public function actionSeriesDetail(){
		$series_name = \Yii::$app->request->get('series_name');
		$date = \Yii::$app->request->get('date');
		//搜索当前菜品信息
		$series = new Series();
		$series_id = $series->series_id(['series_name'=>$series_name]);
		$statseries = new StatSeries();
		//该菜品各门店营业额分析饼图
		$pie_menu_chart = $statseries->pie_series_menu_chart($series_id,$date);
		//该菜品配送类型营业额分析饼图
		$pie_shop_chart = $statseries->pie_series_shop_chart($series_id,$date);
		//各菜品营业额分析饼图
		//$pie_series = $statseries->pie_series_chart($series_name,$date);
		$data['series_name'] = $series_name;
		$data['pie_menu_chart'] = $pie_menu_chart;
		$data['pie_shop_chart'] = $pie_shop_chart;
		$data['date'] = $date;
		return $this->render('series_detail',$data);
	}
}
