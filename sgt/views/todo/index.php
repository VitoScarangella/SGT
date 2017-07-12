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
 * @var common\models\TodoSearch $searchModel
 */

$this->title = 'Todo';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="todo/report-excel";
}
</script>
<div class="todo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Todo', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php
          //Pjax::begin();
          echo GridView::widget([
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'id'=>'todo_w0',
        'pjaxSettings' =>[
            'neverTimeout'=>true,
            'options'=>[
                    'id'=>'todo_w0pjax',
                    'enablePushState' => false,
                ]
            ],
        'filterUrl' => Url::to(["todo/index"]) ,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'options'=>['width'=>'20px']],

            Tool::XbuildColumn('note'), //text
            Tool::XbuildEditableColumnTextArea('note'),

            Tool::XbuildColumn('note2'), //text
            Tool::XbuildEditableColumnTextArea('note2'),

            Tool::XbuildColumnCombo('stato', ['data'=>Tool::dropdown('(select "0" id, "APERTO" codice union select "1" id, "CHIUSO" codice  union select "2" id, "SOSPESO" codice) combo_yn','id','codice'), 'width'=>'120px']),

            Tool::XbuildEditableColumnCombo('stato', ['data'=>Tool::dropdown('(select "0" id, "APERTO" codice union select "1" id, "CHIUSO" codice  union select "2" id, "SOSPESO" codice) combo_yn','id','codice'), 'width'=>'120px']),

            Tool::XbuildColumnCombo('priorita', ['data'=>Tool::dropdown('(select "0" id, "BASSA" codice union select "1" id, "MEDIA" codice  union select "2" id, "ALTA" codice union select "3" id, "BLOCCANTE" codice) combo_yn','id','codice'), 'width'=>'120px']),

            Tool::XbuildEditableColumnCombo('priorita', ['data'=>Tool::dropdown('(select "0" id, "BASSA" codice union select "1" id, "MEDIA" codice  union select "2" id, "ALTA" codice union select "3" id, "BLOCCANTE" codice) combo_yn','id','codice'), 'width'=>'120px']),


    			[
    				'class' => 'kartik\grid\ActionColumn',
            'contentOptions'=>['class'=>'kv-align-right'],
    				'template' => '{update} {delete}',
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
