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
use yii\web\JsExpression;
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
		'columns'=>1,
		'attributes' => [
            'societa'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Società...', 'maxlength'=>150]],
			]
		],

 		[
		'columns'=>5,
		'attributes' => [
            'indirizzo'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Corso Manzoni, 26', 'maxlength'=>50]],
            'civico'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Corso Manzoni, 26', 'maxlength'=>50]],
            'cap'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
            'comune'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
            'provincia'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
			]
		],

		[
		'columns'=>3,
		'attributes' => [
            'telefono1'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Inserisci numero di telefono', 'maxlength'=>50]],
            'telefono2'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Inserisci altro numero di telefono', 'maxlength'=>50]],
            'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Inserisci altro numero di telefono', 'maxlength'=>50]],

			]
		],

		[
		'columns'=>2,
		'attributes' => [
      'referente' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],
      'url' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],
      'fb' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],

			]
		],

    [
		'columns'=>2,
		'attributes' => [
      'ragioneSociale' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],
      'piva' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],
      'cf' => ['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','type' =>'url','placeholder'=>'Inserisci sito web', 'maxlength'=>50]],

			]
		],
    [
		'columns'=>5,
		'attributes' => [
            'legale_indirizzo'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Corso Manzoni, 26', 'maxlength'=>50]],
            'legale_civico'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Corso Manzoni, 26', 'maxlength'=>50]],
            'legale_cap'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
            'legale_comune'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
            'legale_provincia'=>['type'=> Form::INPUT_TEXT, 'options'=>['class'=>'textField','placeholder'=>'Es. Roma', 'maxlength'=>50]],
			]
		],
    [
		'columns'=>2,
		'attributes' => [
            'X'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter X...', 'maxlength'=>255]],
            'Y'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Y...', 'maxlength'=>255]],
			]
		],

		] //rows

    ]);
    ?>
    <h3>Geocoding </h3>
    <input class="form-control" autocomplete="off" type="text" id="us2-address" style="width: 400px"/>
    <?
        echo \pigolab\locationpicker\LocationPickerWidget::widget([
           'key' => 'AIzaSyDogYLKKyCK78zpgOk8nUUh3SBrFqa_WCc', // itsupport@orionskyglobal.com
           'options' => [
                'style' => 'width: 500px; height: 200px', // map canvas width and height
            ] ,
            'clientOptions' => [
                'location' => [
                    'latitude'  => $model->X ,
                    'longitude' => $model->Y,
                ],
                'radius'    => 10,
                    'onchanged'=>new JsExpression("
                    function (currentLocation, radius, isMarkerDropped) {
                            var addressComponents = $(this).locationpicker('map').location.addressComponents;
                            $('#sgtsocieta-cap').val(addressComponents.postalCode);
                            $('#sgtsocieta-indirizzo').val(addressComponents.streetName);
                            $('#sgtsocieta-provincia').val(addressComponents.stateOrProvince);
                            $('#sgtsocieta-civico').val(addressComponents.streetNumber);
                            $('#sgtsocieta-comune').val(addressComponents.city);

                            /*console.log($(this).locationpicker('map').location);
                            console.log(addressComponents);
                            console.log(addressComponents.addressLine2);
                            console.log(addressComponents.city);
                            console.log(addressComponents.stateOrProvince);
                            console.log(addressComponents.postalCode);
                            console.log(addressComponents.country);
                            */

                        }"),
                'addressFormat' => 'street_address', //https://developers.google.com/maps/documentation/geocoding/intro?hl=en#Types
                'enableAutocomplete'=>true,
                'inputBinding' => [
                    'latitudeInput'     => new JsExpression("$('#sgtsocieta-x')"),
                    'longitudeInput'    => new JsExpression("$('#sgtsocieta-y')"),
                    'locationNameInput' => new JsExpression("$('#us2-address')")
                ]
            ]
        ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salva') : Yii::t('app', 'Salva'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);

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
