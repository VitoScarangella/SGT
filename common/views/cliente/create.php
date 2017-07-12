<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Cliente $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Cliente ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
