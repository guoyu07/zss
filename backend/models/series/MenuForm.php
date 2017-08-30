<?php

namespace backend\models\series;

use \yii\base\Model;

class MenuForm extends Model{

     public $menu_sort;
     public $menu_name;
     public $menu_code;
     public $series_id;
     public $menu_price;
     public $menu_introduce;
     public $menu_status;
     public $shop_show;
  
     public $created_at;
     public $updated_at;
     public $image_url;
     public $image_wx;
     public $image_pc;

    public function Rules(){
        return [
        [['menu_name','series_id','menu_price',"menu_sort",'menu_introduce',"menu_code"], 'required',"message"=>"添加信息不能为空"],
            [['series_id'], 'integer'],
            [['menu_price'], 'number',"message"=>"价格格式不对！"],
            [['menu_price'], 'number','max' => 9999999999],
            [['shop_show'], 'number',"message"=>"格式不对！"],
            [['menu_sort'], 'number','max' => 255,"message"=>"格式不对！"],
            [['menu_name'], 'string', 'max' => 150,"message"=>"菜品名称格式不对"],
            [['menu_introduce'], 'string', 'max' => 255,"message"=>"字数太长"]
        ];
    }

    

    
		
}   
