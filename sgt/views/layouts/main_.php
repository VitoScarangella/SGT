<?php

/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
use backend\assets\SmartyThemeAsset;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;
use webvimark\modules\UserManagement\components\GhostNav; 
use common\models\Userdetails;


//AppAsset::register($this);
SmartyThemeAsset::register($this);
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
    </head>
 
    <body class="smoothscroll enable-animation">
 <?php $this->beginBody() ?>
 
        <div id="slidetop">
            [SLIDE_TOP]
        </div>
 
        <div id="wrapper">
         
            <div id="topBar">
                 <? require_once("navbar.php") ?>
            </div>
 
            <div id="header">
                
            </div>
 
            <section>
                <?= Alert::widget() ?>
				<?= $content ?>
            </section>

 
        </div>
  
 
        <!-- FOOTER -->
        <footer id="footer">
            <? require_once("footer.php") ?>
        </footer>
        <!-- /FOOTER -->
 
<?php $this->endBody() ?> 
    </body>
</html>
<?php $this->endPage() ?>