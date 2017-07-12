<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\gii\components\ActiveField;
use yii\gii\CodeFile;

/* @var $this yii\web\View */
/* @var $generator yii\gii\Generator */
/* @var $id string panel ID */
/* @var $form yii\widgets\ActiveForm */
/* @var $results string */
/* @var $hasError boolean */
/* @var $files CodeFile[] */
/* @var $answers array */

$this->title = $generator->getName();
$templates = [];
foreach ($generator->templates as $name => $path) {
    $templates[$name] = "$name ($path)";
}
?>
<script>
var impostab = function(model){
    $("#generator-modelclass").val("backend\\models\\" + $("#master-modelclass").val());
    $("#generator-searchmodelclass").val("backend\\models\\" + $("#master-modelclass").val()+"Search");
    $("#generator-controllerclass").val("backend\\controllers\\" + $("#master-modelclass").val()+"Controller");
}
var imposta = function(model){
    $("#generator-modelclass").val("app\\models\\" + $("#master-modelclass").val());
    $("#generator-searchmodelclass").val("app\\models\\" + $("#master-modelclass").val()+"Search");
    $("#generator-controllerclass").val("backend\\controllers\\" + $("#master-modelclass").val()+"Controller");
}
var impostac = function(model){
    $("#generator-modelclass").val("common\\models\\" + $("#master-modelclass").val());
    $("#generator-searchmodelclass").val("common\\models\\" + $("#master-modelclass").val()+"Search");
    $("#generator-controllerclass").val("common\\controllers\\" + $("#master-modelclass").val()+"Controller");
}

</script>
<div class="default-view">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="form-group field-generator-modelclass required">
<label class="control-label help" for="generator-modelclass" data-original-title="" title="">Model Class</label>
<input type="text" id="master-modelclass" class="form-control" value="">
<div class="hint-block">Nome del model</div>
<div class="help-block"></div>
<button  class="btn btn-default" name="preview" onClick="impostab()">backend</button>
<button  class="btn btn-default" name="preview" onClick="imposta()">app</button>
<button  class="btn btn-default" name="preview" onClick="impostac()">common</button>
</div>

    <p><?= $generator->getDescription() ?></p>

    <?php $form = ActiveForm::begin([
        'id' => "$id-generator",
        'successCssClass' => '',
        'fieldConfig' => ['class' => ActiveField::className()],
    ]); ?>
        <div class="row">
            <div class="col-lg-8 col-md-10">
                <?= $this->renderFile($generator->formView(), [
                    'generator' => $generator,
                    'form' => $form,
                ]) ?>
                <?= $form->field($generator, 'template')->sticky()
                    ->label('Code Template')
                    ->dropDownList($templates)->hint('
                        Please select which set of the templates should be used to generated the code.
                ') ?>
                <div class="form-group">
                    <?= Html::submitButton('Preview', ['name' => 'preview', 'class' => 'btn btn-primary']) ?>

                    <?php if (isset($files)): ?>
                        <?= Html::submitButton('Generate', ['name' => 'generate', 'class' => 'btn btn-success']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
        if (isset($results)) {
            echo $this->render('view/results', [
                'generator' => $generator,
                'results' => $results,
                'hasError' => $hasError,
            ]);
        } elseif (isset($files)) {
            echo $this->render('view/files', [
                'id' => $id,
                'generator' => $generator,
                'files' => $files,
                'answers' => $answers,
            ]);
        }
        ?>
    <?php ActiveForm::end(); ?>
</div>
