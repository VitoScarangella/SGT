<?php

namespace common\models;

use Yii;
use common\models\Tool;

class Operazione extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operazione';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['annoEsercizio', 'dataOperazione', 'dataDocumento', 'idUtente', 'idFiscale', 'segno', 'idTipomov', 'idTipodoc', 'importoTotale'], 'required'],
            [['annoEsercizio', 'numeroDocumento', 'numeroProtocollo', 'idIva', 'idCliente', 'idFornitore', 'idUtente', 'segno', 'idTipomov', 'idTipodoc', 'idModalitaPagamento', 'idScadenza'], 'integer'],
            [['dataOperazione', 'dataDocumento',  'dataPagamento', 'lastUpdate', 'created', 'pagato'], 'safe'],
            [['importoTotale'], 'number'],
            [['note', 'conto'], 'string'],
            [['idFiscale', 'idRiferimento'], 'string', 'max' => 50],
            [['codCountry'], 'string', 'max' => 6],
            [['codiceProvincia'], 'string', 'max' => 10],
            [['idComune'], 'string', 'max' => 20],
            ['idCliente', 'required',
                          'when' => function($model) {
                            return $model->segno==1;
                          }
            ],
            ['idFornitore', 'required',
                          'when' => function($model) {
                            return $model->segno==-1;
                          }
            ],


            //[['banca'], 'string', 'max' => 100],
            //[['indirizzoBanca'], 'string', 'max' => 200],
            //[['iban'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public $idIva;
    public function getIdIva() { return $this->idIva;}
    public function setIdIva($v) { $this->idIva = $v;}

    public function attributeLabels()
    {
        return [
            'dataDocumento' => Yii::t('yii', 'Invoice date'),
            'numeroDocumento' => Yii::t('yii', 'Invoice number'),
            'idFiscale' => Yii::t('yii', 'VAT number'),
            'importoTotale' => Yii::t('yii', 'Amount'),

            'id' => 'ID',
            'idIva' => 'Iva',

            'codCountry' => 'Cod Country',

            'idRiferimento' => 'Riferimento',

            'pagato' => 'Pagato',

            'dataPagamento' => 'Data Pagamento',

            'annoEsercizio' => 'Anno Esercizio',

            'dataOperazione' => 'Data Operazione',

            'numeroProtocollo' => 'Numero Protocollo',

            'idCliente' => 'Cliente',

            'idModalitaPagamento' => 'Modalita Pagamento',

            'idFornitore' => 'Fornitore',

            'idUtente' => 'Utente',

            'segno' => 'Segno',

            'idTipomov' => 'Tipo Costo',

            'idTipodoc' => 'Tipo Documento',

            'codiceProvincia' => 'Codice Provincia',

            'idComune' => 'Comune',

            'note' => 'Note',

            'idModalitaPagamento' => 'Modalita Pagamento',

            'idScadenza' => 'Scadenza',

            'conto' => 'Conto',

            'lastUpdate' => 'Last Update',

            'created' => 'Created',

            //'banca' => 'Banca',

            //'indirizzoBanca' => 'Indirizzo Banca',

            //'iban' => 'Iban',

        ];
    }


    public function save($runValidation = true, $attributeNames = NULL)
    {
        if ($this->segno==1 && ($this->numeroDocumento===false || trim($this->numeroDocumento)=="") )
          $this->nextNumeroDocumento();

        $ris = parent::save($runValidation, $attributeNames);
        return $ris;
    }

    public function delete()
    {

        parent::delete();
    }


    private function afterMasterUpdateE($hasDetail, $conta)
    {
      $connection = \Yii::$app->db;
      $session = Yii::$app->session;

      $m = $connection->createCommand("select aliquo from iva where id='" . $session["user"]["idIvaVendite"]."'");
    	$fromprofile = $m->queryOne();
      if (empty($fromprofile)) $aliquo=0; else $aliquo=$fromprofile["aliquo"];
      $imponibile = $this->importoTotale / (1+$aliquo/100);

      //Se non ho dettagli ne inserisco uno
    	if($conta==0)
    		{
    		$connection->createCommand( "insert into operazionedettaglio
          (idOperazione, segno, idIva, imponibile, descrizione,importo) values " .
    		  "(" . $this->id . ", $this->segno, '" . $session["user"]["idIvaVendite"] . "', '" . $imponibile . "', '...', " . $this->importoTotale . ")" )->execute();
    		}

      //operazione con dettaglio. Importo totale non modificabile sul master
    	if ($hasDetail)
    		{
          Tool::log("afterMasterUpdate: 1");
    		//Aggiorno l'importo dell'operazione
    		$sql = "select ifnull(sum(ifnull(importo,0)),0) importoTotale
                from operazionedettaglio
                where idOperazione=" . $this->id;
    	    Tool::log("sql :".$sql );
    		$model = $connection->createCommand($sql);
    		$u = $model->queryOne();
    		$connection->createCommand("update operazione set importoTotale = " . $u["importoTotale"] . "  where id=" . $this->id )->execute();
    		}
      //
      if (!$hasDetail)
      		{
            Tool::log("afterMasterUpdate: 2");
      		//operazione con dettaglio unico. Il dettaglio non è modificabile
      		//Se ho un dettaglio aggiorno l'importo
      		if($conta==1)
      			{
      			$connection->createCommand( "update operazionedettaglio set imponibile='" . $imponibile . "', importo='" . $this->importoTotale . "' " .
      			" where idOperazione=" . $this->id  )->execute();
      			}

      		//Se ho più dettagli cancello tutti e ne inserisco uno (caso che non dovrebbe verificarsi
      		if($conta>1)
      			{
      			$connection->createCommand( "delete from operazionedettaglio  where idOperazione=" . $this->id  )->execute();
      			$connection->createCommand( "insert into operazionedettaglio (idOperazione, segno, idIva, imponibile, descrizione,importo) values " .
      			"(" . $this->id . ", $this->segno, '" .  $session["user"]["idIvaVendite"] . "', '" . $imponibile . "', '...', '" . $this->importoTotale . "')" )->execute();
      			}
      		$m = false;
      		$u = false;
      		$fromprofile = false;

      		}


    }

    private function afterMasterUpdateU($hasDetail, $conta)
    {
      $connection = \Yii::$app->db;
      $session = Yii::$app->session;
      $idProfilo = $session["user"]["idProfilo"];

      $m = $connection->createCommand("
        select idTipomov, dettaglio, ifnull(aliquo,0) aliquo, ".$this->importoTotale."/(1+ifnull(aliquo,0)/100) imponibile, idIva
        from profilo_tipocosto top
        left join iva on  top.idIva=iva.id
        left join tipocosto tt on idTipomov=tt.id
        where idProfilo=$idProfilo
        and idTipomov=" . $this->idTipomov);
    	$fromprofile = $m->queryOne();

      Tool::log("afterMasterUpdate:".$fromprofile['dettaglio']);

      //Se non ho dettagli ne inserisco uno
    	if($conta==0)
    		{
        Tool::log("afterMasterUpdate:".$fromprofile['dettaglio']);
    		$connection->createCommand( "insert into operazionedettaglio
          (idOperazione, segno, idIva, imponibile, descrizione,importo) values " .
    		  "(" . $this->id . ", $this->segno, '" . $fromprofile["idIva"] . "', '" . $fromprofile["imponibile"] . "', '...', " . $this->importoTotale . ")" )->execute();
    		}

      //operazione con dettaglio. Importo totale non modificabile sul master
    	if ($hasDetail)
    		{
          Tool::log("afterMasterUpdate: 1");
    		//Aggiorno l'importo dell'operazione
    		$sql = "select ifnull(sum(ifnull(importo,0)),0) importoTotale
                from operazionedettaglio
                where idOperazione=" . $this->id;
    	    Tool::log("sql :".$sql );
    		$model = $connection->createCommand($sql);
    		$u = $model->queryOne();
    		$connection->createCommand("update operazione set importoTotale = " . $u["importoTotale"] . "  where id=" . $this->id )->execute();
    		}
     //
     if (!$hasDetail)
    		{
          Tool::log("afterMasterUpdate: 2");
    		//operazione con dettaglio unico. Il dettaglio non è modificabile
    		//Se ho un dettaglio aggiorno l'importo
    		if($conta==1)
    			{
    			$connection->createCommand( "update operazionedettaglio set imponibile='" . $fromprofile["imponibile"] . "', importo='" . $this->importoTotale . "' " .
    			" where idOperazione=" . $this->id  )->execute();
    			}

    		//Se ho più dettagli cancello tutti e ne inserisco uno (caso che non dovrebbe verificarsi
    		if($conta>1)
    			{
    			$connection->createCommand( "delete from operazionedettaglio  where idOperazione=" . $this->id  )->execute();
    			$connection->createCommand( "insert into operazionedettaglio (idOperazione, segno, idIva, imponibile, descrizione,importo) values " .
    			"(" . $this->id . ", $this->segno, '" . $fromprofile["idIva"] . "', '" . $fromprofile["imponibile"] . "', '...', '" . $this->importoTotale . "')" )->execute();
    			}
    		$m = false;
    		$u = false;
    		$fromprofile = false;

    		}


    }

    /**
     * @inheritdoc
     * afterMasterUpdate
     */
    public function afterMasterUpdate($insert=false)
    {
    $connection = \Yii::$app->db;
    Tool::log("AFTER MASTER UPDATE ".$this->id);
    $session = Yii::$app->session;
    $idProfilo = $session["user"]["idProfilo"];
     //in base a profilo e tipo costo seleziono il dettaglio,  l'aliquota e calcolo l'imponibile

    Tool::log("afterMasterUpdate:".$this->id." |". "select dettaglio, aliquo, ".$this->importoTotale."/(1+aliquo/100) imponibile, idIva from profilo_tipocosto top, iva, tipocosto tt where idProfilo=".$idProfilo." and idTipomov=" . $this->idTipomov . " and top.idIva=iva.id and idTipomov=tt.id" );

    ///////////////////////////////////////////////////////////////
    // Presenza  di dettaglio
    ///////////////////////////////////////////////////////////////
    $hasDetail = self::getHasDetail($this->idTipodoc);

    Tool::log("...!!");

    ///////////////////////////////////////////////////////////////
    // Numero di righe di dettaglio
    ///////////////////////////////////////////////////////////////
  	$sql = "SELECT count(*) conta FROM operazionedettaglio where idOperazione=" . $this->id;
  	Tool::log("sql :".$sql );
  	$model = $connection->createCommand($sql);
  	$u = $model->queryOne();
  	$conta = $u['conta'];

    if($this->segno==1)
      $this->afterMasterUpdateE($hasDetail, $conta);
    else
      $this->afterMasterUpdateU($hasDetail, $conta);
    }

    /**
     * @inheritdoc
     * afterDetailUpdate
     */
    public static function afterDetailUpdate($id)
    {
      Tool::log("AFTER MASTER UPDATE $id");


  	$modelOperazione = Operazione::findOne($id);

  	$connection = \Yii::$app->db;

    //Se non ho dettagli ne inserisco uno
    $model = $connection->createCommand("SELECT count(*) conta FROM operazionedettaglio where idOperazione=" . $modelOperazione->id);
    $u = $model->queryOne();
    if($u['conta']==0)
		{
		//in base a profilo e tipo costo seleziono l'aliquota
		$session = Yii::$app->session;
		$idProfilo = $session["user"]["idProfilo"];
		$m = $connection->createCommand("select aliquo, ".$modelOperazione->importoTotale."/(1+aliquo/100) imponibile from profilo_tipocosto top, iva where idProfilo=".$idProfilo." and idTipomov=" . $modelOperazione->idTipomov . " and top.idIva=iva.id");
		$u = $m->queryOne();

	    $connection->createCommand( "insert into operazionedettaglio (idOperazione, segno, idIva, imponibile, descrizione,importo) values " .
		"(" . $modelOperazione->id . ", 1, 1, " . $u["imponibile"] . ", '...', " . $modelOperazione->importoTotale . ")" )->execute();

		}

  	//Aggiorno l'importo dell'operazione
    $sql = "select ".$modelOperazione->segno." * segno*ifnull(sum(ifnull(importo,0)),0) importoTotale from operazionedettaglio where idOperazione=" . $modelOperazione->id;
  	$model = $connection->createCommand($sql);
    Tool::clear(); Tool::log($sql);
  	$u = $model->queryOne();
  	$connection->createCommand("update operazione set importoTotale = " . $u["importoTotale"] . "  where id=" . $modelOperazione->id )->execute();
    }



    public static function getHasDetail($tipoDoc)
    {
        $connection = \Yii::$app->db;
        $model = $connection->createCommand("SELECT dettaglio FROM tipodoc where id=" . $tipoDoc);
        $u = $model->queryOne();
        Tool::log("getHasDetail ".$u['dettaglio']);
        if($u['dettaglio']==1) return true;
        else
        return false;
    }


    public function nextNumeroDocumento()
    {
      $connection = \Yii::$app->db;
      $m = $connection->createCommand(
        " select IFNULL(max(numeroDocumento),0)+1 numeroDocumento, now() today from operazione "
        . " where idTipodoc=".$this->idTipodoc
        . " and segno=".$this->segno
        . " and year(now())=year(dataOperazione)   ");
      $mnum = $m->queryOne();
      $this->numeroDocumento = $mnum["numeroDocumento"];
    }

    public function init()
    {
      $session = Yii::$app->session;
      $this->segno = $session['operazione']['segno'];
      $this->idUtente = \Yii::$app->user->identity->id;
      $this->annoEsercizio = $session["esercizio"];

      //$this->dataOperazione = date('Y-m-d');
    }

}
