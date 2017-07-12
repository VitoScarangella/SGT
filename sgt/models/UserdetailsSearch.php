<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Userdetails;

/**
 * UserdetailsSearch represents the model behind the search form about `backend\models\Userdetails`.
 */
class UserdetailsSearch extends \common\models\UserdetailsSearch
{
    public function rules()
    {
        return [
            [['id', 'idProfilo', 'periodicita', 'idModalitaPagamento', 'regime', 'idIvaVendite'], 'integer'],
            [['idLingua', 'partitaIva', 'codiceFiscale', 'codiceProvincia', 'idComune', 'note', 'telefonoCellulare', 'telefonoFisso', 'mail', 'nome', 'cognome', 'dataNascita', 'idCommercialista', 'lastUpdate', 'created', 'codiceProvinciaDefault', 'idComuneDefault', 'indirizzo', 'cap'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Userdetails::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idProfilo' => $this->idProfilo,
            'dataNascita' => $this->dataNascita,
            'lastUpdate' => $this->lastUpdate,
            'created' => $this->created,
            'periodicita' => $this->periodicita,
            'idModalitaPagamento' => $this->idModalitaPagamento,
            'regime' => $this->regime,
            'idIvaVendite' => $this->idIvaVendite,
        ]);

        $query->andFilterWhere(['like', 'idLingua', $this->idLingua])
            ->andFilterWhere(['like', 'partitaIva', $this->partitaIva])
            ->andFilterWhere(['like', 'codiceFiscale', $this->codiceFiscale])
            ->andFilterWhere(['like', 'codiceProvincia', $this->codiceProvincia])
            ->andFilterWhere(['like', 'idComune', $this->idComune])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'telefonoCellulare', $this->telefonoCellulare])
            ->andFilterWhere(['like', 'telefonoFisso', $this->telefonoFisso])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'cognome', $this->cognome])
            ->andFilterWhere(['like', 'idCommercialista', $this->idCommercialista])
            ->andFilterWhere(['like', 'codiceProvinciaDefault', $this->codiceProvinciaDefault])
            ->andFilterWhere(['like', 'idComuneDefault', $this->idComuneDefault])
            ->andFilterWhere(['like', 'indirizzo', $this->indirizzo])
            ->andFilterWhere(['like', 'cap', $this->cap]);

        return $dataProvider;
    }
}
