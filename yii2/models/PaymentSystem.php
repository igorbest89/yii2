<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_systems".
 *
 * @property integer $payment_system_id
 * @property string $payment_system_name
 */
class PaymentSystem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_systems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['payment_system_name'],
                'required'
            ],
            [
                ['payment_system_name'],
                'string'
            ],
            [
                ['payment_system_id'],
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
            'payment_system_id'   => 'ID',
            'payment_system_name' => 'Name'
        ];
    }
}
