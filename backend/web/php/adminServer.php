<?php
/**
 * service admin 
 * 学校
 */
class cls_service_admin extends sys_serviceabs
{

    public function addUsername($data, $role)
    {
        $aInfo = [
            'appid'    => $data['appid'],
            'username' => $data['username'],
            'password' => $data['password'],
            'tel'      => $data['username'],
            'nickname' => $data['nickname']
        ];

        $type = 'schoolmaster';
        if ($data['type']==1) {
            $type = 'admin';
        }elseif ($data['type']==2) {
            $type = 'schoolmaster';
        }

        $userServiceObj = $this->serviceLocator->getService('user');

        $ret = $userServiceObj->register($aInfo, $type);

        $uid = 0;

        $flag = 0;
        if (empty($ret['data']['id'])) {
            $uid = $userServiceObj -> getUserIdByTel($data['username']);
            $flag = 0;
        }else{
            $uid = $ret['data']['id'];
            if ($data['type']==2) {
                //绑定班级关系
                $userServiceObj->addUserBelong($uid, 1, $data['scl_id'],$data['cls_id']);
            }
            //为账号分配角色
            $data = array(
                'user_id' => $uid,
                'role_id' => $role,
                'creater_name' => $_SESSION['realname'],
                'creater_id'   => $_SESSION['userid'],
            );
            $this->assginRoleForAdmin($data);
            $flag = 1;
        }
        return $flag;
    }


    //---------------------------------------- 以下是后台登陆操作 ------------------------------------------

    //登陆接口
    public function login($iServerId, $username, $password, $deviceType=2)
    {
        $userServiceObj = $this->serviceLocator->getService('user');

        //验证ucenter login
        $aRet = $userServiceObj->loginUcenter(['appid'=>$iServerId,'username'=>$username,'password'=>$password]);
        if (empty($aRet['userinfo']['id'])){
            return -1; //账号不存在
        }
        
        $iUid = $aRet['userinfo']['id'];
        //添加登录的设备类型
        $oCommonDao = $this->serviceLocator->getService('common');
        $oCommonDao->addDeviceType($iUid,$deviceType);

        //个人信息
        $aUserInfo  = $this->serviceLocator->getService('userinfo')->getUserInfoById($iUid);

        if ($aUserInfo['type'] ==1 || $aUserInfo['type'] ==4) {

            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $iUid;
            $_SESSION['usertype'] = $aUserInfo['type'];
            $_SESSION['realname'] = $aUserInfo['nickname'];

            if ($aUserInfo['type'] ==1) {
                $_SESSION['typename'] = '【园长】';
                $belongDao = $this->daoLocator->getDao('belong');
                $belongInfo = $belongDao->getSclInfoOfUser($iUid);
                $_SESSION['user_scl_id'] = empty($belongInfo['scl_id'])? 0 : $belongInfo['scl_id'];
            }else{
                $_SESSION['typename'] = '【管理员】';
            }

            //获取用户角色
            $role = $this->getRoleByUid($iUid);
            $selfRole = explode(",", $role['role_id']);

            if (in_array("1", $selfRole)) {
                $_SESSION['IS_SUPER_ADMIN'] = 1;
            }else{
                $_SESSION['IS_SUPER_ADMIN'] = 0;
                $menu1 = array();
                $menu2 = array();
                foreach ($selfRole as $roleid) {
                    $menu = $this->getMenuByRoleid($roleid);
                    $menu1temp = $menu['menu1'];
                    $menu2temp = $menu['menu2'];
                    if (!empty($menu1temp)) {
                        $menu1 = array_merge($menu1,$menu1temp);
                        array_unique($menu1);
                    }
                    if (!empty($menu2temp)) {
                        foreach ($menu2temp as $key => $v2) {
                            $menu2 = array_merge($menu2,$v2);
                            array_unique($menu2);
                        }
                    }
                }
                $_SESSION['USER_MENU1'] = $menu1;
                $_SESSION['USER_MENU2'] = $menu2;
            }
            return 1;
        }
        return 0;
    }


    //---------------------------------------- 以下是角色的添加，更新，获取信息等操作 ------------------------------------------

    //添加角色
    public function addRole($data)
    {
        $admin = $this->daoLocator->getDao('admin');
        $insertId = $admin->addRole($data);
        return $insertId;
    }


    /**
     * 修改角色
     * @return type
     */
    public function updateRole($data,$roleid)
    {
        $admin = $this->daoLocator->getDao('admin');
        $ret = $admin->updateRole($data,$roleid);
        return $ret;
    }

     /**
     * 删除角色
     * @return type
     */
    public function role_del($roleid)
    {
        $admin = $this->daoLocator->getDao('admin');
        $ret = $admin->role_del($roleid);
        return $ret;
    }


    /**
     * 通过roleid获取role角色信息
     * @return type
     */
    public function getRoleById($roleid)
    {
        $admin = $this->daoLocator->getDao('admin');
        $ret = $admin->getRoleById($roleid);
        return $ret;
    } 


    /**
     * 获取所有role角色
     * @return type
     */
    public function getAllRole()
    {
        $admin = $this->daoLocator->getDao('admin');
        $ret = $admin->getAllRole();
        return $ret;
    } 


    public function getAllRoleName($idStr){
        $admin = $this->daoLocator->getDao('admin');
        $ret = $admin->getAllRoleName($idStr);
        return $ret;
    }


    /**
     * 角色分页
     * @param type $aWhere
     * @param type $iPerRow
     * @param type $iNowPage
     * @return type
     */
    public function getRolePage($aWhere=[],$iPerRow=10,$iNowPage=1,$aParam=[])
    {
        $adminDao = $this->daoLocator->getDao("admin");
        $roles = $adminDao->getRolePage($aWhere,$iPerRow,$iNowPage,$aParam);
        return $roles;
    }   

    //---------------------------------------- 以下是分配用户角色、获取用户角色等操作 ------------------------------------------

    /**
     * 为管理员分配角色
     */
    public function assginRoleForAdmin($data)
    {
        $adminDao = $this->daoLocator->getDao("admin");
        $flag = $adminDao->isExistUserRole($data['user_id']);

        if (empty($flag) || !is_array($flag)) {
            $data['create_time'] = date("Y-m-d H:i:s");
            $data['update_time'] = date("Y-m-d H:i:s");
            $result = $adminDao->addUserRole($data);

            return empty($result) ? 0:1;
        }else{
            $uid = $data['user_id'];
            unset($data['user_id']);
            $result = $adminDao->updateUserRole($uid, $data);

            return empty($result) ? 0:1;
        }

    }   


    /**
     * 通过用户id获取用户的角色
     */
    public function getRoleByUid($uid)
    {
        $adminDao = $this->daoLocator->getDao("admin");
        $ret = $adminDao->getRoleByUid($uid);

        return $ret;
    }   

    //---------------------------------------- 以下是分配角色权限、获取角色权限等操作 ------------------------------------------

    /**
     * 为角色分配菜单权限
     */
    public function assginMenuForRole($data,$menu1,$menu2)
    {
        $adminDao = $this->daoLocator->getDao("admin");

        $flag1 = $adminDao->isExistRoleMenu($data['role_id'], 1);
        if (empty($flag1) || !is_array($flag1)) {
            $data['create_time'] = date("Y-m-d H:i:s");
            $data['update_time'] = date("Y-m-d H:i:s");
            $data['route'] = $menu1;
            $data['type'] = 1;
            $adminDao->addRoleMenu($data);
        }else{
            $role_id = $data['role_id'];
            $data['route'] = $menu1;
            $adminDao->updateRoleMenu($role_id, $data, 1);
        }

        $flag2 = $adminDao->isExistRoleMenu($data['role_id'], 2);

        if (empty($flag2) || !is_array($flag2)) {
            $data['create_time'] = date("Y-m-d H:i:s");
            $data['update_time'] = date("Y-m-d H:i:s");
            $data['route'] = $menu2;
            $data['type'] = 2;
            $result = $adminDao->addRoleMenu($data);

            return empty($result) ? 0:1;
        }else{
            $role_id = $data['role_id'];
            $data['route'] = $menu2;
            $result = $adminDao->updateRoleMenu($role_id, $data, 2);

            return empty($result) ? 0:1;
        }

    } 



    /**
     * 通过角色id获取角色权限
     */
    public function getMenuByRoleid($roleid)
    {
        $adminDao = $this->daoLocator->getDao("admin");
        $ret = $adminDao->getMenuByRoleid($roleid);

        return $ret;
    }     
    
    
}
