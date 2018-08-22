<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "file_to_user".
 *
 * @property integer $file_to_user_id
 * @property integer $file_to_user_file_id
 * @property integer $file_to_user_user_id
 * @property integer $file_to_user_created_at
 * @property integer $file_to_user_updated_at
 */
class FileToUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['file_to_user_file_id', 'file_to_user_user_id', 'file_to_user_created_at', 'file_to_user_updated_at'],
                'required'
            ],
            [
                ['file_to_user_file_id', 'file_to_user_user_id', 'file_to_user_created_at', 'file_to_user_updated_at'],
                'integer'
            ],
            [
                ['file_to_user_id'],
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
            'file_to_user_id'         => 'ID',
            'file_to_user_file_id'    => 'ID of file',
            'file_to_user_user_id'    => 'ID of user',
            'file_to_user_created_at' => 'Date of creating',
            'file_to_user_updated_at' => 'Date of updating'
        ];
    }

    /**
     * Method for add file to user association type to DB
     * @param $fileId
     * @param $userId
     * @return integer | null
     */
    public static function addFileToUserAssociationType($fileId, $userId)
    {
        $type = new self();
        $type->file_to_user_file_id = $fileId;
        $type->file_to_user_user_id = $userId;
        $type->file_to_user_created_at = time();
        $type->file_to_user_updated_at = time();

        if ($type->save()) {

            return $type->file_to_user_id;

        } else {

            return null;
        }
    }
}
