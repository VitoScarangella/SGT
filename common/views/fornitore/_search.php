<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\FornitoreSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="fornitore-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ragioneSociale') ?>

    <?= $form->field($model, 'piva') ?>

    <?= $form->field($model, 'cf') ?>

    <?= $form->field($model, 'codCountry') ?>

    <?php // echo $form->field($model, 'indirizzo') ?>

    <?php // echo $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'codComune') ?>

    <?php // echo $form->field($model, 'codProvincia') ?>

    <?php // echo $form->field($model, 'banca') ?>

    <?php // echo $form->field($model, 'indirizzoBanca') ?>

    <?php // echo $form->field($model, 'iban') ?>

    <?php // echo $form->field($model, 'mail') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'codPA') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
