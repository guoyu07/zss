<?php

namespace backend\models\shop;

use yii\base\Model;

class ShopForm extends Model
{
    public $shop_name;
    public $shop_tel;
	public $shop_status;
	public $shop_address;
	public $shop_x;
	public $shop_y;
	public $admin;
	public $distribution;
	public $lunchbox;
	public $add_id;
	public $subtract_id;
	
	/**
     * @inheritdoc
     * 定义的正则验证规则
     */
    public function rules()
    {
        return [
			['shop_name', 'required','message' => '店名不能为空'],
			['admin', 'required','message' => '店长不能为空'],
			['shop_name', 'unique', 'targetClass' => 'backend\models\shop\Shop', 'message' => '该店已经存在'],
			['shop_tel', 'required', 'message' => '门店电话不能为空'],
			['shop_address', 'required', 'message' => '门店地址不能为空'],
			['shop_x', 'required', 'message' => '门店经度不能为空'],
			['shop_y', 'required', 'message' => '门店纬度不能为空'],
			['shop_tel','match','pattern'=>'/^1[34578]\d{9}$/','message'=>'请输入正确的手机号码.'],
			['shop_x','match','pattern'=>'/^[0-9\.]{4,10}$/','message'=>'请输入正确的门店经度.'],
			['shop_y','match','pattern'=>'/^[0-9\.]{4,10}$/','message'=>'请输入正确的门店纬度.'],

		];

    }

	/**
     * @inheritdoc
     * 返回表对应属性
     */
    public function attributeLabels()
    {
        return [
            'shop_name' => '门店名称',
            'shop_tel' => '门店电话',
            'shop_status' => '门店状态',
            'shop_address' =>'门店地址',
			'shop_x' =>'门店经度',
			'shop_y' =>'门店纬度',
        ];
    }



}