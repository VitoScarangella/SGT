<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Fornitore;

/**
 * FornitoreSearch represents the model behind the search form about `common\models\Fornitore`.
 */
class FornitoreSearch extends Fornitore
{
    public function rules()
    {
        return [
            [['id', 'codProvincia', 'deleted'], 'integer'],
            [['ragioneSociale', 'piva', 'cf', 'codCountry', 'indirizzo', 'cap', 'codComune', 'banca', 'indirizzoBanca', 'iban', 'mail', 'codPA'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Fornitore::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'codProvincia' => $this->codProvincia,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'ragioneSociale', $this->ragioneSociale])
            ->andFilterWhere(['like', 'piva', $this->piva])
            ->andFilterWhere(['like', 'cf', $this->cf])
            ->andFilterWhere(['like', 'codCountry', $this->codCountry])
            ->andFilterWhere(['like', 'indirizzo', $this->indirizzo])
            ->andFilterWhere(['like', 'cap', $this->cap])
            ->andFilterWhere(['like', 'codComune', $this->codComune])
            ->andFilterWhere(['like', 'banca', $this->banca])
            ->andFilterWhere(['like', 'indirizzoBanca', $this->indirizzoBanca])
            ->andFilterWhere(['like', 'iban', $this->iban])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'codPA', $this->codPA]);

        return $dataProvider;
    }
}
