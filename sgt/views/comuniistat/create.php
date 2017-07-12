<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Comuniistat $model
 */

$this->title = 'Create Comuniistat';
$this->params['breadcrumbs'][] = ['label' => 'Comuniistats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comuniistat-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
