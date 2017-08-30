<?php

namespace app\models\paylist;

use yii\base\Model;
/**
 * 等级添加验证
 */
class Addtable extends Model
{
    public $tablenum;
	public $paytype;
	public $MSG;

    public function rules()
    {
        return [
           //  ['tablenum','required','message'=>'必须填写.'],
        ];
    }
}