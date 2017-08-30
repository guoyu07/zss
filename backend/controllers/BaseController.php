<?php
namespace backend\controllers;

use Yii;
use common\components\RbacControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


/** 
 * 后台公共控制器基础类
 */
class BaseController extends Controller
{
    /** 
     * 行为方法，加载过滤器
     */
    public function behaviors()
    {
        return [

            //RBAC权限控制
            'access' => [
                'class' => RbacControl::className(),
            ],

            //指定方法的请求方式
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 用于加载公共action类
     */
    public function actions()
    {
        return [

            //公共错误页面
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 自定义成功跳转
     * @params $msg  提示信息
     * @params $redirct 跳转地址
     */
    protected function success($msg, $redirect = [])
    {
        Yii::$app->getSession()->setFlash('success', $msg, true);
        if (! $redirect) $redirect = [$this->id.'/'.$this->action->id];
        $this->redirect($redirect);
    }

    /**
     * 自定义错误跳转
     * @params $msg  提示信息
     * @params $redirct 跳转地址
     */
    protected function error($msg, $redirect = [])
    {
        Yii::$app->getSession()->setFlash('error', $msg, true);
        if (! $redirect) $redirect = [$this->id.'/'.$this->action->id];
        $this->redirect($redirect);
    }

    /**
     *  生成url
     * @params $url 访问地址
     */
    protected function createUrl($url)
    {
        return Yii::$app->urlManager->createUrl($url);
    }

    /**
     *  ajax成功返回
     *  @params $data 返回的数据
     *  @params $code 返回状态码
     *  @params $msg  返回信息描述
     */
    protected function ajaxSuccess($data, $code = null, $msg = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => $code ? $code : '200',
            'msg'  => $msg ? $msg : '操作成功！',
            'data' => $data,
        ];
    }

    /**
     *  ajax失败返回
     *  @params $data 返回的数据
     *  @params $code 返回状态码
     *  @params $msg  返回信息描述
     */
    protected function ajaxError($data, $code = null, $msg = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => $code ? $code : '400',
            'msg'  => $msg ? $msg : '操作失败！',
            'data' => $data,
        ];
    }

    /**
     * 设置cookie
     * @params $key     名
     * @params $value   值
     * @params $expire  过期时间
     */
    protected function setCookie($key, $value, $expire = 0)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name'  => $key,
            'value' => $value,
            'expire'=> $expire,
        ]));
    }

    /**
     *  返回cookie对象
     *  用于get(获取)  remove(删除) has(检测是否存在)
     */
    protected function cookies()
    {
        return Yii::$app->request->cookies;
    }

    /**
     *  返回session对象
     *  get(获取) set(设置) remove(删除) has(检测是否存在) destroy(销毁)
     */
    protected function session(){
        return Yii::$app->session;
    }

    /*
    *传入参数:
    *$dir string 源图路径
    *$filename 文件名
    *$target_width integer 目标图宽度
    *$target_height integer 目标图高度
    *源图支持MIMETYPE: image/gif, image/jpeg, image/png ,bmp.
    */
   public function fileSet($dir,$filename,$thumbWi=100,$thumbHe=100)
    {
        $file = $dir.$filename;
         $lastnum = strrpos($filename,".");//判断位置
        $type = substr($filename, $lastnum+1);
        //设置缩略图的文件名
        $thu_filename = rand(100000,999999);
        $time = time(); 
        $thu_file=$dir."thu_".$thu_filename.$time.".".$type;//缩略图名
        //$menu_wx=substr($thu_file,33);
       
        if (strtolower($type)=="png") {
             $im=imagecreatefrompng($file);  //原图的信息
        }
        if (strtolower($type)=="jpg"||strtolower($type)=="jpeg") {
             $im=imagecreatefromjpeg($file);  //原图的信息
        }
        if (strtolower($type)=="bmp") {
             $im=imagecreatefrombmp($file);  //原图的信息
        }
        if (strtolower($type)=="gif") {
             $im=imagecreatefromgif($file);  //原图的信息
        }
       
       

        list($src_W,$src_H)=getimagesize($file);
        $tn = imagecreatetruecolor($thumbWi, $thumbHe); //创建缩略图

        imagecopyresampled($tn, $im, 0, 0, 0, 0, $thumbWi,$thumbHe, $src_W, $src_H); //复制图像并改变大小

        imagejpeg($tn,$thu_file); //图像生成


        return "thu_".$thu_filename.$time.".".$type;
    }
		 
	//获取用户ID
    public function getUserid(){

    return $username = Yii::$app->user->identity->id;//获取session

    }

    /**
     * 输出方法(方便看测试数据);
     * @param $var [要打印的数据]
     */
    public function p($var)
    {
        if (is_bool($var)) {
            var_dump($var);
        } else if (is_null($var)) {
            var_dump(NULL);
        } else {
            echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
        }
    }


}