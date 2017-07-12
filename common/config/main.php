<?php
use kartik\mpdf\Pdf;

$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
     /*

    */

    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['debug','languagepicker'],


    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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


        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // refer settings section for all configuration options
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'authClientCollection' => [
              'class' => 'yii\authclient\Collection',
              'clients' => [
                  'google' => [
                      'class' => 'yii\authclient\clients\GoogleOAuth'
                  ],

                ],
        ],

        'user' => [
            'class' => 'webvimark\modules\UserManagement\components\UserConfig',

            // Comment this if you don't want to record user logins
          //  'on afterLogin' => function($event) {
                  //  \webvimark\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
          //      }
        ],

            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                /*'rules' => [
                    // your rules go here
                ],*/
            ],
    ],

	'modules' => [
            'treemanager' =>  [
                 'class' => '\kartik\tree\Module',
                 // other module settings, refer detailed documentation
             ],
            'social' => [
                // the module class
                'class' => 'kartik\social\Module',

                // the global settings for the Google+ Plugins widget
                /*
                'google' => [
                    'clientId' => 'GOOGLE_API_CLIENT_ID',
                    'pageId' => 'GOOGLE_PLUS_PAGE_ID',
                    'profileId' => 'GOOGLE_PLUS_PROFILE_ID',
                ],*/

            ],


            'gii' => [
                'class' => 'yii\gii\Module',
            ],
            'gridview' => [
                'class' => 'kartik\grid\Module',
            ],

            'debug' => [
                'class' => 'yii\debug\Module',
            ],



      			'datecontrol' =>  [
      				'class' => 'kartik\datecontrol\Module',

        				// format settings for displaying each date attribute
        			'displaySettings' => [
        				'date' => 'dd/MM/yyyy',
        				'time' => 'HH:mm:ss a',
        				'datetime' => 'dd/MM/yyyy HH:mm:ss a',
        			],

        				// format settings for saving each date attribute
        				'saveSettings' => [
        					'date' => 'yyyy-MM-dd',
        					'time' => 'H:i:s',
        					'datetime' => 'yyyy-MM-dd H:i:s',
        				],

        			'displayTimezone' => 'Europe/Rome',

        				// automatically use kartik\widgets for each of the above formats
        				'autoWidget' => true,

        			'autoWidgetSettings' => [
        				'date'  => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
        				'time'  => [], // setup if needed
        				'datetime' => [], // setup if needed
        			],
      			]
		],

];

$config['modules']['gii']['generators'] = [
        'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator',
                            'templates' => [
                                    'efx' => '@app/../vendor/warrence/yii2-kartikgii/crud/efx',
                                    //'efx booking' => '@app/../vendor/warrence/yii2-kartikgii/crud/efx_book'
                                    ]
                            ],
];

return $config;
