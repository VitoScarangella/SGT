<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\tipodoc */
if (!isset($msg)) $msg="";
echo $msg;

$session = Yii::$app->session;
$this->title = 'Update Evento: ' . ' ' . $session['idEvento'];
$this->params['breadcrumbs'][] = ['label' => 'Eventi', 'url' => ['gsevento/index']];
$this->params['breadcrumbs'][] = ['label' => $session['eventotitolo'], 'url' => ['gsevento/update', 'id' => $session['idEvento']]];
$this->params['breadcrumbs'][] = $titlepage;

?>
<style>
#gproxy
    {
        border:1px solid gray;
        width:1040px;
        height:900px;
        
        
    }
</style>
<div class="tipodoc-view">

    
    
<iframe id="gproxy" src="<?=$url?>">
</iframe>

</div>
