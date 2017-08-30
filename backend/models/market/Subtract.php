<?php

namespace backend\models\market;

use Yii;

/**
 * This is the model class for table "{{%subtract}}".
 *
 * @property integer $subtract_id
 * @property string $subtract_price
 * @property string $subtract_subtract
 * @property integer $subtract_show
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
            [['subtract_show', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subtract_id' => '自增id',
            'subtract_price' => '满足条件的金额',
            'subtract_subtract' => '可减的金额',
            'subtract_show' => 'Subtract Show',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

	//满减的查询
	public function select()
	{
		 return $this->find()
			 ->select(["zss_subtract.created_at",
			 "zss_subtract.subtract_id",
			 "zss_subtract.subtract_subtract",
			 "zss_subtract.subtract_price",
			 "zss_admin.username",
			 "zss_subtract.updated_at",
			 "zss_subtract.subtract_show",
			 ])
			 ->innerjoin("`zss_admin` on zss_subtract.`updated_id` = `zss_admin`.`id`")
			 ->asArray()
			 ->all();
	}

	 //删除选中的满减数据
	 public function delOne($id)
	 {
		return $this->findOne($id)->delete();
	 }
	//为满减表添加数据
	public function add_subtract($data)
	{
		$this->subtract_price = $data['SubtractForm']['subtract_price'];
		$this->subtract_subtract = $data['SubtractForm']['subtract_subtract'];
		$this->subtract_show = $data['discount_show'];
		$this->updated_id = Yii::$app->user->identity->id;//修改人
		$this->created_at = time();
		$this->updated_at = time();
		return $this->save();
	}

	//获取要修改的数据信息
	public function getOne($id)
	{
		return $this->findOne($id);
	}


	//修改选中的满减数据信息
	 public function update_subtract($data,$id)
	 {
		$subtract = $this->findOne($id);

		$subtract->subtract_price = $data['SubtractForm']['subtract_price'];		//满
		$subtract->subtract_subtract = $data['SubtractForm']['subtract_subtract'];	//减
		$subtract->subtract_show = $data['discount_show'];		//是否显示
		$subtract->updated_id = Yii::$app->user->identity->id;//修改人
		$subtract->updated_at = time();				//修改时间
		return $subtract->save();			//返回修改结果

	 }

	//修改选中信息的显示状态
	public function  ChangeOneShow($data)
	{
		$subtract = $this->findOne($data['id']);
		if($data['show'] == 1){
			$subtract->subtract_show = 0;
		}
		if($data['show'] == 0){
			$subtract->subtract_show = 1;
		}
		return $subtract->save();
	}
	//查询满减的单条详情
	public function getOneinfo($data)
	{
		 $subinfo =  $this->find()
			 ->select(["zss_subtract.created_at",
			 "zss_subtract.subtract_id",
			 "zss_subtract.subtract_subtract",
			 "zss_subtract.subtract_price",
			 "zss_admin.username",
			 "zss_subtract.updated_at",
			 "zss_subtract.subtract_show",
			 ])
			 ->innerjoin("`zss_admin` on zss_subtract.`updated_id` = `zss_admin`.`id`")
			 ->where(['subtract_id'=>$data['id']])
			 ->asArray()
			 ->One();
		 $subinfo['created_at'] = date("Y-m-d",$subinfo['created_at']);
		 $subinfo['updated_at'] = date("Y-m-d",$subinfo['updated_at']);
		 if($subinfo['subtract_show']==1){
			$subinfo['subtract_show']="是";
		 }else{
			$subinfo['subtract_show']="否";
		 }
		 return $subinfo;
	}
	 //批量删除满减
	 public function delmore($str)
	{
		return $this->deleteAll(["in","subtract_id",$str]);
	 }
}
