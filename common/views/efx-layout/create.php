<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxLayout $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Efx Layout ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-layout-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
