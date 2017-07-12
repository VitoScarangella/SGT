<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SgtRicerca $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Sgt Ricerca ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sgt-ricerca-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
