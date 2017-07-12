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
 * @var backend\models\SgtRicercaSearch $searchModel
 */

$this->title = 'Configura Ricerca';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="/sgt-ricerca/report-excel";
}
</script>
<div class="sgt-ricerca-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Sgt Ricerca', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php
          //Pjax::begin();
          echo GridView::widget([
        'pjax'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'id'=>'sgt-ricerca_w0',
        'pjaxSettings' =>[
            'neverTimeout'=>true,
            'options'=>[
                    'id'=>'sgt-ricerca_w0pjax',
                    'enablePushState' => false,
                ]
            ],
        'toolbar' => [],
        'filterUrl' => Url::to(["sgt-ricerca/index"]) ,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'options'=>['width'=>'20px']],

            Tool::XbuildEditableColumnCombo('tipo', ['data'=>["0"=>"Escludi", "1"=>"Sinonimo"], 'width'=>'120px']),

            Tool::XbuildEditableColumn('lemma', ['width'=>'120px']),
            Tool::XbuildEditableColumn('sinonimo', ['width'=>'120px']),


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

            'before'=>/*GhostHtml::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app','Aggiungi'), ['create'], ['class' => 'btn btn-success'])*/
            " " . GhostHtml::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app','Aggiungi'), ['create-div'], ['class' => 'btn btn-success'])
            /*. " " . Html::a('<i class="fa fa-file-excel-o fa-1x"></i>&nbsp;', null, [
                'title'=>Yii::t('app', 'Export Excel'),
                'class' => 'btn btn-success',
                'href' => 'javascript:void(0);',
                'onclick' => 'reportExcel()'])
            . "  "*/
            ,
            'after'=>'',
            'showFooter'=>false
        ],
    ]);
    //Pjax::end();

    /*
      PATCH: se al primo caricamento non ci sono righe, ai successivi i campi editabili non vengono visualizzati correttamente
      perche' non viene effettuata l'inizializzazione della classe.
      Questo campo fittizio e nascosto in fondo alla pagina garantisce l'inizializzazione della classe Editable
      */
       $widgetParams = [
           'type'=>'primary',
           'size'=>'md',
           'editableValueOptions'=>['class'=>'text-success']
       ];
       echo \kartik\editable\Editable::widget(
           array_merge($widgetParams, [
               'name' => 'hidden',
               'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
              'containerOptions'=>['style'=>'display:none'],
              'pjaxContainerId'=>'none'
           ])
       );
       /*
       FINE PATCH
       */

    ?>

</div>
