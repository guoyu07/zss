<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use backend\models\Upload;
use backend\models\system\Group;
use app\models\system\Carousel;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\Pagination;
use frontend\models\user\Rebate;
use backend\models\system\Recharge;
use backend\models\system\Takeout;

/**
 * 系统功能模块
 * @author 王文秀
 */
class SystemController extends BaseController
{
    public $img_format = array('wx'=>array('width'=>'400','height'=>'140'),'pc'=>array('width'=>'600','height'=>'200'),'original'=>array('width'=>'500','height'=>'300'));
    
	/*
	 * @inheritdoc   轮播图列表
	 * 
	 * */
	public function actionImagelist(){
	    $carousel = new Carousel();   //实例化轮播图片类
	    $cdata=$carousel->carousel_list();   //调用方法查询相关数据
	    return $this->render('imagelist',array('cdata'=>$cdata)); //渲染视图
	}

	/**
	 *  @inheritdoc   轮播图添加
	 */
	public function actionImage(){
	    $upload = new UploadForm();
	    $carousel = new Carousel(); 
	    $group = new Group();
	    //获取所有符合条件的轮播组
	    $group_all = $group->findCon();
	    //获取修改人id
	    $updated_id = isset(yii::$app->user->identity->id) ? yii::$app->user->identity->id : null;
	    //如果post数据,判断是否登录
	    if(Yii::$app->request->Ispost && $updated_id != null) {
	        //加载验证表单
	        if($carousel->load(yii::$app->request->post()) && $carousel->validate()){
    	        $upload->file = UploadedFile::getInstance($upload, 'file');
                if ($upload->file && $upload->validate()) {
                    //执行图片上传
                   $file_upload_return=$upload->imageupload($upload);
                   //上传成功
                   if($file_upload_return){
                       //调用公共方法,执行缩略图
                       foreach ($this->img_format as $ik=>$iv){
                           $imagelist['carousel_'.$ik] = dirname($file_upload_return).'/'.$this->fileSet(dirname($file_upload_return).'/',basename($file_upload_return),$iv['width'],$iv['height']);
                       }
                       //生成缩略图成功
                       if($imagelist){
                           unlink($file_upload_return);  //删除原有的图片
                           //数据入库
                           $save_status=$carousel->imagesave($imagelist,$updated_id);
                           if($save_status){    //判断数据保存状态
                               Yii::$app->session->setFlash('success','上传成功！');
                               return $this->render('image', ['upload' => $upload,'group'=>$group_all,'carousel' => $carousel]);
                           }
                       }
                   }
                } 
	       }
	   }
	    return $this->render('image', ['upload' => $upload,'group'=>$group_all,'carousel' => $carousel]);
	}

	
	
	/*
	 * @inheritdoc   轮播图修改
	 * */
	public function actionImageedit(){
	    $carousel = new Carousel();    //实例化轮播图类
	    $upload = new UploadForm();        //实例化上传类
	    $group = new Group();  //查询轮播图分类
	    $request = Yii::$app->request;
	    $id = $request->get('id');
	    //如果没有id,返回列表选择修改对象
	    if(!$id){
	        $this->redirect('index.php?r=system/imagelist');
	    }
	    $updated_id = isset(yii::$app->user->identity->id) ? yii::$app->user->identity->id : null;
	    if(yii::$app->request->post()){
	    	if ($request->isPost && $updated_id != null) {
	        	$upload->file = UploadedFile::getInstance($upload, 'file');
        		if($upload->file){
           			$file_upload_return=$upload->imageupload($upload);
            		$old_image_path = $request->post('hidden_img');  //旧图片地址
            		if($file_upload_return){
                		//调用公共方法,执行缩略图
                		foreach ($this->img_format as $ik=>$iv){
                    		$imagelist['carousel_'.$ik] = dirname($file_upload_return).'/'.$this->fileSet(dirname($file_upload_return).'/',basename($file_upload_return),$iv['width'],$iv['height']);
                		}
            		}
        		}else{
            		$imagelist = 0;
        		}
     
        		$old_img = Carousel::find()->select(['carousel_original','carousel_pc','carousel_wx'])->where("carousel_id=$id")->asArray()->One();
        		//验证数据
		        if($carousel->load(yii::$app->request->post())){
		            $save_status=$carousel->imageupdate($imagelist,$id,$updated_id);   //数据更新入库
		        }
		        if($save_status && $imagelist){   //清理原来的图片物理存储
		            foreach ($old_img as $ik=>$iv){
		                if(file_exists($iv)){
		                    unlink($iv);
		                }
		            }
		            unlink($file_upload_return);
		        }
            	return $this->redirect('index.php?r=system/imagelist');
			}
	   	}
	    $result = $carousel -> image_sel($id);
	    $group_all = $group->findCon($result['group_id']);
	    
	    return $this->render('imageedit',['id' => $id,'result' => $result,'carousel' => $carousel,'group' => $group_all,'upload' =>$upload]);
	  }
	
	
	/*
	 * @inheritdoc   轮播图删除
	 * */
	public function actionImgdel(){
	    $gid=yii::$app->request->get('iid');  //接收参数
	    if($gid){
	        $fdata=Carousel::find()->where("carousel_id=$gid")->one();
	        if($fdata){
	            if(is_file($fdata['carousel_original'])){
	                unlink($fdata['carousel_original']);
	            }
	            if(is_file($fdata['carousel_pc'])){
	                unlink($fdata['carousel_pc']);
	            }
	            if(is_file($fdata['carousel_wx'])){
	                unlink($fdata['carousel_wx']);
	            }
	        }
	    }
	    echo $fdata->delete()?1:0;
	}
	
	
	/*
	 * 轮播图批量删除
	 * 
	 * */
	public function actionImgdelcheck(){
	    $iid = \yii::$app->request->get('iid');
	    if(Carousel::deleteAll("carousel_id in ($iid)")){
	        return $this->ajaxSuccess(1);
	    }else{
	        return $this->ajaxError(0);
	    }
	}
	
	/**
	 * @inheritdoc  轮播组管理
	 */
	public function actionGroup(){
	    $group = new Group();
	    if(!$this->cookies('group_status')){
	        $group->AutoChange(); //自动变换轮播组
	    }
        $list_data = $group->GroupList();   //获取要显示的数据
        return $this->render('group',array('group'=>$list_data['model'],'pages' => $list_data['pages']));
	}

	/*
	 *  @inheritdoc   轮播组添加
	 * */
	public function actionGroupadd(){
	    $group = new Group();
	    $mess = '';
	    if($group->load(yii::$app->request->post()) && $group->validate()){
	        $pdata=yii::$app->request->post();
	        //检测轮播组中是否存在时间重叠
	        $time_status = $group->IsTimeRe($pdata['Group']['group_start'],$pdata['Group']['group_end']);
	        $mess = $time_status?'':'轮播组开始结束时间不能重叠';
	        if($pdata && $time_status){
	            $group_status=$group->groupsave($pdata);
	            //判断保存状态
	            if($group_status == 2){//如果开始时间晚于结束时间
	                return $this->render('groupadd',array('group'=>$group,'mess'=>'轮播图开始时间不能晚于结束时间'));
	            }else if($group_status == 1){
	                $this->redirect('index.php?r=system/group');
	            }
	        }
	    }
	    return $this->render('groupadd',array('group'=>$group,'mess'=>$mess));
	}

	/*
	 *  @inheritdoc  轮播组删除
	 * */
	public function actionDel(){
	    $gid=yii::$app->request->get('gid');  //接收参数
	    if($gid){
	        $group = new Group();
	        $status = $group->AfterDel($gid);//检测轮播组状态,如果正在播放则不能删除
	        //判断返回状态
	       if($status == 0){
	           $group_delete_status = $group->GroupDelete($gid); //如果状态满足,执行删除操作
	           echo $group_delete_status?1:0;  //1表示删除成功    0表示删除失败
	       }else if($status == 1){
	           echo 2;   //轮播组正在使用中,无法完成删除操作
	       }else if($status == 2){
	           echo 3;   //轮播组下存在轮播图,无法完成删除
	       }
	    }else{
	        echo 0;
	    }   
	}
	
	/*
	 * @inheritdoc 轮播组批量删除
	 * */
	public function actionDelcheck(){
	    $gid = \yii::$app->request->get('gid');
	    if(Group::deleteAll("group_id in ($gid)")){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
	}
	
	/*
	 *  轮播组搜索查询
	 * */
	public function actionFindgroup(){
	    $search = Yii::$app->request->get('search');//接收前台传递的数据
	    if(!empty($search)){
	        $group = new Group();
	        $result_search=$group->searchByName($search);
	        if($result_search){  //如果查询成功   有相关数据
	            return json_encode($result_search);
	        }else if($result_search == 0){
	            return '0';
	        }
	    }
	}
	
	/*
	 * 轮播组替换
	 * */
	public function actionStatuschange(){
	    $id = yii::$app->request->get('id');
	    $status = yii::$app->request->get('status');
	    //如果接收的值不为空
	    if(isset($id) && $status == 0){
	        $group = new Group();
	        $change_status = $group->ChangeStatus($id,$status);
	        if($change_status){
	            $this->setCookie('group_status', 1);
	            echo 1; 
	        }else{
	            echo 0;
	        }
	    }else{
	        echo "请直接切换至要更改的轮播组";
	    }
	}
	
	/*
	 * 轮播组详情
	 * */
	public function actionGroupdetail(){
	    //接收显示的id
	    $did = yii::$app->request->get('did');
	    if($did){
	        $group = new Group();
	        $groupdata=$group->groupdetail($did);
	        if($groupdata){
	            return $this->renderPartial('detail',array('detail'=>$groupdata));
	        }else{
	            return 0;
	        }
	    }
	}
	
	/*
	 *  轮播图搜索查询
	 * */
	public function actionFindimage(){
	    $search = Yii::$app->request->get('search');//接收前台传递的数据
	    if(!empty($search)){
	        $carousel = new Carousel();
	        $result_search=$carousel->searchByName($search);
	        if($result_search){  //如果查询成功   有相关数据
	            return json_encode($result_search);
	        }else if($result_search == 0){
	            return '0';
	        }
	    }
	}
	
	/*
	 * @inheritdoc   轮播组修改
	 * */
	public function actionGroupupdate(){
	    $group = new Group();
	    $gid = yii::$app->request->get('gid')?yii::$app->request->get('gid'):0;
	    $mess = '';
	    //非法修改
	    if($gid == 0){
	        $this->redirect('index.php?r=system/group');
	    }
	    //根据传入的id来查询出这一条数据
	    $gdata = Group::find()->where("group_id=$gid")->one();
	    //判断是否符合规则，满足则入库
	    if(yii::$app->request->isPost){
	        //处理数据更新   返回进行状态判断
	        $save_status = $group->groupUpdate($gdata);
	        if($save_status == 1){
	            $this->setCookie('group_status', 1);  //轮播组修改完毕,保存cookie
	            $this->redirect("index.php?r=system/group");
	        }else if($save_status == 2){
	            $mess = '修改轮播组停用状态时需要设置默认首选项';
	            $this->redirect("index.php?r=system/groupupdate&&gid=$gid");
	        }
	    }
	    return $this->render('groupup',array('gdata'=>$gdata,'group'=>$group,'mess'=>$mess));
	}

	
	/*
	 * 轮播图详情
	 * */
	public function actionImagedetail(){
	    //接收显示的id
	    $cid = yii::$app->request->get('cid');
	    if($cid){
	        $carousel = new Carousel();
	        $imagedata=$carousel->ImageDetail($cid);
	        return $this->renderPartial('imagedetail',array('imagedetail'=>$imagedata));
	    }   
	}
	
    /*
     * 充值管理
     * */
    public function actionRecharge(){
        $recharge = new Rebate();
        $recharge_data = $recharge->findAllRecharge();
        return $this->render('rechargelist',array('redata'=>$recharge_data));
    }
    
    /*
     * 充值删除
     * */
    public function actionRechargedel(){
        if(yii::$app->request->isAjax){
            $rid = yii::$app->request->get('rid');
            $recharge = new Rebate();
            return $recharge->RechargeDelById($rid);
        }else{
            return 'Must be submitted with Ajax';
        }
    }
    
    /*
     * 充值批量删除
     * */
    public function actionRechargedelcheck(){
        if(yii::$app->request->isGet){
            $rid = yii::$app->request->get('rid');
            if($rid){
                if(Rebate::deleteAll("rebate_id in ($rid)")){
                    return $this->ajaxSuccess(1);
                }else{
                    return $this->ajaxError(0);
                }
            }
        }
    }
    
    /*
     * 充值搜索查询
     * */
    public function actionFindrecharge(){
        $search = Yii::$app->request->get('search');//接收前台传递的数据
        if(!empty($search)){
            $recharge = new Rebate();
            $result_search=$recharge->searchByName($search);
            if($result_search){  //如果查询成功   有相关数据
                return json_encode($result_search);
            }else if($result_search == 0){
                return '0';
            }
        }
    }
    
    /*
     * 充值奖励添加
     * */
    public function actionRechargeadd(){
        $recharge = new Rebate();
        $mess = '';
        $rechargeadd = yii::$app->request->post();
        if(yii::$app->request->isPost){
            if($recharge->load($rechargeadd) && $recharge->validate()){
                $recharge_add_status = $recharge->RechargeAdd($rechargeadd);
                if($recharge_add_status == 1){
                    $this->redirect('index.php?r=system/recharge');
                }else if($recharge_add_status == -1){
                    $mess = '赠送金额不能大于充值金额';
                }
            }
        }
        return $this->renderPartial('rechargeadd',array('recharge'=>$recharge,'mess'=>$mess));
    }
    
    /*
     * 充值奖励修改
     * */
    public function actionRechargeedit(){
        $rid = yii::$app->request->get('id');
        if(!$rid){
            $this->redirect('index.php?r=system/recharge');
        }
        $recharge = new Rebate();
        $recharge_find_data = $recharge->SelectRechargeById($rid);
        $mess = '';
        if(yii::$app->request->isPost){
            $rechargeupdate = yii::$app->request->post();
            if($recharge->load($rechargeupdate)){
                $recharge_up_status = $recharge->RechargeUp($rechargeupdate);
                if($recharge_up_status == 1){
                    $this->redirect('index.php?r=system/recharge');
                }else if($recharge_up_status == -1){
                    $mess = '赠送金额不能大于充值金额';
                }
            }
        }
        return $this->render('rechargeedit',array('rechargeedit'=>$recharge_find_data,'mess'=>$mess));
    }
}
