<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>

<link rel="stylesheet" href="<?php yii::$app->request->baseUrl?>css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php yii::$app->request->baseUrl?>css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php yii::$app->request->baseUrl?>css/uniform.css" />
<link rel="stylesheet" href="<?php yii::$app->request->baseUrl?>css/select2.css" />
<link rel="stylesheet" href="<?php yii::$app->request->baseUrl?>css/matrix-style2.css" />
<link rel="stylesheet" href="<?php yii::$app->request->baseUrl?>css/matrix-media.css" />
<link href="<?php yii::$app->request->baseUrl?>font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.useso.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<style>
  *{font-family: 楷体;}
</style>
 <script src="<?php yii::$app->request->baseUrl?>js/jquery.min.js"></script>
    <?php echo $content?>

<script src="<?php yii::$app->request->baseUrl?>assets/layer/layer.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/jquery.ui.custom.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/bootstrap.min.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/jquery.uniform.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/select2.min.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/jquery.dataTables.min.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/matrix.js"></script>
<script src="<?php yii::$app->request->baseUrl?>js/matrix.tables.js"></script>
