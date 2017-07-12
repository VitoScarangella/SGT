<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Operazione;

/**
 * OperazioneSearch represents the model behind the search form about `common\models\Operazione`.
 */
class OperazioneSearch extends Operazione
{
    public function rules()
    {
        return [
            [['id', 'annoEsercizio', 'numeroDocumento', 'numeroProtocollo', 'idCliente', 'idUtente', 'segno', 'idTipomov', 'idTipodoc', 'idModalitaPagamento'], 'integer'],
            [['dataOperazione', 'dataDocumento', 'idFiscale', 'codiceProvincia', 'idComune', 'note', 'conto', 'lastUpdate', 'created', 'idRiferimento'], 'safe'],
            [['importoTotale'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        Tool::log("....");
        
        $session = Yii::$app->session;
        $query = Operazione::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->annoEsercizio = $session["esercizio"];
        $this->segno = $session['operazione']["segno"];
        $query->andFilterWhere([
            'annoEsercizio' => $this->annoEsercizio,
            'segno' => $this->segno,
      ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'dataOperazione' => $this->dataOperazione,
            'dataDocumento' => $this->dataDocumento,
            'numeroDocumento' => $this->numeroDocumento,
            'numeroProtocollo' => $this->numeroProtocollo,
            'idCliente' => $this->idCliente,
            'idUtente' => $this->idUtente,
            'idTipomov' => $this->idTipomov,
            'idTipodoc' => $this->idTipodoc,
            'importoTotale' => $this->importoTotale,
            'idModalitaPagamento' => $this->idModalitaPagamento,
            'lastUpdate' => $this->lastUpdate,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'idFiscale', $this->idFiscale])
            ->andFilterWhere(['like', 'codiceProvincia', $this->codiceProvincia])
            ->andFilterWhere(['like', 'idComune', $this->idComune])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'conto', $this->conto]);

        return $dataProvider;
    }
}
