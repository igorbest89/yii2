<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_to_account".
 *
 * @property integer $account_id
 * @property integer $user_id
 * @property integer id
 *
 */
class UserToAccount extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_to_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['account_id', 'user_id'],
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
            'account_id' => 'ID of account',
            'user_id'    => 'ID of user'
        ];
    }
}
