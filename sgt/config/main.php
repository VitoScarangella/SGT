<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => $params["app_id"],
    'language' => 'it_IT',
    'basePath' => dirname(__DIR__),

    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                //'controllers' => '', //Se non specifico controller abilita tutti
                'actions' => ['login', 'confirm-registration-email', 'access-by-token', 'confirm-email-receive', 'password-recovery', 'password-recovery-receive',
                'take-control',
                'service', 'registration', 'captcha', 'log', 'deletelog', 'deletelogtab', 'create-step1', 'create-step1b', 'create-step2', 'create-step3', 'ricerca'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],

    'modules' => [
          'efxlayout' => [
              'class' => 'common\modules\efxlayout\EfxLayout',
              'params'=>['traceLevel' => 0,]
          ],
          'efxtool' => [
              'class' => 'common\modules\efxtool\EfxTool',
              'params'=>['traceLevel' => 0,]
          ],
          'debug' => [
              'class' => 'yii\debug\Module',
              'params'=>['traceLevel' => 0,]
          ],

            'user-management' => [
                'class' => 'webvimark\modules\UserManagement\UserManagementModule',
                'enableRegistration' => true,
                'useEmailAsLogin' => true,
                'emailConfirmationRequired' => true,
                'rolesAfterRegistration' => ['SOCIETA'],
                //'on afterRegistration' => function(UserAuthEvent $event) {
                    // Here you can do your own stuff like assign roles, send emails and so on
                //},
                /*
                'on beforeAction'=>function(yii\base\ActionEvent $event) {
                        if ( $event->action->uniqueId == 'user-management/auth/registration' )
                        {
                            $event->action->controller->layout = 'registrationOrion.php';
                        };
                    },*/


            ],


    ],

    'components' => [
        'view' => [
             'theme' => [
                 'pathMap' => [
                   //'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                   '@app/views' => '@app/themes/adminlte'
                 ],
             ],
        ],
        'db' => [
      			'class' => 'yii\db\Connection',
      			'dsn' => $params["db_dsn"],
      			'username' => $params["db_username"],
      			'password' => $params["db_password"],
      			'charset' => 'utf8',
            'enableSchemaCache' => true,
            // Duration of schema cache.
            'schemaCacheDuration' => 360000,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',

        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            // Set the following if you want to use DB component other than
            // default 'db'.
            // 'db' => 'mydb',
            // To override default session table, set the following
            // 'sessionTable' => 'my_session',
            /*
            CREATE TABLE session (
                id CHAR(40) NOT NULL PRIMARY KEY,
                expire INTEGER,
                data BLOB
            )
            */
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@backend/views/mail',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'efisio.bova.kons@gmail.com',
                'password' => '3cc3ll3r3',
                'port' => '465',
                'encryption' => 'ssl',
                //'port' => '587',
                //'encryption' => 'tls',
                ],
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params["cookieValidationKey"],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d/m/Y', //'dd/mm/yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'EUR',
            'nullDisplay' => ' ',
        ],


       'i18n'=>array(
                'translations' => array(
                    'app*'=>array(
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => "@vendor/yiisoft/yii2/messages",
                       // 'sourceLanguage' => 'en_US',
                        'fileMap' => array(
                            'app'=>'orion.php',
                            'app/authorization'=>'authorization.php'
                        )
                    ),
                )
            ),

        'user' => [
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_'.$params["app_id"].'Identity',

            ],
         ],

         'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',        // List of available languages (icons and text)
            'languages' => ['en' => 'English', 'it' => 'Italiano', 'es' => 'Spanish']
         ],


        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
			      'flushInterval' =>111,  // <-- and here
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'trace' ], //'trace'
                    'logFile' => '@app/runtime/logs/'.$params["app_id"].'.log', //efx ***
					          'exportInterval' => 5, // <-- and here
                ],
                /*[
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@app/runtime/logs/'.$params["app_id"].'_sql.log', //efx ***
                    'logVars' => [],
                    'levels' => ['profile'],
                    'categories' => ['yii\db\Command::query', 'yii\db\Command::execute'],
                    'prefix' => function($message) {
                        return '';
                    }
                ]*/
            ],
        ],
    ],
    'params' => $params,
];
