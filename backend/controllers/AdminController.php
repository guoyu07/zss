<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

use yii\data\Pagination;
use yii\web\UploadedFile;
use backend\models\admin\Admin;
use backend\models\admin\Admins;
use backend\models\admin\AuthNode;
use backend\models\admin\AuthRole;
use backend\models\admin\AuthRoleNode;
use backend\models\admin\AuthAdminRole;
use backend\models\admin\AuthNodeTemp;
/**
 * 管理员功能模块
 * @author 王文秀
 */

class AdminController extends BaseController
{   

    /**
    * @annotation    管理员管理信息
    */
   public function actionIndex()
   {
        $model = new Admins;
        $cond = ['and',['>','id','1']];
        $data = $model -> AdminSearch($cond);
        return $this->render('index',[
                            'data' => $data,
                            'model' => $model,
                            ]);
   }
     
   
   /**
    * @annotation    管理员管理信息
    */
   public function actionAdmin()
   {
        $model = new Admins;
        $cond = ['and',['>','id','1']];
        $data = $model -> AdminSearch($cond);
        return $this->render('index',[
                            'data' => $data,
                            'model' => $model,
                            ]);
   }

   /**
     * @inheritdoc  修改管理员状态
     */
    public function actionAdminstatus()
    {
        $request = Yii::$app->request;
        $id = $request->get("id");
        $status = $request->get("status");
        $model = new Admin;
        $res = $model->AdminStatus($id,$status);
        if($res){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }
    
    /**
     * @inheritdoc  管理员详情页
     */
    public function actionAdmininfo()
    {
        $request = Yii::$app->request;
        $id = $request->post("id");
        $model = new Admin;
        $data = $model->AdminInfo($id);
        $auth_admin_role = new AuthAdminRole;
        $admin_role = $auth_admin_role->AdminRole($id);
        $auth_role = new AuthRole;
        $role = $auth_role -> RoleSelect();
        //判断该角色有哪些角色
        foreach ($role as $k => $v) {
            $role[$k]['is_checked'] = 0;
            foreach ($admin_role as $kk => $vv) {
                if ($v['role_id'] == $vv['role_id']) {
                    $role[$k]['is_checked'] = 1;
                }
            }
        }
        $arr = $this->renderPartial('admininfo',[
                            'admin' => $data,
                            'role' => $role,
        ]);
        return $this->ajaxSuccess($arr);
    }
    
    
    /**
     * @inheritdoc  添加管理角色
     */
    public function actionAdminrolecreate()
    {
        $request = Yii::$app->request->post();
        $role_id = $request['role_id'];
        $admin_id = $request['admin_id'];
        foreach($role_id as $key => $val)
        {
            $data[$key]['role_id'] = $val;
            $data[$key]['admin_id'] = $admin_id;
        }
        //判断
        $auth_admin_role = new AuthAdminRole;
        $admin_role = $auth_admin_role->AdminRole($admin_id);
        if($admin_role){
            //批量删除
            $re = $auth_admin_role -> deleteAll(['=','admin_id',$admin_id]);
            if($re){
                //批量添加
                foreach($data as $attributes)
                {
                    $_model = clone $auth_admin_role;
                    $_model->setAttributes($attributes);
                    $_model->save();
                }
                $this->success('添加角色成功!',['admin/admin']);
            }
        }else{
            //批量添加
            foreach($data as $attributes)
            {
                $_model = clone $auth_admin_role;
                $_model->setAttributes($attributes);
                $_model->save();
            }
            $this->success('添加角色成功!',['admin/admin']);
        }
    }

    /**
     * @inheritdoc  管理员分配角色
     */
    public function actionRoleallot()
    {
        $request = Yii::$app->request;
        $id = $request->post("id");
        $model = new Admin;
        $data = $model->AdminInfo($id);
        $auth_admin_role = new AuthAdminRole;
        $admin_role = $auth_admin_role->AdminRole($id);
        $auth_role = new AuthRole;
        $role = $auth_role -> RoleSelect();
        //判断该角色有哪些角色
        foreach ($role as $k => $v) {
            $role[$k]['is_checked'] = 0;
            foreach ($admin_role as $kk => $vv) {
                if ($v['role_id'] == $vv['role_id']) {
                    $role[$k]['is_checked'] = 1;
                }
            }
        }
        //获取该用户下的所有
        $arr = $this->renderpartial('roleallot',[
                        'admin' => $data,
                        'role' => $role,
                        'admin_id' => $id,
        ]);
        return $this->ajaxSuccess($arr);
    }
       
    /**
     * @inheritdoc  添加管理员
     */
    public function actionAdmincreate()
    {
        $request = Yii::$app->request;
        $request = $request->post('Admins');
        $data['username'] = $request['username'];
        $data['password_hash'] = Yii::$app->getSecurity()->generatePasswordHash($request['password_hash']);//加密密码
        $data['email'] = $request['email'];
        $data['created_at'] = time();
        $data['updated_at'] = time();
        $data['auth_key'] = '123456';
        $data['role'] = '10';
        $data['status'] = '10';
        $data['type'] = $request['type'];
        $admin = new Admin;
        $admin -> attributes = $data;
        if($admin -> save()){
            $this->success('添加管理员成功!',['admin/admin']);
        } else {
            $this->error('添加失败,用户名或是邮箱重复!',['admin/admin']);
        }
    }

    /**
     * @inheritdoc 角色管理
     */
    public function actionRole()
    {
        $cond = ['and',['>','role_id','0']];
        $model = new AuthRole;
        $data = $model -> RoleSearch($cond);
        return $this->render('role',[
                            'data' => $data,
                            'model' => $model,
        ]);
    }

    /**
     * @wwx  添加角色
     */
    public function actionRolecreate()
    {
        $model = new AuthRole;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->success('添加角色成功!',['admin/role']);
        } else {
            $this->error('添加角色失败!',['admin/role']);
        }
    }
    
    /**
     * @inheritdoc  修改角色状态
     */
    public function actionRolestatus()
    {
        $request = Yii::$app->request;
        $id = $request->get("id");
        $status = $request->get("status");
        $model = new AuthRole;
        $res = $model->RoleStatus($id,$status);
        if($res){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }


    /**
     * @wwx  修改显示角色
     */
    public function actionRoleupdate()
    {
        $request = Yii::$app->request;
        $model = new AuthRole;      
        if($request->get('type') == 'list'){
            $role_id = $request->get("role_id");
            $model = $model->findOne($role_id);
            $data = $this->renderPartial('roleupdate', ['model' => $model,]);
            return $this->ajaxSuccess($data);
        }else{
            $AuthRole = $request->post("AuthRole");
            $role_id = $AuthRole['role_id'];
            $model = $model->findOne($role_id);
            if ($model->load($request->post()) && $model->save()) {
                $this->success('修改角色成功!',['admin/role']);
            } else {
                $this->error('修改角色失败!',['admin/role']);
            }
        }
    }
    
    /**
     * @inheritdoc  删除角色
     */
    public function actionRoledelete()
    {
        $request = \YII::$app->request;
        $role_id = $request->get("role_id");
        $model = new AuthRole;
        $auth_role = $model->findOne($role_id);
        $res=$auth_role->delete();
        if($res){
            $auth_role_node = new AuthRoleNode;
            $re = $auth_role_node -> deleteAll(['=','role_id',$role_id]);
            if($re){
                return $this->ajaxSuccess(1);
            }else{
                return $this->ajaxError(0);
            }
        }else{
            return $this->ajaxError(0);
        }
    }
    /**
     * @inheritdoc  角色分配
     */
    public function actionAuthallot(){
        $request = Yii::$app->request;
        $role_id = $request->get("role_id");
        $model = new AuthRole;
        $role = $model->findOne($role_id);
        //获取节点
        $auth_node = new AuthNode;
        $auth = $auth_node -> AuthSelect();
        //获取当前角色可操作节点
        $AuthRoleNode = new AuthRoleNode;
        $role_node = $AuthRoleNode -> RoleNode($role_id);
        //判断该角色有哪些权限
        foreach ($auth as $k => $v) {
            $auth[$k]['is_checked'] = 0;
            foreach ($role_node as $kk => $vv) {
                if ($v['node_id'] == $vv['node_id']) {
                    $auth[$k]['is_checked'] = 1;
                }
            }
        }
        //处理权限节点
		//print_r($auth);
        foreach($auth as $key => $val){
            if($val['node_pid'] == 0){
                $arr[] =  $val;
            }
            foreach($arr as $k => $v){
                if($v['node_id'] == $val['node_pid']){
                    $arr[$k]['node'][] =$val;
                }
            }
        }
		
        $data = $this->renderPartial('authallot', [
                            //'model' => $auth_node,
                            'role' => $role,
                            'auth' => $arr,
                            'role_id' => $role_id,
            ]);
        return $this->ajaxSuccess($data);
    }

    
    /**
     * @inheritdoc  角色添加权限
     */
    public function actionRolenodecreate(){
        $request = Yii::$app->request->post();
        $role_id = $request['role_id'];
        $node_id = $request['node_id'];
        foreach($node_id as $key => $val)
        {
            $data[$key]['role_id'] = $role_id;
            $data[$key]['node_id'] = $val;
        }
        //判断
        $auth_role_node = new AuthRoleNode;
        $role_node = $auth_role_node -> RoleNode($role_id);
        if($role_node){
            //批量删除
            $re = $auth_role_node -> deleteAll(['=','role_id',$role_id]);
            if($re){
                //批量添加
                foreach($data as $attributes)
                {
                    $_model = clone $auth_role_node;
                    $_model->setAttributes($attributes);
                    $_model->save();
                }
                $this->success('添加权限成功!',['admin/role']);
            }
        }else{
            //批量添加
            foreach($data as $attributes)
            {
                $_model = clone $auth_role_node;
                $_model->setAttributes($attributes);
                $_model->save();
            }
            $this->success('添加权限成功!',['admin/role']);
        }
    }
    
    /**
     * @inheritdoc  权限分配
     */
    public function actionRoleinfo(){
        $request = Yii::$app->request;
        $role_id = $request->post("role_id");
        $model = new AuthRole;
        $role = $model->findOne($role_id);
        //获取节点
        $auth_node = new AuthNode;
        $auth = $auth_node -> AuthSelect();
        //获取当前角色可操作节点
        $AuthRoleNode = new AuthRoleNode;
        $role_node = $AuthRoleNode -> RoleNode($role_id);
        //判断该角色有哪些角色
        foreach ($auth as $k => $v) {
            $auth[$k]['is_checked'] = 0;
            foreach ($role_node as $kk => $vv) {
                if ($v['node_id'] == $vv['node_id']) {
                    $auth[$k]['is_checked'] = 1;
                }
            }
            
        }
        //处理权限节点
        foreach($auth as $key => $val){
            if($val['node_pid'] == 0){
                $arr[] =  $val;
            }
            foreach($arr as $k => $v){
                if($v['node_id'] == $val['node_pid']){
                    $arr[$k]['node'][] =$val;
                }
            }
        }
        $data = $this->renderPartial('roleinfo', [
                            'model' => $auth_node,
                            'role' => $role,
                            'auth' => $arr,
                            'role_id' => $role_id,
            ]);
        return $this->ajaxSuccess($data);
    }
    
    /**
     * @inheritdoc  权限管理
     */
    public function actionAuth()
    {

        $cond = ['and',['>','node_id','0']];
        $model = new AuthNode;
        $data = $model -> AuthSearch($cond);
        return $this->render('auth',[
                            'data' => $data,
                            'model' => $model,
        ]);
    }

    /**
     * @inheritdoc  修改权限状态
     */
    public function actionAuthstatus()
    {
        $request = Yii::$app->request;
        $id = $request->get("id");
        $status = $request->get("status");
        $model = new AuthNode;
        $res = $model->AuthStatus($id,$status);
        if($res){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }
    /**
     * @inheritdoc  临时权限
     */
    public function actionTemporaryauth()
    {
        //判断临时权限是否过期
        $auth_node_temp = new AuthNodeTemp;
        $code = ['<','node_temp_expire',time()];
        $auth_node_temp -> TempDelete($code);
        //获取当前用户id
        $user_id = Yii::$app->user->id;
        $node_temp = $auth_node_temp -> TempUser($user_id);
        if($node_temp){
            $node_temp =  ($node_temp);
            foreach($node_temp as $key => $val){
                $admin_arr[$key] = $val['node_temp_admin'];
            }           
            $admin_id = implode(',',$admin_arr);
            $admin = new Admin;
            $admin_user = $admin -> AdminSelect("id in ($admin_id)");
        }
        $auth_node = new AuthNode;
        //所有管理员
        $admin = new Admin;
        $code = ['and',['!=','username','admin'],['=','status','10'],['!=','id',"$user_id"]];
        $admin_data = $admin -> AdminSelect($code);
        $admin_datas[] =array('id'=>0,'username'=>"--请选择用户--");
        foreach($admin_data as $key => $val)
        {
            //$admin_datas[$val['id']] = $val['username'];
            $admin_datas[] =array('id'=>$val['id'],'username'=>$val['username']);
        }
        //当前用户数据
        $admin_info = $admin -> AdminInfo("$user_id");
        if($admin_info['username'] == "admin"){
            //所有权限
            $auth = $auth_node -> AuthSelect();
            foreach($auth as $key => $val){
                if($val['node_pid'] == 0){
                    $arr[] =  $val;
                }
                foreach($arr as $k => $v){
                    if($v['node_id'] == $val['node_pid']){
                        $arr[$k]['node'][] =$val;
                    }
                }
            }
        }else{
            $auth_admin_role = new AuthAdminRole;
            $admin_role = $auth_admin_role->AdminRole("$user_id");
           
            if($admin_role){
                //获取角色id
                $role_id = null;
                foreach($admin_role as $key => $val)
                {
                    $role_id[] = $val['role_id'];
                }
              
                if($role_id){
                    $role_id = implode(',',$role_id);
                }
                
                //获取权限id
                $auth_role_node = new AuthRoleNode;
                $node = $auth_role_node -> RoleNodeIn($role_id);
                foreach($node as $key => $val)
                {
                    $node_id[$key] = $val['node_id'];
                }
                $node_id = array_unique($node_id);
                $node_id = implode(',',$node_id);
                //所有权限
                $auth = $auth_node -> AuthIn($node_id);
                foreach($auth as $key => $val){
                    if($val['node_pid'] == 0){
                        $arr[] =  $val;
                    }
                    foreach($arr as $k => $v){
                        if($v['node_id'] == $val['node_pid']){
                            $arr[$k]['node'][] =$val;
                        }
                    }
                }
            }
        }
        return $this->render('temporaryauth',[
                        'admin' => $admin_user,
                        'admin_info' => $admin_info,
                        'admin_data' => $admin_datas,
                        'auth' => $arr,
        ]);
    }
    
    /**
     * @inheritdoc  添加临时权限
     */
    public function actionTemporarycreate()
    {
        $request = Yii::$app->request->post();
        if($request['node_id'] && $request['admin_id'] && $request['node_temp_expire']){
            $node_id = implode(',',$request['node_id']);
            $auth_node = new AuthNode;
            $node = $auth_node -> AuthIn($node_id);
            foreach($node as $key => $val){
                $arr[$key]['node_id'] = $val['node_id'];
                $arr[$key]['node_temp_name'] = $val['node_name'];
                $arr[$key]['node_temp_title'] = $val['node_title'];
                $arr[$key]['node_temp_status'] = $val['node_status'];
                $arr[$key]['node_temp_remark'] = $val['node_remark'];
                $arr[$key]['node_temp_sort'] = $val['node_sort'];
                $arr[$key]['node_temp_pid'] = $val['node_pid'];
                $arr[$key]['node_temp_level'] = $val['node_level'];
                $arr[$key]['node_temp_admin'] = $request['admin'];
                $arr[$key]['node_temp_expire'] = strtotime($request['node_temp_expire']);
                $arr[$key]['node_temp_share_id'] = $request['admin_id'];
            }
            $auth_node_temp = new AuthNodeTemp;
            foreach($arr as $attributes)
            {
                $_model = clone $auth_node_temp;
                $_model->setAttributes($attributes);
                $_model->save();
            }
            $this->success('添加权限成功!',['admin/temporaryauth']);
        }else{
            $this->error('权限,授权人,结束时间不能为空!',['admin/temporaryauth']);
        }
    }

    /**
     * @inheritdoc  临时授权详情
     */
    public function actionTempallot()
    {
        $request = Yii::$app->request->post();
        $id = Yii::$app->request->post('id');
        $admin = new Admin;
        //获取当前用户id
        $user_id = Yii::$app->user->id;
        $admin_info = $admin -> AdminInfo("$user_id");
        $admin = $admin -> AdminInfo($id);
        $auth_node = new AuthNode;
        $auth_node_temp = new AuthNodeTemp;
        $temp_node = $auth_node_temp -> TempNode($id);
        if($admin_info['username'] == "admin"){
            //所有权限
            $auth = $auth_node -> AuthSelect();
            foreach ($auth as $k => $v) {
                $auth[$k]['is_checked'] = 0;
                foreach ($temp_node as $kk => $vv) {
                    if ($v['node_id'] == $vv['node_id']) {
                        $auth[$k]['is_checked'] = 1;
                    }
                }
            }
            foreach($auth as $key => $val){
                if($val['node_pid'] == 0){
                    $arr[] =  $val;
                }
                foreach($arr as $k => $v){
                    if($v['node_id'] == $val['node_pid']){
                        $arr[$k]['node'][] =$val;
                    }
                }
            }
        }else{
            $auth_admin_role = new AuthAdminRole;
            $admin_role = $auth_admin_role->AdminRole("$user_id");
            if($admin_role){
                //获取角色id
                $role_id = null;
                foreach($admin_role as $key => $val)
                {
                    $role_id[] = $val['role_id'];
                }
                if($role_id){
                    $role_id = implode(',',$role_id);
                }
                //获取权限id
                $auth_role_node = new AuthRoleNode;
                $node = $auth_role_node -> RoleNodeIn($role_id);
                foreach($node as $key => $val)
                {
                    $node_id[$key] = $val['node_id'];
                }
                $node_id = array_unique($node_id);
                $node_id = implode(',',$node_id);
                //所有权限
                $auth = $auth_node -> AuthIn($node_id);
                foreach ($auth as $k => $v) {
                    $auth[$k]['is_checked'] = 0;
                    foreach ($temp_node as $kk => $vv) {
                        if ($v['node_id'] == $vv['node_id']) {
                            $auth[$k]['is_checked'] = 1;
                        }
                    }
                }
                foreach($auth as $key => $val){
                    if($val['node_pid'] == 0){
                        $arr[] =  $val;
                    }
                    foreach($arr as $k => $v){
                        if($v['node_id'] == $val['node_pid']){
                            $arr[$k]['node'][] =$val;
                        }
                    }
                }
            }
        }
        //获取查询临时权限用户的权限
		//print_r($temp_node);die;
        //$temp_node = array_unique($temp_node);
        $data = $this->renderPartial('tempallot', [
                            'admin' => $admin,
                            'auth' => $arr,
                            'temp_node' => $temp_node,
                            //'admin_data' => $admin_data,
            ]);
        return $this->ajaxSuccess($data);
    }
    
    /**
     * @inheritdoc  收回临时权限
     */
    public function actionTempdelete()
    {
        $request = Yii::$app->request->post();
        $id = Yii::$app->request->post('id');
        $auth_node_temp = new AuthNodeTemp;
        $code = ['=','node_temp_admin',$id];
        $res = $auth_node_temp -> TempDelete($code);
        if($res){
            return $this->ajaxSuccess(1);
        }else{
            return $this->ajaxError(0);
        }
    }
}   
