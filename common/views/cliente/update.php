<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Cliente $model
 */

$this->title = 'Update';
 
$this->params['breadcrumbs'][] = ['label' => 'Cliente ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
