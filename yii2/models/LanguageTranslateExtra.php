<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
/**
 * Class LanguageTranslate
 *
 * @package app\models
 *
 * @property integer $id
 * @property integer  $language
 * @property string  $translation
 */
class LanguageTranslateExtra extends LanguageTranslate {
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language_translate}}';
    }

    /**
     * Attribute labels
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'language'    => 'Target language',
            'translation' => 'Translated text'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['translation'], 'string'],
            [['id', 'language'], 'integer'],
        ];
    }
}
