<?php
/**
 * @var $this yii\web\View
 * @var $user webvimark\modules\UserManagement\models\User
 */
use yii\helpers\Html;

?>

Ciao  <?= Html::encode($user->username) ?> 
<br>
la tua password è <?= Html::encode($user->password) ?>
