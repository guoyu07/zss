<?php
namespace frontend\constrollers;


use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use frontend\controllers\WeixinController;

/** 
 * 后台公共控制器基础类
 */
class BaseController extends WeixinController
{
  

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
    /*
    *随机数生成器 
    *$len 生成长度
    */
    public function GetRandStr($len) { 
    $chars = array( 
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
        "3", "4", "5", "6", "7", "8", "9" 
    ); 
    $charsLen = count($chars) - 1; 
    shuffle($chars);   
    $output = ""; 
    for ($i=0; $i<$len; $i++) 
    { 
        $output .= $chars[mt_rand(0, $charsLen)]; 
    }  
    return $output;  
} 


//获取微信端 openid

 public function getopenid($appid,$secret,$code){


         $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$get_token_url);  
            curl_setopt($ch,CURLOPT_HEADER,0);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
            $res = curl_exec($ch);  
            curl_close($ch);  
            $json_obj = json_decode($res,true);  
            var_dump($json_obj);die;
            
            //根据openid和access_token查询用户信息  
            $access_token = $json_obj['access_token'];  
            $openid = $json_obj['openid']; 

            return $openid; 
 }
 
 
 //获取微信号具体信息
 public function getuserdata($token,$openid){
 
    $get_token_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid&lang=zh_CN";
     
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL,$get_token_url);
     curl_setopt($ch,CURLOPT_HEADER,0);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     $res = curl_exec($ch);
     curl_close($ch);
     $json_obj = json_decode($res,true);

     return $json_obj;
 }
 
 //获取assess_token
 public function gettoken($appid,$secret){
     $get_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
      echo $get_token_url;die;
     $ch = curl_init();
     curl_setopt($ch,CURLOPT_URL,$get_token_url);
     curl_setopt($ch,CURLOPT_HEADER,0);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     $res = curl_exec($ch);
     curl_close($ch);
     $json_obj = json_decode($res,true);
     
     return $json_obj['access_token'];
}


}