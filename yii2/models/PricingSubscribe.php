<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_activity".
 *
 * @property integer $user_activity_id
 * @property integer $user_activity_user_id
 * @property integer $user_activity_date
 * @property string $user_activity_ip
 * @property string $user_activity_key
 * @property string $user_activity_data
 */
class PricingSubscribe extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pricing_subscribe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [
                ['id','country_id','scheme','currency_id','pro_monthly','price_pro_3_monthly','package_3_monthly','price_pro_6_monthly','package_6_monthly','price_pro_12_monthly','package_12_monthly'],
                'required'
            ],
            [
                ['pro_monthly','price_pro_3_monthly','package_3_monthly','price_pro_6_monthly','package_6_monthly','price_pro_12_monthly','package_12_monthly'],
                'float'
            ],
            [
                ['country_id','scheme','currency_id'],
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
            'country_id'       => 'country ID',
            'scheme' => 'scheme',
            'currency_id'    => 'id wallet',
            'pro_monthly'      => 'IP',
            'price_pro_3_monthly'     => 'price for 1 month',
            'package_3_monthly'    => 'price for 3 month subscribe',
            'price_pro_6_monthly'    => 'price for 1 month',
            'package_6_monthly'    => 'price for half year subscribe',
            'price_pro_12_monthly'    => 'price for 1 month',
            'package_12_monthly'    => 'price for 1 year subscribe'
        ];
    }
}
