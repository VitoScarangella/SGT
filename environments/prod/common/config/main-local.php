<?php
return [
    'components' => [
        'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=promae_efx',
			'username' => 'dareepqd_root',
			'password' => 'r00tlight',
			'charset' => 'utf8',            
        ],     
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
