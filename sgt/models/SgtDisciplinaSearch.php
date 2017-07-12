<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SgtDisciplina;

/**
 * SgtDisciplinaSearch represents the model behind the search form about `backend\models\SgtDisciplina`.
 */
class SgtDisciplinaSearch extends SgtDisciplina
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descr'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SgtDisciplina::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'descr', $this->descr]);

        return $dataProvider;
    }
}
