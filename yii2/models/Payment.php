<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "payments".
 *
 * @property integer $payment_id
 * @property integer $payment_user
 * @property integer $payment_currency
 * @property integer $payment_status
 * @property float $payment_amount
 * @property float $payment_rate
 * @property string $payment_created_at
 * @property string $payment_updated_at
 */
class Payment extends ActiveRecord
{
    //Scenarios
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['payment_currency', 'payment_amount', 'payment_rate', 'payment_user'],
                'required'
            ],
            [
                ['payment_amount', 'payment_rate'],
                'number'
            ],
            [
                ['payment_currency', 'payment_status', 'payment_user'],
                'integer'
            ],
            [
                ['payment_id', 'payment_created_at', 'payment_updated_at'],
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
            'payment_id'         => 'ID',
            'payment_user'       => 'User',
            'payment_currency'   => 'Currency',
            'payment_amount'     => 'Amount',
            'payment_rate'       => 'Rate',
            'payment_status'     => 'Status',
            'payment_created_at' => 'Date of creating',
            'payment_updated_at' => 'Date of updating'
        ];
    }
}
