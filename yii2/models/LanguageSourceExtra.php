<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Class LanguageSourceExtra
 *
 * @package app\models
 *
 * @property integer $id
 * @property string  $category
 * @property string  $message
 */
class LanguageSourceExtra extends LanguageSource {
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language_source}}';
    }
    
    
    /**
     * Attribute labels
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'category' => 'Category name',
            'message'  => 'Message text'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['message', 'category'], 'string'],
            [['id'], 'integer'],
        ];
    }
}
