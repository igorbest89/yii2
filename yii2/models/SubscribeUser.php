<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class SubscribeUser
 * @package app\models
 */
class SubscribeUser extends ActiveRecord
{
    public $user_id;
    public $country_id;
    public $is_active_subscribe;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribe_user';
    }

    public function getCountry()
    {
        return $this->hasOne(Countries::className(),['country_id' => 'country_id'])->one();
    }

}
