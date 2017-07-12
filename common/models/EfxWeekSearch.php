<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxWeek;

/**
 * EfxWeekSearch represents the model behind the search form about `common\models\EfxWeek`.
 */
class EfxWeekSearch extends EfxWeek
{
    public function rules()
    {
        return [
            [['id', 'idKey', 'anno', 'week', 'presente', 'default'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxWeek::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
 
        $query->andFilterWhere([
            'idKey' => $this->idKey,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idKey' => $this->idKey,
            'anno' => $this->anno,
            'week' => $this->week,
            'presente' => $this->presente,
            'default' => $this->default,
        ]);

        return $dataProvider;
    }
}
