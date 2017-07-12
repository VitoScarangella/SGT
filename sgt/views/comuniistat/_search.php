<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\ComuniistatSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="comuniistat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CodiceRegione') ?>

    <?= $form->field($model, 'CodiceCittaMetropolitana') ?>

    <?= $form->field($model, 'codiceProvincia') ?>

    <?= $form->field($model, 'ProgressivoComune') ?>

    <?= $form->field($model, 'CodiceComune') ?>

    <?php // echo $form->field($model, 'denominazioneItaliano') ?>

    <?php // echo $form->field($model, 'DenominazioneTedesco') ?>

    <?php // echo $form->field($model, 'CodiceRipartizioneGeografica') ?>

    <?php // echo $form->field($model, 'RipartizioneGeografica') ?>

    <?php // echo $form->field($model, 'Regione') ?>

    <?php // echo $form->field($model, 'CittaMetropolitana') ?>

    <?php // echo $form->field($model, 'Provincia') ?>

    <?php // echo $form->field($model, 'FlagCapoluogo') ?>

    <?php // echo $form->field($model, 'SiglaAutomobilistica') ?>

    <?php // echo $form->field($model, 'CodiceComuneNumerico') ?>

    <?php // echo $form->field($model, 'CodiceComuneNumerico_2006_2009') ?>

    <?php // echo $form->field($model, 'CodiceComunenumerico_1995_2005') ?>

    <?php // echo $form->field($model, 'CodiceCatastale') ?>

    <?php // echo $form->field($model, 'Popolazione_2011') ?>

    <?php // echo $form->field($model, 'CodiceNUTS1_2010') ?>

    <?php // echo $form->field($model, 'CodiceNUTS2_2010') ?>

    <?php // echo $form->field($model, 'CodiceNUTS3_2010') ?>

    <?php // echo $form->field($model, 'CodiceNUTS1_2006') ?>

    <?php // echo $form->field($model, 'CodiceNUTS2_2006') ?>

    <?php // echo $form->field($model, 'CodiceNUTS3_2006') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
