<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxLayout;

/**
 * EfxLayoutSearch represents the model behind the search form about `common\models\EfxLayout`.
 */
class EfxLayoutSearch extends EfxLayout
{
    public function rules()
    {
        return [
            [['id', 'idLingua', 'idTipodoc', 'idSezione', 'visibile', 'ordinamento'], 'integer'],
            [['titolo', 'sottotitolo', 'descrizione', 'dataCreazione', 'dataModifica', 'dataArticolo'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxLayout::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idLingua' => $this->idLingua,
            'idTipodoc' => $this->idTipodoc,
            'idSezione' => $this->idSezione,
            'visibile' => $this->visibile,
            'dataCreazione' => $this->dataCreazione,
            'dataModifica' => $this->dataModifica,
            'dataArticolo' => $this->dataArticolo,
            'ordinamento' => $this->ordinamento,
        ]);

        $query->andFilterWhere(['like', 'titolo', $this->titolo])
            ->andFilterWhere(['like', 'sottotitolo', $this->sottotitolo])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione]);

        return $dataProvider;
    }
}
