<?php

namespace backend\models\market;

use Yii;

/**
 * This is the model class for table "{{%add}}".
 *
 * @property integer $add_id
 * @property string $add_price
 * @property integer $gift_id
 * @property integer $add_show
 * @property integer $created_at
 * @property integer $updated_at
 */
class Add extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%add}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['add_price'], 'number'],
            [['gift_id', 'add_show', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'add_id' => '自增id',
            'add_price' => '满足条件的金额',
            'gift_id' => '赠品id',
            'add_show' => '是否显示',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

	//查询满赠列表
	public function select()
	{
		 return $this->find()
			 ->select(["zss_add.created_at as start_time",
			 "zss_admin.username",
			 "zss_add.updated_at as upd_time",
			 "zss_add.add_id",
			 "zss_add.add_price",
			 "zss_add.add_show",
			 "zss_gift.gift_name"])
			 ->innerjoin("`zss_gift` on `zss_add`.`gift_id` = `zss_gift`.`gift_id`")
			 ->innerjoin("`zss_admin` on `zss_add`.`updated_id` = `zss_admin`.`id`")
			 ->asArray()
			 ->all();
	}

	//条件查询满赠列表
	public function selectwhere($sea)
	{
		 return $this->find()
			 ->select(["zss_add.created_at as start_time",
			 "zss_admin.username",
			 "zss_add.updated_at as upd_time",
			 "zss_add.add_id",
			 "zss_add.add_price",
			 "zss_add.add_show",
			 "zss_gift.gift_name"])
			 ->innerjoin("`zss_gift` on `zss_add`.`gift_id` = `zss_gift`.`gift_id`")
			 ->innerjoin("`zss_admin` on `zss_add`.`updated_id` = `zss_admin`.`id`")
			 ->where(["like","zss_gift.gift_name",$sea])
			 ->asArray()
			 ->all();
	}


	 //删除选中的满赠数据
	 public function delOne($id)
	 {
		return $this->findOne($id)->delete();
	 }

	 //添加新增表数据
	 public function add_add($data)
	{
		$this->add_price = $data['AddForm']['add_price'];
		$this->gift_id = $data['gift'];
		$this->add_show = $data['add_show'];
		$this->updated_id = Yii::$app->user->identity->id;//修改人
		$this->created_at = time();
		$this->updated_at = time();
		return $this->save();	 
	 }

	 //查询选中的满赠信息
	 public function getOne($id)
	{
		return $this->findOne($id);
	 }

	 //修改满赠表的数据信息

	 public function update_add($data,$id)
	{
		$add = $this->findOne($id);

		$add->add_price = $data['AddForm']['add_price'];
		$add->gift_id = $data['gift'];
		$add->add_show = $data['add_show'];
		$add->updated_id = Yii::$app->user->identity->id;//修改人
		$add->updated_at = time();
		return $add->save();
	 }

	//修改选中信息的显示状态
	public function  ChangeOneShow($data)
	{
		$add = $this->findOne($data['id']);
		if($data['show'] == 1){
			$add->add_show = 0;
		}
		if($data['show'] == 0){
			$add->add_show = 1;
		}
		return $add->save();
	}
	//查询选中满赠的单条详情
	public function getOneinfo($data)
	{
		 $addinfo = $this->find()
			 ->select(["zss_add.created_at as start_time",
			 "zss_admin.username",
			 "zss_add.updated_at as upd_time",
			 "zss_add.add_id",
			 "zss_add.add_price",
			 "zss_add.add_show",
			 "zss_gift.gift_name"])
			 ->innerjoin("`zss_gift` on `zss_add`.`gift_id` = `zss_gift`.`gift_id`")
			 ->innerjoin("`zss_admin` on `zss_add`.`updated_id` = `zss_admin`.`id`")
			 ->where(["zss_add.add_id"=>$data['id']])
			 ->asArray()
			 ->One();
		 $addinfo['start_time'] = date("Y-m-d",$addinfo['start_time']);
		 $addinfo['upd_time'] = date("Y-m-d",$addinfo['upd_time']);
		 if($addinfo['add_show']==1){
			$addinfo['add_show'] = "是";
		 }else{
			$addinfo['add_show'] = "否";
			}
		 return $addinfo;

	}
	 //批量删除满赠
	 public function delmore($str)
	{
		return $this->deleteAll(["in","add_id",$str]);
	 }
}
