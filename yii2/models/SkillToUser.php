<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "skill_to_user".
 *
 * @property integer $skill_id
 * @property integer $user_id
 */
class SkillToUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skill_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['skill_id', 'user_id'],
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
            'skill_id' => 'ID of skill',
            'user_id'  => 'ID of user'
        ];
    }
}
