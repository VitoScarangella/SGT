<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Operazione;
use DateTime;

/**
 * OperazioneSearch represents the model behind the search form about `common\models\Operazione`.
 */
class OperazioneSearch extends Operazione
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idUtente', 'idCliente', 'segno', 'idTipomov', 'idTipodoc'], 'integer'],
            [['annoEsercizio', 'trimestre', 'mese', 'idFiscale', 'idComune', 'lastUpdate', 'dataOperazione', 'created'], 'safe'],
            [['note'], 'string'],
			[['dataOperazione'], 'date'],
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
        $session = Yii::$app->session;
        $query = Operazione::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $d="";
		//if ($this->dataOperazione!="")
    //$d = DateTime::createFromFormat('d/m/Y', $this->dataOperazione)->format('Y-m-d');

		$session = Yii::$app->session;
		$periodo = ( $session["user"]['periodicita']==MENSILE?"mese": ($session["user"]['periodicita']==TRIMESTRALE?"trimestre":"trimestre" ) );
		$periodoval = ( $session["user"]['periodicita']==MENSILE?$this->mese: ($session["user"]['periodicita']==TRIMESTRALE?$this->trimestre:$this->trimestre) );

	Tool::clear();
	Tool::log(  $this->tableName() . " !".$periodo. " !" . $periodoval);
	//Tool::log(" :".print_r($_REQUEST,true));
return $dataProvider;
        $query->andFilterWhere([
          //  'id' => $this->id,
          //  $periodo => $periodoval,
            'idUtente' => $session["user"]["id"],
            'annoEsercizio' => $session["esercizio"],
            'segno' => $this->segno,
            //'idTipomov' => $this->idTipomov,
            //'dataOperazione' => $d,
            //'lastUpdate' => $this->lastUpdate,
            //'trimestre' => $this->trimestre,
          //  'mese' => $this->mese,
            //'created' => $this->created,
            //'note' => $this->note,
        ]);

        //$query->andFilterWhere(['like', 'idFiscale', $this->idFiscale])
      ///      ->andFilterWhere(['like', 'idComune', $this->idComune]);

        return $dataProvider;
    }
}
