<?php 
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\base\Controller;
use backend\models\series\Series;
use backend\models\series\SeriesForm;
use backend\models\series\ShopMenu;
use backend\models\series\UploadForm;
/**
 * 类别功能模块
 * @author 王文秀
 */
class SeriesController extends BaseController{


    /*
     * 名厨列表
     * */
    public function actionList(){
      $model = new Series;
      $modelForm = new SeriesForm;
      $img = new UploadForm;


      if (yii::$app->request->post()) {//判断是否添加  
        if ($modelForm->load(yii::$app->request->post())&&$modelForm->validate()) {
          $postall= yii::$app->request->post();
          $seriesname = $postall["SeriesForm"]["series_name"];
          $seriessort = $postall["SeriesForm"]["series_sort"];
          if(!$model->checkinfo($seriesname)){//判断成功
            $arrinfo["series_name"] =  $seriesname;
            $arrinfo["series_sort"] =  $seriessort;
            $arrinfo["series_status"] =  1;
            $arrinfo["created_at"] =  time();
            $arrinfo["updated_at"] =  time();
             $arrinfo["img1"] = "upload1.jpg";
             $arrinfo["img2"] = "upload1.jpg";
             $arrinfo["img3"] = "upload1.jpg";
            $arrinfo["updated_id"] =  $this->getUserid();
            if($model->addinfo($arrinfo)){
              Yii::$app->session->setFlash('success', '添加成功');
            }else{
              Yii::$app->session->setFlash('error', '添加失败');
            }
          }else{
            Yii::$app->session->setFlash('error', '不能重复添加');
          }
        }else{
          $aller = $modelForm->errors;
          foreach ($aller as $key => $value) {
            $error[] = $value[0];
          }
          Yii::$app->session->setFlash('error', $error[0]);
        }
        return $this->redirect(['list']);   
      }
      $allinfo = $model->showall();//获取所有数据
      foreach ($allinfo as $key => $value) {
        $allinfo[$key]["start"] = date("y-m-d",$value["created_at"]);
        $allinfo[$key]["end"] = date("y-m-d",$value["updated_at"]);
      }


      return $this->render('list',["allinfo"=>$allinfo,"model"=>$modelForm,"modelimg"=>$img]);
    }
    
    /**
     * @inheritdoc 删除分类
     */
    public function actionDel(){
      $id = yii::$app->request->post("id");
      $models = new ShopMenu;
      if ($models->isOk($id)) {
        echo 1;die;
      }
      if (!yii::$app->request->post("id")) {
        echo 3;die;
      }else{
        $model = new Series;
        if($model->delone($id)){
          echo 2;die;
        }else{
          echo 3;die;
        }
      }
    }

    /**
     * @inheritdoc 类别修改
     */
    public function actionFixinfo(){
      $seriesname = yii::$app->request->post("name");
      $seriessort = yii::$app->request->post("sort"); 
      $seriesid = yii::$app->request->post("id");
      $seriesstatus = yii::$app->request->post("isshow");
      if($seriessort>9999|| strlen($seriesname)>50){
        Yii::$app->session->setFlash('error', '排序值太大或类别名字太长');
        return $this->redirect(['list']);  die; 
      }
      if (empty($seriessort)||empty($seriesname)) {
        Yii::$app->session->setFlash('error', '不能为空');
        return $this->redirect(['list']);  die; 
      }
      $arrinfo["series_name"] =  $seriesname;
      $arrinfo["series_id"] =  $seriesid;
      $arrinfo["series_sort"] =  $seriessort;
      $arrinfo["series_status"] =  $seriesstatus;
      $arrinfo["updated_at"] =  time();
      $arrinfo["updated_id"] =  $this->getUserid();
      $model = new Series;
      $ctime = $model->oneinfo($seriesid);
      $arrinfo["created_at"] =  $ctime["created_at"];
      if($model->fixinfo($arrinfo)){
        Yii::$app->session->setFlash('success', '修改成功');
      }else{
        Yii::$app->session->setFlash('error', '修改失败');
      }
      return $this->redirect(['list']);   
    }

    /**
     * @inheritdoc 类别搜索
     */
    public function actionSearch(){
      if(!yii::$app->request->get("key")){
        Yii::$app->session->setFlash('error', '搜索内容不能为空');
      }else{
        $model = new Series;  
        $key = yii::$app->request->get("key");
        $allinfo = $model->search($key);
        if ($allinfo) {
          foreach ($allinfo as $key => $value) {
            $allinfo[$key]["start"] = date("y-m-d",$value["created_at"]);
            $allinfo[$key]["end"] = date("y-m-d",$value["updated_at"]);
          }
          return $this->render('list',["allinfo"=>$allinfo]);  
        }else{
          Yii::$app->session->setFlash('error', '没有相关内容');
        }
      }
      return $this->redirect(['list']);   
    }

    /**
     * @inheritdoc 即点即改
     */
    public function actionFixnow(){
      $id = yii::$app->request->post("id");
      $status = yii::$app->request->post("status");
      $model = new Series(); 
      if (!$model->fixnow($id,$status)) {
          return false;
      }else{
        return true;
      }
    }

    //类别图片啊修改 图片1
    public function actionFiximg1()
    {
      
       $id = yii::$app->request->post("sid");

       $file=$_FILES['upfile'];
      
       $name=rand(0,500000).dechex(rand(0,10000)).".jpg";
      
       $re = move_uploaded_file($file['tmp_name'],Yii::$app->basePath."/web/add/imges/".$name);
      
       $model = new Series(); 

       if (!$model->fiximg1($id,$name)) {
            echo "<script>parent.stopSend('$name')</script>";
      }else{
          echo "<script>parent.stopSend('$name')</script>";
      }


    }

    //类别图片啊修改 图片2
    public function actionFiximg2()
    {

       $id = yii::$app->request->post("sid");

       $file=$_FILES['upfile'];
      
       $name=rand(0,500000).dechex(rand(0,10000)).".jpg";
      
       move_uploaded_file($file['tmp_name'],Yii::$app->basePath."/web/add/imges/".$name);
      
       $model = new Series(); 

       if (!$model->fiximg2($id,$name)) {
             echo "<script>parent.stopSend('$name')</script>";
              }else{
       
         echo "<script>parent.stopSend('$name')</script>";
      }

    }

      //类别图片啊修改 分类图片3
    public function actionFiximg3()
    {

       $id = yii::$app->request->post("sid");

       $file=$_FILES['upfile'];
      
       $name=rand(0,500000).dechex(rand(0,10000)).".jpg";
      
       move_uploaded_file($file['tmp_name'],Yii::$app->basePath."/web/add/imges/".$name);
      
       $model = new Series(); 

       if (!$model->fiximg3($id,$name)) {
             echo "<script>parent.stopSend('$name')</script>";
              }else{
       
         echo "<script>parent.stopSend('$name')</script>";
      }
    }



}
?>