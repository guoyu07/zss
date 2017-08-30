<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property integer $image_id
 * @property string $image_url
 * @property string $image_wx
 * @property string $image_pc
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $model_id
 * @property integer $image_status
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'model_id', 'image_status'], 'integer'],
            [['image_url', 'image_wx', 'image_pc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'image_url' => 'Image Url',
            'image_wx' => 'Image Wx',
            'image_pc' => 'Image Pc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'model_id' => 'Model ID',
            'image_status' => 'Image Status',
        ];
    }
}
