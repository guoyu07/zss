<?php

namespace app\models\paylist;

use Yii;

class Cart extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%cart}}';
    }
	
    public function delcart($uid){
		return $this->find($uid)->delete();
	}
}
