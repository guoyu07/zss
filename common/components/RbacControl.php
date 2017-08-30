<?php

namespace common\components;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;

/**
 * 作者：王文秀
 * 时间：2016-03-26
 * 功能：rbac权限控制
 */
class RbacControl extends ActionFilter
{
    
    public $user = 'user';     //user组件
      
    public $controller = '';   //当前访问控制器
    
    public $action = '';       //当前访问方法

    public $user_info = 'user_info';  //当前验证用户的信息
    
    
    /**
     * 初始化方法
     */
    public function init()
    {
        parent::init();

        //获取user实例
        $this->user = Instance::ensure($this->user, User::className());
        $this->user_info = $this->user->identity;
    }

    
    // 在控制器方法执行前调用 
    
    public function beforeAction($action)
    {
        //获取当前访问控制器和方法名
        $this->controller = $action->controller->id;
        $this->action = $action->id;

        //判断是否登陆
        if ($this->user->getIsGuest()) {
            //未登陆
            $this->user->loginRequired();
        } else {  
            //是否为登陆验证模式,查询权限并存入session
            if (Yii::$app->params['rbac']['user_auth_type'] == 1) {
                $access = $this->saveAccessList();
                Yii::$app->params['access'] = $access;
            }
            //进行操作权限认证
            if (!$this->accessDecision()) {
                if ( Yii::$app->request->isAjax ) {  
                    die(json_encode(['code'=>403, 'msg'=>'暂无权限！']));
                } else {
                    //登录判断权限进行跳转
                    $access = Yii::$app->params['access'];
                    /*$url = [];
                    foreach ($access as $key => $value) {
                        foreach ($value as $k => $v) {
                            $url = [strtolower($key).'/'.strtolower($k)];
                            break;
                        }
                        break;
                    }*/
                    $urls = ['site/index2'];
                    $action->controller->redirect($urls);
                    //throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
                }
            } else {
                
                return true;
            } 
        }
      
    }

    //用于检测用户权限的方法,并保存到Session中
    public function saveAccessList($auth_id = null)
    {
        
        if(null===$auth_id)   $auth_id = $this->user_info->id;
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        if( $this->user_info->username != Yii::$app->params['rbac']['admin_auth_key'] )
            Yii::$app->session['_ACCESS_LIST']	=	$this->getAccessList($auth_id);    
        
        return ;
    }

    // 权限认证的过滤器方法
    public function AccessDecision() {
        //检测是否需要验证
        if ($this->checkAccess()) {
            $accessGuid   =   md5($this->controller.$this->action);
            if($this->user_info->username != Yii::$app->params['rbac']['admin_auth_key']) {
                if(Yii::$app->params['rbac']['user_auth_type'] == 2) {
                    
                    //通过数据库进行访问检查
                    $accessList = $this->getAccessList($this->user->id);
                }else {
                    // 如果是管理员或者当前操作已经认证过，无需再次认证
                    if( Yii::$app->session[$accessGuid] ) {
                        return true;
                    }
                    //登录验证模式，比较登录后保存的权限访问列表
                    $accessList = Yii::$app->session['_ACCESS_LIST'];
                }

                if(!isset($accessList[strtoupper($this->controller)][strtoupper($this->action)])) {
                    Yii::$app->session[$accessGuid]  =  false;
                    return false;
                }else {
                    Yii::$app->session[$accessGuid]  =	 true;
                }
            }else{
                //管理员无需认证
				return true;
			}
        }
        return true;
    }

    //检查当前操作是否需要认证
    public function checkAccess() {
        //判断是否开启RBAC验证，当前访问控制器是否不需要验证
        $is_auth = Yii::$app->params['rbac']['user_auth_on'];
        $not_auth_module = Yii::$app->params['rbac']['not_auth_controller'];
        if ($is_auth && !in_array($this->controller, $not_auth_module)) {
            return true;
        }
        return false;
    }

    //获取当前登陆用户权限列表
    public function getAccessList($auth_id)
    {

        $table = [
            'role'   => Yii::$app->params['rbac']['rbac_role_table'],
            'user'   => Yii::$app->params['rbac']['rbac_user_table'],
            'access' => Yii::$app->params['rbac']['rbac_access_table'],
            'node'   => Yii::$app->params['rbac']['rbac_node_table'],
        ];
        $controller_map  = [
            'user.admin_id'    =>  (int)$auth_id,
            'role.role_status' =>  1,
            'node.node_level'  =>  1,
            'node.node_pid'    =>  0,
            'node.node_status' =>  1,
        ];

        //获取控制器访问权限列表
        $controllers = (new \yii\db\Query())
              ->select(['node.node_id', 'node.node_name'])
              ->from($table['role'].' as role')
              ->innerJoin($table['user'].' as user', '`user`.role_id = role.role_id')
              ->innerJoin($table['access'].' as access', 'access.role_id = role.role_id')
              ->innerJoin($table['node'].' as node', 'access.node_id = node.node_id')
              ->where($controller_map)
              ->all();
        

        $access =  array();
        //获取控制器对应方法的权限列表
        foreach ($controllers as $key => $items) {
            $controller_id   = $items['node_id'];
            $controller_name = $items['node_name'];
            $access[strtoupper($controller_name)] = array();
            $action_map = [
                'user.admin_id'    =>  (int)$auth_id,
                'role.role_status' =>  1,
                'node.node_level'  =>  2,
                'node.node_pid'    =>  (int)$controller_id,
                'node.node_status' =>  1,
            ];
            
            
            //获取控制器访问权限列表
            $result = (new \yii\db\Query())
                ->select(['node.node_id', 'node.node_name'])
                ->from($table['role'].' as role')
                ->innerJoin($table['user'].' as user', '`user`.role_id = role.role_id')
                ->innerJoin($table['access'].' as access', 'access.role_id = role.role_id')
                ->innerJoin($table['node'].' as node', 'access.node_id = node.node_id')
                ->where($action_map)
                ->all();
            $actions = array();
            foreach ($result as $k=>$value) {
                $actions[$value['node_name']] = $value['node_id'];
            }
            

            $access[strtoupper($controller_name)]   =  array_change_key_case($actions, CASE_UPPER);

            //获取临时权限
            

        }
        $temp_access = $this->getTempAccess($auth_id);
		//合并临时授权 和 本身权限
		$access = ArrayHelper::merge($access, $temp_access);
        //添加公用首页权限
        $public = ['SITE' => ['INDEX'=>'','INDEX2'=>'']];
        $access = ArrayHelper::merge($access,$public);
        Yii::$app->params['access'] = $access;
        return array_merge($access, $temp_access);
    }

    //获取临时权限
    public function getTempAccess($auth_id) {
		$action_map = [
				'node_temp_admin'    =>  (int)$auth_id,
				'node_temp_pid'    =>  0,
				'node_temp_status' =>  1,
			];
		//获取rbac的edu_auth_node_temp临时权限表
		$temp = Yii::$app->params['rbac']['rbac_temp_table'];
		//获取控制器访问权限列表
		$controllers = (new \yii\db\Query())
			->select(['node_id', 'node_temp_name'])
			->from($temp)
			->where($action_map)
			->all();
            if ($controllers) {
                //获取控制器对应方法的权限列表
                foreach ($controllers as $key => $items) {
                    $controller_id   = $items['node_id'];
                    $controller_name = $items['node_temp_name'];
                    $access[strtoupper($controller_name)] = array();
                    $action_map = [
                       'node_temp_admin'    =>  (int)$auth_id,
                        'node_temp_status' =>  1,
                        'node_temp_pid'    =>  (int)$controller_id,
                    ];
                    //获取控制器访问权限列表
                    $result = (new \yii\db\Query())
                        ->select(['node_id', 'node_temp_name'])
                        ->from($temp)
                        ->where($action_map)
                        ->all();
                    $actions = array();
                    foreach ($result as $k=>$value) {
                        $actions[$value['node_temp_name']] = $value['node_id'];
                    }
                   
                    //array_change_key_case数组的所有的 KEY 都转换为大写或小写 默认小写   CASE_UPPER大写
                    $access[strtoupper($controller_name)]   =  array_change_key_case($actions, CASE_UPPER);
                }
                return $access ? $access : [];
            }else{
                return [];
            }
		

    }
}
/*
$map = ['and',['>', 'id', 0]];
if ($c) $map[] = ['like', 'c', $c];
if ($d) $map[] = ['liek', 'd', $d]; 
*/