<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cv".
 *
 * @property integer $cv_id
 * @property string $cv_file
 * @property string $cv_format
 * @property integer $cv_size
 * @property string $cv_url
 */
class Cv extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['cv_file', 'cv_format', 'cv_size', 'cv_url'],
                'required'
            ],
            [
                ['cv_file', 'cv_format', 'cv_url'],
                'string'
            ],
            [
                ['cv_size'],
                'integer'
            ],
            [
                ['cv_id'],
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
            'cv_id'     => 'ID',
            'cv_file'   => 'File',
            'cv_format' => 'Format',
            'cv_size'   => 'Size',
            'cv_url'    => 'URL'
        ];
    }

    /**
     * Method for add cv to DB
     * @param $cvFile
     * @param $cvFormat
     * @param $cvSize
     * @param $cvUrl
     * @return integer | null
     */
    public function addCv($cvFile, $cvFormat, $cvSize, $cvUrl)
    {
        $this->cv_file = $cvFile;
        $this->cv_format = $cvFormat;
        $this->cv_size = $cvSize;
        $this->cv_url = $cvUrl;

        if ($this->save()) {

            return $this->cv_id;

        } else {

            return null;
        }
    }

    public static function getAllCvCount()
    {
        return self::find()->count();
    }
}
