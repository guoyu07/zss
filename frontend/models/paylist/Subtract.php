<?php

namespace app\models\paylist;

use Yii;

/**
 * This is the model class for table "{{%subtract}}".
 *
 * @property integer $subtract_id
 * @property string $subtract_price
 * @property string $subtract_subtract
 * @property integer $subtract_show
 * @property integer $updated_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Subtract extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subtract}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subtract_price', 'subtract_subtract'], 'number'],
            [['subtract_show', 'updated_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subtract_id' => 'Subtract ID',
            'subtract_price' => 'Subtract Price',
            'subtract_subtract' => 'Subtract Subtract',
            'subtract_show' => 'Subtract Show',
            'updated_id' => 'Updated ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	//查询满减表的信息
	public function getSubtract()
	{
		return $this->find()
		->select(['subtract_id','subtract_price','subtract_subtract'])
		->asArray()
		->all();
	}	 
	
}
