<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "file_extensions".
 *
 * @property integer $file_extension_id
 * @property string $file_extension_name
 * @property boolean $file_extension_status
 * @property integer $file_extension_created_at
 * @property integer $file_extension_updated_at
 */
class FileExtension extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_extensions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['file_extension_name', 'file_extension_status', 'file_extension_created_at', 'file_extension_updated_at',],
                'required'
            ],
            [
                ['file_extension_name'],
                'string'
            ],
            [
                ['file_extension_created_at', 'file_extension_updated_at'],
                'integer'
            ],
            [
                ['file_extension_id', 'file_extension_status'],
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
            'file_extension_id'         => 'ID',
            'file_extension_name'       => 'Name',
            'file_extension_status'     => 'Status of extension',
            'file_extension_created_at' => 'Date of creating',
            'file_extension_updated_at' => 'Date of updating'
        ];
    }

    /**
     * Method for get array of authorized extensions
     * @return array | null
     */
    public static function getAuthorizedExtensions()
    {
        $extensions = self::find()->select(['file_extension_name'])->where(['file_extension_status' => true])->asArray()->all();

        return (!empty($extensions)) ? $extensions : null;
    }

    /**
     * Method for check by authorized extension
     * @param $extensionName
     * @return boolean
     */
    public static function checkAuthorizeExtension($extensionName)
    {
        $extension = self::findOne(['file_extension_name' => $extensionName]);

        return (!empty($extension) && $extension->file_extension_status) ? true : false;
    }

    /**
     * Method for get extension ID
     * @param $extensionName
     * @return integer | null
     */
    public static function getExtensionId($extensionName)
    {
        $extension = self::findOne(['file_extension_name' => $extensionName]);

        return (!empty($extension)) ? $extension->file_extension_id : null;
    }

    /**
     * Method for add extension to DB
     * @param $fileExtensionName
     * @param $fileExtensionStatus
     * @return integer | null
     */
    public static function addExtension($fileExtensionName, $fileExtensionStatus = true)
    {
        $extension = new self();
        $extension->file_extension_status = $fileExtensionStatus;
        $extension->file_extension_name = $fileExtensionName;
        $extension->file_extension_created_at = time();
        $extension->file_extension_updated_at = time();

        if ($extension->save()) {

            return $extension->file_extension_id;

        } else {

            return null;
        }
    }

    /**
     * Method for change extension status in DB
     * @param $fileExtensionName
     * @param $fileExtensionStatus
     * @return integer | null
     */
    public function changeExtensionStatus($fileExtensionName, $fileExtensionStatus)
    {
        $extension = self::findOne(['file_extension_name' => $fileExtensionName]);
        $extension->setAttribute('file_extension_status', $fileExtensionStatus);
        $extension->setAttribute('file_extension_updated_at', time());

        if ($extension->save()) {

            return $extension->file_extension_id;

        } else {

            return null;
        }
    }
}
