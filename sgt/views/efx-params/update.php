<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxParams $model
 */

$this->title = 'Update';
 
$this->params['breadcrumbs'][] = ['label' => 'Efx Params ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-params-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
