<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\SgtSocietaSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sgt-societa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ente') ?>

    <?= $form->field($model, 'societa') ?>

    <?= $form->field($model, 'numeroIscrizioneEnte') ?>

    <?= $form->field($model, 'dataIscrizioneEnte') ?>

    <?php // echo $form->field($model, 'codiceFiscale') ?>

    <?php // echo $form->field($model, 'regione') ?>

    <?php // echo $form->field($model, 'affiliazione') ?>

    <?php // echo $form->field($model, 'codiceAffiliazione') ?>

    <?php // echo $form->field($model, 'tipoSocieta') ?>

    <?php // echo $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'comune') ?>

    <?php // echo $form->field($model, 'provincia') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
