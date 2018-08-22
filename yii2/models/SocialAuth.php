<?php

namespace app\models;

use yii\db\ActiveRecord;


class SocialAuth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'socialAuth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'number'],
            [['source','source_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'user_id'        => 'user_id',
            'source'         => 'source',
            'source_id'      => 'Geo source_id',
        ];
    }


}
