<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SgtSocieta;
use yii\data\SqlDataProvider;
/**
 * SgtSocietaSearch represents the model behind the search form about `backend\models\SgtSocieta`.
 */
class SgtSocietaSearch extends SgtSocieta
{
    public function rules()
    {
        return [
            [['id', 'numeroIscrizioneEnte'], 'integer'],
            [['ente', 'societa', 'dataIscrizioneEnte', 'codiceFiscale', 'regione', 'affiliazione', 'codiceAffiliazione', 'tipoSocieta', 'cap', 'comune', 'provincia'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public $escludiFiltro = [];
    public function initExclude()
    {
    $escludi = [];
    $escludi[]='DILETTANTISTICA';
    $escludi[]='SPORTIVA';
    $escludi[]='ASSOCIAZIONE';
    $escludi[]='A.S.DILETTANTISTICA';
    $escludi[]='A.S.';
    $escludi[]='ASDILETTANTISTICA';
    $escludi[]='A.S.D.';
    $escludi[]='SOCIETA\'';
    $escludi[]='SOCIETÃ ';
    $escludi[]='ASD';
    $escludi[]='ASS.';
    $escludi[]='DILETTANTISTICO';
    $escludi[]='S.S.DILETTANTISTICA';
    $escludi[]='S.R.L.';
    $escludi[]='SOCIALE';
    $escludi[]='PROMOZIONE';
    $escludi[]='RESPONSABILITA\'';
    $escludi[]='SSDILETTANTISTICA';
    $escludi[]='SOCIETÃ€';
    $escludi[]='ASS.SPORTIVA';
    $escludi[]='SOCIETA';
    $escludi[]='RESPONSABILITÃ ';
    $escludi[]='ASS.NE';
    $escludi[]='A.S.D';
    $escludi[]='A.DIL.';
    $escludi[]='A.D.';
    $escludi[]='ASS.SPORT.DILETTANTISTICA';
    $escludi[]='DILETTANTISTICA.';
    $escludi[]='A.P.S.';
    $escludi[]='A.C.S.DILETTANTISTICA';
    $escludi[]='A.S.DILETTANTISTICA.';
    $escludi[]='A.P.DILETTANTISTICA';
    $escludi[]='A.S.DIL.';
    $escludi[]='ASSOC.';
    $escludi[]='A.S.DILETTANTISTICO';
    $escludi[]='SOCIETA`';
    $escludi[]='ASS';
    $escludi[]='ASSOCIATION';
    $escludi[]='ASOCIAZIONE';
    $escludi[]='U.S.DILETTANTISTICA';
    $escludi[]='A.S';
    $escludi[]='"DILETTANTISTICA"';
    $escludi[]='A.P.D.';
    $escludi[]='ASS.SPORT.';
    $escludi[]='DILETTANTISTICA"';
    $escludi[]='DILETTANTISTICA)';
    $escludi[]='A.SPORTIVA';
    $escludi[]='SOCIAL';
    $escludi[]='DILETTANTISTICO/A';
    $escludi[]='(ASSOCIAZIONE';
    $escludi[]='ASSOCIZIONE';
    $escludi[]='A.S.C.DILETTANTISTICA';
    $escludi[]='ASDILETTANTISTICAILETTANTISTICA';
    $escludi[]='ASS.DILETTANTISTICA';
    $escludi[]='A.C.DILETTANTISTICA';
    $escludi[]='RESPONSABILITÃ€';
    $escludi[]='S.DILETTANTISTICA';
    $escludi[]='SOCIO';
    $escludi[]='SPORT.DILETTANTISTICA';
    $escludi[]='"ASSOCIAZIONE';
    $escludi[]='A.DILETTANTISTICA';
    $escludi[]='ASDILETTANTISTICA.';
    $escludi[]='ASSOCIAIZONE';
    $escludi[]='ASS.SP.DILETTANTISTICA';
    $escludi[]='ASSOCIAZ.';
    $escludi[]='DILETTANTISTICA,';
    $escludi[]='*A.S.DILETTANTISTICA';
    $escludi[]='DILETTANTI';
    $escludi[]='POL.DILETTANTISTICA';
    $escludi[]='RESPONSABILITA';
    $escludi[]='S.S.DILETTANTISTICA.';
    $escludi[]='ASSOCIAZIONESPORTIVA';
    $escludi[]='DILETT.';
    $escludi[]='SOCIETA\'SPORTIVA';
    $escludi[]='ASSOCIAZONE';
    $escludi[]='(DILETTANTISTICA)';
    $escludi[]='ASSOC.SPORTIVA';
    $escludi[]='Â°ASSOCIAZIONE';
    $escludi[]='RESPONSABILITA`';
    $escludi[]='ASSOCAZIONE';
    $escludi[]='ASSOCIAZIONE.SPORTIVA.DILETTANTISTICA.';
    $escludi[]='ASSSOCIAZIONE';
    $escludi[]='ASS.S.DILETTANTISTICA';
    $escludi[]='G.S.DILETTANTISTICO';
    $escludi[]='SOCIETAÂ´';
    $escludi[]='SOCIETÃƑÂ ';
    $escludi[]='A.P.S.DILETTANTISTICA';
    $escludi[]='ASSOCIAZIONI';
    $escludi[]='DILETTANTISTICA-';
    $escludi[]='G.S.DILETTANTISTICA';
    $escludi[]='ASDILETTANTISTICO';
    $escludi[]='S.P.A.';
    $escludi[]='SOC.SPORT.DILETTANTISTICA';
    $escludi[]='"A.S.D.';
    $escludi[]='ASSICIAZIONE';
    $escludi[]='ASSOCIAZINE';
    $escludi[]='ASSOCCIAZIONE';
    $escludi[]='*ASSOCIAZIONE';
    $escludi[]='S.C.S.DILETTANTISTICA';
    $escludi[]='ASSOC.SPORT.';
    $escludi[]='ASSOC.SPORT.DILETTANTISTICA';
    $escludi[]='SP.DILETTANTISTICA';
    $escludi[]='.DILETTANTISTICA';
    $escludi[]='ACRSDILETTANTISTICA';
    $escludi[]='ASSOCIACIONE';
    $escludi[]='ASSOCIAZIONESPORTIVADILETTANTISTICA';
    $escludi[]='PROM.SOCIALE';
    $escludi[]='SOCIALE,';
    $escludi[]='SPORTIVADILETTANTISTICA';
    $escludi[]='DILETTANTISTICA';
    $escludi[]='A.C.R.S.DILETTANTISTICA';
    $escludi[]='ASS.POL.DILETTANTISTICA';
    $escludi[]='ASS0CIAZIONE';
    $escludi[]='ASSOCIAZ.SPORTIVA';
    $escludi[]='ASSOCIAZION';
    $escludi[]='DILETTANTISTICATENNIS';
    $escludi[]='SOCIETY';
    $escludi[]='A.S.D.DILETTANTISTICA';
    $escludi[]='ACSDILETTANTISTICA';
    $escludi[]='APDILETTANTISTICA';
    $escludi[]='AS.DILETTANTISTICA';
    $escludi[]='ASSOCIATI';
    $escludi[]='ASSOCIAZZIONE';
    $escludi[]='S.S.DILETTANTISTICO';
    $escludi[]='ASCDILETTANTISTICA';
    $escludi[]='ASDILETTANTISTICAC';
    $escludi[]='Â°A.S.DILETTANTISTICA';
    $escludi[]='SOCIETÃ€\'';
    $escludi[]='DILETTANTISTICO/A';
    $escludi[]='A.S.D.ASSOCIAZIONE';
    $escludi[]='A.S.DILETTANTISTICA';
    $escludi[]='ASSOCIAZIONE.';
    $escludi[]='DDILETTANTISTICA';
    $escludi[]='DILETTANTISTICAC.';
    $escludi[]='S.C.DILETTANTISTICA';
    $escludi[]='SOCI';
    $escludi[]='SPORTIVA.DILETTANTISTICA';
    $escludi[]='"DILETTANTISTICO"';
    $escludi[]='ASSIOCIAZIONE';
    $escludi[]='ASSOCAIZIONE';
    $escludi[]='ASSOCIATE';
    $escludi[]='ASSOCIAZIO';
    $escludi[]='ASSOCIAZIOE';
    $escludi[]='ASSOCIAZIONA';
    $escludi[]='ASSOCIAZIONE.SPORTIVA';
    $escludi[]='C.S.DILETTANTISTICO';
    $escludi[]='DILETTANTISTICA';
    $escludi[]='DILETTANTISTICAREAL';
    $escludi[]='DILETTANTISTICHE';
    $escludi[]='P.DILETTANTISTICA';
    $escludi[]='RESPONSABILITÃƑÂ ';
    $escludi[]='SOC.DILETTANTISTICA';
    $escludi[]='SSDILETTANTISTICAILETTANTISTICA';
    $escludi[]='SSDILETTANTISTICARL';
    $escludi[]='SSOCIAZIONE';
    $escludi[]='.DILETTANTISTICA.';
    $escludi[]='A.S.DILETTANTISTICO.';
    $escludi[]='A.SSOCIAZIONE';
    $escludi[]='ASC.DILETTANTISTICA';
    $escludi[]='ASDILETTANTISTICA-APS';
    $escludi[]='ASS.DIL.';
    $escludi[]='ASS.SPORT';
    $escludi[]='ASSOC.NE';
    $escludi[]='ASSOCIANE';
    $escludi[]='ASSOCIAZ.SPORT.DILETTANTISTICA';
    $escludi[]='ASSOCIAZIONISMO';
    $escludi[]='ASSOIAZIONE';
    $escludi[]='ASSOZIAZIONE';
    $escludi[]='DILETTANTISTICACENTRO';
    $escludi[]='DILETTANTISTICATENNISTAVOLO';
    $escludi[]='F.C.DILETTANTISTICA';
    $escludi[]='F.C.DILETTANTISTICO';
    $escludi[]='GR.DILETTANTISTICO';
    $escludi[]='INTERSOCIALE';
    $escludi[]='S.P.S.DILETTANTISTICA';
    $escludi[]='SOC.SP.DILETTANTISTICA';
    $escludi[]='(DILETTANTISTICO)';
    $escludi[]='A.B.DILETTANTISTICA';
    $escludi[]='A.P.DILETTANTISTICA.';
    $escludi[]='A.S.DILETTANTISTICA.C.';
    $escludi[]='A.S.R.DILETTANTISTICA';
    $escludi[]='ASS.CULT.';
    $escludi[]='ASS.CULT.SPORT.DILETTANTISTICA';
    $escludi[]='ASS.DI';
    $escludi[]='ASS.SPOR.';
    $escludi[]='ASSOCIAZIOME';
    $escludi[]='ASSOCIONE';
    $escludi[]='Â°A.C.R.S.DILETTANTISTICA';
    $escludi[]='BOCC.DILETTANTISTICA';
    $escludi[]='DILET.';
    $escludi[]='DILETTANTISTICA-CULTURALE';
    $escludi[]='DILETTANTISTICACIRCOLO';
    $escludi[]='DILETTANTISTICATIRO';
    $escludi[]='DILETTANTISTICO.';
    $escludi[]='RESPONSABILIT';
    $escludi[]='RESPONSABILITÃ€';
    $escludi[]='SOCIETA\'DILETTANTISTICA';
    $escludi[]='SSDILETTANTISTICO';
    $escludi[]='U.P.DILETTANTISTICA';
    $escludi[]='U.S.DILETTANTISTICA.';
    $escludi[]='"A.S.DILETTANTISTICA';
    $escludi[]='DILETTANTISTICA';
    $escludi[]='A,S,DILETTANTISTICA';
    $escludi[]='A.C.DILETTANTISTICO';
    $escludi[]='A.D.DILETTANTISTICA';
    $escludi[]='A.D.S.DILETTANTISTICA';
    $escludi[]='A.POL.DILETTANTISTICA';
    $escludi[]='A.R.C.S.DILETTANTISTICA';
    $escludi[]='A.S.D.DILETTANTISTICO';
    $escludi[]='A.S.DILETTANTISTICA.-';
    $escludi[]='A.S.DILETTANTISTICATIRO';
    $escludi[]='A.S.DILETTANTISTICO/A';
    $escludi[]='A.S.G.DILETTANTISTICA';
    $escludi[]='A.SPORT.DILETTANTISTICA';
    $escludi[]='A.T.S.DILETTANTISTICA';
    $escludi[]='ACS.DILETTANTISTICA';
    $escludi[]='ADILETTANTISTICA';
    $escludi[]='AS.SP.DILETTANTISTICA';
    $escludi[]='ASDILETTANTISTICARC';
    $escludi[]='ASS.SPOR.DILETTANTISTICA';
    $escludi[]='ASS.SPORT.DILETTANT';
    $escludi[]='ASS.SPORT.DILETTANTISTICA.';
    $escludi[]='ASSDILETTANTISTICA';
    $escludi[]='ASSOC.DILETTANTISTICA';
    $escludi[]='ASSOCIAZIONE.SPORTIVA.DILETTANTISTICA';
    $escludi[]='COOP.DILETTANTISTICA';
    $escludi[]='DILETTANTIASTICA';
    $escludi[]='DILETTANTIS';
    $escludi[]='DILETTANTISTCA';
    $escludi[]='DILETTANTISTIC';
    $escludi[]='DILETTANTISTICA-CLUB';
    $escludi[]='DILETTANTISTICA/APS';
    $escludi[]='DILETTANTISTICA/O';
    $escludi[]='DILETTANTISTICA:';
    $escludi[]='DILETTANTISTICAA';
    $escludi[]='DILETTANTISTICAD';
    $escludi[]='DILETTANTISTICAGINNASTICA';
    $escludi[]='DILETTANTISTICO"';
    $escludi[]='DILETTANTISTICO/ASD';
    $escludi[]='DILETTANTISTICOA';
    $escludi[]='GR.SP.DILETTANTISTICO';
    $escludi[]='POL.DILETTANTISTICA.';
    $escludi[]='POLISP.DILETTANTISTICA';
    $escludi[]='POLISPORTIVADILETTANTISTICA';
    $escludi[]='DILETTANTISTICA';
    $escludi[]='RESPONSAB';
    $escludi[]='RESPONSABILITA\'LIMITATA';
    $escludi[]='RESPONSBILITA\'';
    $escludi[]='S.P.DILETTANTISTICA';
    $escludi[]='S.R.L.S.DILETTANTISTICA';
    $escludi[]='S.S.DILETTANTISTICA.A';
    $escludi[]='SDILETTANTISTICA';
    $escludi[]='RESPONSAB.LIMITATA';
    $escludi[]='RESPONSABI';
    $escludi[]='RESPONSABIL';
    $escludi[]='RESPONSABILITAÂ´';
    $escludi[]='RESPONSABILITÃ Â ';
    $escludi[]='RESPONSABILTA\'';
    $escludi[]='RESPONSABILTA`';
    $escludi[]='RESPONSABILTÃ ';
    $escludi[]='RESPONSABLITA\'';
    $escludi[]='RESPONSANILITA\'';

    $this->escludiFiltro = $escludi;


    }


    public function searchFull($societa, $comune, $pagesize, $page)
    {

        $keys = explode(" ", $societa);
        //esclusioni
        $this->initExclude();

        $sql = "select * from sgt_societa where 1=1 ";
        $sql2 = "select count(*) conta from sgt_societa where 1=1 ";
        $sqlfilter="";
        if (trim($comune)!="") $sqlfilter .= "and comune='".$comune."' ";
        $excluded = [];

        foreach($keys as $key)
        {
            $key = strtoupper($key);
            if (in_array($key, $this->escludiFiltro) ){
                $excluded[] = $key;
            }
            else if (trim($key)!="") {
                $sqlfilter .= " and societa like '%".$key."%'";
            }
        }

        if (trim($comune)=="" && trim($societa)=="") $sqlfilter=" and 1=2";

        $sqlfilter .= " order by id";



        $stmt = \Yii::$app->db->createCommand($sql2.$sqlfilter);
        $modelCount = $stmt->queryOne();
        $count = $modelCount["conta"];

		$cr = new SqlDataProvider([
			'sql' => $sql.$sqlfilter,
			'totalCount' => $count,
			'sort' => [
				'attributes' => [
				],
			],
			'pagination' => [
				'pageSize' => $pagesize,
				'page' => $page-1,
			],
		]);


		return [$cr, $excluded];

    }


    public function searchute($params)
    {
        $query = SgtSocieta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere([
            'idUser' => Yii::$app->user->id,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }



        $query->andFilterWhere([
            'id' => $this->id,
            'numeroIscrizioneEnte' => $this->numeroIscrizioneEnte,
            'dataIscrizioneEnte' => $this->dataIscrizioneEnte,
        ]);

        $query->andFilterWhere(['like', 'ente', $this->ente])
            ->andFilterWhere(['like', 'societa', $this->societa])
            ->andFilterWhere(['like', 'codiceFiscale', $this->codiceFiscale])
            ->andFilterWhere(['like', 'regione', $this->regione])
            ->andFilterWhere(['like', 'affiliazione', $this->affiliazione])
            ->andFilterWhere(['like', 'codiceAffiliazione', $this->codiceAffiliazione])
            ->andFilterWhere(['like', 'tipoSocieta', $this->tipoSocieta])
            ->andFilterWhere(['like', 'cap', $this->cap])
            ->andFilterWhere(['like', 'comune', $this->comune])
            ->andFilterWhere(['like', 'provincia', $this->provincia]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = SgtSocieta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'numeroIscrizioneEnte' => $this->numeroIscrizioneEnte,
            'dataIscrizioneEnte' => $this->dataIscrizioneEnte,
        ]);

        $query->andFilterWhere(['like', 'ente', $this->ente])
            ->andFilterWhere(['like', 'societa', $this->societa])
            ->andFilterWhere(['like', 'codiceFiscale', $this->codiceFiscale])
            ->andFilterWhere(['like', 'regione', $this->regione])
            ->andFilterWhere(['like', 'affiliazione', $this->affiliazione])
            ->andFilterWhere(['like', 'codiceAffiliazione', $this->codiceAffiliazione])
            ->andFilterWhere(['like', 'tipoSocieta', $this->tipoSocieta])
            ->andFilterWhere(['like', 'cap', $this->cap])
            ->andFilterWhere(['like', 'comune', $this->comune])
            ->andFilterWhere(['like', 'provincia', $this->provincia]);

        return $dataProvider;
    }
}
