
application/x-httpd-php confirmEmailSuccess.php ( PHP script text )

<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $user
 */

?>
<div class="change-own-password-success">

	<div class="alert alert-danger text-center">
		<?= UserManagementModule::t('front', 'Token non valido') ?> - 

	</div>

</div>