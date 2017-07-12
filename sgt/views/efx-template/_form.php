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
 * @var common\models\EfxTemplate $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="efx-template-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo FormGrid::widget([

        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [

 		[
		'columns'=>1,
		'attributes' => [
            'idTipotemplate'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('efx_tipo_template','id','descrizione'),
                 'size' => Select2::SMALL,
            ]],

			]
		],
 		[
		'columns'=>1,
		'attributes' => [
            'descrizione'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Descrizione...', 'maxlength'=>50]],

			]
		],
 		[
		'columns'=>1,
		'attributes' => [
            'template'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Template...','rows'=> 22]],

			]
		],
        ] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
