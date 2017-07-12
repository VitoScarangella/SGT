<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\Userdetails;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;
use webvimark\modules\UserManagement\components\GhostNav;
use kartik\icons\Icon;
use backend\models\Tool;
use  webvimark\modules\UserManagement\models\User;
use mdm\admin\components\Helper;

$session = Yii::$app->session;
$username = "";
$id = "";
$partitaIva = "";
$codiceFiscale = "";
$nome = "";
$cognome = "";

//if (isset(\Yii::$app->user->identity))
try {
		$user = \Yii::$app->user->identity;
		if (empty($user))
		{
			NavBar::begin([
				'brandLabel' => 'SGT',
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
					'class' => "navbar-inverse", //navbar-fixed-top navbar-inverse navbar-default
				],
			]);
			NavBar::end();
			return;
		}

		//if ($session["profilo"]=="")
		//echo "<div class='alert alert-danger'>Attenzione profilo non definito.</div>";

		$username = $user->username;
		$id = $user->id;
		$partitaIva = $session["user"]["partitaIva"];
		$codiceFiscale = $session["user"]["codiceFiscale"];
		$nome = $session["user"]['nome'];
		$cognome = $session["user"]['cognome'];

		//la variabile canChangeUser viene immpostata solo se mi loggo come superadmin
		if (!isset($session["canChangeUser"]))
		{
			if (Tool::hasRole(Tool::SWAPUSER) || Tool::hasRole(Tool::SUPERADMIN))
			{
				$session["canChangeUser"] = 1;
				$session["masterUser"] = $session["user"];
			}
		}
		if (isset($session["canChangeUser"]))
		{
			// echo ">".$session["masterUser"]["idCommercialista"]."< <hr>";
			// print_r($session["masterUser"]);
		}

} catch(Exception $e) {
	print_r($e);
}



$menuItems = [ ['label' => 'Home', 'url' => ['/site/index']], ];

if (Yii::$app->user->isGuest) {
	$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
	$menuItems[] = [
		'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
		'url' => ['/site/logout'],
		'linkOptions' => ['data-method' => 'post']
		];
}

	$items1 = [
	    
		[
				'label' => 'Le mie società', 'icon' => 'file-code-o','url' => ['/sgt-societa/indexute'], 'linkOptions' => ['data-method' => 'post']
 
		],
	    
		[
			'label' => 'Anagrafiche',
			'items'=>[
				['icon' => 'fa fa-gears', 'label' => 'Ricerca Societa', 'url' => ['/sgt-societa/ricerca-base'], 'linkOptions' => ['data-method' => 'post']],
				['icon' => 'fa fa-gears', 'label' => 'Societa', 'url' => ['/sgt-societa/index'], 'linkOptions' => ['data-method' => 'post']],
				['icon' => 'fa fa-gears', 'label' => 'Discipline', 'url' => ['/sgt-disciplina/index'], 'linkOptions' => ['data-method' => 'post']],
				['icon' => 'fa fa-gears', 'label' => 'Chiavi di ricerca', 'url' => ['/sgt-ricerca/index'], 'linkOptions' => ['data-method' => 'post']],
			],
		],



	];



require_once("../../common/views/tool/admintool_lte.php");
$items1 = Helper::filter($items1);
$items = array_merge($items1, $itemsadmin);

if (Tool::hasRole(Tool::SUPERADMIN))
		{
			$ute = [];
			$ute = [
				['icon' => 'fa fa-gears', 'label' => UserManagementModule::t('back', 'Users'), 						'url' => ['/user-management/user/index']],
				['icon' => 'fa fa-gears', 'label' => UserManagementModule::t('back', 'Roles'), 						'url' => ['/user-management/role/index']],
				['icon' => 'fa fa-gears', 'label' => UserManagementModule::t('back', 'Permissions'), 			'url' => ['/user-management/permission/index']],
				['icon' => 'fa fa-gears', 'label' => UserManagementModule::t('back', 'Permission groups'), 'url' => ['/user-management/auth-item-group/index']],
				['icon' => 'fa fa-gears', 'label' => UserManagementModule::t('back', 'Visit log'), 				'url' => ['/user-management/user-visit-log/index']],
			];
			$items[] =
			[
				'label' => 'Gestione Utenti', 'icon' => 'file-code-o',
				'items'=>$ute,
			];
		}



?>
