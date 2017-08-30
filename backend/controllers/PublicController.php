<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use common\components\FileToken;

/**
 * 后台登陆
 */
class PublicController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            //错误提示
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

            //验证码
            'captcha' => [
              'class' => 'yii\captcha\CaptchaAction',
              'maxLength' => 5,
              'minLength' => 5
            ],
        ];
    }
    
    /**
     * 登陆处理及界面
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderAjax('login.php', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 退出登陆
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
