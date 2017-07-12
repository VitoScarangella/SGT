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
 * @var common\models\ClienteSearch $searchModel
 */

$this->title = 'Cliente';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="cliente/report-excel";
}
</script>
<div class="cliente-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Cliente', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ragioneSociale',
            'riferimento',
            'piva',
            'cf',
            [
              'attribute'=>'codCountry',
              'vAlign'=>'middle',
              'value'=>function ($model, $key, $index, $widget) {
                  return Tool::dropdownValue('country','iso3','istat_name', $model->codCountry);
              },
              'filterType'=>GridView::FILTER_SELECT2,
              'filter'=>Tool::dropdown('country','iso3','istat_name'),
              'filterWidgetOptions'=>[
                  'pluginOptions'=>['allowClear'=>true],
              ],
              'filterInputOptions'=>['placeholder'=>'...'],
              'format'=>'raw',
              //'width' => '180px',
            ],

            [
              'attribute'=>'codComune',
              'vAlign'=>'middle',
              'value'=>function ($model, $key, $index, $widget) {
                  return Tool::dropdownValue('comuniistat','codiceComune','denominazioneItaliano', $model->codComune);
              },
              'filterType'=>GridView::FILTER_SELECT2,
              'filter'=>Tool::dropdown('comuniistat','codiceComune','denominazioneItaliano'),
              'filterWidgetOptions'=>[
                  'pluginOptions'=>['allowClear'=>true],
              ],
              'filterInputOptions'=>['placeholder'=>'...'],
              'format'=>'raw',
              //'width' => '180px',
            ],

            [
              'attribute'=>'codProvincia',
              'vAlign'=>'middle',
              'value'=>function ($model, $key, $index, $widget) {
                  return Tool::dropdownValue('comuniistat','codiceProvincia','concat(provincia," ",cittaMetropolitana," ",siglaAutomobilistica)', $model->codProvincia);
              },
              'filterType'=>GridView::FILTER_SELECT2,
              'filter'=>Tool::dropdown('comuniistat','codiceProvincia','concat(provincia," ",cittaMetropolitana," ",siglaAutomobilistica)'),
              'filterWidgetOptions'=>[
                  'pluginOptions'=>['allowClear'=>true],
              ],
              'filterInputOptions'=>['placeholder'=>'...'],
              'format'=>'raw',
              //'width' => '180px',
            ],

/*
            'iban',
            Tool::buildEditableColumn('iban', 'editinline', false, '30%'),

*/
/*
            'mail',
            Tool::buildEditableColumn('mail', 'editinline', false, '30%'),

*/
/*

            [
              'attribute'=>'deleted',
              'vAlign'=>'middle',
              'value'=>function ($model, $key, $index, $widget) {
                  return Tool::dropdownValue('combo_yn','id','codice', $model->deleted);
              },
              'filterType'=>GridView::FILTER_SELECT2,
              'filter'=>Tool::dropdown('combo_yn','id','codice'),
              'filterWidgetOptions'=>[
                  'pluginOptions'=>['allowClear'=>true],
              ],
              'filterInputOptions'=>['placeholder'=>'...'],
              'format'=>'raw',
              //'width' => '180px',
            ],
            Tool::buildEditableColumnCombo('deleted', 'editinline', Tool::dropdown('combo_yn','id','codice'), false, '30%', '..'),

*/
/*
            'codPA',
            Tool::buildEditableColumn('codPA', 'editinline', false, '30%'),

*/

			[
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update}',
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
	           'before'=>GhostHtml::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app','Aggiungi'), ['create'], ['class' => 'btn btn-success'])            . " " . Html::a('<i class="fa fa-file-excel-o fa-1x"></i>', null, [
                'title'=>Yii::t('app', 'Export Excel'),
                'class' => 'btn btn-success',
                'href' => 'javascript:void(0);',
                'onclick' => 'reportExcel()'])
            . "  "
            ,
            'after'=>'',
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
