<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $role_name; // Add the role_name attribute
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_name', 'user_email', 'password', 'nick_name', 'authKey', 'accessToken', 'date_created', 'role_name'], 'safe'], // Include role_name in the rules
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        // return Model::scenarios();
        return parent::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        $query = User::find()->joinWith('role');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_email', $this->user_email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'nick_name', $this->nick_name])
            ->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'role_name', $this->role_name]); // Include role_name in the filtering conditions

        return $dataProvider;
    }
}

