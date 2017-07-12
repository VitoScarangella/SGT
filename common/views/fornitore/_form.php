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
use kartik\tabs\TabsX;
/**
 * @var yii\web\View $this
 * @var common\models\Fornitore $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="fornitore-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [
          [
      		'columns'=>2,
      		'attributes' => [
                  'ragioneSociale'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ragione Sociale...', 'maxlength'=>200]],

      			]
      		],
          [
      		'columns'=>2,
      		'attributes' => [
                  'riferimento'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ragione Sociale...', 'maxlength'=>200]],

      			]
      		],
 		[
		'columns'=>2,
		'attributes' => [
            'piva'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Piva...', 'maxlength'=>16]],

			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'cf'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cf...', 'maxlength'=>16]],

			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'mail'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mail...', 'maxlength'=>100]],

			]
		],
 		[
    'contentBefore'=>'<legend class="text-info"><small>Indirizzo Sede Legale</small></legend>',
		'columns'=>2,
		'attributes' => [
            'codCountry'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('country','iso3','istat_name') //Tool::dropdownYN() ['0'=>'modificare...','1'=>'modificare...',]
            ]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'indirizzo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Indirizzo...', 'maxlength'=>200]],

			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'cap'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cap...', 'maxlength'=>5]],

			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'codProvincia'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('comuniistat','codiceProvincia','concat(provincia," ",cittaMetropolitana," ",siglaAutomobilistica)')
            ]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'codComune'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('comuniistat','codiceComune','denominazioneItaliano') //Tool::dropdownYN() ['0'=>'modificare...','1'=>'modificare...',]
            ]],

			]
		],
 		[
    'contentBefore'=>'<legend class="text-info"><small>Dati della banca</small></legend>',
		'columns'=>2,
		'attributes' => [
            'banca'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Banca...', 'maxlength'=>100]],

			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'indirizzoBanca'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Indirizzo Banca...', 'maxlength'=>200]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'iban'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Iban...', 'maxlength'=>40]],

			]
		],
        ] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
?>
<br>
<?
    \backend\controllers\ThisSiteController::footerFornitore($model);


?>
<hr>
</div>
