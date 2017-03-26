<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'phone_buyer', 'phone_receiver', 'created_at', 'updated_at'], 'integer'],
            [['name_buyer', 'address_buyer', 'email_buyer', 'name_receiver', 'address_receiver', 'note'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Order::find();

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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'phone_buyer' => $this->phone_buyer,
            'phone_receiver' => $this->phone_receiver,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name_buyer', $this->name_buyer])
            ->andFilterWhere(['like', 'address_buyer', $this->address_buyer])
            ->andFilterWhere(['like', 'email_buyer', $this->email_buyer])
            ->andFilterWhere(['like', 'name_receiver', $this->name_receiver])
            ->andFilterWhere(['like', 'address_receiver', $this->address_receiver])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
