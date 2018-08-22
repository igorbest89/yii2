<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.08.2018
 * Time: 16:48
 */

namespace app\models;


use yii\db\ActiveRecord;

class UrlLocalization extends ActiveRecord

{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url_localization';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'default_route' => 'english route',
            'locale_route' => 'locale rouyte',
            'flag' => 'country flag',
            'is_active' => 'active language'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['default_route','locale_route','is_active','flag'], 'required'
            ],

            [
                ['id'],
                'safe'
            ],
        ];
    }



}