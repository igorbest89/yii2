<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_statuses".
 *
 * @property integer $payment_status_id
 * @property string $payment_status_name
 */
class PaymentStatus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_statuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['payment_status_name'],
                'required'
            ],
            [
                ['payment_status_name'],
                'string'
            ],
            [
                ['payment_status_id'],
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
            'payment_status_id'   => 'ID',
            'payment_status_name' => 'Name'
        ];
    }
}
