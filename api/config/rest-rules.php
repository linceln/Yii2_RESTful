<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 13:44
 */
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/user',
        'extraPatterns' => [
            'GET login' => 'login',
            'POST signup' => 'signup',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/site',
        'extraPatterns' => [
            'POST auto-pull' => 'auto-pull',
            'GET test' => 'test',
            'GET error' => 'error',
        ]
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'v1/bmi',
        'extraPatterns' => [
            'GET average' => 'average',
        ]
    ],
];