<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Comuniistat $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="comuniistat-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'CodiceRegione'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Regione...']], 

'CodiceCittaMetropolitana'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Citta Metropolitana...', 'maxlength'=>12]], 

'codiceProvincia'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Provincia...']], 

'ProgressivoComune'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Progressivo Comune...']], 

'CodiceComune'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Comune...', 'maxlength'=>12]], 

'denominazioneItaliano'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Denominazione Italiano...', 'maxlength'=>80]], 

'CodiceRipartizioneGeografica'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Ripartizione Geografica...']], 

'RipartizioneGeografica'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ripartizione Geografica...', 'maxlength'=>80]], 

'Regione'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Regione...', 'maxlength'=>80]], 

'CittaMetropolitana'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Citta Metropolitana...', 'maxlength'=>80]], 

'Provincia'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Provincia...', 'maxlength'=>80]], 

'FlagCapoluogo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Flag Capoluogo...']], 

'SiglaAutomobilistica'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sigla Automobilistica...', 'maxlength'=>80]], 

'CodiceComuneNumerico'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Comune Numerico...']], 

'CodiceComuneNumerico_2006_2009'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Comune Numerico 2006 2009...']], 

'CodiceComunenumerico_1995_2005'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Comunenumerico 1995 2005...']], 

'CodiceCatastale'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Catastale...', 'maxlength'=>80]], 

'Popolazione_2011'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Popolazione 2011...']], 

'CodiceNUTS1_2010'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Nuts1 2010...', 'maxlength'=>80]], 

'CodiceNUTS2_2010'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Nuts2 2010...', 'maxlength'=>80]], 

'CodiceNUTS3_2010'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Nuts3 2010...', 'maxlength'=>80]], 

'CodiceNUTS1_2006'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Nuts1 2006...', 'maxlength'=>80]], 

'CodiceNUTS2_2006'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Nuts2 2006...', 'maxlength'=>80]], 

'CodiceNUTS3_2006'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Codice Nuts3 2006...', 'maxlength'=>80]], 

'DenominazioneTedesco'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Denominazione Tedesco...', 'maxlength'=>80]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
