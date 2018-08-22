<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "account_template".
 *
 * @property integer $id
 * @property string $name
 * @property integer $cost
 */
class AccountTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['name', 'cost'],
                'required'
            ],
            [
                ['cost'],
                'integer'
            ],
            [
                ['name'],
                'string'
            ],
            [
                ['id'],
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
            'id'   => 'ID',
            'name' => 'Name',
            'cost' => 'Cost'
        ];
    }

    /**
     * Method for add new account template type to DB
     * @param $name
     * @param $cost
     * @return boolean
     */
    public static function addFileToUserAssociationType($name, $cost)
    {
        $type = new self();
        $type->name = $name;
        $type->cost = $cost;

        if ($type->save()) {

            return true;

        } else {

            return false;
        }
    }
    public function getTemplate(){
        return $this->hasOne(TemplateInfo::className(),['name' => 'template_type']);
    }


}
