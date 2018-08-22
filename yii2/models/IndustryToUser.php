<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "industry_to_user".
 *
 * @property integer $industry_to_user_id
 * @property integer $industry_to_user_user_id
 * @property integer $industry_to_user_industry_id
 */
class IndustryToUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'industry_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['industry_to_user_user_id', 'industry_to_user_industry_id'],
                'required'
            ],
            [
                ['industry_to_user_user_id', 'industry_to_user_industry_id'],
                'integer'
            ],
            [
                ['industry_to_user_id'],
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
            'industry_to_user_id'          => 'ID',
            'industry_to_user_user_id'     => 'ID of user',
            'industry_to_user_industry_id' => 'ID of industry'
        ];
    }

    /**
     * Method for add industry to user association type to DB
     * @param $industryId
     * @param $userId
     * @return integer | null
     */
    public static function addIndustryToUserAssociationType($industryId, $userId)
    {
        $type = new self();
        $type->industry_to_user_industry_id = $industryId;
        $type->industry_to_user_user_id = $userId;

        if ($type->save()) {

            return $type->industry_to_user_id;

        } else {

            return null;
        }
    }
}
