<style type="text/css">
    body{
        background:none transparent;
    }
    .sgt-societa-form{
        
        margin: 10px;
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
 * @var 
 * @var yii\widgets\ActiveForm $form
 */
 
//EFX errorSummary provvisorio per sviluppo
?>


<div class="sgt-societa-form">
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 
    
    echo $form->errorSummary($model); 
    
    echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns'=>false,
        'rows'=> [

 		[
		'columns'=>2,
		'attributes' => [
            'societa'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Ricerca il tuo sport', 'maxlength'=>50]],
            
			]
		],
 		
        ] //rows
        
        

    ]);
 
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'CERCA') : Yii::t('app', 'Modifica'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);

    echo $model->isNewRecord ? "" : "&nbsp;&nbsp;" .  Html::button('Cancella',
        [ 'class' => 'btn btn-primary',
          'onclick' => '
          if (confirm("'.\Yii::t('yii', 'Are you sure to delete this item?').'"))
          location.href="'
            . Yii::$app->urlManager->createUrl('sgt-societa/delete')
            .'&id='.$model->id.'";',
        ]);
        
    //echo $form->checkBox($model,'status',  array('checked'=>'checked'));

    ActiveForm::end(); ?>

</div>