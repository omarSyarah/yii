<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module']
    ] ,
   'components' => [
//        'modules' => [
//            'gridview' => ['class' => 'kartik\grid\Module']
//        ] ,
       'mongodb' => [
       'class' => '\yii\mongodb\Connection',
           'dsn' => 'mongodb://localhost:27017/admin',
       'options' => [
           "username" => "Username",
           "password" => "Password"
            ]
       ],
       'cache' => [
           'class' => 'yii\caching\MemCache',
           'useMemcached' => true,
           'servers' => [
               [
                   'host' => '127.0.0.1',
                   'port' => 11211,
                   'weight' => 100,
               ],
           ],
       ],

       'mailer' => [
           'class' => 'yii\swiftmailer\Mailer',
           'useFileTransport' => false,
           'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.mailtrap.io',
            'username' => '3c67cf7395d013',
            'password' => 'a75f84eb17ed86',
            'port' => '2525',
            'encryption' => 'tls',
               ],
       ],
        'request' => [
//            'csrfParam' => '_csrf-frontend',
            'csrfParam' => false,
            'enableCsrfValidation'=>false,

//        'parsers' => [
//            'application/json'=>\yii\web\JsonParser::class,
//            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],

        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => TRUE,
            'showScriptName' => false,
//            'rules' => [
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'api'],
//
//            ],


           'rules' => [
//                'OPTIONS v1/user/login' => 'v1/user/login',
//                'POST v1/user/login' => 'v1/user/login',
           'GET api/index' => 'api/index',
           'POST,GET api/create' => 'api/create',
           'POST api/delete' => 'api/delete',
           'PUT,PATCH api/index' => 'api/index',
//           'DELETE api/delete' => 'api/delete',


]
        ],

    ],
    'params' => $params,
];
