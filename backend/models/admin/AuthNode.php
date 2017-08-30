<?php

namespace backend\models\admin;

use Yii;

/**
 * This is the model class for table "{{%edu_auth_node}}".
 *
 * @property integer $node_id
 * @property string $node_name
 * @property string $node_title
 * @property integer $node_status
 * @property string $node_remark
 * @property integer $node_sort
 * @property integer $node_pid
 * @property integer $node_level
 */
class AuthNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['node_name', 'node_title', 'node_pid', 'node_level'], 'required'],
            [['node_status', 'node_sort', 'node_pid', 'node_level'], 'integer'],
            [['node_name'], 'string', 'max' => 20],
            [['node_title'], 'string', 'max' => 50],
            [['node_remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'node_id' => 'Node ID',
            'node_name' => 'Node Name',
            'node_title' => 'Node Title',
            'node_status' => 'Node Status',
            'node_remark' => 'Node Remark',
            'node_sort' => 'Node Sort',
            'node_pid' => 'Node Pid',
            'node_level' => 'Node Level',
        ];
    }
	/**
	* 查询
	*/
	public function AuthCount($code)
	{
		return $this->find()
					->where($code)
					->count();
	}
	/**
	* 搜索查询
	*/
	public function AuthSearch($code)
    {
		return $this->find()
				->where($code)
				->orderBy(['node_sort'=>SORT_DESC])
				->asArray()
				->all();
	}
	/**
	* 修改禁用状态
	*/
	public function AuthStatus($id,$status)
	{
		return $this->updateAll(['node_status' => $status],'node_id=:node',[':node'=>$id]);
	}
	/**
	* 查询所有
	*/
	public function AuthSelect(){
		return $this->find()
				->where(['=','node_status','1'])
				->asArray()
				->all();
	}
	/**
	* 查询所有
	*/
	public function AuthIn($node_id){
		return $this->find()
				->where("node_id in ($node_id) and node_status = 1")
				->asArray()
				->all();
	}
}
