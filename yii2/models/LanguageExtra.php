<?php

namespace app\models;

use Yii;

/**
 * This is the model class extenede from base model class "Language".
 *
 * @property integer $language_id
 * @property string $code
 * @property string $language
 * @property string $country
 * @property string $name
 * @property string $name_ascii
 * @property integer $status
 *
 * @property LanguageTranslate[] $languageTranslates
 * @property LanguageSource[] $ids
 */
class LanguageExtra extends Language
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language', 'country', 'name', 'name_ascii', 'status'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['language', 'country'], 'string', 'max' => 3],
            [['name', 'name_ascii'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'language_id' => Yii::t('app', 'Language ID'),
            'code' => Yii::t('app', 'Language code'),
            'language' => Yii::t('app', 'Language'),
            'country' => Yii::t('app', 'Country'),
            'name' => Yii::t('app', 'Name'),
            'name_ascii' => Yii::t('app', 'Name Ascii'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageTranslates()
    {
        return $this->hasMany(LanguageTranslate::className(), ['language' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIds()
    {
        return $this->hasMany(LanguageSource::className(), ['id' => 'id'])->viaTable('language_translate', ['language' => 'language_id']);
    }

    /**
     * @inheritdoc
     * @return LanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageQuery(get_called_class());
    }

    /**
     *Method for getting all active languages
     *
     * @return array
     */
    public static function getAllActiveLanguages()
    {
        $languages = self::find()->where(['status' => 1])->asArray()->all();

        return (!empty($languages)) ? $languages : [];
    }
}
