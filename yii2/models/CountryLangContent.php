<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country_lang_content".
 *
 * @property int $id
 * @property int $country_id
 * @property string $flag
 * @property string $collection
 *
 * @property Countries $country
 */
class CountryLangContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_lang_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'flag'], 'required'],
            [['country_id'], 'integer'],
            [['collection'], 'string'],
            [['flag'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_id' => 'country_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'flag' => Yii::t('app', 'Flag'),
            'collection' => Yii::t('app', 'Collection'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['country_id' => 'country_id']);
    }

    /**
     * {@inheritdoc}
     * @return CountryLangContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryLangContentQuery(get_called_class());
    }
}
