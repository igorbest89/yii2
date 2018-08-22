<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "account_to_template".
 *
 * @property integer $account_id
 * @property integer $template_id
 */

class AccountToTemplate extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'account_to_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['account_id', 'template_id'],
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
            'account_id'   => 'ID of account',
            'template_id'  => 'ID of template'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTmpl()
    {
        return $this->hasMany(AccountTemplate::class,['id' => 'template_id']);
    }

    public function getAccount()
    {
        return $this->hasOne(Account::className(),['id' => 'account_id']);
    }
    public function getTemplate()
    {
        return $this->hasOne(AccountTemplate::className(),['id' => 'template_id']);
    }


}
