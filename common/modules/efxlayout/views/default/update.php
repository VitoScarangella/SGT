<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxLayout $model
 */

$this->title = 'Update';
 
$this->params['breadcrumbs'][] = ['label' => 'Efx Layout ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-layout-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
