<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%series}}".
 *
 * @property integer $series_id
 * @property string $series_name
 * @property integer $series_sort
 * @property integer $series_status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
 */
class Series extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%series}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['series_sort', 'series_status', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['series_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'series_id' => 'Series ID',
            'series_name' => 'Series Name',
            'series_sort' => 'Series Sort',
            'series_status' => 'Series Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_id' => 'Updated ID',
        ];
    }
    
    
    /*
     * 查询所有分类数据
     * */
    public function GetSeriesAll(){
        return $this->find()
        ->select(['zss_menu.menu_id','menu_name','zss_menu.series_id','menu_price','image_wx','menu_introduce'])
        ->innerJoin("`zss_menu` on `zss_series`.`series_id` = `zss_menu`.`series_id`")
        //->innerJoin("`zss_shop_menu` on `zss_shop_menu`.`menu_id` = `zss_menu`.`menu_id`")
        ->innerJoin("`zss_image` on `zss_menu`.`menu_id` = `zss_image`.`model_id`")
        ->where("series_status = 1")->asArray()->all();
    }
}
