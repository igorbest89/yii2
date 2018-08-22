<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language_translate".
 *
 * @property integer $id
 * @property integer $language
 * @property string $translation
 *
 * @property Language $language0
 * @property LanguageSource $id0
 */
class LanguageTranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => LanguageSource::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(Language::className(), ['language_id' => 'language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(LanguageSource::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return LanguageTranslateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageTranslateQuery(get_called_class());
    }
}
