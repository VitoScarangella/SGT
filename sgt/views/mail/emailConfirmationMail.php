<?php
/**
 * @var $this yii\web\View
 * @var $user webvimark\modules\UserManagement\models\User
 */
use yii\helpers\Html;

?>
<img class="img-responsive standard-logo" width="100" height="40" src="//www.sportgrandtour.it/wp-content/uploads/2016/09/The-Sport-Grand-Tour-v1-small.png" alt="Sport Grand Tour">
<hr>


<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user-management/auth/confirm-registration-email', 'token' => $user->confirmation_token]);
?>

Hello <?= Html::encode($user->username) ?>, follow this link to confirm your email:

<?= Html::a('Confirm E-mail', $resetLink) ?>