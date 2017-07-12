<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\UserdetailsSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="userdetails-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idLingua') ?>

    <?= $form->field($model, 'partitaIva') ?>

    <?= $form->field($model, 'codiceFiscale') ?>

    <?= $form->field($model, 'codiceProvincia') ?>

    <?php // echo $form->field($model, 'idComune') ?>

    <?php // echo $form->field($model, 'idProfilo') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'telefonoCellulare') ?>

    <?php // echo $form->field($model, 'telefonoFisso') ?>

    <?php // echo $form->field($model, 'mail') ?>

    <?php // echo $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'cognome') ?>

    <?php // echo $form->field($model, 'dataNascita') ?>

    <?php // echo $form->field($model, 'idCommercialista') ?>

    <?php // echo $form->field($model, 'lastUpdate') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'codiceProvinciaDefault') ?>

    <?php // echo $form->field($model, 'idComuneDefault') ?>

    <?php // echo $form->field($model, 'periodicita') ?>

    <?php // echo $form->field($model, 'indirizzo') ?>

    <?php // echo $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'idModalitaPagamento') ?>

    <?php // echo $form->field($model, 'regime') ?>

    <?php // echo $form->field($model, 'idIvaVendite') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
