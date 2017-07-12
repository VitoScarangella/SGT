<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comuniistat;

/**
 * ComuniistatSearch represents the model behind the search form about `\Comuniistat`.
 */
class ComuniistatSearch extends Comuniistat
{
    public function rules()
    {
        return [
            [['CodiceRegione', 'codiceProvincia', 'ProgressivoComune', 'CodiceRipartizioneGeografica', 'FlagCapoluogo', 'CodiceComuneNumerico', 'CodiceComuneNumerico_2006_2009', 'CodiceComunenumerico_1995_2005', 'Popolazione_2011'], 'integer'],
            [['CodiceCittaMetropolitana', 'CodiceComune', 'denominazioneItaliano', 'DenominazioneTedesco', 'RipartizioneGeografica', 'Regione', 'CittaMetropolitana', 'Provincia', 'SiglaAutomobilistica', 'CodiceCatastale', 'CodiceNUTS1_2010', 'CodiceNUTS2_2010', 'CodiceNUTS3_2010', 'CodiceNUTS1_2006', 'CodiceNUTS2_2006', 'CodiceNUTS3_2006'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Comuniistat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'CodiceRegione' => $this->CodiceRegione,
            'codiceProvincia' => $this->codiceProvincia,
            'ProgressivoComune' => $this->ProgressivoComune,
            'CodiceRipartizioneGeografica' => $this->CodiceRipartizioneGeografica,
            'FlagCapoluogo' => $this->FlagCapoluogo,
            'CodiceComuneNumerico' => $this->CodiceComuneNumerico,
            'CodiceComuneNumerico_2006_2009' => $this->CodiceComuneNumerico_2006_2009,
            'CodiceComunenumerico_1995_2005' => $this->CodiceComunenumerico_1995_2005,
            'Popolazione_2011' => $this->Popolazione_2011,
        ]);

        $query->andFilterWhere(['like', 'CodiceCittaMetropolitana', $this->CodiceCittaMetropolitana])
            ->andFilterWhere(['like', 'CodiceComune', $this->CodiceComune])
            ->andFilterWhere(['like', 'denominazioneItaliano', $this->denominazioneItaliano])
            ->andFilterWhere(['like', 'DenominazioneTedesco', $this->DenominazioneTedesco])
            ->andFilterWhere(['like', 'RipartizioneGeografica', $this->RipartizioneGeografica])
            ->andFilterWhere(['like', 'Regione', $this->Regione])
            ->andFilterWhere(['like', 'CittaMetropolitana', $this->CittaMetropolitana])
            ->andFilterWhere(['like', 'Provincia', $this->Provincia])
            ->andFilterWhere(['like', 'SiglaAutomobilistica', $this->SiglaAutomobilistica])
            ->andFilterWhere(['like', 'CodiceCatastale', $this->CodiceCatastale])
            ->andFilterWhere(['like', 'CodiceNUTS1_2010', $this->CodiceNUTS1_2010])
            ->andFilterWhere(['like', 'CodiceNUTS2_2010', $this->CodiceNUTS2_2010])
            ->andFilterWhere(['like', 'CodiceNUTS3_2010', $this->CodiceNUTS3_2010])
            ->andFilterWhere(['like', 'CodiceNUTS1_2006', $this->CodiceNUTS1_2006])
            ->andFilterWhere(['like', 'CodiceNUTS2_2006', $this->CodiceNUTS2_2006])
            ->andFilterWhere(['like', 'CodiceNUTS3_2006', $this->CodiceNUTS3_2006]);

        return $dataProvider;
    }
}
