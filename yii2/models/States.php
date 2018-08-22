<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "states".
 *
 * @property integer $id
 * @property string $country_code
 * @property string $name
 * @property integer $language_id
 */
class States extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code', 'en', 'geo_lat', 'geo_long'], 'required'],
            [['country_code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
            [['language_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'country_code' => 'Country Code',
            'name'         => 'Name',
            'language_id'  => 'Language ID'
        ];
    }

    /**
     * Method for return all states
     *
     * @return array
     */
    public static function getAllStates()
    {
        $states = self::find()->asArray()->all();

        return (!empty($states)) ? $states : [];
    }

    /**
     * Method for return state by id
     *
     * @param $id
     * @return self
     */
    public static function getState($id)
    {
        $state = self::findOne(['id' => $id]);

        return (!empty($state)) ? $state : new self();
    }

    /**
     * Method for return all states grouped by countries
     *
     * @return array
     */
    public static function getAllStatesGroupedByCountries()
    {
        $resultingStates = [];
        $states = self::getAllStates();

        if (!empty($states)) {
            foreach ($states as $state) {
                $resultingStates[$state['country_code']][] = $state;
            }

            return $resultingStates;
        } else {

            return [];
        }
    }

    /**
     * Method for creating new state
     *
     * @param $data
     *
     * @return boolean
     */
    public static function createNewState($data)
    {
        $englishLanguageId = Language::findOne(['code' => 'en-US'])->language_id;
        $state = new self();

        $state->setAttributes([
            'country_code' => $data['country_code'],
            'name'         => $data['name'],
            'language_id'  => (!empty($data['language_id'])) ? $data['language_id'] : $englishLanguageId
        ]);

        if ($state->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method for deleting state
     *
     * @param $id
     * @throws
     *
     * @return boolean
     */
    public static function deleteState($id)
    {
        $state = self::findOne(['id' => $id]);

        if (!empty($state)) {
            $state->delete();

            return true;
        }

        return false;
    }

    /**
     * Method for updating existed state
     *
     * @param $id
     * @param $data
     *
     * @return boolean
     */
    public static function updateState($id, $data)
    {
        $englishLanguageId = Language::findOne(['code' => 'en-US'])->language_id;
        $state = self::findOne(['id' => $id]);

        $state->setAttributes([
            'country_code' => $data['country_code'],
            'name'         => $data['name'],
            'language_id'  => (!empty($data['language_id'])) ? $data['language_id'] : $englishLanguageId
        ]);

        if ($state->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method for return all states by country code
     *
     * @param $countryCode
     *
     * @return array
     */
    public static function getCountryStates($countryCode)
    {
        $states = self::find()
//            ->select(['id', 'country_code', 'name', 'language_id'])
            ->where(['country_code' => $countryCode])
            ->distinct()
            ->asArray()
            ->all();

        return (!empty($states)) ? $states : [];
    }

    /**
     * Method for return state ID by state name
     *
     * @param $name
     *
     * @return integer
     */
    public static function getStateId($name)
    {
        $id = self::findOne(['name' => $name])->id;

        return (!empty($id)) ? $id : 0;
    }
}
