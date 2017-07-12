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
 * @var common\models\Cliente $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="cliente-form">
<?php /*
	'rows'=>[
		/////////////////////////////////////////
		//semplice
		/////////////////////////////////////////
		[
		//'contentBefore'=>'<legend class="text-info"><small> Titolo...</small></legend>',
		'columns'=>2,
		'attributes' => [
			'EV_TITOLO'=>[
					'label' => 'Cliente',
					'type'=> Form::INPUT_TEXT,
					'options'=>['placeholder'=>'...', 'maxlength'=>80,
					]
				],
			'EV_DESCRIZIONE'=>['type'=> Form::INPUT_TEXT,
					'options'=>['placeholder'=>'...', 'maxlength'=>80,
					]
				],
			]
		],

		/////////////////////////////////////////
		//campi nascosti
		/////////////////////////////////////////
		[
		'columns'=>2,
		'attributes' => [
			'numeroDocumento'=>['type'=> Form::INPUT_TEXT,
					'options'=>['placeholder'=>'...', 'maxlength'=>16,
					'style'=>'width:190px;',
					]
				],
			'importoTotale'=>['type'=> Form::INPUT_TEXT,
			'columnOptions'=>['hidden'=>true],
			'hint'=>'', 'label'=>'',
					'options'=>['readonly'=>true, 'placeholder'=>'...', 'maxlength'=>16,
					'style'=>'display:none;height:0px;width:190px;', 'hidden'=>true
					]
				],
			]
		],

		/////////////////////////////////////////
		//combo  singola
		/////////////////////////////////////////
		[
		'columns'=>2,
		'attributes' => [
			'id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'...', 'maxlength'=>11, 'style'=>'width:190px']],
			'idModalitaPagamento'=>[
				'type'=> Form::INPUT_WIDGET,
				'widgetClass'=>'\kartik\widgets\Select2',
				'options'=>['data'=>$idModalitaPagamento ]
				],

			'codLingua'=>[
				'type'=> Form::INPUT_WIDGET,
				'widgetClass'=>'\kartik\widgets\Select2',
				'options'=>['data'=>Tool::dropdown("booking_lingue","codice","lingua"),],
				],
			]

		],


		/////////////////////////////////////////
		//combo  collegate
		/////////////////////////////////////////
		[
		'columns'=>2,
		'attributes' => [
			'codiceProvincia'=>[
				'type'=> Form::INPUT_WIDGET,
				'widgetClass'=>'\kartik\widgets\Select2',
				'options'=>['data'=>$datacomuni, 'id'=>'codiceProvincia']
				],
			'idComune'=>[
				'type'=> Form::INPUT_WIDGET,
				'widgetClass'=>DepDrop::classname(),
				'options'=>['pluginOptions'=>[
						'depends'=>[Html::getInputId($model, 'codiceProvincia')],
						'placeholder'=>'Seleziona il comune',
						'initialize' => true,
						'url'=>Url::to(['/operazione/comune', 'id' => $model->id, 'idComune' => $model->idComune])]
						]
				],
			]
		],
		/////////////////////////////////////////
		NEL CONTROLLER L'ACTION PER POPOLARE LA COMBO
		/////////////////////////////////////////
		    public function actionComune()
    {
	//$model->idComune
	if (!isset($_REQUEST["idComune"]))
		$idComune = "";
	else
		$idComune = $_REQUEST["idComune"];

    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $prov = $parents[0];
            $out = Comuniistat::dropdownComuniDedrop($prov); //self::getSubCatList($cat_id);
            echo Json::encode(['output'=>$out, 'selected'=>$idComune]);
            return;
        }
    }
	//$out = Comuniistat::dropdownComuniDedrop("");
    echo Json::encode(['output'=>[['id'=>'aa', 'name'=>'vv']], 'selected'=>'']);
	}
		/////////////////////////////////////////
		//data
		/////////////////////////////////////////
			'dataOperazione'=>['type'=> Form::INPUT_WIDGET,
				'widgetClass'=>'kartik\datecontrol\DateControl',
				'options'=>[ 'pluginOptions'=>['autoclose' => true], ],
				'size'=>'md',

				],


    ]//rows

*/
?>
<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo FormGrid::widget([
    'model' => $model,
    'form' => $form,
    'autoGenerateColumns'=>false,
    'rows'=> [
      [
      'columns'=>2,
      'attributes' => [
              'ragioneSociale'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ragione Sociale...', 'maxlength'=>200]],

        ]
      ],
      [
      'columns'=>2,
      'attributes' => [
              'riferimento'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ragione Sociale...', 'maxlength'=>200]],

        ]
      ],
[
'columns'=>2,
'attributes' => [
        'piva'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Piva...', 'maxlength'=>16]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'cf'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cf...', 'maxlength'=>16]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'mail'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mail...', 'maxlength'=>100]],

  ]
],
[
'contentBefore'=>'<legend class="text-info"><small>Indirizzo Sede Legale</small></legend>',
'columns'=>2,
'attributes' => [
        'codCountry'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
             'data'=>Tool::dropdown('country','iso3','istat_name') //Tool::dropdownYN() ['0'=>'modificare...','1'=>'modificare...',]
        ]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'indirizzo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Indirizzo...', 'maxlength'=>200]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'cap'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cap...', 'maxlength'=>5]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'codProvincia'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
             'data'=>Tool::dropdown('comuniistat','codiceProvincia','concat(provincia," ",cittaMetropolitana," ",siglaAutomobilistica)')
        ]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'codComune'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
             'data'=>Tool::dropdown('comuniistat','codiceComune','denominazioneItaliano') //Tool::dropdownYN() ['0'=>'modificare...','1'=>'modificare...',]
        ]],

  ]
],
[
'contentBefore'=>'<legend class="text-info"><small>Dati della banca</small></legend>',
'columns'=>2,
'attributes' => [
        'banca'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Banca...', 'maxlength'=>100]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'indirizzoBanca'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Indirizzo Banca...', 'maxlength'=>200]],

  ]
],
[
'columns'=>2,
'attributes' => [
        'iban'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Iban...', 'maxlength'=>40]],

  ]
],
    ] //rows

]);

echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end(); ?>

</div>
