<?
$app_id             = "app-";
$env                = "sgt_prod";
$logo               = 'nologo.png';
$theme              = "Yeti";
$_SESSION["yiiprj"] = "sgt" ;  //efx ***

$db_dsn = "mysql:host=localhost;dbname=jrsportg_sgtapp";
$db_username = 'jrsportg_admin';
$db_password = 'sp0r71v070ur';
$cookieValidationKey = "6GghXYZTZQftVLqfUg9LPIPHwYIfO4_22";

$gdrive_app = "";
$gdrive_user = "efisio.bova@gmail.com";
$gdrive_eventi = 'light';

$params = [
    'adminEmail' => 'admin@example.com',
	  'icon-framework' => 'whhg',  // Font Awe$subFoldersCommon["PROCEDURE AZIENDALI"] = [];

    'gdrive_oauth_redirect' => "http://".$_SERVER['HTTP_HOST']."/documentale/getauth",
    'gdrive_dbcache' => '1', //cache su db dei riferimenti gdrive

    'gdrive_app' => $gdrive_app,
    'gdrive_user' => $gdrive_user,

    'upload_path' => 'uploads', // //D:/EFXBIZ/YII2git/yii/htdocs/backendorion/web/hotels/img',
    'upload_url' => 'uploads',

    'user_details_update' => '/efx-user-params/indexupd', //richiamato da webvimark/module-user-management/views/user/index.php tasto details

    'websocketurl' => '/utenteserver/router',

    'theme' => $theme, //Spacelab
    'logo' => $logo,
    'app_id' => $app_id,
    'db_dsn' => $db_dsn,
    'db_username' => $db_username,
    'db_password' => $db_password,
    'cookieValidationKey' => $cookieValidationKey,

    //Parametri per phpExcel
    'styleArrayTitle' => [
        'font'  => [
            'bold'  => true,
            'color' => array('rgb' => '000000'),
        ],
        'fill' => [
             'type' => \PHPExcel_Style_Fill::FILL_SOLID,
             'color' => array('rgb' => 'EEEEEE')
         ]
    ],
    'info' => [
        'font'  => [
            'bold'  => true,
            'color' => array('rgb' => '000000'),
        ],
        'fill' => [
             'type' => \PHPExcel_Style_Fill::FILL_SOLID,
             'color' => array('rgb' => 'dff0d8')
         ]
    ],
    'danger' => [
        'font'  => [
            'bold'  => true,
            'color' => array('rgb' => '000000'),
        ],
        'fill' => [
             'type' => \PHPExcel_Style_Fill::FILL_SOLID,
             'color' => array('rgb' => 'ebcccc')
         ]
    ],
    'success' => [
        'font'  => [
            'bold'  => true,
            'color' => array('rgb' => '000000'),
        ],
        'fill' => [
             'type' => \PHPExcel_Style_Fill::FILL_SOLID,
             'color' => array('rgb' => 'fcf8e3')
         ]
    ],
    'warning' => [
        'font'  => [
            'bold'  => true,
            'color' => array('rgb' => '000000'),
        ],
        'fill' => [
             'type' => \PHPExcel_Style_Fill::FILL_SOLID,
             'color' => array('rgb' => 'faf2cc')
         ]
    ],

    'styleArrayBold' => [
        'font'  => [
            'bold'  => true,
        ]
    ],

];

?>
