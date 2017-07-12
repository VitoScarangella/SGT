<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SgtDisciplina $model
 */

$this->title = 'Update';

$this->params['breadcrumbs'][] = ['label' => 'Disciplina ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sgt-disciplina-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
