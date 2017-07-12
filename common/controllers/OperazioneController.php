<?php

namespace common\controllers;

use Yii;
use common\models\Upload;
use common\models\Iva;

use common\models\Operazione;
use common\models\OperazioneSearch;
use common\models\Operazionedettaglio;
use common\models\OperazionedettaglioSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\Tool;
/**
 * OperazioneController implements the CRUD actions for Operazione model.
 */
class OperazioneController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get' ],
                ],
            ],
        ];
    }

    /**
     * Lists all Operazione models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        if (!isset($_REQUEST["segno"])) $_REQUEST["segno"]= "1";

    		if ($_REQUEST["segno"] == "1")
    		  $title = 'Entrate';
    		if ($_REQUEST["segno"] == "-1")
    		  $title = 'Uscite';

    		$session['operazione'] = [
    				'segno' => $_REQUEST["segno"],
    				'titolo' => $title,
    			];

        $searchModel = new OperazioneSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Operazione model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Operazione model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        $model = new Operazione;
        $model->init();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->afterMasterUpdate($model->idTipodoc);

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'hasDetail' => false,
                'detail' =>"",
            ]);
        }
    }



    /**
     * Deletes an existing Operazione model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     public function actionDelete($id)
    {
        $session = Yii::$app->session;
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'segno'=>$session['operazione']['segno']]);
    }

    /**
     * Updates an existing Operazione model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$session = Yii::$app->session;
    $request = Yii::$app->request;

    $model = $this->findModel($id);
    //$model->segno = $session['operazione']['segno'];
		//$model->idUtente = \Yii::$app->user->identity->id;
    //$model->annoEsercizio = $session["esercizio"];
		$session['idOperazione'] = $id;
    $hasDetail = Operazione::getHasDetail($model->idTipodoc);
    $oldIdTipodoc =  $model->idTipodoc;
    $hasDetail=true; //per test

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->afterMasterUpdate($oldIdTipodoc);
            //return $hasDetail$this->redirect(['view', 'id' => $model->id])
            return $this->render('update', [
                'model' => $model,
                'hasDetail' => $hasDetail,
                'detail' =>(isset($hasDetail) && $hasDetail==1 ? Yii::$app->runAction('operazionedettaglio/indexdetail', ['id'=>$model->id]) : ""),
            ])
			//.Yii::$app->runAction('operazionedettaglio/indexdetail', ['id'=>$model->id])
			;
        } else {
          $model->afterMasterUpdate($oldIdTipodoc);
          Tool::log("...qw");
          return $this->render('update', [
                'model' => $model,
                'hasDetail' => $hasDetail,
                'detail' =>(isset($hasDetail) && $hasDetail==1 ? Yii::$app->runAction('operazionedettaglio/indexdetail', ['id'=>$model->id]) : ""),
            ])
			//.(isset($hasDetail) && $hasDetail==1 ? Yii::$app->runAction('operazionedettaglio/indexdetail', ['id'=>$model->id]) : Yii::$app->runAction('operazionedettaglio/indexnodetail', ['id'=>$model->id]))
			//.Yii::$app->runAction('operazionedettaglio/indexdetail', ['id'=>$model->id])
			;
        }
    }

    public function actions()
    {
        //Operazione::$tableName = Operazione::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => Operazione::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }

    public function actionReportExcel() {
        $session = Yii::$app->session;
        $this->layout='ajax';

        $periodo = $_REQUEST["periodo"];
        $segno = $_REQUEST["segno"];
        $annoEsercizio = $session["esercizio"];
        $idUtente = $session["user"]["id"];
        $table = Operazione::tableName();
        $periodoLabel = ($session["user"]['periodicita']==Operazione::MENSILE?"Mese": ($session["user"]['periodicita']==Operazione::TRIMESTRALE?"Trimestre":"Trimestre" ) );
        $xlsname = $session["cognome"]." ".$session["nome"]." ".$session["partitaIva"]
        . " Operazioni $annoEsercizio $periodoLabel $periodo";


        if (trim($periodo)=="")
        {
          $sql = "select * from $table
                  where annoEsercizio = $annoEsercizio
                  and idUtente=$idUtente
                  and segno=$segno";
        }
        elseif ($session["user"]['periodicita']==Operazione::TRIMESTRALE)
        {
          $sql = "select * from $table
                  where QUARTER(dataOperazione)=$periodo
                  and annoEsercizio = $annoEsercizio
                  and idUtente=$idUtente
                  and segno=$segno";
        }
        else
        {
          $sql = "select * from $table
                  where MONTH(dataOperazione)=$periodo
                  and annoEsercizio = $annoEsercizio
                  and idUtente=$idUtente
                  and segno=$segno";
        }


        Tool::buildExcel($sql,
                         (new Operazione())->attributeLabels(),
                         $xlsname,
                          ['D' => 'dd/mm/yyyy',],
                          [
                            // Dates and datetimes must be converted to Excel format
                            'D' => function ($value, $row, $data) {
                                return \PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
                                },
                          ]
                         );
    }

  public function actionUpload()
  {
    set_time_limit(0);
    ini_set('memory_limit', '100240M');
    $model = new Upload();
    $model->setUploadDir(Yii::$app->params['upload_path']);

		//$model->load(Yii::$app->request->post());
		//$model->idUtente = $_REQUEST["idUtente"];
    if (Yii::$app->request->isPost) {
	     Tool::log("actionUpload4:".print_r($model,true));
       $model->docfile = UploadedFile::getInstances($model, 'docfile');
       Tool::log("actionUpload5:".print_r($model,true));
			 echo $model->upload(); //echo se voglio aggiungere a lista file
      }
      return;
    }

    /**
     * Inserimento veloce di scontrini tramite caricamento di scannerizzazioni
     * @return mixed
     */
    public function actionQuick()
    {
      set_time_limit(0);
      ini_set('memory_limit', '10480M');
  		$session = Yii::$app->session;
      $model = new Operazione();
      $model->init();

      if (!$model->load(Yii::$app->request->post()) )
          {
            $model->idIva = 1; //valore di default
            $model->dataOperazione = $session["esercizio"] . Date('-m-d');
            $model->dataDocumento = $session["esercizio"] . Date('-m-d');
            $model->dataPagamento = $session["esercizio"] . Date('-m-d');
            return $this->render('quick', [
                'model' => $model,
            ]);

          }
      else
      {
        $model->idIva = $_REQUEST["Operazione"]["idIva"];
        $model->dataOperazione=$model->dataDocumento;

        Tool::logd($_REQUEST);
        Tool::logd($model);
        Tool::log("---------------". $_REQUEST["Operazione"]["idIva"]);

        return $this->render('quick', [
          'model' => $model,
          'idIva' =>  $model->idIva,
        ]);
      }
    }

    public function actionUploadquick()
    {
      set_time_limit(0);
      ini_set('memory_limit', '100240M');
    $session = Yii::$app->session;

    $model = new Upload();
    $model->setUploadDir(Yii::$app->params['upload_path']);

		//$model->load(Yii::$app->request->post());
		//$model->idUtente = $_REQUEST["idUtente"];
    if (!Yii::$app->request->isPost) return;

    $files=UploadedFile::getInstances($model, 'docfile');


    Tool::logd($_REQUEST);
    $msg="";
    foreach ($files as  $file) {
      $modelOp = new Operazione();
      $modelOp->init();
      $modelOp->load(Yii::$app->request->post());
      $modelOp->idUtente        = $_REQUEST["idEntity"];
      $modelOp->idTipodoc       = $_REQUEST["idTipodoc"];
      $modelOp->idTipomov     = $_REQUEST["idTipomov"];
      $modelOp->dataDocumento   = $_REQUEST["dataDocumento"];
      $modelOp->dataPagamento   = $_REQUEST["dataPagamento"];
      $modelOp->pagato          = $_REQUEST["pagato"];
      $modelOp->dataOperazione  = $_REQUEST["dataDocumento"];
      $modelOp->codiceProvincia = $_REQUEST["codiceProvincia"];
      $modelOp->idUtente        = $_REQUEST["idUtente"];
      $modelOp->segno           = $session['operazione']['segno'];
      $modelOp->idFiscale       = $session["user"]["partitaIva"];
      if ($modelOp->segno==1)
          $modelOp->idCliente   = $_REQUEST["idCliente"];
      if ($modelOp->segno==-1)
          $modelOp->idFornitore = $_REQUEST["idFornitore"];

      if ($session['operazione']['segno']==1) $modelOp->nextNumeroDocumento();
      $modelOp->note = $_REQUEST["note"];
      $modelOp->importoTotale = $_REQUEST["importoTotale"];
      $stateOp = $modelOp->validate();
      Tool::logValidate($modelOp);
      $modelOp->save();

      $msg = $stateOp?" Inserita operazione " . $modelOp->id : "Fallito inserimento operazione";


Tool::log("*****************");
      $rows = preg_split("/\\r\\n|\\r|\\n/", $_REQUEST["note"]);

      if (trim($_REQUEST["note"])=="")
      {
        Tool::log("*****************");
        $modelOpDet = new Operazionedettaglio();
        $modelOpDet->idOperazione = $modelOp->id;
        $modelOpDet->importo = $modelOp->importoTotale;
        $modelOpDet->idIva = $_REQUEST["idIva"];

        $percIva = Iva::findOne($modelOpDet->idIva)->aliquo;
        $modelOpDet->imponibile = $modelOpDet->importo * ((100-$percIva)/100);
        $modelOpDet->segno           = $session['operazione']['segno'];

        Tool::logValidate($modelOpDet);
        $stateOpDet = $modelOpDet->validate();
        $modelOpDet->save();
        $msg .= $stateOpDet?" - Inserito dettaglio " . $modelOpDet->id : "Fallito inserimento dettaglio";
      }
      else {
           //descrizione;imponibile
           foreach ($rows as $key => $row) {
             $fields = explode(";",$row);
             if (count($fields)!=2) continue;

             $modelOpDet = new Operazionedettaglio();
             $modelOpDet->idOperazione = $modelOp->id;
             $modelOpDet->importo = $modelOp->importoTotale;
             $modelOpDet->idIva = $_REQUEST["idIva"];

             $percIva = Iva::findOne($modelOpDet->idIva)->aliquo;
             $modelOpDet->descrizione = $fields[0];
             $modelOpDet->imponibile  = $fields[1];
             $modelOpDet->importo     = $modelOpDet->imponibile * ((100+$percIva)/100);
             $modelOpDet->segno       = $session['operazione']['segno'];

             Tool::logValidate($modelOpDet);
             $stateOpDet = $modelOpDet->validate();
             $modelOpDet->save();
             $msg .= $stateOpDet?" - Inserito dettaglio " . $modelOpDet->id : "Fallito inserimento dettaglio";
           }
      $modelOp->note = "";
      }
      $modelOp->afterMasterUpdate(); //ricalcola importo in base ai dettagli
      $modelOp->save();

      $model = new Upload();
      $model->docfile = Array($file);
      $s = $model->upload($_REQUEST["urlCancel"],$modelOp->idUtente,$modelOp->id ); //non faccio echo

      $msg .= json_decode($s,true)["error"];

    }

    return Json::encode(['responseText'=>"OK", 'error'=>$msg ]);
    }

    public function actionInvoice($id)
    {
      \backend\controllers\FatturaController::printInvoice($id);
      return;
	  }

    /**
     * Finds the Operazione model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operazione the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Operazione::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
