<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Tool;
use kartik\editable\Editable;
use webvimark\modules\UserManagement\components\GhostHtml;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\EfxLayoutSearch $searchModel
 */

$this->title = 'Efx Layout';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="efx-layout/report-excel";
}
</script>
<div class="efx-layout-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Efx Layout', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php
          //Pjax::begin();
          echo GridView::widget([
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            Tool::buildColumnCombo('idLingua', Tool::dropdown('languages','id','title'), '120px'),

            Tool::buildEditableColumnCombo('idTipodoc', 'editinline', Tool::dropdown('Tipodoc','id','descrizione'), false, '30%', '..'),

            Tool::buildEditableColumnCombo('idSezione', 'editinline', Tool::dropdown('sezione','id','descrizione'), false, '30%', '..'),

            Tool::buildEditableColumn('titolo', 'editinline', false, '120px'),

            Tool::buildEditableColumn('sottotitolo', 'editinline', false, '120px'),


			[
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update}{delete}',
				'buttons' => require_once(__DIR__ ."/../actionbuttons.php"),

			],

        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'primary',

            'before'=>GhostHtml::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app','Aggiungi'), ['create'], ['class' => 'btn btn-success'])
            . " " . Html::a('<i class="fa fa-file-excel-o fa-1x"></i>', null, [
                'title'=>Yii::t('app', 'Export Excel'),
                'class' => 'btn btn-success',
                'href' => 'javascript:void(0);',
                'onclick' => 'reportExcel()'])
            . "  "
            ,
            'after'=>'',
            'showFooter'=>false
        ],
    ]);
    //Pjax::end();
    ?>

</div>
