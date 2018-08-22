<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "settings".
 *
 * @property integer $setting_id
 * @property string $setting_key
 * @property string $setting_value
 * @property string $setting_description
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['setting_key', 'setting_value', 'setting_description'],
                'string'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id'          => 'Setting ID',
            'setting_key'         => 'Setting Key',
            'setting_value'       => 'Setting Value',
            'setting_description' => 'Setting Description',
        ];
    }

    /**
     * @param $key
     * @param $value
     * @param string $description
     */
    public static function setSetting($key, $value, $description = '')
    {
        $model = new Settings();

        Settings::deleteAll('setting_key = :key', [':key' => $key]);
        $model->setting_key = $key;
        $model->setting_description =  $description;
        $model->setting_value = serialize($value);
        $model->save(false);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getSetting($key)
    {
        $setting = Settings::find()->where(['setting_key' => $key])->one();

        return unserialize($setting->setting_value);
    }
}
