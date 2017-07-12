<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
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
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomeSocieta') ?>

    <div class="form-group">
        <?= Html::submitButton('INSERISCI', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
