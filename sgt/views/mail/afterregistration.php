<?php
/**
 * @var $this yii\web\View
 * @var $user webvimark\modules\UserManagement\models\User
 */
use yii\helpers\Html;


?>
Ciao<br><?=Html::encode($user->username)?>
<br>
la tua password è <?=Html::encode($user->auth_key)?>
<hr>

<?
$returnUrl = Yii::$app->user->returnUrl == Yii::$app->homeUrl ? null : rtrim(Yii::$app->homeUrl, '/') . Yii::$app->user->returnUrl;
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/user-management/auth/access-by-token', 'token' => $user->auth_key, 'returnUrl'=>$returnUrl]);

//EFX  Messaggio 
?>
Ciao<br><?=Html::encode($user->username)?>
<br>
sei iscritto su  <?= Yii::$app->urlManager->hostInfo ?>

<br/><br/>
Fai click su questo link per accedere alla tua area privata. Una volta entrato potrai cambiare la password.

<?= Html::a('Accesso alla mia area privata', $confirmLink) ?>