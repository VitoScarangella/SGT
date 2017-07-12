<?php

namespace common\models;
use Yii;
use efx\validator\PiValidator;
use efx\validator\CfValidator;
use common\models\Tool;

use app\models\Tipodoc;
use app\models\Tipocosto;


/**
 * This is the model class for table "operazione".
 *
 * @property integer $id
 * @property integer $idUtente
 * @property string $idFiscale
 * @property integer $segno
 * @property integer $idTipomov
 * @property string $importoTotale
 * @property string $idComune
 * @property string $lastUpdate
 * @property string $created
 */
class Operazione extends \yii\db\ActiveRecord
{
    //public static $tableName = 'operazione';
    public static $tableName = 'operazione';
    public static $tableNameTab = 'operazione';
    public static $tableNameView = 'operazione';// 'operazione_view';

	public $docfile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Operazione::$tableName;
    }

    /**
     * Essendo una view devo mettere questo metodo
     */
    public static function primaryKey()
    {
        return ['id'];
    }


     private $_prov;

     public function getProv(){
         return $this->_prov;
     }

     public function setProv($prov){
         $this->_prov = $prov;
     }

     public $trimestre;
     function setTrimestre($t) {
       $this->trimestre=$t;
     }

     function getTrimestre() {
       $long = strtotime($this->dataOperazione);
       $m =  intval(date('m', $long));
        return ceil($m/3);
     }

     function getMese() {
       $long = strtotime($this->dataOperazione);
       return intval(date('m', $long));
     }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUtente', 'idFiscale', 'segno', 'idTipomov', 'idTipodoc', 'importoTotale','dataOperazione','codiceProvincia','idComune'], 'required'],
            [['numeroDocumento', 'idCliente', 'idUtente', 'segno', 'idTipomov', 'idTipodoc'], 'integer'],
            [['importoTotale'], 'number'],
            [['annoEsercizio','idModalitaPagamento','lastUpdate', 'created','note'], 'safe'],
            [['note'], 'string'],
            [['idFiscale'], 'string', 'max' => 50],
            [['idComune'], 'string', 'max' => 20],
			[['dataOperazione'], 'string' ],
			[['docfile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf, doc, docx, xls, xlsx, txt', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
      return [

          'id' => 'ID',

          'annoEsercizio' => 'Anno Esercizio',

          'dataOperazione' => 'Data Operazione',

          'dataDocumento' => 'Data Documento',

          'numeroDocumento' => 'Numero Documento',

          'numeroProtocollo' => 'Numero Protocollo',

          'idCliente' => 'Cliente',

          'idUtente' => 'Utente',
          'idCliente' => 'Cliente',
          'idFiscale' => 'Fiscale',
          'annoEsercizio' => 'Esercizio',
          'segno' => 'Segno',

          'idTipomov' => 'Tipocosto',

          'idTipodoc' => 'Tipodoc',

          'importoTotale' => 'Importo Totale',

          'codiceProvincia' => 'Codice Provincia',

          'idComune' => 'Comune',

          'note' => 'Note',
          'trimestre' => 'Trimestre',
          'idTipomov' => 'Tipo Costo',
          'idTipodoc' => 'Tipo Documento',
          'importoTotale' => 'Importo Totale',
          'codiceProvincia' => 'Provincia',
          'idComune' => 'Comune',
                'idModalitaPagamento' => 'Modalita Pagamento',
          'idModalitaPagamento' => 'Modalita Pagamento',
          'conto' => 'Conto',
          'lastUpdate' => 'Last Update',

          'created' => 'Created',
      ];
    }

    /**
     * @inheritdoc
     * @return OperazioneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OperazioneQuery(get_called_class());
    }


    public static function deleteDetail($modelOperazione)
    {
        $connection = \Yii::$app->db;
        $connection->createCommand("delete FROM operazionedettaglio where idOperazione=" . $modelOperazione->id)->execute();
    }


    public static function getHasDetail($TipoCosto)
    {
        $connection = \Yii::$app->db;
        $model = $connection->createCommand("SELECT dettaglio FROM tipodoc where id=" . $TipoCosto);
        $u = $model->queryOne();
        return  $u['dettaglio'];
    }





    /**
     * @inheritdoc
     * afterMasterUpdate
     */
    public function afterMasterUpdate($oldIdTipodoc)
    {
    $connection = \Yii::$app->db;
    $session = Yii::$app->session;

    //ho cambiato tipo documento
    if ($this->idTipodoc!=$oldIdTipodoc)
    {
      $hasDetailOld = Operazione::getHasDetail($oldIdTipodoc);

    }

    return;

    $idProfilo = $session["user"]["idProfilo"];
     //in base a profilo e tipo costo seleziono il dettaglio,  l'aliquota e calcolo l'imponibile

    Tool::log("afterMasterUpdate:".$this->id." |". "select dettaglio, aliquo, ".$this->importoTotale."/(1+aliquo/100) imponibile, idIva from profilo_tipocosto top, iva, tipocosto tt where idProfilo=".$idProfilo." and idTipomov=" . $this->idTipomov . " and top.idIva=iva.id and idTipomov=tt.id" );

  	$m = $connection->createCommand("select dettaglio, aliquo, ".$this->importoTotale."/(1+aliquo/100) imponibile, idIva from profilo_tipocosto top, iva, tipocosto tt where idProfilo=".$idProfilo." and idTipomov=" . $this->idTipomov . " and top.idIva=iva.id and idTipomov=tt.id");
  	$fromprofile = $m->queryOne();

    Tool::log("afterMasterUpdate:".$fromprofile['dettaglio']);

    ///////////////////////////////////////////////////////////////
    // Numero di righe di dettaglio
    ///////////////////////////////////////////////////////////////
  	$sql = "SELECT count(*) conta FROM operazionedettaglio where idOperazione=" . $this->id;
  	Tool::log("sql :".$sql );
  	$model = $connection->createCommand($sql);
  	$u = $model->queryOne();
  	$conta = $u['conta'];
  	//Se non ho dettagli ne inserisco uno
  	if($conta==0)
  		{
  		$connection->createCommand( "insert into operazionedettaglio (idOperazione, segno, idIva, imponibile, descrizione,importo) values " .
  		"(" . $this->id . ", 1, '" . $fromprofile["idIva"] . "', '" . $fromprofile["imponibile"] . "', '...', " . $this->importoTotale . ")" )->execute();
  		}

    //operazione con dettaglio. Importo totale non modificabile sul master
  	if ($fromprofile['dettaglio']==1)
  		{
  		//Aggiorno l'importo dell'operazione
  		$sql = "select ifnull(sum(ifnull(importo,0)),0) importoTotale from operazionedettaglio where idOperazione=" . $this->id;
  	    Tool::log("sql :".$sql );
  		$model = $connection->createCommand($sql);
  		$u = $model->queryOne();
  		$connection->createCommand("update operazione set importoTotale = " . $u["importoTotale"] . "  where id=" . $this->id )->execute();
  		}
  	else
  		{
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
  			"(" . $this->id . ", 1, '" . $fromprofile["idIva"] . "', '" . $fromprofile["imponibile"] . "', '...', '" . $this->importoTotale . "')" )->execute();
  			}
  		$m = false;
  		$u = false;
  		$fromprofile = false;

  		}
	////////////////////////////////////////////////////////////
    }

    public function init()
    {
      $session = Yii::$app->session;
      $this->idUtente = \Yii::$app->user->identity->id;
      $this->segno = $session['operazione']['segno'];
      $this->annoEsercizio = $session["esercizio"];
      $this->idFiscale = $session["user"]["partitaIva"];
      $this->codiceProvincia = $session["user"]["codiceProvinciaDefault"];
      $this->idComune = $session["user"]["idComuneDefault"];

      //$this->dataOperazione = date('Y-m-d');
    }

    public function nextNumeroDocumento()
    {
      $connection = \Yii::$app->db;
      $m = $connection->createCommand(
        " select IFNULL(max(numeroDocumento),0)+1 numeroDocumento, now() today from operazione " .
        " where idTipodoc=".$this->idTipodoc." and year(now())=year(dataOperazione) and idUtente= " . $this->idUtente);
      $mnum = $m->queryOne();
      $this->numeroDocumento = $mnum["numeroDocumento"];
    }


    public function upload__()
    {
	$start = '{"files": [';
	$end = ']}';
	/*
		echo '{"files": [
  {
    "name": "picture1.jpg",
    "size": 902604,
    "url": "http:\/\/example.org\/files\/picture1.jpg",
    "thumbnailUrl": "http:\/\/example.org\/files\/thumbnail\/picture1.jpg",
    "deleteUrl": "http:\/\/example.org\/files\/picture1.jpg",
    "deleteType": "DELETE"
  },
  {
    "name": "picture2.jpg",
    "size": 841946,
    "url": "http:\/\/example.org\/files\/picture2.jpg",
    "thumbnailUrl": "http:\/\/example.org\/files\/thumbnail\/picture2.jpg",
    "deleteUrl": "http:\/\/example.org\/files\/picture2.jpg",
    "deleteType": "DELETE"
  }
]}';

	*/
	$files="";
	Tool::log("file->baseName:!!");
	$valid = $this->validate();
	Tool::log("upload getErrors>>" . print_r($this->getErrors(),true) );

	$thedir = "uploads";

        if ($valid) {
	Tool::log("file->baseName:***");
			$virgola="";
            foreach ($this->docfile as $file) {
			Tool::log("file->baseName:".print_r($file,true));
                $file->saveAs($thedir.'/' . $file->baseName . '.' . $file->extension);

				Image::thumbnail($thedir."/".$file->name , 40, 40)
           ->save($thedir.'/tt' . $file->name , ['quality' => 50]);

			$files.=$virgola.'{'
			.'"name": "'.$file->name.'",'
			.'"size": '.$file->size.','
			.'"url": "'. Url::base()."/".$thedir."/".$file->name.'",'
			.'"thumbnailUrl": "'. Url::base()."/".$thedir."/tt".$file->name.'",'
			.'"deleteUrl": "'
			. Url::base().'/operazione/cancelattach&filename='.$thedir.'/'.$file->name.'&filenamethumb='.$thedir.'/tt'.$file->name.'&filedir='.$thedir.'",'
			.'"deleteType": "DELETE"'
			.'}';



			$virgola=",";
            }
            return $start.$files.$end;
        } else {


            return $start.$end;;
        }
    }
}
