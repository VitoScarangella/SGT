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
 * @var backend\models\SgtRicerca $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sgt-ricerca-form">
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
            'tipo'=>['type'=> Form::INPUT_TEXT, 'options'=>['type'=>'number', 'placeholder'=>'Enter Tipo...', 'maxlength'=>11]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'lemma'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Lemma...', 'maxlength'=>50]],

			]
		],
 		[
		'columns'=>2,
		'attributes' => [
            'sinonimo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sinonimo...', 'maxlength'=>50]],

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
            . Yii::$app->urlManager->createUrl('sgt-ricerca/delete')
            .'&id='.$model->id.'";',
        ]);

    ActiveForm::end(); ?>

</div>
