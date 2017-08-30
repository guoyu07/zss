<?php
/**
 * 后台账号统一模块管理
 * @author iProg
 */
    
class cls_ctrl_admin extends cls_ctrl_base
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function main(){
        return $this->display('admin.login.html');
    }
    
    /**
     * 后台登录
     */
    public function login(){
        if (isset($_SESSION['username'])) {
            echo 1;die();
        }else{
            $username =  isset($this->_post['username'])?$this->_post['username'] : '';
            $password =  isset($this->_post['password'])?$this->_post['password'] : '';

            if (empty($username) || empty($password)) {
                echo -1;die();
            } else {
                $adminService = $this->serviceLocator->getService('admin');
                $flag = $adminService->login($this->iServerId, $username, $password);

                if ($flag == -1) {
                    echo -1; die();
                }elseif ($flag == 1) {
                    echo 1;  die();
                }else {
                    echo 0;  die();
                }

            }
        }
    }

    /**
     * 后台退出
     */
    public function logout(){
        session_unset(); 
        session_destroy();

        return $this->display('admin.login.html');
    }


    /**
     * 添加管理员
     */
    public function addAccount(){
        if (empty($this->_post)) {

            $oSchoolServer =  $this->serviceLocator->getService("school");
            $aSchool['schools'] = $oSchoolServer->getAll();
            $this->assign($aSchool);

            $adminServer =  $this->serviceLocator->getService("admin");
            $roles['roles'] = $adminServer->getAllRole();
            $this->assign($roles);

            return $this->display('admin.addAccount.html');

        }else{

            $username  = isset($this->_post['username']) ? $this->_post['username'] : '';
            $password  = isset($this->_post['password']) ? $this->_post['password'] : '';
            $realname  = isset($this->_post['realname']) ? $this->_post['realname'] : '';
            $type      = isset($this->_post['type']) ? $this->_post['type'] : '';
            $roleidArr = isset($this->_post['roleid']) ? $this->_post['roleid'] : 0;
            $scl_id    = isset($this->_post['scl_id']) ? $this->_post['scl_id'] : '';

            if (empty($username) || empty($password) ||empty($realname) ||empty($type)) {
                echo -2;die();
            }else{
                $data = array(
                    'appid'    => $this->iServerId,
                    'username' => $username,
                    'password' => $password,
                    'nickname' => $realname,
                    'type'     => $type,
                    'scl_id'   => $scl_id,
                    'cls_id'   => 0
                );

                $role = array();
                if (!empty($roleidArr)) {
                    $role = implode($roleidArr, ",");
                }
                
                $adminService = $this->serviceLocator->getService('admin');
                $flag = $adminService->addUsername($data, $role);

                if ($flag == 1) {
                    echo 1;  die();   //添加成功
                }else{
                    echo 0;  die();   //添加失败
                }
            }

        }
    }


    public function admin_list(){

        $nickname = isset($this->_data['nickname']) ? $this->_data['nickname'] : "";
        $tel = isset($this->_data['tel']) ? $this->_data['tel'] : "";
        $type = isset($this->_data['type']) ? $this->_data['type'] : 0;

        $param = $this->_get;

        $where = " and (type=1 or type=4) ";

        if ($type) {
            $where = " and type=".$type." ";
            $param['type'] = $type;
        }

        if ($nickname) {
            $where .= " and nickname like '%".$nickname."%' ";
            $param['nickname'] = $nickname;
        }

        if ($tel) {
            $where .= " and tel='".$tel."' ";
            $param['tel'] = $tel;
        }

        $oUserServer =  $this->serviceLocator->getService("user");
        $aUser['admins'] = $oUserServer->getUserPageForAdmin($this->iServerId, $where, 10, empty($this->_get['page'])?1:$this->_get['page'], $param);

        $adminService = $this->serviceLocator->getService('admin');
        foreach ($aUser['admins']['data'] as $key => $value) {
            $role = $adminService->getRoleByUid($value['uid']);
            $ret = $adminService->getAllRoleName($role['role_id']);
            $rolename = "";
            foreach ($ret as $k => $v) {
                if ($v['id']==1) {
                    $rolename .= '<span title="超级管理员不能编辑">'.$v['role_name'].'</span>';
                }else{
                    $rolename .= '<a title="点击为角色分配菜单权限" style="margin-left:5px;margin-right:5px;color:#9F79EE;" href="?act=admin.role_assginMenu&roleid='.$v['id'].'&rolename='.$v['role_name'].'">'.$v['role_name'].'</a>';
                }
            }
            $aUser['admins']['data'][$key]['role_name'] = $rolename;
        }

        $aUser['nickname'] = $nickname;
        $aUser['tel'] = $tel;
        $aUser['type'] = $type;
        $this->assign($aUser);
        return $this->display('admin.admin_list.html');
    }


    public function forgetPassword(){

        $username = isset($this->_data['username']) ? $this->_data['username'] : "";
        $password = isset($this->_data['password']) ? $this->_data['password'] : "";

        if (empty($username) || empty($password)) {
            echo -1;die();
        }

        $userService = $this->serviceLocator->getService('user');
        $returnData = $userService->forgetPassWord($this->iServerId,$username,$password);

        if ($returnData['code']==1) {
            echo 1;die();
        }else{
            echo 0;die();
        }

    }

    public function changePwd(){
        if (!empty($this->_post)) {
            $uid = isset($this->_data['uid']) ? $this->_data['uid'] : "";
            $oldpassword = isset($this->_data['oldpassword']) ? $this->_data['oldpassword'] : "";
            $newpassword = isset($this->_data['newpassword']) ? $this->_data['newpassword'] : "";

            if (empty($uid) || empty($oldpassword) || empty($newpassword)) {
                echo -1;die();
            }

            $userService = $this->serviceLocator->getService('user');
            $returnData = $userService->changePassWord($this->iServerId,$uid,$newpassword,$oldpassword);

            if (!empty($returnData['data']['code']) && $returnData['data']['code']==1) {
                echo 1;die();
            }else{
                echo 0;die();
            }

        }else{
            return $this->display('admin.changePwd.html');
        }
    }


    /**
     * 添加角色
     */
    public function role_add(){
        if (empty($this->_post)) {

            $roleid   =  isset($this->_get['roleid'])?$this->_get['roleid'] : '';
            if (empty($roleid)) {
                $data['role'] = array(
                    'roleid' =>"",
                    'rolename' =>"",
                    'roledesc' => ""
                );
            }else{
                $adminService = $this->serviceLocator->getService('admin');
                $ret = $adminService->getRoleById($roleid);
                $data['role'] = array(
                    'roleid' =>$ret['id'],
                    'rolename' =>$ret['role_name'],
                    'roledesc' => $ret['role_desc']
                );
            }

            
            $this->assign($data);
            return $this->display('admin.role_add.html');

        }else{

            $roleid   =  isset($this->_post['roleid'])?$this->_post['roleid'] : '';
            $rolename =  isset($this->_post['rolename'])?$this->_post['rolename'] : '';
            $roledesc =  isset($this->_post['roledesc'])?$this->_post['roledesc'] : '';

            if (empty($rolename) || empty($roledesc)) {
                echo -2;die();
            }

            $data = array(
                'role_name'    => $rolename,
                'role_desc'    => $roledesc
            );

            $adminService = $this->serviceLocator->getService('admin');

            $flag = 0;

            if (empty($roleid)) {    //添加角色

                $data['creater_id']   = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
                $data['creater_name'] = isset($_SESSION['realname']) ? $_SESSION['realname'] : "";
                $data['create_time']  = date("Y-m-d H:i:s");
                $data['update_time']  = date("Y-m-d H:i:s");

                $flag = $adminService->addRole($data);

            }else{                   //修改角色
                $data['update_id']   = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
                $data['update_name'] = isset($_SESSION['realname']) ? $_SESSION['realname'] : "";

                $flag = $adminService->updateRole($data,$roleid);

            }

            if (!empty($flag)) {
                echo 1;  die();   //操作成功
            }else{
                echo 0;  die();   //操作失败
            }

        }
    }


    /**
     * 添加角色
     */
    public function role_del(){
        $roleid   =  isset($this->_post['roleid'])?$this->_post['roleid'] : '';

        if (empty($roleid)) {
            header("Loaction:?act=admin.role_list");
        }

        $adminService = $this->serviceLocator->getService('admin');

        $flag = $adminService->role_del($roleid);

        header("Loaction:?act=admin.role_list");
    }


    /**
     * 角色列表
     */
    public function role_list(){

        $rolename =  isset($this->_data['rolename'])?$this->_data['rolename'] : '';
        $roledesc =  isset($this->_data['roledesc'])?$this->_data['roledesc'] : '';
        $param = $this->_get;

        $where = "";

        if ($rolename) {
            $where .= " and role_name like '%".$rolename."%' ";
            $param['rolename'] = $rolename;
        }

        if ($roledesc) {
            $where .= " and role_desc like '%".$roledesc."%' ";
            $param['roledesc'] = $roledesc;
        }

        $adminServer =  $this->serviceLocator->getService("admin");
        $roles['roles'] = $adminServer->getRolePage($where, 10, empty($this->_get['page'])? 1 :$this->_get['page'], $param);
        $this->assign($roles);

        $search['rolename'] = $rolename;
        $search['roledesc'] = $roledesc;
        $this->assign($search);

        return $this->display('admin.role_list.html');
    }

    
    /**
     * 分配用户角色
     */
    public function admin_assginRole(){
        if (empty($this->_post)) 
        {
            $uid = isset($this->_get['uid']) ? $this->_get['uid'] : 0;
            $nickname = isset($this->_get['nickname']) ? $this->_get['nickname'] : '';

            if (empty($uid)) {
                header("Loaction:?act=admin.admin_list");
            }else{
                $adminServer =  $this->serviceLocator->getService("admin");
                $roles['roles'] = $adminServer->getAllRole();
                $this->assign($roles);

                $role = $adminServer->getRoleByUid($uid);
                $selfRole['selfRole'] = explode(",", $role['role_id']);
                $this->assign($selfRole);

                $admin = array(
                    'uid' => $uid,
                    'nickname' => $nickname
                );
                $this->assign($admin);

                return $this->display('admin.admin_assginRole.html');
            }
        }
        else
        {
            $uid = isset($this->_post['uid']) ? $this->_post['uid'] : 0;
            $roleidArr = isset($this->_post['roleid']) ? $this->_post['roleid'] : 0;

            $data = array(
                'user_id' => $uid,
                'role_id' => implode(',',$roleidArr),
                'creater_name' => $_SESSION['realname'],
                'creater_id'   => $_SESSION['userid'],
            );

            $adminServer =  $this->serviceLocator->getService("admin");
            $flag = $adminServer -> assginRoleForAdmin($data);

            echo $flag;die();
        } 
    }


    /**
     * 分配角色菜单权限
     */
    public function role_assginMenu(){
        if (empty($this->_post)) 
        {
            $roleid   = isset($this->_get['roleid']) ? $this->_get['roleid'] : 0;
            $rolename = isset($this->_get['rolename']) ? $this->_get['rolename'] : '';

            if (empty($roleid) || empty($rolename)) {
                header("Location:?act=index.main");
            }

            $menu =  $this->serviceLocator->getService("menu");
            $sysMenu = $menu->getSysMenu();
            $data['level1menu'] = $sysMenu['level1menu'];
            $data['level2menu'] = $sysMenu['level2menu'];

            $adminServer =  $this->serviceLocator->getService("admin");
            $ret = $adminServer -> getMenuByRoleid($roleid);
            $data['rolemenu1'] = $ret['menu1'];
            $data['rolemenu2'] = $ret['menu2'];

            $data['roleid'] = $roleid;
            $data['rolename'] = $rolename;

            $this->assign($data);

            return $this->display('admin.role_assginMenu.html');
        }
        else
        {
            $roleid   = isset($this->_post['roleid']) ? $this->_post['roleid'] : 0;
            $menu1Arr = isset($this->_post['menu1']) ? $this->_post['menu1'] : '';

            if (empty($roleid) || empty($menu1Arr)) {
                echo -1;die();
            }

            $menu2Arr = array();
            foreach ($menu1Arr as $value) {
                $menu2Arr[$value] = isset($this->_post[$value]) ? $this->_post[$value] : array();
            }

            $data = array(
                'role_id' => $roleid,
                'creater_name' => $_SESSION['realname'],
                'creater_id'   => $_SESSION['userid']
            );

            $menu1  = json_encode($menu1Arr);
            $menu2  = json_encode($menu2Arr);
            
            $adminServer =  $this->serviceLocator->getService("admin");
            $flag = $adminServer -> assginMenuForRole($data,$menu1,$menu2);

            echo $flag;die();

        }
    }


    public function test(){

        $server =  $this->serviceLocator->getService("user");

        //注册imucenter模拟数据
        $aData = [
            'appid'    => 1001,
            'username' => '13918126454',
            'nickname' => '',
            'password' => '123456',
            'sex'      => 1,
            'uid'      => 1799
        ];
        // $ret = $server->_getReqOfImUncenter($aData, 'register');

        //加入群模拟数据
        $aData = [
            'uid'    => 1799,
            'gid'    => 1
        ];
        // $ret = $server->_getReqOfImUncenter($aData, 'joingroup');

        $aData = [
            'uid'    => 1799,
            'gid'    => 1
        ];
        $ret = $server->_getReqOfImUncenter($aData, 'removegroupuser');

        //添加im群模拟数据
        $aData = [
            'gid'    => 16,
            'uid'    => 634,
            'gtype'  => 'normal',
            'gname'  => '一年级sna班'
        ];
        // $ret = $server->_getReqOfImUncenter($aData, 'addgroup');


        //添加临时会话群模拟数据
        $aData = [
            'uid'    => 527,
            'tname'  => '492_1'
        ];
        // $ret = $server->_getReqOfImUncenter($aData, 'gettag');

        //推送消息测试
        // cls_service_common::imPushFromServer('631','王老师','634','u','测试测试22',1);

        //系统图推送消息
        // cls_service_common::imPushFromServer('1','系统消息','634','u','测试测试22',1,'send','0','0', '4');

        var_dump($ret);die();

    }

}
