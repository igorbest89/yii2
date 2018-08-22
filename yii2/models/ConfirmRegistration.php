<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_systems".
 *
 * @property integer $confirm_registration_id
 * @property integer $confirm_registration_user_id
 * @property string $confirm_registration_token
 */
class ConfirmRegistration extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'confirm_registrations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['confirm_registration_user_id', 'confirm_registration_token'],
                'required'
            ],
            [
                ['confirm_registration_token'],
                'string'
            ],
            [
                ['confirm_registration_user_id'],
                'integer'
            ],
            [
                ['confirm_registration_id'],
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
            'confirm_registration_id'      => 'ID',
            'confirm_registration_user_id' => 'User ID',
            'confirm_registration_token'   => 'Token'
        ];
    }

    /**
     * Create confirm data
     *
     * @param $id
     * @param $token
     */
    public static function createConfirmData($id, $token){
        $confirmData =  new self();
        $confirmData->confirm_registration_user_id = $id;
        $confirmData->confirm_registration_token = $token;
        $confirmData->save(false);
    }

    /**
     * Check confirm data
     *
     * @param $data
     * @return boolean
     */
    public static function confirmUser($data){
       $confirmed =  self::findOne(['confirm_registration_user_id' => $data['id'], 'confirm_registration_token' => $data['confirm_token']]);

       return (!empty($confirmed)) ? true : false;
    }
}
