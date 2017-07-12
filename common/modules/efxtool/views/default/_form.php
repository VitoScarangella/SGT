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
use dosamigos\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var common\models\EfxTool $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="efx-tool-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [

    [
   'columns'=>2,
   'attributes' => [
       'idTipodoc'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
            'data'=>Tool::dropdown('Tipodoc','id','descrizione')
         ]],

       ]
   ],
   [
  'columns'=>2,
  'attributes' => [
      'idSezione'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
           'data'=>Tool::dropdown('sezione','id','descrizione')
        ]],

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
		'columns'=>1,
		'attributes' => [
			'descrizione'=>[
				'type'=> Form::INPUT_WIDGET,
				'widgetClass'=>CKEditor::className(),
				'options'=>[],
                'columnOptions'=>['colspan'=>2, 'rowspan'=>45]
				],
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
            'visibile'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('(select "0" id, "NO" codice union select "1" id, "SI" codice ) combo_yn','id','codice', '',false)
              ]],

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
