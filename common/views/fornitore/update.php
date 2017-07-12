<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Fornitore $model
 */

$this->title = 'Update';
 
$this->params['breadcrumbs'][] = ['label' => 'Fornitore ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornitore-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
