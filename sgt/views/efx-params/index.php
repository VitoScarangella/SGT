<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Tool;
use kartik\editable\Editable;
use webvimark\modules\UserManagement\components\GhostHtml;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\EfxParamsSearch $searchModel
 */

$this->title = 'Efx Params';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="efx-params/report-excel";
}
</script>
<div class="efx-params-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Efx Params', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php
          //Pjax::begin();
          echo GridView::widget([
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'id'=>'efx-params_w0',
        'pjaxSettings' =>[
            'neverTimeout'=>true,
            'options'=>[
                    'id'=>'efx-params_w0pjax',
                    'enablePushState' => false,
                ]
            ],
        'filterUrl' => Url::to(["efx-params/index"]) ,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'options'=>['width'=>'20px']],

            Tool::XbuildEditableColumn('param'),

            Tool::XbuildEditableColumn('label'),


    			[
    				'class' => 'kartik\grid\ActionColumn',
            'contentOptions'=>['class'=>'kv-align-right'],
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
    ]);
    //Pjax::end();
    ?>

</div>
