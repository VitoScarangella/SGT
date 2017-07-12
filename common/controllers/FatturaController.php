<?php

namespace common\controllers;

use Yii;
use common\models\Operazione;
use common\models\Operazionedettaglio;
use common\models\Cliente;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;
use yii\db\Expression;
use common\models\Tool;
use common\models\Tipodoc;
use common\models\EfxLayout;



/**
 * FornitoreController implements the CRUD actions for Fornitore model.
 */
class FatturaController extends Controller
{

  public static function printInvoice($idOperazione, $idtemplate=Tipodoc::FATTURA)
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    $headers = Yii::$app->response->headers;
    $headers->add('Content-Type', 'application/pdf');
    $pdf = Yii::$app->pdf;

    Tool::logd(Yii::$app->session);
    $session = Yii::$app->session;


    $idTipodoc = Tipodoc::FATTURA;
    $efxLayout = EfxLayout::find()
      ->where(['=', "idTipodoc", $idTipodoc])
      //->andWhere(['=', "idLingua", 1])
      ->andWhere(['=', "titolo", "STANDARD"])->one();

    if (empty($efxLayout))
    $efxLayout = EfxLayout::find()
      ->where(['=', "idTipodoc", $idTipodoc])->one();

    $html = $efxLayout->descrizione;

    Tool::log("....2");

  $operazione = Operazione::find()
  ->where(['=', "id", $idOperazione])->one();
  Tool::log("....3");

  $cliente = Cliente::find()
  ->where(['=', "id", $operazione->idCliente])->one();
  Tool::log("....4");


  if (empty($cliente))
  {
    $pdf->content = "<h3>Non hai associato un cliente alla fattura!</h3><h3>La stampa non è possibile</h3>";
    return $pdf->render();
  }


  $comune = \common\models\Comuniistat::find()->where(['=', "codiceComune", $operazione->idComune])->one();
  $cliente = \common\models\Cliente::find()->where(['=', "id", $operazione->idCliente])->one();

  if (!empty($cliente->codComune))
  $comuneCliente = \common\models\Comuniistat::find()->where(['=', "codiceComune", $cliente->codComune])->one();

  if (!empty($session['user']['idComune']))
  $comuneUtente = \common\models\Comuniistat::find()->where(['=', "codiceComune", $session['user']['idComune']])->one();


  //////////////////////////////////////////////////////////////
  // VOCI DI FATTURAZIONE
  //////////////////////////////////////////////////////////////
  $head = "
  <tr>
  <th>Descrizione</th>
  <th>Iva</th>
  <th>Imponibile</th>
  </tr>
  ";
  $body = "";
  $headRiepilogoIva = "
  <tr>
  <th> </th>
  <th> </th>
  <th>Iva</th>
  </tr>
  ";
  $bodyRiepilogoIva = "";

  $details = \common\models\Operazionedettaglio::find()->where(['=', "idOperazione", $operazione->id])->all();
  $riepilogo = array();
  $totaleIva=0;
  $totaleImponibile=0;
  foreach ($details as $key => $detail) {
    $iva = \common\models\Iva::find()->where(['=', "id", $detail["idIva"]])->one();

    $body .= "<tr>";
    $body .= "<td>" . $detail["descrizione"] . "</td>";
    $body .= "<td>" . $iva["aliquo"] . "</td>";
    $body .= "<td align=right>" . Tool::fmtCurrency($detail["imponibile"]) . "</td>";
    $totaleImponibile += $detail["imponibile"];

    //($detail["importo"]-$detail["imponibile"])

    if (!isset($riepilogo[$detail["idIva"]]))
      {
      $riepilogo[$detail["idIva"]] = array(
              $iva["descrizione"],
              ($detail["importo"]-$detail["imponibile"])
            );
      }
    else {
      $riepilogo[$detail["idIva"]][1] += ($detail["importo"]-$detail["imponibile"]);
    }
    $totaleIva += ($detail["importo"]-$detail["imponibile"]);
    $body .= "</tr>";
  }
  $body .= "<tr class='info'>";
  $body .= "<th></th>";
  $body .= "<th>TOTALE IMPONIBILE</th>";
  $body .= "<th align=right>" . Tool::fmtCurrency($totaleImponibile) . "</th>";
  $body .= "</tr>";


  foreach ($riepilogo as $key => $detail) {
    $bodyRiepilogoIva .= "<tr>";
    $bodyRiepilogoIva .= "<td> </td>";
    $bodyRiepilogoIva .= "<td>" . $detail[0] . "</td>";
    $bodyRiepilogoIva .= "<td align=right>" . Tool::fmtCurrency($detail[1]) . "</td>";
    $bodyRiepilogoIva .= "</tr>";
  }
  $bodyRiepilogoIva .= "<tr class='info'>";
  $bodyRiepilogoIva .= "<td></td>";
  $bodyRiepilogoIva .= "<th>TOTALE IVA</th>";
  $bodyRiepilogoIva .= "<th align=right>" . Tool::fmtCurrency($totaleIva) . "</th>";
  $bodyRiepilogoIva .= "</tr>";

  $bodyTot = "<tr class='info'>";
  $bodyTot .= "<td></td>";
  $bodyTot .= "<th>TOTALE FATTURA</th>";
  $bodyTot .= "<th align=right>" . Tool::fmtCurrency($totaleImponibile+$totaleIva) . "</th>";
  $bodyTot .= "</tr>";

  if (!empty($cliente->codComune))
  {
    $DenominazioneItaliano = $comuneCliente->DenominazioneItaliano;
    $SiglaAutomobilistica  = $comuneCliente->SiglaAutomobilistica;
  }
  else {
    $DenominazioneItaliano = "...";
    $SiglaAutomobilistica  = "...";
  }
  if (!empty($comuneUtente))
  {
    $DenominazioneItalianoUtente = $comuneUtente->DenominazioneItaliano;
    $SiglaAutomobilisticaUtente  = $comuneUtente->SiglaAutomobilistica;
  }
  else {
    $DenominazioneItalianoUtente = "...";
    $SiglaAutomobilisticaUtente  = "...";
  }




  $vars = array(
    ///////////////////////////////////////////////
    '{numeroDocumento}'        => $operazione->numeroDocumento,
    '{dataDocumento}'          => date_format(date_create($operazione->dataDocumento), 'd/m/Y'),

    '{ragioneSociale}'         => $session['user']['ragioneSociale'],
    '{indirizzo}'              => $session['user']['indirizzo'],
    '{cap}'                    => $session['user']['cap'],
    '{comune}'                 => $DenominazioneItalianoUtente,
    '{provincia}'              => $SiglaAutomobilisticaUtente,
    '{partitaIva}'             => $session['user']['partitaIva'],
    '{codiceFiscale}'          => $session['user']['codiceFiscale'],

    '{clienteRagioneSociale}'  => $cliente->ragioneSociale,
    '{clienteIndirizzo}'       => $cliente->indirizzo,
    '{clienteCap}'             => $cliente->cap,
    '{clienteComune}'          => $DenominazioneItaliano,
    '{clienteProvincia}'       => $SiglaAutomobilistica,
    '{clientePartitaIva}'      => $cliente->piva,
    '{clienteCodiceFiscale}'   => $cliente->cf,

    '{modalitaPagamento}'      => Tool::dropdownValue("modalita_pagamento","id","descrizione",$operazione->idModalitaPagamento),
    '{scadenza}'               => Tool::dropdownValue("scadenza","id","descrizione",$operazione->idScadenza),

    '{banca}'                  => $session["user"]["banca"],
    '{iban}'                   => $session["user"]["iban"],
    '{indirizzoBanca}'         => $session["user"]["indirizzoBanca"],

    ///////////////////////////////////////////////

    '{id}'                     => $operazione->id,
    '{annoEsercizio}'          => $operazione->annoEsercizio,
    '{dataOperazione}' => 		 $operazione->dataOperazione,
    '{numeroProtocollo}' => 		 $operazione->numeroProtocollo,
    '{idUtente}' => 		 $operazione->idUtente,
    '{idFiscale}' => 		 $operazione->idFiscale,
    '{segno}' => 		 $operazione->segno,
    '{idTipomov}' => 		 $operazione->idTipomov,
    '{idTipodoc}' => 		 $operazione->idTipodoc,
    '{importoTotale}' => 		 $operazione->importoTotale,
    '{note}' => 		 $operazione->note,
    '{idModalitaPagamento}' => 		 $operazione->idModalitaPagamento,
    '{conto}' => 		 $operazione->conto,
    '{lastUpdate}' => 		 $operazione->lastUpdate,
    '{created}' => 		 $operazione->created,

    ///////////////////////////////////////////////
    '{nome}' => 		 $session['user']['nome'],
    '{cognome}' => 		 $session['user']['nome'],

    '<!--{DETTAGLIO_HEAD}-->' => $head,
    '<!--{DETTAGLIO_BODY}-->' => $body,
    '<!--{DETTAGLIO_HEADRIEPIVA}-->' => $headRiepilogoIva,
    '<!--{DETTAGLIO_BODYRIEPIVA}-->' => $bodyRiepilogoIva,
    '<!--{DETTAGLIO_TOT}-->' => $bodyTot,
    '{SERVER_NAME}' => "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']
  );

  //debug
  foreach ($vars as $key => $value) {
  //$vars[$key] = $value . "[" . $key . "]";
  }





  $totaleImponibile = 0;
  $totaleIva = 0;
  $totaleFattura = 0;

Tool::logd($efxLayout);

$template= strtr($html, $vars);
$my_html= strtr($html, $vars);

Tool::log("....9");

  Tool::log("....10");

$pdf->content = $my_html;
Tool::log("....11");
return $pdf->render();
}

}
