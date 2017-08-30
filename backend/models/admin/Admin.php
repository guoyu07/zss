<?php

namespace backend\models\admin;

use Yii;

/**
 * This is the model class for table "{{%edu_admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $login_time
 * @property string $login_ip
 */
class Admin extends \yii\db\ActiveRecord
{
    public $user_repassword;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key','email','type'], 'required'],
            [['role', 'status', 'created_at', 'updated_at', 'login_time'], 'integer'],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 30],
            ['email','unique'],
            [['auth_key'], 'string', 'max' => 32],
            ['user_repassword', 'compare', 'compareAttribute' => 'auth_key', 'message' => '两次密码不一致'],
            [['login_ip'], 'string', 'max' => 30],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'login_time' => 'Login Time',
            'login_ip' => 'Login Ip',
            'type' => 'Type',
        ];
    }
	
	/**
	* 修改禁用状态
	*/
	public function AdminStatus($id,$status)
	{
		return $this->updateAll(['status' => $status],'id=:admin',[':admin'=>$id]);
	}
	/**
	* 查询
	*/
	public function AdminCount($code)
	{
		return $this->find()
					->where($code)
					->count();
	}
	/**
	* 搜索查询
	*/
	public function AdminSearch($code)
    {
		return $this->find()
				->where($code)
				->orderBy(['created_at'=>SORT_DESC])
				->asArray()
				->all();
	}
	/**
	* 查询管理员详情
	*/
	public function AdminInfo($id)
	{
		return $this->find()
				->where(['=','id',$id])
				->asArray()
				->one();
	}
	/**
	* 修改邮箱
	*/
	public function EmailSave($id,$email)
	{
		return $this->updateAll(['email' => $email],'id=:admin',[':admin'=>$id]);
	}
	/**
	* 查询所有
	*/
	public function AdminSelect($code)
	{
		return $this->find()
					->where($code)
					->asArray()
					->all();
	}
}	
