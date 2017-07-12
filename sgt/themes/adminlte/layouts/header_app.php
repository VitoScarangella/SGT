<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


$session = Yii::$app->session;
$user = \Yii::$app->user->identity;

$username = "";
$id = "";
$partitaIva = "";
$codiceFiscale = "";
$nome = "";
$cognome = "";
$username = "";
$id = "";
$nome = "";
$cognome = "";

if (!empty($user))
{
  $username = $user->username;
  $id = $user->id;
  $nome = $session["user"]['nome'];
  $cognome = $session["user"]['cognome'];
}
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini ">Z</span><span class="logo-lg">SGT APP</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <!-- User Account: style can be found in dropdown.less -->
                <?
                /*
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                */
                ?>
            </ul>
        </div>
    </nav>
</header>
