<?php
namespace frontend\controllers;

use yii\base\Controller;
use backend\models\shop\Shop;


class ShopController extends Controller{

    /*
     * 显示门店
     * */
    public function actionIndex(){
        $shop = new Shop();
        $shops = $shop->shop_order();
        return $this->render('index',['shops'=>$shops]);
    }
}
?>
