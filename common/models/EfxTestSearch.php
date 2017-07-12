<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxTest;

/**
 * EfxTestSearch represents the model behind the search form about `common\models\EfxTest`.
 */
class EfxTestSearch extends EfxTest
{
    public function rules()
    {
        return [
            [['id', 'idLingua', 'idPippo', 'numero'], 'integer'],
            [['testo', 'testogrande', 'data', 'dataora', 'tempo', 'timest'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxTest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
 
        $query->andFilterWhere([
            'id' => $this->id,
            'idLingua' => $this->idLingua,
            'idPippo' => $this->idPippo,
            'numero' => $this->numero,
            'data' => $this->data,
            'dataora' => $this->dataora,
            'tempo' => $this->tempo,
            'timest' => $this->timest,
        ]);

        $query->andFilterWhere(['like', 'testo', $this->testo])
            ->andFilterWhere(['like', 'testogrande', $this->testogrande]);

        return $dataProvider;
    }
}
