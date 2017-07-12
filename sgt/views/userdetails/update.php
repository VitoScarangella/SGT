<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Userdetails $model
 */

$this->title = 'Update';

//$this->params['breadcrumbs'][] = ['label' => 'Profilo utente', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdetails-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
