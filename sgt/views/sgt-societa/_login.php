<style type="text/css">
    body{
        background: none transparent;
    }
    .sgt-societa-form{

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

//EFX errorSummary provvisorio per sviluppo
?>

<div class="sgt-societa-form">
  <h1>Bentornato</h1>
  <h2>Per proseguire inserisci la tua password oppure utilizza il link che abbiamo mandato alla tua email.</h2>

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
                  'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type'=>'email', 'placeholder'=>'Es: info@societa.it', 'maxlength'=>30]],
                  'password'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type'=>'password', 'placeholder'=>'Imposta la tua password', 'maxlength'=>30]],
      			]
      		],
        ] //rows
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'AVANTI') : Yii::t('app', 'Modifica'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);


    ActiveForm::end(); ?>

</div>
