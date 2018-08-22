<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "category_path".
 *
 * @property integer $category_id
 * @property integer $category_path_id
 */
class CategoryPath extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_path';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['category_id', 'category_path_id'],
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
            'category_id'      => 'ID of category',
            'category_path_id' => 'ID of path'
        ];
    }
}
