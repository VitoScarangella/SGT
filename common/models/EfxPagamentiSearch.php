<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxPagamenti;

/**
 * EfxPagamentiSearch represents the model behind the search form about `common\models\EfxPagamenti`.
 */
class EfxPagamentiSearch extends EfxPagamenti
{
    public function rules()
    {
        return [
            [['id', 'idTipopagamento', 'idKey', 'idOperazione', 'idUtente', 'idCliente', 'statoPagamento'], 'integer'],
            [['idPagamento', 'mediatore', 'valuta'], 'safe'],
            [['importo'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxPagamenti::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idTipopagamento' => $this->idTipopagamento,
            'idKey' => $this->idKey,
            'idOperazione' => $this->idOperazione,
            'idUtente' => $this->idUtente,
            'idCliente' => $this->idCliente,
            'importo' => $this->importo,
            'statoPagamento' => $this->statoPagamento,
        ]);

        $query->andFilterWhere(['like', 'idPagamento', $this->idPagamento])
            ->andFilterWhere(['like', 'mediatore', $this->mediatore])
            ->andFilterWhere(['like', 'valuta', $this->valuta]);

        return $dataProvider;
    }
}
