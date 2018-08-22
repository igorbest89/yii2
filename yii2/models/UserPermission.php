<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_permission".
 *
 * @property integer $permission_id
 * @property string $permission_name
 * @property string $permission_action
 * @property boolean $permission_status
 */
class UserPermission extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['permission_name', 'permission_action', 'permission_status'],
                'required'
            ],
            [
                ['permission_name', 'permission_action'],
                'string'
            ],
            [
                ['permission_id', 'permission_status'],
                'safe'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'permission_id'     => 'ID',
            'permission_name'   => 'Name',
            'permission_action' => 'Action',
            'permission_status' => 'Status'
        ];
    }
}
