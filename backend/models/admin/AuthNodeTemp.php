<?php

namespace backend\models\admin;

use Yii;

/**
 * This is the model class for table "{{%edu_auth_node_temp}}".
 *
 * @property integer $node_temp_id
 * @property string $node_temp_name
 * @property string $node_temp_title
 * @property integer $node_temp_status
 * @property string $node_temp_remark
 * @property integer $node_temp_sort
 * @property integer $node_temp_pid
 * @property integer $node_temp_level
 * @property integer $node_temp_admin
 * @property integer $node_temp_expire
 * @property integer $node_temp_share_id
 */
class AuthNodeTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_node_temp}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['node_id','node_temp_status', 'node_temp_sort', 'node_temp_pid', 'node_temp_level', 'node_temp_admin', 'node_temp_expire', 'node_temp_share_id'], 'integer'],
            [['node_temp_name'], 'string', 'max' => 20],
            [['node_temp_title'], 'string', 'max' => 50],
            [['node_temp_remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'node_temp_id' => 'Node Temp ID',
			'node_id' => 'Node ID',
            'node_temp_name' => 'Node Temp Name',
            'node_temp_title' => 'Node Temp Title',
            'node_temp_status' => 'Node Temp Status',
            'node_temp_remark' => 'Node Temp Remark',
            'node_temp_sort' => 'Node Temp Sort',
            'node_temp_pid' => 'Node Temp Pid',
            'node_temp_level' => 'Node Temp Level',
            'node_temp_admin' => 'Node Temp Admin',
            'node_temp_expire' => 'Node Temp Expire',
            'node_temp_share_id' => 'Node Temp Share ID',
        ];
    }
	/**
	* 查询所有
	*/
	public function TempUser($admin_id){
		return $this->find()
				->select('node_temp_admin')
				->where(['=','node_temp_share_id',$admin_id])
				->asArray()
				->all();
	}

	/**
	* 查询临时权限用户的权限
	*/
	public function TempNode($user_id){
		return $this->find()
				->where(['=','node_temp_admin',$user_id])
				->asArray()
				->all();
	}
	/**
	*删除临时权限
	*/
	public function TempDelete($code){
		return $this ->deleteAll($code);
	}
}
