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
 * @var backend\models\SgtSocietaSearch $searchModel
 */

$this->title = 'Societa';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="/sgt-societa/report-excel";
}
</script>
<div class="sgt-societa-index">
    <?php
          //Pjax::begin();
          echo GridView::widget([
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'id'=>'sgt-societa_w0',
        'pjaxSettings' =>[
            'neverTimeout'=>true,
            'options'=>[
                    'id'=>'sgt-societa_w0pjax',
                    'enablePushState' => false,
                ]
            ],
        'toolbar' => [],
        'filterUrl' => Url::to(["sgt-societa/index"]) ,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'options'=>['width'=>'20px']],

            Tool::XbuildColumn('ente'), //string
            //Tool::XbuildEditableColumn('ente'),

            //Tool::XbuildColumn('societa'), //text
            Tool::XbuildEditableColumnTextArea('societa'),

            //Tool::XbuildColumn('numeroIscrizioneEnte'), //integer
            //Tool::XbuildColumnDate('dataIscrizioneEnte'),

            //Tool::XbuildEditableColumnDate('dataIscrizioneEnte'),

            //Tool::XbuildColumn('codiceFiscale'), //string
            Tool::XbuildEditableColumn('codiceFiscale'),

            Tool::XbuildColumn('regione'), //string
            //Tool::XbuildEditableColumn('regione'),

            Tool::XbuildColumn('affiliazione'), //string
            //Tool::XbuildEditableColumn('affiliazione'),

            Tool::XbuildColumn('codiceAffiliazione'), //string
            //Tool::XbuildEditableColumn('codiceAffiliazione'),

            //Tool::XbuildColumn('tipoSocieta'), //string
            Tool::XbuildEditableColumn('tipoSocieta'),

            //Tool::XbuildColumn('cap'), //string
            Tool::XbuildEditableColumn('cap'),

            //Tool::XbuildColumn('comune'), //string
            Tool::XbuildEditableColumn('comune'),

            //Tool::XbuildColumn('provincia'), //string
            Tool::XbuildEditableColumn('provincia'),

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
            //. " " . GhostHtml::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app','Aggiungi'), ['create-div'], ['class' => 'btn btn-success'])
            . " " . Html::a('<i class="fa fa-file-excel-o fa-1x"></i>&nbsp;', null, [
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
