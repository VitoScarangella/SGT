<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxTemplate $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Efx Template ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
