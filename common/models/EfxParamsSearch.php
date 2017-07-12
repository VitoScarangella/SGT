<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxParams;

/**
 * EfxParamsSearch represents the model behind the search form about `common\models\EfxParams`.
 */
class EfxParamsSearch extends EfxParams
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['param', 'label'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxParams::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'param', $this->param])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
