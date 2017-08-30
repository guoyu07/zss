<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\user\User;
use backend\models\user\Vip;
use backend\models\user\VipInfo;
use backend\models\user\Company;
use backend\models\user\Gift;
use backend\models\user\EntryForm;
use backend\models\user\VipForm;
use backend\models\user\VipinfoForm;
use backend\models\user\MemberForm;
use backend\models\user\VipLog;
use backend\models\user\VipCharge;


/**
 * 用户功能模块
 * @author 王文秀
 */

class UserController extends BaseController
{

    /**
    * @annotation    会员信息
    */
   public function actionMemberlist()
   {
        $zssuser = new User();
        //利用model内方法多表联查
        $result = $zssuser -> selectuser();
        $data['list'] = $result;
        return $this->render('memberlist',$data);
   }

    /**
     * @annotation    修改会员状态
     */
    public function actionUserstatus()
    {
        $cid = Yii::$app->request->get('cid');
        $status = Yii::$app->request->get('status');
        $user = User::find()->where(['user_id' => $cid])->one();
        $user->user_status = $status;
        $user->updated_at = time();
        if($user->save()){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }

   /**
    * @annotation   会员详细信息
    */
   public function actionMoreuser()
   {
        $cid = Yii::$app->request->get('cid');
        $user = new User();
        $result = $user->getdetail($cid);
        $updated = $user->getupdated($cid);
        $charge = VipCharge::find()->where(['user_id' => $cid])->limit(5)->asArray()->all();
        $company = Company::find()->asArray()->all();
        $data['result'] = $result;
        //print_r($result);die;
        $data['username'] = $updated;
        $data['charge'] = $charge;
        $data['company'] = $company;
        $view = $this->renderPartial('moreuser',$data);
        return  $this->ajaxSuccess($view);
    }

    /**
    *@annotataiojn   搜索会员
    */
    public function actionFindmember()
    {
        $search = Yii::$app->request->get('search');
        $zssuser = new User();
        $result = $zssuser -> whereuser($search);
        $data['list'] = $result;
        $view = $this->render('findmember',$data);
        return  $this->ajaxSuccess($view);
    }

    /**
    * @annotation   会员详细信息修改
    */
   public function actionUpdmember()
   {
        $cid = Yii::$app->request->post('cid');
        $user = User::find()->where(['user_id' => $cid])->one();
        //判断是否为空
        if(!empty(Yii::$app->request->post('virtual'))){
            $user->user_virtual = Yii::$app->request->post('virtual');
        }
        if(!empty(Yii::$app->request->post('price'))){
            $user->user_price = Yii::$app->request->post('price');
        }
        if(!empty(Yii::$app->request->post('company'))){
            $user->company_id = Yii::$app->request->post('company');
        }

        $user->updated_id = Yii::$app->user->identity->id;
        $user->updated_at = time();
        //进行修改
        if($user->save()){
            $this->success('修改成功',['user/memberlist']);
        }else{
            $this->error('修改失败',['user/memberlist']);
        }
   }

   /**
    * @annotation   会员添加页面
    */
   public function actionAdmember()
   {
        $model = new MemberForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据
            $entryform = Yii::$app->request->post();
            //添加数据
            $user = new User();
            $user->user_name = $entryform['MemberForm']['user_name'];
            $user->user_sex = $entryform['MemberForm']['user_sex'];
            $user->user_phone = $entryform['MemberForm']['user_phone'];
            $user->user_password =  $entryform['MemberForm']['user_password'];
            $user->user_price =  $entryform['MemberForm']['user_price'];
            $user->user_virtual =  $entryform['MemberForm']['user_virtual'];
            //$user->vip_id = Yii::$app->request->post('vip_id');
            $user->company_id = Yii::$app->request->post('company_id');
            $user->created_at = time();
            $user->updated_at = time();
            //判断是否添加成功
            if($user->save()){
                $this->success('添加会员成功',['user/memberlist']);
            }else{
                $this->error('添加会员失败',['user/memberlist']);
            }
        } else {
            // 无论是初始化显示还是数据验证错误
            $company = Company::find()->asArray()->all();
            $vip = Vip::find()->asArray()->all();
            $data['company'] = $company;
            $data['vip'] = $vip;
            $data['model'] = $model;
            return $this->render('addmember', $data);
        }

   }

   /**
    * @annotation   会员添加
    */
   public function actionVerimember()
   {
        $user = new User();
        $user->user_name = Yii::$app->request->post('user_name');
        $user->user_sex = Yii::$app->request->post('user_sex');
        $user->user_phone = Yii::$app->request->post('user_phone');
        $user->user_password = md5(Yii::$app->request->post('user_password'));
        $user->user_price = Yii::$app->request->post('user_price');
        $user->user_virtual = Yii::$app->request->post('user_virtual');
        $user->vip_id = Yii::$app->request->post('vip_id');
        $user->company_id = Yii::$app->request->post('company_id')==""?"":Yii::$app->request->post('company_id');
        $user->created_at = time();
        $user->updated_at = time();
        if($user->save()){
             $this->success('添加成功',['user/memberlist']);
        }else{
             $this->error('添加失败',['user/memberlist']);
        }
   }


   /*
    * @annotation    会员删除
    */
   public function actionDellist()
   {
        $cid = Yii::$app->request->get('cid');
        if(User::deleteAll("user_id in ($cid)")){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
   }

   /**
    * @annotation    会员等级管理
    */
   public function actionMemberrank()
   {
       $memberrank = new Vip();
       //查询每个修改人的信息
       $rank = $memberrank->getdetail();
       $data['rank'] = $rank;
       return $this->render('memberrank',$data);
   }

    /**
     * @annotation    修改会员等级状态
     */
    public function actionVipstatus()
    {
        $cid = Yii::$app->request->get('cid');
        $status = Yii::$app->request->get('status');
        $vip = Vip::find()->where(['vip_id' => $cid])->one();
        $vip->vip_status = $status;
        $vip->updated_at = time();
        if($vip->save()){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }

     /**
     * @annotation   会员等级添加
     */
    public function actionAdrank()
    {
        $model = new VipForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据
            $entryform = Yii::$app->request->post();
            //添加数据
            $vip = new Vip();
            $vip->vip_name = $entryform['VipForm']['vip_name'];
            $vip->vip_discount = $entryform['VipForm']['vip_discount'];
            $vip->vip_price = $entryform['VipForm']['vip_price'];
            $vip->vip_subtract =  $entryform['VipForm']['vip_subtract'];
            $vip->vip_experience =  $entryform['VipForm']['vip_experience'];
            $vip->gift_id = Yii::$app->request->post('gift')==0?"":Yii::$app->request->post('gift');
            $vip->created_at = time();
            $vip->updated_at = time();
            //判断是否添加成功
            if($vip->save()){
                $this->success('添加成功',['user/memberrank']);
            }else{
                $this->error('添加失败',['user/memberrank']);
            }
        } else {
            // 无论是初始化显示还是数据验证错误
            $gift = Gift::find()->asArray()->all();
            $data['gift'] = $gift;
            $data['model'] = $model;
            return $this->render('addrank', $data);
        }

    }

   /**
    * @annotation    会员等级删除
    */
   public function actionDelrank()
   {
        $cid = Yii::$app->request->get('cid');
        if(Vip::deleteAll("vip_id in ($cid)")){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
   }

   /**
    * @annotation    会员等级详情
    */
   public function actionMorerank()
   {
        $cid = Yii::$app->request->get('cid');
        $vip = new Vip();
        $result = $vip->getgift($cid);
        $data['result'] = $result;
        $view = $this->renderPartial('morevip',$data);
        return $this->ajaxSuccess($view);
    }

    /**
     * @annotation    修改会员等级
     */
    public function actionUpdvip()
    {
        $cid = Yii::$app->request->get('cid');
        $vip = new Vip();
        $result = $vip->getgift($cid);
        $gift = Gift::find()->asArray()->all();
        $data['result'] = $result;
        $data['gift'] = $gift;
        //验证数据
        $model = new VipinfoForm;
        $entryform = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkname($entryform['VipinfoForm']['vip_name'],$result['vip_name'])) {
             $vip = Vip::find()->where(['vip_id' => $cid])->one();
             $vip->vip_name = $entryform['VipinfoForm']['vip_name'];
             $vip->vip_discount = $entryform['VipinfoForm']['vip_discount'];
             $vip->vip_price = $entryform['VipinfoForm']['vip_price'];
             $vip->vip_subtract = $entryform['VipinfoForm']['vip_subtract'];
             $vip->vip_experience =  $entryform['VipinfoForm']['vip_experience'];
             $vip->gift_id = Yii::$app->request->post('gift');
             $vip->updated_id = Yii::$app->user->identity->id;
             $vip->updated_at = time();
             //判断是否修改成功
             if($vip->save()){
                    $this->success('修改成功',['user/memberrank']);
             }else{
                    $this->error('修改失败',['user/memberrank']);
             }
        }else{
            $data['model'] = $model;
            return $this->render('updvip',$data);
        }
    }

   /**
    *@annotataiojn   搜索vip等级
    */
    public function actionFindrank()
    {
        $search = Yii::$app->request->get('search');
        $result = Vip::find()->where(['like','vip_name',"$search"])->asArray()->all();
        $data['rank'] = $result;
        $view = $this->render('findvip',$data);
        return $this->ajaxSuccess($view);
    }

   /**
    * @annotation    合作伙伴
    */
    public function actionCompany()
    {
        $company = new Company();
        //获取公司信息
        $partner = $company->getdetail();
        $data['partner'] = $partner;
        return $this->render('company',$data);
    }

    /**
     * @annotation    修改公司状态
     */
    public function actionComstatus()
    {
        $cid = Yii::$app->request->get('cid');
        $status = Yii::$app->request->get('status');
        $company = new Company();
        if($company->updstatus($cid,$status)){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }

    /**
     * @annotation   公司添加
     */
    public function actionAdcompany()
    {
        $model = new EntryForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据
            $entryform = Yii::$app->request->post();
            //添加数据
            $company = new Company();
            $company->company_name = $entryform['EntryForm']['company_name'];
            $company->company_discount = $entryform['EntryForm']['company_discount'];
            $company->company_price = $entryform['EntryForm']['company_price'];
            $company->company_subtract =  $entryform['EntryForm']['company_subtract'];
            $company->gift_id = Yii::$app->request->post('gift')==0?"": Yii::$app->request->post('gift');
            $company->created_at = time();
            $company->updated_at = time();
            //判断是否添加成功
            if($company->save()){
                $this->success('添加成功',['user/company']);
            }else{
                $this->error('添加失败',['user/company']);
            }
        } else {
            // 无论是初始化显示还是数据验证错误
            $gift = Gift::find()->asArray()->all();
            $data['gift'] = $gift;
            $data['model'] = $model;
            return $this->render('addcompany', $data);
        }
    }

    /**
     * @annotation    公司信息删除
     */
    public function actionDelcompany()
    {
        $cid = Yii::$app->request->get('cid');
        //删除公司信息 或批量删除
        if(Company::deleteAll("company_id in ($cid)")){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }

    /**
     * @annotation    公司详情
     */
    public function actionMorecompany()
    {
        $cid = Yii::$app->request->get('cid');
        $company = new Company();
        $result = $company->getgift($cid);
        $data['result'] = $result;
        $view = $this->renderPartial('morecompany',$data);
        return  $this->ajaxSuccess($view);
    }

    /**
     * @annotation    修改公司
     */
    public function actionUpdcompany()
    {
        $cid = Yii::$app->request->get('cid');
        $company = new Company();
        $result = $company->getgift($cid);
        $gift = Gift::find()->asArray()->all();
        $data['result'] = $result;
        $data['gift'] = $gift;
        //验证数据
        $model = new Company;
        $entryform = Yii::$app->request->post();
       if ($model->load($entryform) && $model->validate() && $model->checkname($entryform['Company']['company_name'],$result['company_name'])) {
             $company = Company::find()->where(['company_id' => $cid])->one();
             $company->company_name = $entryform['Company']['company_name'];
             $company->company_discount = $entryform['Company']['company_discount'];
             $company->company_price = $entryform['Company']['company_price'];
             $company->company_subtract = $entryform['Company']['company_subtract'];
             $company->gift_id = Yii::$app->request->post('gift');
             $company->updated_id = Yii::$app->user->identity->id;
             $company->updated_at = time();
             //判断是否修改成功
             if($company->save()){
                    $this->success('修改成功',['user/company']);
             }else{
                    $this->error('修改失败',['user/company']);
             }
        }else{
            $data['model'] = $model;
            return $this->render('updcompany',$data);
        }
    }

    /**
     * @annotation    搜索公司
     */
    public function actionFindcompany()
    {
        $search = Yii::$app->request->get('search');
        $result = Company::find()->where(['like','company_name',"$search"])->asArray()->all();
        $data['partner'] = $result;
        $view = $this->render('findcompany',$data);
        return $this->ajaxSuccess($view);
    }

    /**
     * 经验管理
     */
    public function actionVipInfo()
    {
        $vip_experience_get = Yii::$app->request->get('ge');
        $vip_experience_raiders = Yii::$app->request->get('ra');
        if(empty($vip_experience_get) || empty($vip_experience_raiders)){
          $vipinfo = new VipInfo();
          $info = $vipinfo->get_info();
          return $this->render('vipinfo',['info'=>$info]);
        }else{
          if(strpos($vip_experience_get,'<script') || strpos($vip_experience_raiders,'<script')){
            echo 2;die;
          }
          $vipinfo = new VipInfo();
          $info = $vipinfo->upd_info($vip_experience_get,$vip_experience_raiders);
          if($info){
              echo 1;
          }else{
              echo 0;
          }
        }

    }


}
