<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ToolCombo;

/**
 * ToolComboSearch represents the model behind the search form about `common\models\ToolCombo`.
 */
class ToolComboSearch extends ToolCombo
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['key_id', 'field_id', 'field_descr', 'field_table', 'type', 'note'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {

        $query = ToolCombo::find();

        $query->andFilterWhere([
            ]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'key_id', $this->key_id])
            ->andFilterWhere(['like', 'field_id', $this->field_id])
            ->andFilterWhere(['like', 'field_descr', $this->field_descr])
            ->andFilterWhere(['like', 'field_table', $this->field_table])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
