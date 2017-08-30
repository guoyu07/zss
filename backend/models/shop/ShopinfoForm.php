<?php

namespace backend\models\shop;

use yii\base\Model;

class ShopinfoForm extends Model
{
    public $shop_name;
    public $shop_tel;
	public $shop_status;
	public $shop_address;
	public $shop_x;
	public $shop_y;
	public $takeaway_start_time;
	public $takeaway_end_time;
	public $eat_start_time;
	public $eat_end_time;
	public $shop_remark;
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
			['shop_tel', 'required', 'message' => '门店电话不能为空'],
			['shop_address', 'required', 'message' => '门店地址不能为空'],
			['shop_x', 'required', 'message' => '门店经度不能为空'],
			['shop_y', 'required', 'message' => '门店纬度不能为空'],
			['takeaway_start_time', 'required', 'message' => '外卖开始时间不能为空'],
			['takeaway_end_time', 'required', 'message' => '外卖结束时间不能为空'],
			['eat_end_time', 'required', 'message' => '堂食开始时间不能为空'],
			['eat_end_time', 'required', 'message' => '堂食结束时间不能为空'],
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