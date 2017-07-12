<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SgtRicerca;

/**
 * SgtRicercaSearch represents the model behind the search form about `backend\models\SgtRicerca`.
 */
class SgtRicercaSearch extends SgtRicerca
{
    public function rules()
    {
        return [
            [['id', 'tipo'], 'integer'],
            [['lemma', 'sinonimo'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SgtRicerca::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tipo' => $this->tipo,
        ]);

        $query->andFilterWhere(['like', 'lemma', $this->lemma])
            ->andFilterWhere(['like', 'sinonimo', $this->sinonimo]);

        return $dataProvider;
    }
}
