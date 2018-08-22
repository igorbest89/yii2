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
class AuthAssignment extends ActiveRecord
{
    public $item_name;
    public $user_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }


    /**
     * @inheritdoc
     */



}
