<?php

namespace app\models\paylist;

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
 * @property integer $updated_id
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
            [['wallet_is_price', 'updated_id', 'wallet_show', 'created_at', 'updated_at'], 'integer'],
            [['wallet_price', 'wallet_share_price', 'wallet_shares_price'], 'number'],
            [['wallet_name'], 'string', 'max' => 50],
            [['wallet_template'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wallet_id' => 'Wallet ID',
            'wallet_name' => 'Wallet Name',
            'wallet_is_price' => 'Wallet Is Price',
            'wallet_price' => 'Wallet Price',
            'wallet_share_price' => 'Wallet Share Price',
            'wallet_shares_price' => 'Wallet Shares Price',
            'updated_id' => 'Updated ID',
            'wallet_show' => 'Wallet Show',
            'wallet_template' => 'Wallet Template',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	//查询登录用户下有没有红包    返回0或1
	public function getWallet($userId)
	{
		$wallet_id = (new \yii\db\Query())
			->select(['wallet_id'])
			->from('zss_user')
			->where(['user_id' => $userId])
			->limit(1) 
			->One();
		$wallet_arr = explode(",",$wallet_id['wallet_id']);
		
		foreach($wallet_arr as $k=>$v)
		{
			if($v === ''){
				return 0;
			}
		}
		return 1;
	}

	//查寻用户账户下的红包信息
	public function getWalletinfo($userId)
	{
		$wallet_id = (new \yii\db\Query())
			->select(['wallet_id'])
			->from('zss_user')
			->where(['user_id' => $userId])
			->limit(1) 
			->One();
		$wallet = $wallet_id['wallet_id'];
		return $this->find()
					->select(['wallet_name',
							  'wallet_id',
							  'wallet_price',
							  'wallet_endtime'
							])
					->where("wallet_id in ($wallet)")
					->asArray()
					->all();
	}
}
