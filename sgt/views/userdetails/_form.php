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
use backend\models\Operazione;
/**
 * @var yii\web\View $this
 * @var backend\models\Userdetails $model
 * @var yii\widgets\ActiveForm $form
 */

 if (!Tool::hasRole(Tool::SUPERADMIN))
 {
 $onlyadmin = true;
 }
 else
 {
 $onlyadmin = false;
 }
?>

<div class="userdetails-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);

    echo $form->errorSummary($model);
    echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [
          [
          'contentBefore'=>'<legend class="text-info"><small>Dati personali</small></legend>',
      		'columns'=>2,
      		'attributes' => [
                  'nome'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Nome...', 'maxlength'=>50]],
                  'cognome'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cognome...', 'maxlength'=>50]],

      			]
      		],
          [
      		'columns'=>2,
      		'attributes' => [
                  'dataNascita'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATE]],
                  'indirizzo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Indirizzp...', 'maxlength'=>50]],
      			]
      		],

          [
      		'columns'=>3,
      		'attributes' => [
                  'codiceProvincia'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                       'data'=>Tool::dropdown('comuniistat','codiceProvincia','concat(provincia," ",cittaMetropolitana," ",siglaAutomobilistica)'),
                       'size' => Select2::SMALL,
                    ]],
                  'idComune'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                       'data'=>Tool::dropdown('comuniistat','codiceComune','denominazioneItaliano'),
                       'size' => Select2::SMALL,
                    ]],
                  'cap'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cap...', 'maxlength'=>12]],
      			]
      		],



    [
    'contentBefore'=>'<legend class="text-info"><small>Dati Fiscali</small></legend>',
		'columns'=>2,
		'attributes' => [
      'ragioneSociale'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ragione Sociale...', 'maxlength'=>50]],
      'actions'=>[
                'type'=>Form::INPUT_RAW,
                'value'=>  ' '
            ],
			]
		],

 		[
		'columns'=>2,
		'attributes' => [
      'partitaIva'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Partita Iva...', 'maxlength'=>50]],
      'codiceFiscale'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Fiscale...', 'maxlength'=>50]],
			]
		],
    [
		'columns'=>2,
		'attributes' => [
      'idProfilo'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
           'data'=>Tool::dropdown('profilo','id','descrizione'),
           'size' => Select2::SMALL,
        ]],
			]
		],


    [
		'columns'=>2,
		'attributes' => [
            'telefonoCellulare'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Telefono Cellulare...', 'maxlength'=>50]],
            'telefonoFisso'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Telefono Fisso...', 'maxlength'=>50]],
			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'mail'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mail...', 'maxlength'=>50]],
            'pec'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Pec Mail...', 'maxlength'=>50]],
			]
		],

 		[
		'columns'=>2,
		'attributes' => [
            'idLingua'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('languages','id','title'),
                 'size' => Select2::SMALL,
              ]],
            'note'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Note...','rows'=> 6]],

			]
		],


        ] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
