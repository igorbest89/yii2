<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "skills".
 *
 * @property integer $skill_id
 * @property string $skill_name
 * @property string $skill_description
 * @property boolean $skill_status
 */
class Skill extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skills';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['skill_name', 'skill_status'],
                'required'
            ],
            [
                ['skill_name', 'skill_description'],
                'string'
            ],
            [
                ['skill_id', 'skill_status'],
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
            'skill_id'          => 'ID',
            'skill_name'        => 'Name',
            'skill_description' => 'Description',
            'skill_status'      => 'Status'
        ];
    }
}
