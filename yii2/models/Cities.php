<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $country_code
 * @property string $name
 * @property double $geo_lat
 * @property double $geo_long
 * @property integer $language_id
 * @property integer $place_id
 * @property integer $region_id
 */
class Cities extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code', 'en', 'geo_lat', 'geo_long'], 'required'],
            [['geo_lat', 'geo_long'], 'number'],
            [['country_code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
            [['language_id', 'place_id', 'region_id'], 'integer']
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
            'geo_lat'      => 'Geo Latitude',
            'geo_long'     =>'Geo Longitude',
            'language_id'  => 'Language ID',
            'place_id'     => 'Place ID',
            'region_id'    => 'Region ID'
        ];
    }

    /**
     * Method for return all cities
     *
     * @return array
     */
    public static function getAllCities()
    {
        $cities = self::find()->asArray()->all();

        return (!empty($cities)) ? $cities : [];
    }

    /**
     * Method for return city by id
     *
     * @param $id
     * @return self
     */
    public static function getCity($id)
    {
        $city = self::findOne(['id' => $id]);

        return (!empty($city)) ? $city : new self();
    }

    /**
     * Method for return all cities grouped by countries
     *
     * @return array
     */
    public static function getAllCitiesGroupedByCountries()
    {
        $resultingCities = [];
        $cities = self::getAllCities();

        if (!empty($cities)) {
            foreach ($cities as $city) {
                $resultingCities[$city['country_code']][] = $city;
            }

            return $resultingCities;
        } else {

            return [];
        }
    }

    /**
     * Method for creating new city
     *
     * @param $data
     *
     * @return boolean
     */
    public static function createNewCity($data)
    {
        $englishLanguageId = Language::findOne(['code' => 'en-US'])->language_id;
        $city = new self();

        $city->setAttributes([
            'country_code' => $data['country_code'],
            'name'         => $data['name'],
            'place_id'     => $data['place_id'],
            'language_id'  => (!empty($data['language_id'])) ? $data['language_id'] : $englishLanguageId,
            'geo_lat'      => (!empty($data['geo_lat'])) ? $data['geo_lat'] : '',
            'geo_long'     => (!empty($data['geo_long'])) ? $data['geo_long'] : '',
            'region_id'    => (!empty($data['region_id'])) ? $data['region_id'] : null
        ]);

        if ($city->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method for deleting city
     *
     * @param $id
     * @throws
     *
     * @return boolean
     */
    public static function deleteCity($id)
    {
        $city = self::findOne(['id' => $id]);

        if (!empty($city)) {
            $city->delete();

            return true;
        }

        return false;
    }

    /**
     * Method for updating existed city
     *
     * @param $id
     * @param $data
     *
     * @return boolean
     */
    public static function updateCity($id, $data)
    {
        $englishLanguageId = Language::findOne(['code' => 'en-US'])->language_id;
        $city = self::findOne(['id' => $id]);

        $city->setAttributes([
            'country_code' => $data['country_code'],
            'name'         => $data['name'],
            'place_id'     => $data['place_id'],
            'language_id'  => (!empty($data['language_id'])) ? $data['language_id'] : $englishLanguageId,
            'geo_lat'      => (!empty($data['geo_lat'])) ? $data['geo_lat'] : '',
            'geo_long'     => (!empty($data['geo_long'])) ? $data['geo_long'] : '',
            'region_id'    => (!empty($data['region_id'])) ? $data['region_id'] : null
        ]);

        if ($city->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method for return all cities by country code
     *
     * @param $countryCode
     * @param $symbols
     * @param $region
     *
     * @return array
     */
    public static function getCountryCities($countryCode, $symbols = '', $region = null)
    {

        $query = self::find()->where(['country_code' => $countryCode]);

        if (!empty($region)) {
            $check = self::find()->where(['region_id' => $region])->all();
            
            if (!empty($check)) {
                $query->andWhere(['region_id' => $region]);
            }
        }

        if (!empty($symbols)) {
            $query->andWhere(['like', 'name', '%' . $symbols . '%', false]);
        }

        $cities = $query->limit(10)->distinct('name')->asArray()->all();

        return (!empty($cities)) ? $cities : [];
    }

    /**
     * Method for return city ID by country code and city name
     *
     * @param $countryCode
     * @param $name
     *
     * @return integer
     */
    public static function getCityId($countryCode, $name)
    {
        $id = self::findOne(['country_code' => $countryCode, 'name' => $name])->id;

        return (!empty($id)) ? $id : 0;
    }
}
