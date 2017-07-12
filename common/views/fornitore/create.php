<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Fornitore $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Fornitore ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornitore-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
