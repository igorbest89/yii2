<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LanguageTranslate]].
 *
 * @see LanguageTranslate
 */
class LanguageTranslateQuery extends \yii\db\ActiveQuery
{


    /**
     * @inheritdoc
     * @return LanguageTranslate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return LanguageTranslate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
