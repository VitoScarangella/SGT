<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Comuniistat $model
 */

$this->title = $model->CodiceComune;
$this->params['breadcrumbs'][] = ['label' => 'Comuniistats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comuniistat-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


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
            'CodiceRegione',
            'CodiceCittaMetropolitana',
            'codiceProvincia',
            'ProgressivoComune',
            'CodiceComune',
            'denominazioneItaliano',
            'DenominazioneTedesco',
            'CodiceRipartizioneGeografica',
            'RipartizioneGeografica',
            'Regione',
            'CittaMetropolitana',
            'Provincia',
            'FlagCapoluogo',
            'SiglaAutomobilistica',
            'CodiceComuneNumerico',
            'CodiceComuneNumerico_2006_2009',
            'CodiceComunenumerico_1995_2005',
            'CodiceCatastale',
            'Popolazione_2011',
            'CodiceNUTS1_2010',
            'CodiceNUTS2_2010',
            'CodiceNUTS3_2010',
            'CodiceNUTS1_2006',
            'CodiceNUTS2_2006',
            'CodiceNUTS3_2006',
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->CodiceComune],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
