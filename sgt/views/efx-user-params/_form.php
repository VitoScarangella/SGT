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
 * @var common\models\EfxUserParams $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="efx-user-params-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo FormGrid::widget([
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
            'idUser'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('user','id','username'),
                 'size' => Select2::SMALL,
              ]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'param'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Param...', 'maxlength'=>255]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'value'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Value...', 'maxlength'=>255]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'valueExt'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Value Ext...','rows'=> 6]],

			]
		],
        ] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

    echo $model->isNewRecord ? "" : "&nbsp;&nbsp;" .  Html::button('Delete',
        [ 'class' => 'btn btn-primary',
          'onclick' => '
          if (confirm("'.\Yii::t('yii', 'Are you sure to delete this item?').'"))
          location.href="'
            . Yii::$app->urlManager->createUrl(['efx-user-params/delete','id'=>$model->id])
            .'";',
        ]);

    ActiveForm::end(); ?>

</div>
