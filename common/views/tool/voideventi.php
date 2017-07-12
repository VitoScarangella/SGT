<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\tipodoc */
if (!isset($msg)) $msg="";
$session = Yii::$app->session;
$this->title = 'Update Evento: ' . ' ' . $session['idEvento'];
$this->params['breadcrumbs'][] = ['label' => 'Eventi', 'url' => ['gsevento/index']];
$this->params['breadcrumbs'][] = ['label' => $session['eventotitolo'], 'url' => ['gsevento/update', 'id' => $session['idEvento']]];
$this->params['breadcrumbs'][] = 'Documentale';
?>
<div class="tipodoc-view">
 
<h2>Work in progress...</h2>
    
</div>
