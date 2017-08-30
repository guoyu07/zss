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
use backend\models\series\ShopMenu;

/**
 * 菜单功能模块
 * @author 王文秀
 */
class MenuController extends BaseController
{
  /**
  * @inheritdoc  菜单列表
  */
    public function actionList(){    
      $modelimg = new UploadForm();
      $modelt = new MenuForm();
      $model = new Series();
      $allser = $model->showall();//所有类别查询
      $models = new Menu();
      $menuAddInfo = Yii::$app->request->post("MenuForm"); 
      $menuAddInfo["menu_status"] = 1;
      $menuAddInfo["updated_at"] = time();
      $menuAddInfo["updated_id"] = $this->getUserid();
      /******修改菜品开始******/
      if (yii::$app->request->post()) {

        if ($modelt->load(yii::$app->request->post())&&$modelt->validate()) {
        $modelimg->imageFiles = UploadedFile::getInstances($modelimg, 'imageFiles');
        $allFeilName = $modelimg->upload();//文件上传
        $priID = yii::$app->request->post("menuid");//获取menu_id

        $ig = $_FILES;
          if ($ig["UploadForm"]["name"]["imageFiles"][0]!="") {//判断用户是否有修改图片
            print_r($_FILES);die;
            if ($allFeilName) {  // 文件上传成功
              /*
              *传入参数:
              *$source_path string 源图路径
              *$target_width integer 目标图宽度
              *$target_height integer 目标图高度
              *源图支持MIMETYPE: image/gif, image/jpeg, image/png.
              */  
              $source_path = "add/menu/";
              $small=array(array("width"=>"100","height"=>"155"),
              array("width"=>"50","height"=>"55"),
              array("width"=>"25","height"=>"30"));//图片规格设置 
                foreach ($small as $keyimg => $valueurl) {
                  foreach ($allFeilName as $ke => $val) {
                    //缩略图返回名称集      
                    $allurl[$ke][] = $this->fileSet("add/menu/",$val,$target_width=$valueurl["width"],$target_height=$valueurl["height"]);                        
                    }
                }
              $img = new Image();
              $ifok = $img->imgUrlck($priID,$allurl,$this->getUserid());//开始图片修改
              if($ifok){//图片修改成功开始修改菜品
                $menu = new Menu();
                //菜品修改
                if ($menu->fixinfo(yii::$app->request->post("menuid"),$menuAddInfo,$this->getUserid())) {
                  Yii::$app->session->setFlash('success', '修改成功');
                  return $this->redirect(['list']); 
                }else{
                  Yii::$app->session->setFlash('error', '修改失败');
                  return $this->redirect(['list']); 
                }
              }else{
                Yii::$app->session->setFlash('error', '图片修改失败');
                return $this->redirect(['list']); 
              }
            }
          }else{//没有图片修改
            $menu = new Menu();
            
            if ($menu->fixinfo(yii::$app->request->post("menuid"),$menuAddInfo,$this->getUserid())) {
              Yii::$app->session->setFlash('success', '修改成功');
              return $this->redirect(['list']);
            }
          }
        }else{
          $allerror = $modelt->errors;
          foreach ($allerror as $key => $value) {
            $error[] = $value[0];
          }
          Yii::$app->session->setFlash('error', $error[0]);
          return $this->redirect(['list']);
        }
      }
      /******修改菜品结束******/
      $allinfo = $models->showall();
      foreach ($allinfo as $key => $value) {
        $allinfo[$key]["start"] = date("y-m-d",$value["created_at"]);
        $allinfo[$key]["end"] = date("y-m-d",$value["updated_at"]);  
      }
     return $this->render('list',["allinfo"=>$allinfo,"allser"=>$allser,"model"=>$modelt,"modelimg"=>$modelimg]);
    }
  
    /**
     * @inheritdoc  菜单添加
     */
    public function actionAdd(){  
      $modelimg = new UploadForm();
      $model = new Series();
      $allser = $model->showall();//所有类别查询
      $modelt = new MenuForm();
      if($modelt->load(yii::$app->request->post())&&$modelt->validate()) {
        $modelimg->imageFiles = UploadedFile::getInstances($modelimg, 'imageFiles');
        $allFeilName = $modelimg->upload();//文件上传
        if ($allFeilName) {  // 文件上传成功
          /*
            *传入参数:
            *$source_path string 源图路径
            *$target_width integer 目标图宽度
            *$target_height integer 目标图高度
            *源图支持MIMETYPE: image/gif, image/jpeg, image/png.
          */  
            $source_path = "add/menu/";
            $small=array(array("width"=>"100","height"=>"155"),
                          array("width"=>"50","height"=>"55"),
                          array("width"=>"25","height"=>"30"));//图片规格设置 
            foreach ($small as $keyimg => $valueurl) {
              foreach ($allFeilName as $ke => $val) {
                //缩略图返回名称集      
                $allurl[$ke][] = $this->fileSet("add/menu/",$val,$target_width=$valueurl["width"],$target_height=$valueurl["height"]);                        
              }
            }               
          $menuAddInfo = Yii::$app->request->post("MenuForm"); 
          $menuAddInfo["menu_status"] = 1;
          $menuAddInfo["created_at"] = time();
          $menuAddInfo["updated_at"] = time();
          $menuAddInfo["updated_id"] = $this->getUserid();
          $menu = new Menu();
          if($menu->ckinfo($menuAddInfo["series_id"], $menuAddInfo["menu_name"])){
            Yii::$app->session->setFlash('error', '该类菜品已经存在');
            return $this->redirect(['add']); 
          }else{
            $priID = $menu->infoadd($menuAddInfo);//获取menu_id
            $img = new Image();
            $ifok = $img->imgUrlAdd($priID,$allurl,$this->getUserid());
              if($ifok) {
                Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['list']); 
              }else{
                $img->imgUrlAdd($priID,$allurl,$this->getUserid());//失败后循环继续添加
              }
          }
        }else{
          Yii::$app->session->setFlash('error', '文件上传出错~~');
          return $this->redirect(['add']); 
        }
      }
      return $this->render('add',["allser"=>$allser,"model"=>$modelt,"modelimg"=>$modelimg]);
    }

    /**
     * @inheritdoc  菜单删除
     */
     public function actionDel(){

        $id = yii::$app->request->post("id");

        if (!yii::$app->request->post("id")) {

           return False;

        }else{

            $model = new Menu;

            if($model->delone($id)){

                return True; 

            }else{

                return False;

            }
        }
    }


    /**
     * @inheritdoc  类别修改
     */
    public function actionFixinfo(){
      $seriesname = yii::$app->request->post("name");
      $seriessort = yii::$app->request->post("sort"); 
      $seriesid = yii::$app->request->post("id");
      $seriesstatus = yii::$app->request->post("price");
      $seriescontent = yii::$app->request->post("content");
      $arrinfo["menu_name"] =  $seriesname;
      $arrinfo["menu_id"] =  $seriesid;
      $arrinfo["menu_sort"] =  $seriessort;
      $arrinfo["menu_price"] =  $seriesstatus;
      $arrinfo["menu_introduce"] =  $seriescontent;
      $arrinfo["updated_at"] =  time();
      $arrinfo["updated_id"] =  $this->getUserid();
      $model = new Menu();
      $ctime = $model->oneinfo($seriesid);
      $arrinfo["created_at"] =  $ctime["created_at"];
      if($model->fixinfo($arrinfo)){
        Yii::$app->session->setFlash('success', '修改成功');
        return $this->redirect(['list']); 
      }else{    
          Yii::$app->session->setFlash('success', '该类菜品已经存在');
          return $this->redirect(['list']); 
      }
    }
    
    /**
     * @inheritdoc  菜品搜索
     */
    public function actionSearch(){
      if(!yii::$app->request->get("key")){
        Yii::$app->session->setFlash('error', '搜索内容不能为空');
        return $this->redirect(['list']); 
      }else{
        $model = new Menu;  
        $modelt = new Series;  
        $allser = $modelt->showall();//所有类别查询
        $key = yii::$app->request->get("key");
        $allinfo = $model->search($key);
        if($allinfo) {
          foreach ($allinfo as $key => $value) {
            $allinfo[$key]["start"] = date("y-m-d",$value["created_at"]);
            $allinfo[$key]["end"] = date("y-m-d",$value["updated_at"]);
          }
          return $this->render('list',["allser"=>$allser,"allinfo"=>$allinfo]);
        }else{
          Yii::$app->session->setFlash('error', '没有相关内容');
          return $this->redirect(['add']); 
        }
      }
     }

     /**
     * @inheritdoc  根据分类查询 菜
     */
    public function actionSeriesch(){
      $seriesid = yii::$app->request->post("id");
      $shopid = yii::$app->request->post("shopid");
      $model = new Menu();
      if($model->seriesch($seriesid)){
        $allinfo = $model->seriesch($seriesid);
        foreach ($allinfo as $key => $value) {
          $allinfo[$key]["start"] = date("y-m-d",$value["created_at"]);
          $allinfo[$key]["end"] = date("y-m-d",$value["updated_at"]);
        }
        header("content-type:application/json");
        print_r(json_encode($allinfo));  
      }else{
        echo 1;
      } 
    }

    /**
     * @inheritdoc  门店菜品展示 + 搜索功能
     */
    public function actionShopList(){
      $model = new ShopMenu();
      $username = Yii::$app->user->identity->id;
      $allinfo = $model->shopallid($username);
      if ($allinfo) {
        return  $this->render("myshop",["allinfo"=>$allinfo]);
      }else{
        return  $this->render("myshop",["allinfo"=>""]);
      }
      /*$search = yii::$app->request->get("search");
      $username = Yii::$app->user->identity->id;//获取session
      $model = new ShopMenu();
      $allinfo = $model -> shoplist($username,$search);
      return  $this->render("shoplist",["allinfo"=>$allinfo]);*/
    }

    /**
     * @inheritdoc  显示我的商店
     */
    public function actionListshop(){
      $shop_id = yii::$app->request->get("id");
      $search = yii::$app->request->get("search");
      $username = Yii::$app->user->identity->id;//获取session
      $model = new ShopMenu();
      $allinfo = $model -> shoplist($username,$search,$shop_id);
     
      return  $this->render("shoplist",["allinfo"=>$allinfo,"shop_id"=>$shop_id]);
    }

    /**
     * @inheritdoc  删除我的商店菜品
     */
    public function actionDelshopmenu(){
      $model = new ShopMenu();
      $id = yii::$app->request->get("id");
      $type = yii::$app->request->get("type");
      $post = yii::$app->request->get("post");
      if(!$type){
        if($model->DelShopMenu($id)){
          return True;die;
        }else{
          return True;die;
        }
      }else{
        if($model->DelShopMenu($id)){
          return True;die;
        }else{
          return false; die;   
        }
      }
    }

    /**
     * @inheritdoc  菜品添加展示
     */
    public function actionShopMenuAdd(){
      $username = Yii::$app->user->identity->id;//获取session
      $shopid = yii::$app->request->get("id"); 
      $model = new ShopMenu(); 
      $allinfo = $model->othermenu($username,$shopid);
      return $this->render('shop-menu-add',["allinfo"=>$allinfo,"shopid"=>$shopid]);  
    } 

    /**
     * @inheritdoc  查询菜品
     */
    public function actionMenusearch(){
      $username = $this->getUserid();
      $series_id =  yii::$app->request->post("id");
      $shopid =  yii::$app->request->post("shopid");
      $model = new ShopMenu(); 
      $allinfo = $model->Menusearch($series_id,$username,$shopid);
      if($allinfo) {
        header("content-type:application/json");
        print_r(json_encode($allinfo));   
      }else{
        echo 1;
      }
    }

    /**
     * @inheritdoc  添加店家菜
     */
    public function actionShopMenuAddInfo(){
      $username = Yii::$app->user->identity->id;//获取session
      $menu_id = yii::$app->request->get("id");
      $shopid = yii::$app->request->get("shopid");
      $newmenu_id = explode(",",$menu_id); 
      $model = new ShopMenu(); 
      if($model->ShopMenuAddInfo($username,$newmenu_id,$shopid)){
        Yii::$app->session->setFlash('success', '添加成功');
      }else{
        Yii::$app->session->setFlash('error', '添加失败');
      }
      return $this->redirect(['shop-menu-add']);   
    }

    /**
     * @inheritdoc  显示请求
     */
    public function actionFindUrlInfo(){
        if (yii::$app->request->get()) {
          return true;
        }else{
          return false;
        }
    }

    /**
     * @inheritdoc  显示请求
     */
    public function actionFindDiscountInfo(){
      $discountnum = yii::$app->request->post("discountnum");
      $model = new ShopMenu(); 
      $discountinfo = $model->FindDiscountInfo();
      $option = "";
      $option .= "<select name='discount_id'>";
      foreach ($discountinfo as $key => $value) {
        if($value->discount_num==$discountnum){
          $option .= "<option   value='".$value->discount_id."' selected=true>".$value->discount_num."</option>"; 
        }else{
          $option .= "<option value='".$value->discount_id."'>".$value->discount_num."</option>";
        }
      }
      $option .="</select>";
      print_r($option);
    }

    /**
     * @inheritdoc  打折
     */
    public function actionChangeDiscount(){
      $model = new ShopMenu(); 
      $typeid = yii::$app->request->get("id");
      $allid = yii::$app->request->get("type");
      $discount = yii::$app->request->get("discount");
      $shopid = yii::$app->request->get("shopid");
      $username = $this->getUserid();
      if ($typeid && $discount) {
        if ($typeid==1) {//类别折扣
          $allinfo = $model->SeriesShoutDiscount($allid,$username,$discount,$shopid);
          echo $allinfo;die;      
        }
        if ($typeid==2) {//全店折扣
          if (!$discount) {
            echo -5;die;
          }
          $allinfo = $model->ShopShoutDiscount($username,$discount,$shopid);
          echo $allinfo;die;    
        }
        if ($typeid==3) {//部分折扣    
          $allid = yii::$app->request->get("allinfo");
          $allinfo = $model->MoreShoutDiscount($username,$discount,$allid,$shopid);
          echo $allinfo;die;
        }
      }else{
        echo -5;die;
      }
    }

    /**
     * @inheritdoc  商店菜品修改
     */
    public function actionShopmenufixinfo(){
      $model = new ShopMenu(); 
      $username = $this->getUserid();
      if(strlen(yii::$app->request->post("menu_desc"))>20){
        Yii::$app->session->setFlash('error', '时间格式不对');
        return $this->redirect(['shop-list']); 
      }
      if((yii::$app->request->post("menu_stock")+0)>10000){
        Yii::$app->session->setFlash('error', '库存量太大');
        return $this->redirect(['shop-list']); 
      }
      if(yii::$app->request->post()){
        $arr["menu_desc"] = yii::$app->request->post("menu_desc");  
        $arr["is_show"] = yii::$app->request->post("is_show");  
        $arr["discount_id"] = yii::$app->request->post("discount_id");
        $arr["menu_stock"] = yii::$app->request->post("menu_stock");
        $arr["updated_id"] = $username;
        $arr["updated_at"] = time();
        $id = yii::$app->request->post("id");
        if($model->Shopmenufixinfo($arr,$id,$this->getUserid())){
          Yii::$app->session->setFlash('success', '修改成功');
        }
      }else{
        Yii::$app->session->setFlash('error', '修改内容有错！··');
      }
      return $this->redirect(['shop-list']); 
    }
    /**
     * @inheritdoc  即点即改
     */
    public function actionFixnow()
    {
      $id = yii::$app->request->post("id");
      $status = yii::$app->request->post("status");
      $model = new ShopMenu(); 
      if (!$model->fixnow($id,$status)) {
          return false;
      }else{
        return true;
      }

    }

    /**
     * @inheritdoc  详情显示改
     */
    public function actionFixmenuinfo()
    {
      $modelt = new MenuForm();
      $model = new Series();
      $allser = $model->showall();//所有类别查询
      $models = new Menu();
      $modelimg = new UploadForm();

      /******修改菜品开始******/
      /*if ($modelt->load(yii::$app->request->post())&&$modelt->validate()) {
          $modelimg->imageFiles = UploadedFile::getInstances($modelimg, 'imageFiles');
          $allFeilName = $modelimg->upload();//文件上传
          if ($allFeilName) {  // 文件上传成功*/
            /*
            *传入参数:
            *$source_path string 源图路径
            *$target_width integer 目标图宽度
            *$target_height integer 目标图高度
            *源图支持MIMETYPE: image/gif, image/jpeg, image/png.
            */  
            /*$source_path = "add/menu/";
            $small=array(array("width"=>"100","height"=>"155"),
                 array("width"=>"50","height"=>"55"),
                 array("width"=>"25","height"=>"30"));//图片规格设置 
            foreach ($small as $keyimg => $valueurl) {
              foreach ($allFeilName as $ke => $val) {
                //缩略图返回名称集      
                $allurl[$ke][] = $this->fileSet("add/menu/",$val,$target_width=$valueurl["width"],$target_height=$valueurl["height"]);                        
              }
            }
          }   
        $menuAddInfo = Yii::$app->request->post("MenuForm"); 
        $menuAddInfo["menu_status"] = 1;
        $menuAddInfo["updated_at"] = time();
        $menuAddInfo["updated_id"] = $this->getUserid();
        $menu = new Menu();
        print_r($menuAddInfo);die;
        $menu->fixinfo(yii::$app->request->post("menuid"),$menuAddInfo);//菜品修改
        $priID = yii::$app->request->post("menuid");//获取menu_id
        $img = new Image();
        $ifok = $img->imgUrlck($priID,$allurl,$this->getUserid());//开始图片修改
        if ($ifok) {
          Yii::$app->session->setFlash('success', '修改成功');
          return $this->redirect(['list']);   
        }else{
          $img->imgUrlAdd($priID,$allurl,$this->getUserid());//失败后循环继续添加
        }
      }*/
    /*******修改菜品结束******/
      $info = yii::$app->request->post();

      return $this->render("fixmenuinfo",["info"=> $info,"allser"=>$allser,"model"=>$modelt,"modelimg"=>$modelimg]);
    }

     /**
     * @inheritdoc  门店菜品详情显示
     */
    public function actionShopmenuinfoshow()
    {
      $allinfo = yii::$app->request->post();
      return $this->render("shopmenuallinfo",["allinfo"=>$allinfo]);
    }

    public function actionMenuallinfo()
    {

      $allinfo = yii::$app->request->post();
      return $this->render("menuinfo",["allinfo"=>$allinfo]);
    }
}
