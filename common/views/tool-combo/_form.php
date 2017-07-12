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
 * @var common\models\ToolCombo $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="tool-combo-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo FormGrid::widget([

        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [

    [
		'columns'=>2,
		'attributes' => [
            'key_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Key ID...', 'maxlength'=>50]],

			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'field_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Field ID...', 'maxlength'=>50]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'field_descr'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Field Descr...','rows'=> 6]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'field_table'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Field Table...','rows'=> 6]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Type...', 'maxlength'=>50]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'note'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Note...', 'maxlength'=>50]],

			]
		],
        ] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
