<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "industry".
 *
 * @property integer $industry_id
 * @property string $industry_name
 * @property string $industry_description
 */
class Industry extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'industry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['industry_name'],
                'required'
            ],
            [
                ['industry_name', 'industry_description'],
                'string'
            ],
            [
                ['industry_id'],
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
            'industry_id'          => 'ID',
            'industry_name'        => 'File',
            'industry_description' => 'Format'
        ];
    }

    /**
     * Method for add industry to DB
     * @param $industryName
     * @param $industryDescription
     * @return integer | null
     */
    public function addIndustry($industryName, $industryDescription = null)
    {
        $this->industry_name = $industryName;
        $this->industry_description = $industryDescription;

        if ($this->save()) {

            return $this->industry_id;

        } else {

            return null;
        }
    }
}
