<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "temp_password".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $tmp_pwd
 * @property integer $status
 */

class TempPassword extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_password';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['email', 'password', 'tmp_pwd'],
                'required',
                'on' => [self::SCENARIO_CREATE]
            ],
            [
                ['email', 'password', 'tmp_pwd'],
                'string',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['status'],
                'integer',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['id'],
                'safe',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'email'    => 'Email',
            'password' => 'Password',
            'tmp_pwd'  => 'Temp Password',
            'status'   => 'Status'
        ];
    }

    /**
     * Get temp password by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * Get email by temp password
     *
     * @param string $pwd
     * @return static|null
     */
    public static function findByTempPassword($pwd)
    {
        return self::findOne(['tmp_pwd' => $pwd]);
    }

    /**
     * Create new temp password method
     *
     * @param $email
     * @param $pwd
     * @param $tmpPwd
     * @return boolean
     * @throws \yii\base\Exception
     */
    public static function createTempPassword($email, $pwd, $tmpPwd)
    {
        $tempPassword = self::findByEmail($email);

        if (empty($tempPassword)) {
            $tempPassword = new self();
            $tempPassword->setScenario(self::SCENARIO_CREATE);
        } else {
            $tempPassword->setScenario(self::SCENARIO_UPDATE);
        }

        $tempPassword->setAttributes([
            'email'    => $email,
            'password' => Yii::$app->security->generatePasswordHash($pwd),
            'tmp_pwd'  => $tmpPwd
        ]);

        if ($tempPassword->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Change temp password status method
     *
     * @param $email
     * @param $status
     * @return boolean
     */
    public static function changeStatus($email, $status = 1)
    {
        $tempPassword = self::findOne(['email' => $email]);
        $tempPassword->setScenario(self::SCENARIO_UPDATE);

        $tempPassword->status = $status;

        if ($tempPassword->save(false)) {
            return true;
        }

        return false;
    }
}
