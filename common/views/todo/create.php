<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Todo $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Todo ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="todo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
