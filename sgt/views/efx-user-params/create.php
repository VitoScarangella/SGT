<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxUserParams $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Efx User Params ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-user-params-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
