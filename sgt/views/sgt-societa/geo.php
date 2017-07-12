<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\builder\FormGrid;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use common\models\Tool;
use yii\web\JsExpression;
/**
 * @var yii\web\View $this
 * @var backend\models\SgtSocieta $model
 * @var yii\widgets\ActiveForm $form
 */
$models = $dataProvider->getModels();
$k=0;
$connection = \Yii::$app->db;
$sql = "select * from sgt_societa where indirizzo is not null and indirizzo <>'' ";
$models = $connection->createCommand($sql)->query();
Tool::clear();
foreach($models as $soc)
{
$k++;
//Corso Filippo Brunelleschi, 119, 10141 Torino, Italia
if (trim($soc["indirizzo"]=="")) {
  $model->geo=0;
  $model->save(false);
  echo $k . " Manca indirizzo: " . $soc["societa"]." * "."<br>";
  Tool::log($k . " - " . $soc["societa"]." * ");
  continue;
}

$model = \backend\models\SgtSocieta::findOne($soc["id"]);
if ($model->X!=0 && $model->Y!=0) {
  $model->geo=1;
  $model->save(false);
  //echo $k . " - " . $model["societa"]." * ".$model->X." ".$model->Y.  "<br>";
  Tool::log($k . " Geotaggato: " . $model["societa"]." * ".$model->X." ".$model->Y);
  continue;
}

$esito = $model->geolocate(trim($model["indirizzo"]).",".trim($model["civico"]).",".trim($model["cap"])/*." ".$model["comune"].", Italia"*/);
$model->save(false);
//Tool::logValidate($model);
echo $k . " - " . $model["societa"]
. "<br>" . $model["indirizzo"].",".$model["civico"].",".$model["cap"]/*." ".$model["comune"].", Italia"*/
."<br>X:".$model->X." Y:".$model->Y."<hr>"
;
Tool::log($k . " - " . $soc["societa"]
. " " . $model["indirizzo"].",".$model["civico"].",".$model["cap"]/*." ".$model["comune"].", Italia"*/
." X:".$model->X." Y:".$model->Y." ");
if (!$esito) return;
}
?>

</div>
