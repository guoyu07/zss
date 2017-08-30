<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Weixin;

/**
 * This is the model class for table "{{%weixin}}".
 *
 * @property integer $wx_id
 * @property integer $user_id
 * @property string $wx_name
 */
class Useweixin extends Model
{

	public function index($username){

	$model = new Weixin();

	$model->wx_name = $username;

	$model->user_id = 2;

	return $model->save();
	}		



}