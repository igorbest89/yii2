<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_to_payment_system".
 *
 * @property integer $payment_to_payment_system_id
 * @property integer $payment_to_payment_system_payment_system_id
 * @property integer $payment_to_payment_system_payment_id
 */
class PaymentToPaymentSystem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_to_payment_system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['payment_to_payment_system_payment_system_id', 'payment_to_payment_system_payment_id'],
                'required'
            ],
            [
                ['payment_to_payment_system_payment_system_id', 'payment_to_payment_system_payment_id'],
                'integer'
            ],
            [
                ['payment_to_payment_system_id'],
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
            'payment_to_payment_system_id'                => 'ID',
            'payment_to_payment_system_payment_system_id' => 'Payment System ID',
            'payment_to_payment_system_payment_id'        => 'Payment ID'
        ];
    }
}
