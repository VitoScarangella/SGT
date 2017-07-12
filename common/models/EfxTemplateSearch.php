<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxTemplate;

/**
 * EfxTemplateSearch represents the model behind the search form about `common\models\EfxTemplate`.
 */
class EfxTemplateSearch extends EfxTemplate
{
    public function rules()
    {
        return [
            [['id', 'idTipotemplate'], 'integer'],
            [['descrizione', 'template'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxTemplate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idTipotemplate' => $this->idTipotemplate,
        ]);

        $query->andFilterWhere(['like', 'descrizione', $this->descrizione])
            ->andFilterWhere(['like', 'template', $this->template]);

        return $dataProvider;
    }
}
