<?php 
namespace frontend\controllers;


use yii\base\Controller;
class MenuController extends Controller{
    
    /*
     * 显示菜单
     * */
    public function actionIndex(){
        return $this->render('menu');
    }
}
?>