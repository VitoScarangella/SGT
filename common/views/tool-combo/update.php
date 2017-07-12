<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ToolCombo $model
 */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Tool Combo ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-combo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
