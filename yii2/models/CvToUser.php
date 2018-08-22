<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cv_to_user".
 *
 * @property integer $cv_to_user_id
 * @property integer $cv_to_user_user_id
 * @property integer $cv_to_user_cv_id
 */
class CvToUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cv_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['cv_to_user_user_id', 'cv_to_user_cv_id'],
                'required'
            ],
            [
                ['cv_to_user_user_id', 'cv_to_user_cv_id'],
                'integer'
            ],
            [
                ['cv_to_user_id'],
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
            'cv_to_user_id'      => 'ID',
            'cv_to_user_user_id' => 'ID of user',
            'cv_to_user_cv_id'   => 'ID of cv'
        ];
    }

    /**
     * Method for add cv to user association type to DB
     * @param $cvId
     * @param $userId
     * @return integer | null
     */
    public static function addCvToUserAssociationType($cvId, $userId)
    {
        $type = new self();
        $type->cv_to_user_cv_id = $cvId;
        $type->cv_to_user_user_id = $userId;

        if ($type->save()) {

            return $type->cv_to_user_id;

        } else {

            return null;
        }
    }
}
