<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Schema;

/**
 * This is the model class for table "countries".
 *
 * @property string $code
 * @property string $en
 * @property string $de
 * @property string $es
 * @property string $fr
 * @property string $it
 * @property string $ru
 * @property double $geo_lat
 * @property double $geo_long
 * @property integer $seo_active
 * @property integer $country_id
 */
class Countries extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'es', 'fr', 'it', 'ru', 'geo_lat', 'geo_long','is_active','flag'], 'required'],
            [['geo_lat', 'geo_long'], 'number'],
            [['seo_active', 'country_id'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['en', 'de', 'es', 'fr', 'it', 'ru'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'en' => Yii::t('app', 'En'),
            'de' => Yii::t('app', 'De'),
            'es' => Yii::t('app', 'Es'),
            'fr' => Yii::t('app', 'Fr'),
            'it' => Yii::t('app', 'It'),
            'ru' => Yii::t('app', 'Ru'),
            'geo_lat' => Yii::t('app', 'Geo Lat'),
            'geo_long' => Yii::t('app', 'Geo Long'),
            'seo_active' => Yii::t('app', 'Seo Active'),
            'country_id' => Yii::t('app', 'Country ID'),
             'flag' => Yii::t('app', 'country flag'),
            'is_active' => Yii::t('app', 'active language'),
        ];
    }

    public function getLanguageRelation()
    {

        return $this->hasOne(Language::className(),['country' => 'code']);
    }
}
