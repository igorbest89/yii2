<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "category_description".
 *
 * @property integer $category_id
 * @property integer $language_id
 * @property string $category_name
 * @property string $category_description
 * @property string $category_meta_title
 * @property string $category_meta_description
 * @property string $category_meta_keywords
 */
class CategoryDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['category_name', 'category_description', 'category_meta_title', 'category_meta_description', 'category_meta_keywords'],
                'required'
            ],
            [
                ['category_name', 'category_description', 'category_meta_title', 'category_meta_description', 'category_meta_keywords'],
                'string'
            ],
            [
                ['language_id', 'category_id'],
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
            'category_id'               => 'ID of category',
            'language_id'               => 'ID of language',
            'category_name'             => 'Name',
            'category_description'      => 'Description',
            'category_meta_title'       => 'Meta title',
            'category_meta_description' => 'Meta description',
            'category_meta_keywords'    => 'Meta keywords'
        ];
    }
}
