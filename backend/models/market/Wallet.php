<?php

namespace backend\models\market;

use Yii;

/**
 * This is the model class for table "{{%wallet}}".
 *
 * @property integer $wallet_id
 * @property string $wallet_name
 * @property integer $wallet_is_price
 * @property string $wallet_price
 * @property string $wallet_share_price
 * @property string $wallet_shares_price
 * @property integer $wallet_show
 * @property string $wallet_template
 * @property integer $created_at
 * @property integer $updated_at
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wallet_is_price', 'wallet_show', 'created_at', 'updated_at'], 'integer'],
            [['wallet_price', 'wallet_share_price', 'wallet_shares_price'], 'number'],
            [['wallet_template'], 'string'],
            [['wallet_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wallet_id' => '自增id',
            'wallet_name' => '红包名称',
            'wallet_is_price' => '是否限定金额',
            'wallet_price' => '限定的金额数',
            'wallet_share_price' => '分享者得到的金额',
            'wallet_shares_price' => '被分享者得到的金额',
            'wallet_show' => '是否显示',
            'wallet_template' => '红包模板',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

	//查询红包数据
	 public function select()
	 {
		 return $this->find()
			 ->select(["zss_wallet.created_at",
			 "zss_wallet.updated_at",
			 "zss_wallet.wallet_id",
			 "zss_wallet.wallet_name",
			 "zss_wallet.wallet_price",
			 "zss_wallet.wallet_is_price",
			 "zss_wallet.wallet_show",
			 "zss_admin.username",
			 "zss_wallet.wallet_share_price",
			 "zss_wallet.wallet_shares_price",
			 ])
			 ->innerjoin("`zss_admin` on `zss_wallet`.`updated_id` = `zss_admin`.`id`")
			 ->asArray()
			 ->all();
	 }


	//条件搜索红包数据
	 public function selectwhere($sea)
	 {
		 return $this->find()
			 ->select(["zss_wallet.created_at",
			 "zss_wallet.updated_at",
			 "zss_wallet.wallet_id",
			 "zss_wallet.wallet_name",
			 "zss_wallet.wallet_price",
			 "zss_wallet.wallet_is_price",
			 "zss_wallet.wallet_show",
			 "zss_admin.username",
			 "zss_wallet.wallet_share_price",
			 "zss_wallet.wallet_shares_price",
			 ])
			 ->innerjoin("`zss_admin` on `zss_wallet`.`updated_id` = `zss_admin`.`id`")
			 ->where(["like","wallet_name",$sea])
			 ->asArray()
			 ->all();
	 }



	 //删除选中的红包数据
	 public function delOne($id)
	 {
		return $this->findOne($id)->delete();
	 }
	//检查红包名称
	function checkname($data)
	{
		$arr = $this->find()
				->select(['wallet_id','wallet_name'])
				->where(["wallet_name"=>$data['name']])
				->asArray()
				->one();
		if(isset($arr['wallet_name']))
		{
			if($arr['wallet_name'] == $data['name'] && $arr['wallet_id'] == $data['id'])
			{
				return true;
			}
			else if($arr['wallet_name'] == $data['name'])
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
	 //修改红包表的数据
	 public function update_wallet($data,$id)
	 {
		 $wallet = $this->findOne($id);
		//判断是否限额
		/*if($data['wallet_limit'] == 1){
			$all = 1;
			$share = 1;
			$shares = 0;
		}
		if($data['wallet_limit'] == 0){
			$all = $data['WalletupForm']['wallet_price']?$data['WalletupForm']['wallet_price']:1;
			$share = $data['WalletupForm']['wallet_share']?$data['WalletupForm']['wallet_share']:1;
			$shares = $all-$share;
		}
	*/
		$wallet->wallet_name = htmlspecialchars($data['WalletupForm']['wallet_name']);	//名称
		//$wallet->wallet_is_price = $data['wallet_limit'];	//是否限额
		//$wallet->wallet_price = $all;						//红包总额
		$wallet->wallet_share_price = $data['wallet_share'];				//分享者得到
		$wallet->wallet_shares_price = $data['wallet_shares'];				//被分享者得到
		$wallet->wallet_show = $data['wallet_show'];			//是否显示
		$wallet->wallet_template = $data['wallet_template'];	//红包模板
		$wallet->updated_id = Yii::$app->user->identity->id;//修改人
		$wallet->updated_at = time();				//修改时间
		return $wallet->save();						//返回修改结果

	 }

	 //为红包添加数据
	 public function add_wallet($data)
	{
		//判断是否限额
		/*if($data['wallet_limit'] == 1){
			$all = 1;
			$share = 1;
			$shares = 0;
		}
		if($data['wallet_limit'] == 0){
			$all = $data['WalletForm']['wallet_price']?$data['WalletForm']['wallet_price']:1;
			$share = $data['WalletForm']['wallet_share']?$data['WalletForm']['wallet_share']:1;
			$shares = $all-$share;
		}*/

		$this->wallet_name = htmlspecialchars($data['WalletForm']['wallet_name']);			//名称
		//$this->wallet_is_price = 0;						//是否限额
		//$this->wallet_price = $all;		//红包总额
		$this->wallet_share_price = $data['wallet_share'];	//分享者得到
		$this->wallet_shares_price = $data['wallet_shares'];	//被分享者得到
		$this->wallet_show = $data['wallet_show'];							//是否显示
		$this->wallet_template = $data['wallet_template'];	//红包模板
		$this->updated_id = Yii::$app->user->identity->id;//修改人
		$this->created_at = time();											//添加时间
		$this->updated_at = time();											//修改时间
		return $this->save();
	 }

	 //查询修改红包表的的数据
	 public function getOne($data)
	{
		return $this->findOne($data['id']);
	 }

 //修改一条数据的的显示状态
	 public function ChangeOneShow($data)
	{
		$wallet = $this->findOne($data['id']);
		if($data['show'] == 1){
			$wallet->wallet_show = 0;
		}
		if($data['show'] == 0){
			$wallet->wallet_show = 1;
		}
		return $wallet->save();
	 }

	 //查询一条数据的详情
	 public function getOneinfo($data)
	{
		 $wallet = $this->find()
			 ->select(["zss_wallet.created_at",
			 "zss_wallet.updated_at",
			 "zss_wallet.wallet_id",
			 "zss_wallet.wallet_name",
			 "zss_wallet.wallet_price",
			 "zss_wallet.wallet_is_price",
			 "zss_wallet.wallet_show",
			 "zss_wallet.wallet_template",
			 "zss_admin.username",
			 "zss_wallet.wallet_share_price",
			 "zss_wallet.wallet_shares_price",
			 ])
			 ->innerjoin("`zss_admin` on `zss_wallet`.`updated_id` = `zss_admin`.`id`")
			 ->where(["wallet_id"=>$data['id']])
			 ->asArray()
			 ->One();
			if($wallet['wallet_is_price'] == 1){
				$wallet['wallet_is_price']='是';
			}else{
				$wallet['wallet_is_price']='否';
			}

			if($wallet['wallet_show'] == 1){
				$wallet['wallet_show']='是';
			}else{
				$wallet['wallet_show']='否';
			}
			$wallet['created_at'] = date("Y-m-d",$wallet['created_at']);
			$wallet['updated_at'] = date("Y-m-d",$wallet['updated_at']); 
			return $wallet;
	 }
	 //批量删除红包
	 public function delmore($str)
	{
		return $this->deleteAll(["in","wallet_id",$str]);
	 }
}
