<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxParams $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Efx Params ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-params-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
