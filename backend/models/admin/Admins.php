<?php

namespace backend\models\admin;
use backend\models\admin\Admin;

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
class Admins extends Admin
{
	public $password_re;
	/**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at','teacher_name','password_re','teacher_desc','teacher_at'], 'required'],
            [['role', 'status', 'created_at', 'updated_at', 'login_time'], 'integer'],
            [['password_hash', 'password_reset_token', 'email','teacher_desc','teacher_at'], 'string', 'max' => 255],
			[['username'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 32],
            [['login_ip'], 'string', 'max' => 30],
            [['username'], 'unique'],
			[['email'], 'unique', 'message'=>'{attribute}已经被占用了'],
			['email','match','pattern'=>'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/','message'=>'{attribute}格式不对'],
			['password_re','compare','compareAttribute'=>'password_hash','message'=>'两次密码不一致'],
			
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'login_time' => 'Login Time',
            'login_ip' => 'Login Ip',
			'password_re' => '确认密码',
        ];
    }
}	
