<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Fornitore $model
 */

$this->title = 'View';
 
$this->params['breadcrumbs'][] = ['label' => 'Fornitore ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornitore-view">
 

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'ragioneSociale',
            'piva',
            'cf',
            'codCountry',
            'indirizzo',
            'cap',
            'codComune',
            'codProvincia',
            'banca',
            'indirizzoBanca',
            'iban',
            'mail',
            'deleted',
            'codPA',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
