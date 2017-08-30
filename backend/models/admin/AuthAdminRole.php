<?php

namespace backend\models\admin;

use Yii;

/**
 * This is the model class for table "{{%edu_auth_admin_role}}".
 *
 * @property integer $admin_id
 * @property integer $role_id
 */
class AuthAdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_admin_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'role_id'], 'required'],
            [['admin_id', 'role_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'role_id' => 'Role ID',
        ];
    }
	/**
	* 查询角色
	*/
	public function AdminRole($id){
		return $this->find()
				->where(['=','admin_id',$id])
				->asArray()
				->all();
	}
}
