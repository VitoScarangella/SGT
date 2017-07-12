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
 * @var common\models\ToolComboSearch $searchModel
 */

$this->title = 'Tool Combo';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="tool-combo/report-excel";
}
</script>
<div class="tool-combo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Tool Combo', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            Tool::buildEditableColumn('key_id', 'editinline', false, '30%'),
            Tool::buildEditableColumn('field_id', 'editinline', false, '30%'),
            Tool::buildEditableColumnTextArea('field_descr', 'editinline', false, '30%'),
            Tool::buildEditableColumnTextArea('field_table', 'editinline', false, '30%'),
            Tool::buildEditableColumn('type', 'editinline', false, '30%'),
            Tool::buildEditableColumn('note', 'editinline', false, '30%'),
			[
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update}{delete}',
				'buttons' => require_once(__DIR__ ."/../actionbuttons.php"),

			],

        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,
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
    ]); Pjax::end(); ?>

</div>
