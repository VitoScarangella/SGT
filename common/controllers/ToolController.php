<?php

namespace common\controllers;

use Yii;
use common\models\Log;
use common\models\Logbatch;
use common\models\Tool;
use common\models\ToolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ToolController implements the CRUD actions for Tool model.
 */
class ToolController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'import' => ['post','get'],
                ],
            ],
        ];
    }



    public function actionImport()
    {
        /*

                id: '<?=$modelEvento->EV_ID?>',
                rows: rows,
                table: "plan",
                columns: "colonna1,colonna2",
                key: "idEvento",
                lineSeparator: "\n",
                columnSeparator: ";",
                rows: rows,


        */
        $count=0;
        $countKO=0;

        $connection = \Yii::$app->db;

        $rows = explode($_REQUEST["lineSeparator"], $_REQUEST["rows"]);
        $numColumn = count( explode(',',  $_REQUEST["columns"]) );
        $rowOrder = 0;
        $rowstep =  ( isset($_REQUEST["rowstep"]) ? $_REQUEST["rowstep"] : 1);
        foreach($rows as $row) {
            if (trim($row)=="") continue;
            $columns = explode($_REQUEST["columnSeparator"], $row);

            if (count($columns) != $numColumn) {

                $countKO++;
                continue;
            }



            $values = $_REQUEST["id"];

            $values .= ( isset($_REQUEST["rowOrder"]) ? "," . $rowOrder : "");

            foreach($columns as $col) {
                if ($values!="") $values .= ",";
                $values .= "'" . mysql_real_escape_string($col) . "'";
                }

            $sql = "insert into " . $_REQUEST["table"]
                    . " ("
                    . $_REQUEST["key"] . ","
                    . (isset($_REQUEST["rowOrder"])? $_REQUEST["rowOrder"] . "," : "")
                    . $_REQUEST["columns"] . ")"
                    . " values (" . $values . ")";
            $m = $connection->createCommand($sql)->execute();
            $count++;
            $rowOrder += $rowstep;
            }
       echo  "Sono state inserite $count righe. Ne sono state scartate $countKO ";

       // return $this->render($url);
    }


    /**
     * Lists all Tool models.
     * @return mixed
     */
    public function actionIndex()
    {
        $url = rawurldecode($_REQUEST["url"]);
        header("Location: " . $url);
        die();
        Yii::$app->getResponse()->redirect($url);
       // return $this->render($url);
    }

    public function actionDropdown()
    {
      $tab       = $_REQUEST['tab'];
      $id        = $_REQUEST['id'];
      $descr     = $_REQUEST['descr'];
      $condition = $_REQUEST['condition'];
      $selected  = isset($_REQUEST['selected'])?$_REQUEST['selected']:"";

      if (isset($_REQUEST['depdrop_parents'])) {
          $parents = $_REQUEST['depdrop_parents'];

          if ($parents != null) {
              $idFilter = $parents[0];
              $dropdown = [];
              $items = \common\models\Tool::dropdown($tab, $id, $descr, $condition.$idFilter );
              foreach ($items as $key => $value) {
                  if (trim($key)=="") continue;
                  $dropdown[] = ['id'=>$key, 'name'=>$value];
              }
              echo Json::encode(["output"=>$dropdown, "selected"=>$selected]);
              return;
          }
      }
      echo Json::encode(['output'=>[['id'=>' ', 'name'=>'----']], 'selected'=>' ']);


    }



    public function actionDropdowncomune($codComune)
    {
  	if (!isset($_REQUEST["codComune"]))
  		$idComune = "";
  	else
  		$idComune = $_REQUEST["codComune"];

    $out = [];
    if (isset($_REQUEST['depdrop_parents'])) {
        $parents = $_REQUEST['depdrop_parents'];
        if ($parents != null) {
            $prov = $parents[0];
            $out = \common\models\Comuniistat::dropdownComuniDedrop($prov); //self::getSubCatList($cat_id);
            echo Json::encode(['output'=>$out, 'selected'=>$idComune]);
            return;
        }
    }
 	  //$out = Comuniistat::dropdownComuniDedrop("");
    echo Json::encode(['output'=>[['id'=>'aa', 'name'=>'vv']], 'selected'=>'']);
	}


    public function actionMail()
    {
/*
    \Yii::$app->mail->compose('your_view', ['params' => $params])
       ->setFrom([\Yii::$app->params['supportEmail'] => 'Test Mail'])
       ->setTo('efisio.bova@gmail.com')
       ->setSubject('This is a test mail ' )
       ->send();
*/
       \Yii::$app->mailer->compose()
           ->setFrom([\Yii::$app->params['supportEmail'] => 'Orion test mail'])
           ->setTo('efisio.bova@gmail.com')
           ->setSubject('Verifica fnzionamento mail')
           ->setTextBody('Plain text content')
           ->setHtmlBody('<b>HTML content</b>')
           ->send();

       return $this->actionLog();
   }

    public function actionLog()
    {
      $logs = Log::find()->orderBy('id desc')->all();
      $logsbatch = Logbatch::find()->orderBy('id desc')->all();
        return $this->render('@common/views/tool/log',
        ['logs'=>$logs, 'logsbatch'=>$logsbatch ]);
    }


    public function actionDbcompare()
    {
        return $this->render('@common/views/tool/dbc',
        [ ]);
    }

    public function actionDbhelp()
    {
        return $this->render('@common/views/tool/dbh',
        [ ]);
    }

    public function actionCss()
    {
        return $this->render('@common/views/tool/css',
        [ ]);
    }

    public  function actionDeletelogtab() {
      $logs = Log::deleteAll();
      $logs = Logbatch::deleteAll();
      $this->actionLog();

    }


     public  function actionDeletelog() {
          $dirlog =  Yii::getAlias('@app') . '/runtime/logs/';

          if (file_exists ($dirlog.\Yii::$app->id.".log"))
              unlink ($dirlog.\Yii::$app->id.".log");

          if (file_exists ($_REQUEST["php_error_log"]))
              unlink ($_REQUEST["php_error_log"]);

              $this->actionLog();
     }


    public function actionVoid()
    {
        $t = isset($_REQUEST["title"])?$_REQUEST["title"]:"Work in progress";
        return $this->render('@common/views/tool/void',['title'=>$t]);
    }


    public function actionLegacy($type)
    {
    $session = Yii::$app->session;
    $idEvento = $session["idEvento"];

    $urllegacy = "http://localhost:8022/"; // "http://demogse.cloudpromae.it/gseservizi/";
    $urllegacy = "http://demogse.cloudpromae.it/gseservizi/";
        $url = $urllegacy;
        if ($type=="pdc") $url = $urllegacy . "selezione_piano_costi.php?id_evento=".$idEvento;
        else
            {
                return $this->render('@common/views/tool/voideventi');
            }
        if ($type=="p") $url = $urllegacy . "elenco_pdc.php";
        if ($type=="sal") $url = $urllegacy . "elenco_pdc.php";
        if ($type=="org") $url = $urllegacy . "elenco_pdc.php";

        $request = Yii::$app->request;
       // $this->layout = 'ajax';

        return $this->render('@common/views/tool/vieweventi',['url' => $url, 'titlepage'=>'Piano dei costi']);
    }




    public function actionIframe($url)
    {
        $request = Yii::$app->request;
       // $this->layout = 'ajax';

        return $this->render('@common/views/tool/view',['url' => $url,]);
    }






}
