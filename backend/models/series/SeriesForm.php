<?php

namespace backend\models\series;

use \yii\base\Model;

class SeriesForm extends Model{
	public $series_sort;
	public $series_status;
	public $created_at;
	public $updated_at;
	public $series_name;
	public $series_id;



	 public function rules()
    {
        return [
             [['series_sort', 'series_name'], 'required'],
           	[['series_name'], 'string', 'max' => 50,"message"=>"超过最大字段值"],
           	[['series_sort'], 'number', 'max' =>9999,"message"=>"超过最大字段值"]

        ];
    }

    



}
