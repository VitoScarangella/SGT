<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Operazionedettaglio;

/**
 * OperazionedettaglioSearch represents the model behind the search form about `common\models\Operazionedettaglio`.
 */
class OperazionedettaglioSearch extends Operazionedettaglio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idOperazione', 'segno', 'idIva'], 'integer'],
            [['imponibile', 'importo'], 'number'],
            [['descrizione', 'lastUpdate', 'created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Operazionedettaglio::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idOperazione' => $this->idOperazione,
            'segno' => $this->segno,
            'idIva' => $this->idIva,
            'imponibile' => $this->imponibile,
            'importo' => $this->importo,
            'lastUpdate' => $this->lastUpdate,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'descrizione', $this->descrizione]);

        return $dataProvider;
    }


    public static function getTotal($idOperazione)
    {
	$connection = \Yii::$app->db;
	$model = $connection->createCommand("SELECT sum(importo) totale FROM operazionedettaglio where idOperazione=" . $idOperazione);
	$u = $model->queryOne();

	$connection->createCommand("update operazione set importoTotale = '" . $u['totale'] . "' where id=" . $idOperazione)->execute();
    return  $u['totale'];
    }
}
