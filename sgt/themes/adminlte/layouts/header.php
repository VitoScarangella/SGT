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

    <?= Html::a('<span class="logo-mini ">Z</span><span class="logo-lg">SGT</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/images/user.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?=$cognome . " " . $nome?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/images/user.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <small><?=$username." ".$id?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                          <div class="row">
                            <div class="col-xs-6 text-right">
                                <b>Profilo</b>
                            </div>
                            <div class="col-xs-6 text-left">
                                ...
                            </div>
                          </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                              <?
                              echo Html::a('<i class="fa fa-edit fa-2x"></i>', ['/user-management/auth/change-own-password'],
                              ['data-method' => 'post',  'title'=>'Change Password', 'class'=>'']);

                              echo "&nbsp;&nbsp;&nbsp;" . Html::a('<i class="fa fa-key fa-2x"></i>', ['/user-management/auth/password-recovery'],
                              ['title'=>'Passsword Recovery', 'class'=>'']);

                              echo "&nbsp;&nbsp;&nbsp;" . Html::a('<i class="fa fa-sign-out fa-2x"></i>', ['/user-management/auth/logout'],
                              ['title'=>'Sign out', 'class'=>'']);

                              ?>
                            </div>
                        </li>
                    </ul>
                </li>

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
