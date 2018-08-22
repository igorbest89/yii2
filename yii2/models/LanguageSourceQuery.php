<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LanguageSource]].
 *
 * @see LanguageSource
 */
class LanguageSourceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return LanguageSource[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return LanguageSource|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
