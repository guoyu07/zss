<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property integer $group_id
 * @property string $group_name
 * @property integer $group_ctime
 * @property integer $group_show
 * @property integer $group_start
 * @property integer $group_end
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_id
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_ctime', 'group_show', 'group_start', 'group_end', 'created_at', 'updated_at', 'updated_id'], 'integer'],
            [['group_name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'group_name' => 'Group Name',
            'group_ctime' => 'Group Ctime',
            'group_show' => 'Group Show',
            'group_start' => 'Group Start',
            'group_end' => 'Group End',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_id' => 'Updated ID',
        ];
    }
}
