<?php

namespace backend\models\market;

use Yii;

/**
 * This is the model class for table "{{%gift}}".
 *
 * @property integer $gift_id
 * @property string $gift_name
 * @property integer $gift_num
 * @property string $gift_price
 * @property integer $updated_at
 * @property integer $end_at
 * @property integer $created_at
 */
class Gift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gift}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gift_num', 'updated_at', 'end_at', 'created_at'], 'integer'],
            [['gift_price'], 'number'],
            [['gift_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gift_id' => '赠品自增id',
            'gift_name' => '赠品名称',
            'gift_num' => '赠品数量',
            'gift_price' => '赠品价格',
            'updated_at' => '修改时间',
            'end_at' => '结束时间',
            'created_at' => '创建时间',
        ];
    }

	public function select()
	{
		return $this->find()
			->select(["zss_gift.gift_id",
			"zss_gift.gift_name",
			"zss_gift.gift_num",
			"zss_gift.gift_price",
			"zss_gift.gift_show",
			"zss_admin.username"])
			->innerjoin("`zss_admin` on `zss_gift`.`updated_id` = `zss_admin`.`id`")
			->asArray()
			->all();
	}
	//删除选中的
	public function delone($data)
	{
		return $this->findOne($data['id'])->delete();
	}
	//修改显示状态
	public function ChangeOneShow($data)
	{
		$gift = $this->findOne($data['id']);
		if($data['show'] == 1){
			$gift->gift_show = 0;
		}
		if($data['show'] == 0){
			$gift->gift_show = 1;
		}
		return $gift->save();
	}


	//查询赠品的单条详情
	public function getOneinfo($data)
	{
		 $giftinfo = $this->find()
			 ->select(["zss_gift.created_at",
			 "zss_gift.end_at",
			 "zss_admin.username",
			 "zss_gift.updated_at",
			 "zss_gift.gift_id",
			 "zss_gift.gift_price",
			 "zss_gift.gift_show",
			 "zss_gift.gift_num",
			 "zss_gift.gift_name"])
			 ->innerjoin("`zss_admin` on `zss_gift`.`updated_id` = `zss_admin`.`id`")
			 ->where(["zss_gift.gift_id"=>$data['id']])
			 ->asArray()
			 ->One();
		 $giftinfo['created_at'] = date("Y-m-d",$giftinfo['created_at']);
		 $giftinfo['end_at'] = date("Y-m-d",$giftinfo['end_at']);
		 $giftinfo['updated_at'] = date("Y-m-d",$giftinfo['updated_at']);
		 if($giftinfo['gift_show']==1){
			$giftinfo['gift_show'] = "是";
		 }else{
			$giftinfo['gift_show'] = "否";
			}
		 return $giftinfo;

	}

	//添加赠品数据
	 public function add_gift($data)
	{
		$this->gift_name = $data['GiftForm']['gift_name'];
		$this->gift_show = $data['gift_show'];
		$this->gift_num = $data['GiftForm']['gift_num'];
		$this->gift_price = $data['GiftForm']['gift_price'];
		$this->updated_id = Yii::$app->user->identity->id;//添加人
		$this->end_at	  = strtotime($data['GiftForm']['end_at']);
		$this->created_at = time();
		$this->updated_at = time();
		return $this->save();	 
	 }

	 //批量删除赠品
	 public function delmore($str)
	{
		return $this->deleteAll(["in","gift_id",$str]);
	 }

	 //获取单条数据的信息4
	 public function getOne($id)
	{
		return $this->findOne($id);
	 }

	 //修改赠品信息

	 public function update_gift($data,$id)
	{
		$gift = $this->findOne($id);
		$gift->gift_name = $data['GiftupForm']['gift_name'];
		$gift->gift_price = $data['GiftupForm']['gift_price'];
		$gift->gift_num = $data['GiftupForm']['gift_num'];
		$gift->end_at = strtotime($data['GiftupForm']['end_at']);
		$gift->gift_show = $data['gift_show'];
		$gift->updated_at = time();
		$gift->updated_id = Yii::$app->user->identity->id;//修改人
		return $gift->save();
	 }

	 //模糊查询
	 public function selectwhere($where)
	{
		 return $this->find()
			->select(["zss_gift.gift_id",
			"zss_gift.gift_name",
			"zss_gift.gift_num",
			"zss_gift.gift_price",
			"zss_gift.gift_show",
			"zss_admin.username"])
			 ->innerjoin("`zss_admin` on `zss_gift`.`updated_id` = `zss_admin`.`id`")
			 ->where(["like","zss_gift.gift_name",$where])
			 ->asArray()
			 ->all();
	 }	



	//检查红包名称
	function checkname($data)
	{
		$arr = $this->find()
				->select(['gift_id','gift_name'])
				->where(["gift_name"=>$data['name']])
				->asArray()
				->one();
		if(isset($arr['gift_name']))
		{
			if($arr['gift_name'] == $data['name'] && $arr['gift_id'] == $data['id'])
			{
				return true;
			}
			else if($arr['gift_name'] == $data['name'])
			{
				return false;
			}
			else
			{

				return true;
			}
		}
		else
		{
			return true;
		}
	}	
}
