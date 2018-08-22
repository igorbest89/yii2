<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $currency_id
 * @property string $currency_code
 * @property float $currency_rate
 * @property boolean $currency_is_default
 * @property string $currency_icon
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['currency_code', 'currency_rate'],
                'required'
            ],
            [
                ['currency_code', 'currency_icon'],
                'string'
            ],
            [
                ['currency_rate'],
                'number'
            ],
            [
                ['currency_id', 'currency_is_default'],
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
            'currency_id'         => 'ID',
            'currency_code'       => 'Currency code',
            'currency_rate'       => 'Rate',
            'currency_is_default' => 'Default currency flag',
            'currency_icon'       => 'Icon'
        ];
    }
}
