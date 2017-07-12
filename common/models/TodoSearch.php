<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * TodoSearch represents the model behind the search form about `common\models\Todo`.
 */
class TodoSearch extends Todo
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['note', 'note2', 'stato', 'priorita'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Todo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'note2', $this->note2])
            ->andFilterWhere(['like', 'stato', $this->stato])
            ->andFilterWhere(['like', 'priorita', $this->priorita]);

        return $dataProvider;
    }
}
