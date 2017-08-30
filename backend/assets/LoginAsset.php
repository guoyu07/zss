<?php
/**
 * 后台登录界面 
 *
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login.css',
    ];
    public $js = [
        'assets/1902591f/jquery.min.js',
    ];
    
    //加载页面js文件
    public static function addPageScript($view, $jsfile){
        $view->registerJsFile($jsfile, [LoginAsset::className(), 'depends' => 'backend\assets\LoginAsset']);
    }

}