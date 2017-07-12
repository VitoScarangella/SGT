<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EfxTool $model
 */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Efx Tool ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="efx-tool-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
