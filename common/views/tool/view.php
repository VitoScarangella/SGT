<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\tipodoc */
if (!isset($msg)) $msg="";
?>
<style>
#gproxy
    {
        border:1px solid gray;
        width:980px;
        height:900px;
        
        
    }
</style>
<div class="tipodoc-view">

    
<iframe id="gproxy" src="<?=$url?>">
</iframe>

</div>
