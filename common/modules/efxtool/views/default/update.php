<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxTool $model
 */

$this->title = 'Update';
 
$this->params['breadcrumbs'][] = ['label' => 'Efx Tool ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-tool-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
