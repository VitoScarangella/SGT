<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxTipoTemplate;

/**
 * EfxTipoTemplateSearch represents the model behind the search form about `common\models\EfxTipoTemplate`.
 */
class EfxTipoTemplateSearch extends EfxTipoTemplate
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descrizione'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxTipoTemplate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'descrizione', $this->descrizione]);

        return $dataProvider;
    }
}
