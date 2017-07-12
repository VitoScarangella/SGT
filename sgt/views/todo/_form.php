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
 * @var common\models\Todo $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="todo-form">
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
            'note'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Note...','rows'=> 6]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'note2'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Note2...','rows'=> 6]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'stato'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('(select "0" id, "APERTO" codice union select "1" id, "CHIUSO" codice  union select "2" id, "SOSPESO" codice) combo_yn','id','codice'),
                 'size' => Select2::SMALL,
              ]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'priorita'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                 'data'=>Tool::dropdown('(select "0" id, "BASSA" codice union select "1" id, "MEDIA" codice  union select "2" id, "ALTA" codice union select "3" id, "BLOCCANTE" codice) combo_yn','id','codice'),
                 'size' => Select2::SMALL,
              ]],

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
            . Yii::$app->urlManager->createUrl(['todo/delete','id'=>$model->id])
            .'";',
        ]);

    ActiveForm::end(); ?>

</div>
