<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CountryLangContent]].
 *
 * @see CountryLangContent
 */
class CountryLangContentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CountryLangContent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CountryLangContent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
