<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_pages_description".
 *
 * @property integer $id
 * @property integer $seo_page_id
 * @property integer $language_id
 * @property string $page_title
 * @property string $description
 * @property string $meta_keywords
 * @property string $page_headline
 */
class SeoPageDescription extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_pages_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seo_page_id', 'language_id'], 'integer'],
            [['page_title', 'description', 'meta_keywords', 'page_headline'], 'string'],
            [['id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'seo_page_id'   => 'SEO Page ID',
            'language_id'   => 'Language ID',
            'page_title'    => 'Page Title',
            'description'   => 'Description',
            'meta_keywords' => 'Meta Keywords',
            'page_headline' => 'Page Headline'
        ];
    }
}
