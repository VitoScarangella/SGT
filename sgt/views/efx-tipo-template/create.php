<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxTipoTemplate $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Efx Tipo Template ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-tipo-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
