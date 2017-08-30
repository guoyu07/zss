<?php

namespace backend\models\admin;

use Yii;

/**
 * This is the model class for table "{{%edu_auth_role_node}}".
 *
 * @property integer $role_id
 * @property integer $node_id
 * @property integer $node_level
 */
class AuthRoleNode extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%auth_role_node}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['role_id', 'node_id',], 'required'],
			[['role_id', 'node_id',], 'integer']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'role_id' => 'Role ID',
			'node_id' => 'Node ID',
		];
	}
	/**
	* 查询权限
	*/
	public function RoleNode($id){
		return $this->find()
				->where(['=','role_id',$id])
				->asArray()
				->all();
	}
	/**
	* 查询权限
	*/
	public function RoleNodeIn($role_id){
		return $this->find()
				->where("role_id in ($role_id)")
				->asArray()
				->all();
	}
}
