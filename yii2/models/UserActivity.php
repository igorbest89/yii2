<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_activity".
 *
 * @property integer $user_activity_id
 * @property integer $user_activity_user_id
 * @property integer $user_activity_date
 * @property string $user_activity_ip
 * @property string $user_activity_key
 * @property string $user_activity_data
 */
class UserActivity extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_activity_date', 'user_activity_ip', 'user_activity_key', 'user_activity_data', 'user_activity_date'],
                'required'
            ],
            [
                ['user_activity_ip', 'user_activity_key', 'user_activity_data'],
                'string'
            ],
            [
                ['user_activity_id', 'user_activity_user_id', 'user_activity_date'],
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
            'user_activity_id'       => 'ID',
            'user_activity_user_id' => 'ID of user',
            'user_activity_date'    => 'Date of activity',
            'user_activity_ip'      => 'IP',
            'user_activity_key'     => 'Key',
            'user_activity_data'    => 'Data'
        ];
    }
}
