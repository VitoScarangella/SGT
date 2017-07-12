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
 * @var backend\models\SgtDisciplina $model
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
		'columns'=>2,
		'attributes' => [
            'societa'=>['label'=>'','type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Società...', 'maxlength'=>150 ]],
            'email'=>['label'=>'','type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type'=>'email', 'placeholder'=>'Inserisci una mail che usi spesso sulla quale desideri ricevere le nostre comunicazioni', 'maxlength'=>30]],
			]
		],

 		[
		'columns'=>2,
		'attributes' => [
		    //il campo indirizzo deve usare l'autocomplete di google
            'indirizzo'=>['label'=>'','type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Indirizzo dove pratichi principalmente i tuoi sport', 'maxlength'=>50]],
            //il secondo campo su questa riga è "discipline sportive praticate"
            'telefono1'=>['label'=>'','type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Discipline sportive praticate (da implementare)', 'maxlength'=>50]],
            
			]
		],



		] //rows

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salva e prosegui') : Yii::t('app', 'Salva e prosegui'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);

    $session = Yii::$app->session;
    $societa = isset($session["societa"])?$session["societa"]:"";
    $comune  = isset($session["comune"])?$session["comune"]:"";
    $page    = isset($session["page"])?$session["page"]:"";

?>
    <a class="btn btn-success" href="<?=Yii::$app->request->baseUrl?>/sgt-societa/ricerca?societa=<?=$societa?>&comune=<?=$comune?>&page=<?=$page?>"><i class="fa fa-search"></i>Torna a ricerca</a>
<?

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
