<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories".
 *
 * @property integer $category_id
 * @property string $category_image
 * @property integer $category_parent_id
 * @property integer $category_sort_order
 * @property boolean $category_status
 * @property string $category_alias
 */
class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['category_image', 'category_parent_id', 'category_sort_order', 'category_status', 'category_alias'],
                'required'
            ],
            [
                ['category_image', 'category_alias'],
                'string'
            ],
            [
                ['category_parent_id', 'category_sort_order'],
                'integer'
            ],
            [
                ['category_id', 'category_status'],
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
            'category_id'         => 'ID',
            'category_image'      => 'Image',
            'category_parent_id'  => 'ID of parent category',
            'category_sort_order' => 'Sort order',
            'category_alias'      => 'Alias',
            'category_status'     => 'Status'
        ];
    }
}
