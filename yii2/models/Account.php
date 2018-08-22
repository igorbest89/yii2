<?php

namespace app\models;

use yii\db\ActiveRecord;


/**
 * Class Account
 * This is the model class for table "account".
 * @property int $id
 * @package app\models
 * @property string $name
 */
class Account extends ActiveRecord
{
    const ACCOUNT_FREE = 'free';
    const ACCOUNT_FREE_PLUS = 'free-plus';
    const ACCOUNT_PREMIUM = 'premium';
    const ACCOUNT_PROFESSIONAL = 'professional';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['name'],
                'required'
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
            'name' => 'Name'
        ];
    }

    /**
     * Method for add new account type to DB
     * @param $name
     * @return boolean
     */
    public static function addFileToUserAssociationType($name)
    {
        $type = new self();
        $type->name = $name;

        if ($type->save()) {

            return true;

        } else {

            return false;
        }
    }
   public function getConstants() {
        $oClass = new \ReflectionClass(Account::className());
        return $oClass->getConstants();
    }
    public static function getNewUserAccounts($id)
    {
        $userAccounts = [];

        $accounts = UserToAccount::find()->where(['user_id' => $id])->asArray()->all();

        foreach ($accounts as $account) {

            $name = Account::findOne(['id' => $account['account_id']]);
            $templateIds = AccountToTemplate::find()->where(['account_id' => $account['account_id']])->asArray()->all();
            $ids = [];

            foreach ($templateIds as $templateId) {
                $ids[] = $templateId['template_id'];
            }
            $userAccounts[$name]['name'] = $name->name;
            $userAccounts[$name]['data'] = AccountTemplate::find()->where(['id' => $ids])->asArray()->all();
        }

        return $userAccounts;
    }

    /**
     * @return \yii\db\ActiveQuery AccountToTemplate
     */
    public function getRelationship()
    {
        return $this->hasMany(AccountToTemplate::className(),['account_id' => 'id'])->with('tmpl');
        
    }


}
