<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\EfxLayoutSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="efx-layout-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idLingua') ?>

    <?= $form->field($model, 'idTipo') ?>

    <?= $form->field($model, 'idSezione') ?>

    <?= $form->field($model, 'titolo') ?>

    <?php // echo $form->field($model, 'sottotitolo') ?>

    <?php // echo $form->field($model, 'descrizione') ?>

    <?php // echo $form->field($model, 'visibile') ?>

    <?php // echo $form->field($model, 'dataCreazione') ?>

    <?php // echo $form->field($model, 'dataModifica') ?>

    <?php // echo $form->field($model, 'dataArticolo') ?>

    <?php // echo $form->field($model, 'ordinamento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
