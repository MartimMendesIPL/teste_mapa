<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/prato',
                    'extraPatterns' => [
                        'GET count' => 'count', //count é 'actionCount'
                        'GET nomes' => 'nomes', // nomes é 'actionNomes'
                        'GET {id}/preco' => 'preco', // 'preco' é 'actionPreco'
                        'GET preco/{nomeprato}' => 'precopornome', // 'precopornome' é 'actionPrecopornome'
                        'DELETE {nomeprato}' => 'delpornome', // 'delpornome' é 'actionDelpornome'
                        'PUT {nomeprato}' => 'putprecopornome', // 'putprecopornome' é 'actionPutprecopornome'
                        'POST vazio' => 'postpratovazio', // 'postpratovazio' é 'actionPostpratovazio'
                        'GET {ano}/{mes}/{dia}' => 'pratospordata', // 'pratospordata' é 'actionPratospordata'
                        ],
                            'tokens' => [
                            '{id}' => '<id:\\d+>',
                            '{nomeprato}' => '<nomeprato:\\w+>', //[a-zA-Z0-9_] 1 ou + vezes (char)
                            '{ano}' => '<ano:\\d{4}>',
                            '{mes}' => '<mes:\\d{2}>',
                            '{dia}' => '<dia:\\d{2}>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/cultural-site',
                    'extraPatterns' => [
                        'GET count' => 'count',
                        'GET by-region/{region}' => 'by-region',
                        'GET by-city/{city}' => 'by-city',
                        'GET by-type/{type}' => 'by-type',
                        'GET in-bounds' => 'in-bounds',
                    ],
                    'tokens' => [
                        '{region}' => '<region:[\\w\\s]+>',
                        '{city}' => '<city:[\\w\\s]+>',
                        '{type}' => '<type:\\w+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];