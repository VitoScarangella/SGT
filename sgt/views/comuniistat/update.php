<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Comuniistat $model
 */

$this->title = 'Update Comuniistat: ' . ' ' . $model->CodiceComune;
$this->params['breadcrumbs'][] = ['label' => 'Comuniistats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CodiceComune, 'url' => ['view', 'id' => $model->CodiceComune]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comuniistat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
