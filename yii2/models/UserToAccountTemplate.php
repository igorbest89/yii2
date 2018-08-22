<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_to_account_template".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $template_id
 */
class UserToAccountTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_to_account_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['template_id', 'user_id'],
                'required'
            ],
            [
                ['template_id', 'user_id'],
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
            'id'          => 'ID',
            'user_id'     => 'ID of file',
            'template_id' => 'ID of user'
        ];
    }

    /**
     * Method for add user to template association type to DB
     * @param $templateId
     * @param $userId
     * @return boolean
     */
    public static function addFileToUserAssociationType($templateId, $userId)
    {
        $type = new self();
        $type->template_id = $templateId;
        $type->user_id = $userId;

        if ($type->save()) {

            return true;

        } else {

            return false;
        }
    }
}
