<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SgtSocieta $model
 */

$this->title = 'Modifica Società';

$this->params['breadcrumbs'][] = ['label' => 'Societa ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sgt-societa-update">

    <?= $this->render('_updateaftertake', [
        'model' => $model,
    ]) ?>

</div>
