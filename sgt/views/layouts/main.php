<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;
use webvimark\modules\UserManagement\components\GhostNav;
use common\models\Userdetails;
use yii\web\View;
require_once("theme.php");



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?
    //Viene caricato per ultimo
    $this->registerCssFile("@web/css/site.css", [
        'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    ] );
    ?>
	<style>
		.efxcol {
			float: left;
		}
		.efxclear {
			clear: both;
		}
    //solo temporaneo
    .alert-danger {
        background-color: lightgray !important;
        border-color: lightgray !important;
        color: #ffffff;
    }
    .container
    {
      width: auto !important;
    }

	</style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<? require_once("navbar.php") ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
	<? require_once("footer.php") ?>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
