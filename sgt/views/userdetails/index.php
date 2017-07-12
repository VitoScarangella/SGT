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
 * @var common\models\UserdetailsSearch $searchModel
 */

$this->title = 'Profilo utente';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reportExcel()
{
    document.location="userdetails/report-excel";
}
</script>
<div class="userdetails-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Userdetails', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            Tool::buildEditableColumn('partitaIva', 'editinline', false, '30%'),
            Tool::buildEditableColumn('codiceFiscale', 'editinline', false, '30%'),
            Tool::buildEditableColumnCombo('codiceProvincia', 'editinline', Tool::dropdown('comuniistat','codiceProvincia','concat(provincia," ",cittaMetropolitana," ",siglaAutomobilistica)'), false, '140px'),
            Tool::buildEditableColumnCombo('idComune', 'editinline', Tool::dropdown('comuniistat','codiceComune','denominazioneItaliano'), false, '140px'),
            Tool::buildEditableColumnCombo('idProfilo', 'editinline', Tool::dropdown('profilo','id','descrizione'), false, '90px'),
            Tool::buildEditableColumn('telefonoCellulare', 'editinline', false, '60px'),
            Tool::buildEditableColumn('telefonoFisso', 'editinline', false, '60px'),
            Tool::buildEditableColumn('mail', 'editinline', false, '140px'),
            Tool::buildEditableColumn('cognome', 'editinline', false, '70px'),
            Tool::buildEditableColumn('nome', 'editinline', false, '70px'),

/*
            'cognome',
            Tool::buildEditableColumn('cognome', 'editinline', false, '30%'),

*/
/*
            ['attribute'=>'dataNascita','format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']],
            Tool::buildEditableColumnDate('dataNascita', 'editinline', true, '40%'),

*/
/*
            'idCommercialista',
            Tool::buildEditableColumn('idCommercialista', 'editinline', false, '30%'),

*/
/*
            ['attribute'=>'lastUpdate','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
*/
/*
            ['attribute'=>'created','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
*/
/*
            'codiceProvinciaDefault',
            Tool::buildEditableColumn('codiceProvinciaDefault', 'editinline', false, '30%'),

*/
/*
            'idComuneDefault',
            Tool::buildEditableColumn('idComuneDefault', 'editinline', false, '30%'),

*/
/*
            'periodicita',//integer
*/
/*
            'indirizzo',
            Tool::buildEditableColumn('indirizzo', 'editinline', false, '30%'),

*/
/*
            'cap',
            Tool::buildEditableColumn('cap', 'editinline', false, '30%'),

*/
/*
            'idModalitaPagamento',//integer
*/
/*
            'regime',//integer
*/
/*
            'idIvaVendite',//integer
*/

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
    ]); Pjax::end(); ?>

</div>
