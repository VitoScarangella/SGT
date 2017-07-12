<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\builder\FormGrid;
/**
 * @var yii\web\View $this
 * @var common\models\Userdetails $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="userdetails-form">

    <?php
		$session = Yii::$app->session;
		if (!Tool::hasRole(Tool::SUPERADMIN))
		{
		$onlyadmin = true;
		}
		else
		{
		$onlyadmin = false;
		}


$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo FormGrid::widget([

    'model' => $model,
    'form' => $form,
	'autoGenerateColumns'=>false,
	'rows'=>[
		[
		'contentBefore'=>'<legend class="text-info"><small>Dati personali</small></legend>',
		'columns'=>3,
		'attributes' => [
			//'id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'...', 'maxlength'=>11, 'style'=>'width:190px']],
			'partitaIva'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Partita Iva...', 'maxlength'=>11, 'style'=>'width:190px']],
			'codiceFiscale'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Fiscale...', 'maxlength'=>16, 'style'=>'width:190px']],
			]
		],
		[
		'columns'=>3,
		'attributes' => [
			'telefonoCellulare'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter  ...', 'maxlength'=>11, 'style'=>'width:190px']],
			'telefonoFisso'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter  ...', 'maxlength'=>16, 'style'=>'width:190px']],
			'mail'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter  ...', 'maxlength'=>50, 'style'=>'width:290px']],
			]
		],

		[
		'columns'=>1,
		'attributes' => [
			'idCommercialista'=>['type'=> Form::INPUT_TEXT, 'options'=>[ 'readonly'=>$onlyadmin, 'placeholder'=>'Enter  ...', 'maxlength'=>11, 'style'=>'width:190px']],
			]
		],




		[
		'contentBefore'=>'<legend class="text-info"><small>Dati personali</small></legend>',
		'columns'=>3,
		'attributes' => [

			'nome'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Nome...', 'maxlength'=>20, 'style'=>'width:190px']],
			'cognome'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cognome...', 'maxlength'=>30, 'style'=>'width:190px']],
		//	'dataNascita'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\DatePicker',  ],


//			'note'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Note...','rows'=> 6], 'columnOptions'=>['colspan'=>2]],
		],
		],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
