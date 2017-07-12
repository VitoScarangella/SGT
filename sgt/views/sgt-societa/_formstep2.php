<style type="text/css">
    body{
        background: none transparent;
    }
    .sgt-societa-form{
        background: none transparent;
        margin: 50px;
    }
    .textField{
        border-radius: 5px;
    }
    .btn-primary{
        width: 100%;
    }
    
</style>

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
 * @var backend\models\SgtSocieta $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sgt-societa-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [

 		[
		'columns'=>3,
		'attributes' => [
            'indirizzo'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Corso Manzoni, 26', 'maxlength'=>50]],
            'comune'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
            'provincia'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
			]
		],
	
		[
		'columns'=>2,
		'attributes' => [
            'telefono1'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Inserisci numero di telefono', 'maxlength'=>50]],
            'telefono2'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Inserisci altro numero di telefono', 'maxlength'=>50]],
            
			]
		],
		
		[
		'columns'=>2,
		'attributes' => [
            'url' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],
            
			]
		],
		
		
		
		] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'AVANTI') : Yii::t('app', 'AVANTI'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);

    //echo $model->isNewRecord ? "" : "&nbsp;&nbsp;" .  Html::button('Cancella',
       // [ 'class' => 'btn btn-primary',
        //  'onclick' => '
         // if (confirm("'.\Yii::t('yii', 'Are you sure to delete this item?').'"))
         // location.href="'
          //  . Yii::$app->urlManager->createUrl('sgt-societa/delete')
          //  .'&id='.$model->id.'";',
      //  ]);

    ActiveForm::end(); ?>

</div>