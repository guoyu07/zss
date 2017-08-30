<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%carousel}}".
 *
 * @property integer $carousel_id
 * @property string $carousel_title
 * @property string $carousel_original
 * @property string $carousel_pc
 * @property string $carousel_wx
 * @property string $carousel_desc
 * @property integer $group_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
 */
class Carousel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carousel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carousel_desc'], 'string'],
            [['group_id', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['carousel_title'], 'string', 'max' => 50],
            [['carousel_original', 'carousel_pc', 'carousel_wx'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'carousel_id' => 'Carousel ID',
            'carousel_title' => 'Carousel Title',
            'carousel_original' => 'Carousel Original',
            'carousel_pc' => 'Carousel Pc',
            'carousel_wx' => 'Carousel Wx',
            'carousel_desc' => 'Carousel Desc',
            'group_id' => 'Group ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_id' => 'Updated ID',
        ];
    }
    
    /*
     * 获取当前轮播组数据
     * */
    public function GetNewCarousel(){
        return $this->find()
        ->select(['carousel_wx'])
        ->innerJoin("`zss_group` on `zss_carousel`.`group_id` = `zss_group`.`group_id`")
        ->orderBy('zss_carousel.updated_at')
        ->where("zss_group.group_show = 1 && group_show = 1")
        ->asArray()
        ->limit(3)
        ->all();
    }
}
