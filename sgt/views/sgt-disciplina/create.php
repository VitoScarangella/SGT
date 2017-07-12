<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SgtDisciplina $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Disciplina ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sgt-disciplina-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
