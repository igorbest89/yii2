<?php

namespace app\models;

use yii\base\Model;

class Install extends Model
{
    public function init()
    {

    }

    /**
     *Install basic upload settings
     */
    public static function createUploadSettings()
    {
        $key = 'upload_config';

        $value = [
            'length_name_file' => 10,
            'maxsize' => 200097152
        ];

        $description = 'Basic settings for upload files';

        Settings::setSetting($key, $value, $description);
    }
}