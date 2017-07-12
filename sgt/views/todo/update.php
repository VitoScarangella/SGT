<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Todo $model
 */

$this->title = 'Update';
 
$this->params['breadcrumbs'][] = ['label' => 'Todo ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="todo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
