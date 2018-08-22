<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public $user_email;
    public $user_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_email', 'user_name'],
                'string'
            ]
        ];
    }

    /**
     * Method of getting users list
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (isset($params['UserSearch'])) {
            $query
                ->andFilterWhere(['like', 'user_email', $params['UserSearch']['user_email']])
                ->andFilterWhere(['like', 'user_name', $params['UserSearch']['user_name']]);
        }

        return $dataProvider;
    }
}
