<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "invitations".
 *
 * @property integer $id
 * @property integer $referer_id
 * @property string $email
 * @property string tmpInvitation
 * @property string active_status
 */
class Invitation extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['email', 'referer_id','tmpInvitation'],
                'required'
            ],
                [
                    ['email'], 'unique'
                ],[
                    ['tmpInvitation'], 'unique'
                ],
            [
                ['referer_id','active_status'],
                'integer'
            ],
            [
                ['id'],
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
            'id'         => 'ID',
            'referer_id' => 'Referer ID',
            'email'      => 'Email',
            'tmpInvitation'      => 'temp value for access to resource',
            'active_status'      => '0 if user not approve 1 if approve'
        ];
    }
}
