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

$session = Yii::$app->session;
$username = "";
$id = "";
$partitaIva = "";
$codiceFiscale = "";
$idProfilo = "";
$nome = "";
$cognome = "";


if (isset(\Yii::$app->user->identity))
try {
		$user = \Yii::$app->user->identity;

		$username = $user->username;
		$id = $user->id;
		$partitaIva = $session["user"]["partitaIva"];
		$codiceFiscale = $session["user"]["codiceFiscale"];
		$idProfilo = $session["user"]["idProfilo"];
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




} catch(Exception $e) { print_r($e); }





if (!isset($session["esercizio"]))
$session["esercizio"] = Date("Y");

NavBar::begin([
	'brandLabel' => 'ZZigto',
	'brandUrl' => Yii::$app->homeUrl,
	'options' => [
		'class' => (Tool::hasRole(Tool::COMMERCIALISTA)?"navbar-default":"navbar-inverse"), //navbar-fixed-top navbar-inverse navbar-default
	],
]);


$menuItems = [
	['label' => 'Home', 'url' => ['/site/index']],
];
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
			'label' => 'Gestione Utenti',
			'items'=>UserManagementModule::menuItems()
	],


/*
	[
		'label' => 'Utility',
		'items'=>[
			['label' => '<span class="fa fa-gears"></span> Migrazione', 'url' => ['/tool/porting'], 'linkOptions' => ['data-method' => 'post']],
		],
	],
	*/

	[
		'label' => 'Configurazione',
		'items'=>[
		],
	],


	[
		'label' => '<span class="glyphicon glyphicon-user"></span>' . '<b>' . $cognome . " " . $nome . '</b>',
		'items'=>[
			['label'=>'<b>' . $cognome . " " . $nome . "</b>"],
			['label'=>'Logout', 'url'=>['/user-management/auth/logout']],
			['label'=>'Login', 'url'=>['/user-management/auth/login']],
			['label'=>'Cambia user', 'url'=>['efxtool/index']],

			['label'=>'Change own password', 'url'=>['/user-management/auth/change-own-password']],
			['label'=>'Password recovery', 'url'=>['/user-management/auth/password-recovery']],
			['label'=>'E-mail confirmation', 'url'=>['/user-management/auth/confirm-email']],
			['label'=>'Registration', 'url'=>['/user-management/auth/registration']],
			['label'=>'Ticket', 'url'=>['/todo']],

			['label'=>'<b>Username:' . $username . "</b>"],
			['label'=>'id: ' . $id],
			['label'=>'Profilo:' . $idProfilo],
		],
	],
];


require_once("../../common/views/tool/admintool.php");
$items = array_merge($items1, $itemsadmin);

		echo GhostNav::widget([
			'encodeLabels'=>false,
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => $items,

		]);

NavBar::end();
?>
