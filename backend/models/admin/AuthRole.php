<?php

namespace backend\models\admin;

use Yii;

/**
 * This is the model class for table "{{%edu_auth_role}}".
 *
 * @property integer $role_id
 * @property string $role_name
 * @property integer $role_status
 * @property string $role_remark
 */
class AuthRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_status'], 'integer'],
			[['role_name', 'role_remark'], 'required'],
            [['role_name'], 'string', 'max' => 20],
            [['role_remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => '角色名称',
            'role_status' => '状态',
            'role_remark' => '备用信息',
        ];
    }
    /**
    * 查询
    */
    public function RoleCount($code)
    {
        return $this->find()
                    ->where($code)
                    ->count();
    }
    /**
    * 搜索查询
    */
    public function RoleSearch($code)
    {
        return $this->find()
                ->where($code)
                ->asArray()
                ->all();
    }
    /**
    * 修改禁用状态
    */
    public function RoleStatus($id,$status)
    {
        return $this->updateAll(['role_status' => $status],'role_id=:role',[':role'=>$id]);
    }
	/**
    * 查询所有的角色
    */
    public function RoleSelect()
    {
        return $this->find()
                ->where(['=','role_status','1'])
                ->asArray()
                ->all();
    }
}
