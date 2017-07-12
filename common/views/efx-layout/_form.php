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

/**
 * @var yii\web\View $this
 * @var common\models\EfxLayout $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="efx-layout-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [

 		[
		'columns'=>2,
		'attributes' => [
            'id'=>['type'=> Form::INPUT_TEXT, 'options'=>['type'=>'number', 'placeholder'=>'Enter ID...', 'maxlength'=>11]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'idLingua'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('languages','id','title')
              ]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'idTipo'=>['type'=> Form::INPUT_TEXT, 'options'=>['type'=>'number', 'placeholder'=>'Enter Tipo...', 'maxlength'=>11]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'idSezione'=>['type'=> Form::INPUT_TEXT, 'options'=>['type'=>'number', 'placeholder'=>'Enter Sezione...', 'maxlength'=>11]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'titolo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Titolo...', 'maxlength'=>150]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'sottotitolo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sottotitolo...', 'maxlength'=>250]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'descrizione'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Descrizione...','rows'=> 6]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'visibile'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('combo_yn','id','codice')
              ]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'dataCreazione'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'dataModifica'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'dataArticolo'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATE]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'ordinamento'=>['type'=> Form::INPUT_TEXT, 'options'=>['type'=>'number', 'placeholder'=>'Enter Ordinamento...', 'maxlength'=>11]],

			]
		],
        ] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

  </div>
  <div>
    <?
    echo $model->descrizione;
    ?>
  </div>
