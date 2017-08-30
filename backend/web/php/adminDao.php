<?php

/**
 * dao child 
 * author:zhaoxun
 */
class cls_dao_admin extends sys_daoabs
{

    const TABLE_ROLE          = 'admin_role';
    const TABLE_USER_ROLE     = 'admin_user_role';
    const TABLE_ROLE_ROUTE     = 'admin_role_route';

    public function __construct()
    {
        parent::__construct();
        $this->mc = new sys_memcache(sys_define::$common_memcache);
    }

    /*--------------------- 以下是角色列表、角色添加、删除、修改 ----------------------------------*/

    //添加角色
    public function addRole($data)
    {
        $aFeilds = array_keys($data);
        $this->daoHelper = new sys_daohelper(null,self::TABLE_ROLE,sys_define::$main_db);
        $iInsertId = $this->daoHelper->add($aFeilds, $data,null, 1);
        return $iInsertId;
    }


    /**
     * 修改角色
     * @return type
     */
    public function updateRole($data,$roleid)
    {
        $feilds = array_keys($data);
        $this->daoHelper = new sys_daohelper(null,self::TABLE_ROLE,sys_define::$main_db);
        $iRet =  $this->daoHelper->update($feilds, $data,'id ='.$roleid);
        if($iRet === false)
        {
           sys_log::getLogger()->fatal(sys_log::format('updateRole',['id'=>$roleid])); 
           return $iRet;
        }
        return $iRet;
    } 


    //删除角色
    public function role_del($roleid)
    {
        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE, sys_define::$main_db);
        $ret             = $this->daoHelper->remove('id=:id', ['id' => $roleid]);
        if ($ret == false)
        {
            sys_log::getLogger()->fatal(sys_log::format('admin.role_del', ['id' => $roleid]));
        }
        return $ret;
    }   
    
    
    /**
     * 
     * @param type $aWhere
     * @param type $iPerRow
     * @param type $iNowPage
     * @return type
     */
    public function getRolePage($aWhere=[],$iPerRow=10,$iNowPage=1,$aParam=[])
    {
        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE, sys_define::$main_db);
        $sSql = "SELECT * FROM " .self::TABLE_ROLE ." WHERE 1=1 ";

        if (is_string($aWhere)) {
            $sSql .= " ".$aWhere.' ';
        }else{
            foreach ($aWhere as $sField=>$sValue)
            {
                $sSql .= empty($sField)? "":" AND $sField = '$sValue' ";
            }
        }
        
        $aAll = $this->daoHelper->fetchBySql($sSql);//所有记录
        //分页对象
        $oPagination = new lib_pagination_pagination($iNowPage,count($aAll), $iPerRow,$aParam);
        $rolesList['page'] = $oPagination->makePage();
        
        $iStart = ($oPagination->iNowPage-1)*$oPagination->iPerRow;
        $iStart = $iStart<0 ? 0 : $iStart;
        $rolesList['data']  = $this->daoHelper->fetchBySql($sSql.' ORDER BY create_time DESC LIMIT '.$iStart. ',' .$oPagination->iPerRow);
        return $rolesList; 
    }


    //通过id获取角色的信息 
    public function getRoleById($roleid)
    {
        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE, sys_define::$main_db);
        $ret = $this->daoHelper->fetchSingle('id=:roleid', ['roleid' => $roleid]);
        if ($ret == false)
        {
            sys_log::getLogger()->fatal(sys_log::format('admin.getRoleById', ['roleid' => $roleid]));
        }
        return $ret;
        
    }


    //获取所有角色的信息 
    public function getAllRole()
    {
        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE, sys_define::$main_db);
        $ret = $this->daoHelper->fetchAll();
        if ($ret == false)
        {
            sys_log::getLogger()->fatal(sys_log::format('admin.getAllRole', array()));
        }
        return $ret;
        
    }


    //获取角色的名称信息（按照多个id一次获取） 
    public function getAllRoleName($idStr)
    {
        $tablename = self::TABLE_ROLE;
        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE, sys_define::$main_db);
        $query = "SELECT id,role_name FROM {$tablename} WHERE id in(".$idStr.")";

        $ret = $this->daoHelper->fetchBySql($query);
        return $ret;
        
    }


    /*----------------------------- 以下是用户角色添加、修改 ------------------------------------------------*/

    /**
     * 
     * 判断用户角色表中，该用户是否存在记录
     */
    public function isExistUserRole($uid)
    {
        if(empty($uid)){
            return false;
        }

        $this->daoHelper = new sys_daohelper(null, self::TABLE_USER_ROLE, sys_define::$main_db);
        $ret = $this->daoHelper->fetchSingle('user_id=:user_id', ['user_id' => $uid]);

        if ($ret == false)
        {
            sys_log::getLogger()->fatal(sys_log::format('admin.isExistUserRole', array('user_id' => $uid)));
        }

        return $ret;  
    }


    //添加用户角色
    public function addUserRole($data)
    {
        $aFeilds = array_keys($data);
        $this->daoHelper = new sys_daohelper(null,self::TABLE_USER_ROLE,sys_define::$main_db);
        $iInsertId = $this->daoHelper->add($aFeilds, $data,null, 1);
        return $iInsertId;
    }

    /**
     * 修改角色
     * @return type
     */
    public function updateUserRole($uid, $data)
    {
        $feilds = array_keys($data);
        $this->daoHelper = new sys_daohelper(null,self::TABLE_USER_ROLE,sys_define::$main_db);
        $iRet =  $this->daoHelper->update($feilds, $data,'user_id ='.$uid);
        if($iRet === false)
        {
           sys_log::getLogger()->fatal(sys_log::format('admin.updateUserRole',['user_id'=>$uid])); 
           return $iRet;
        }
        return $iRet;
    } 


    /**
     * 通过用户id获取用户的角色
     */
    public function getRoleByUid($uid)
    {
        if(empty($uid)){
            return false;
        }

        $this->daoHelper = new sys_daohelper(null, self::TABLE_USER_ROLE, sys_define::$main_db);
        $ret = $this->daoHelper->fetchSingle('user_id=:user_id', ['user_id' => $uid]);

        if ($ret == false)
        {
            sys_log::getLogger()->fatal(sys_log::format('admin.getRoleByUid', array('user_id' => $uid)));
        }

        return $ret; 
    } 


    /*----------------------------- 以下是角色权限分配的添加、修改 ------------------------------------------------ */ 

    /**
     * 
     * 判断角色权限表中，该角色权限是否存在记录
     */
    public function isExistRoleMenu($roleid, $type=1)
    {
        if(empty($roleid) || empty($type)){
            return false;
        }

        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE_ROUTE, sys_define::$main_db);
        $ret = $this->daoHelper->fetchSingle('role_id=:role_id and type=:type', ['role_id' => $roleid,'type' => $type]);

        if ($ret == false)
        {
            sys_log::getLogger()->fatal(sys_log::format('admin.isExistRoleMenu', array('isExistRoleMenu' => $roleid)));
        }

        return $ret;  
    }


    //添加用户角色
    public function addRoleMenu($data)
    {
        $aFeilds = array_keys($data);
        $this->daoHelper = new sys_daohelper(null,self::TABLE_ROLE_ROUTE,sys_define::$main_db);
        $iInsertId = $this->daoHelper->add($aFeilds, $data, null, 1);
        return $iInsertId;
    }

    /**
     * 修改角色
     * @return type
     */
    public function updateRoleMenu($roleid, $data, $type)
    {
        $feilds = array_keys($data);
        $this->daoHelper = new sys_daohelper(null,self::TABLE_ROLE_ROUTE,sys_define::$main_db);
        $iRet =  $this->daoHelper->update($feilds, $data,'role_id ='.$roleid.' and type='.$type);

        if($iRet === false)
        {
           sys_log::getLogger()->fatal(sys_log::format('admin.updateRoleMenu',['role_id'=>$roleid])); 
           return $iRet;
        }
        return $iRet;
    }

    /**
     * 
     * 通过角色id获取角色权限
     */
    public function getMenuByRoleid($roleid)
    {
        $this->daoHelper = new sys_daohelper(null, self::TABLE_ROLE_ROUTE, sys_define::$main_db);
        $ret1 = $this->daoHelper->fetchSingle('role_id=:role_id and type=:type', ['role_id' => $roleid,'type' => 1]);
        $menu1 = json_decode($ret1['route'],true);

        $ret2 = $this->daoHelper->fetchSingle('role_id=:role_id and type=:type', ['role_id' => $roleid,'type' => 2]);
        $menu2 = json_decode($ret2['route'],true);

        return array(
            'menu1' => $menu1,
            'menu2' => $menu2
        );  
    }  
    
}
