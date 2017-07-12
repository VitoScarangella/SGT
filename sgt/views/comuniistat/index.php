<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\ComuniistatSearch $searchModel
 */

$this->title = 'Comuniistats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comuniistat-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Comuniistat', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CodiceRegione',
            'CodiceCittaMetropolitana',
            'codiceProvincia',
            'ProgressivoComune',
            'CodiceComune',
//            'denominazioneItaliano', 
//            'DenominazioneTedesco', 
//            'CodiceRipartizioneGeografica', 
//            'RipartizioneGeografica', 
//            'Regione', 
//            'CittaMetropolitana', 
//            'Provincia', 
//            'FlagCapoluogo', 
//            'SiglaAutomobilistica', 
//            'CodiceComuneNumerico', 
//            'CodiceComuneNumerico_2006_2009', 
//            'CodiceComunenumerico_1995_2005', 
//            'CodiceCatastale', 
//            'Popolazione_2011', 
//            'CodiceNUTS1_2010', 
//            'CodiceNUTS2_2010', 
//            'CodiceNUTS3_2010', 
//            'CodiceNUTS1_2006', 
//            'CodiceNUTS2_2006', 
//            'CodiceNUTS3_2006', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['comuniistat/view','id' => $model->CodiceComune,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
