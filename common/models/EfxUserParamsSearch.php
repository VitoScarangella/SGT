<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxUserParams;

/**
 * EfxUserParamsSearch represents the model behind the search form about `common\models\EfxUserParams`.
 */
class EfxUserParamsSearch extends EfxUserParams
{
    public function rules()
    {
        return [
            [['id', 'idUser'], 'integer'],
            [['param', 'value', 'valueExt'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function searchById($id)
    {
      $query = EfxUserParams::find();

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);

      $query->andFilterWhere([
          'idUser' => $id,
      ]);

      return $dataProvider;

    }


    public function search($params)
    {
        $query = EfxUserParams::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idUser' => $this->idUser,
        ]);

        $query->andFilterWhere(['like', 'param', $this->param])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'valueExt', $this->valueExt]);

        return $dataProvider;
    }
}
