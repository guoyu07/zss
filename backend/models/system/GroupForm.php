<?php

namespace backend\models\system;

use yii\base\Model;

class GroupForm extends Model{

    public $group_name;
    public $group_show;
    public $group_ctime;
    public $group_start;
    public $group_end;

    public function rules(){
        return [
            [['group_name', 'group_ctime'], 'required'],            
        ];
    }
}