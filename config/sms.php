<?php
return [
    // HTTP 请求的超时时间（秒）
    'timeout'  => 5.0,

    //验证码配置
    'captcha'  => [
        'length'  => 6,
        'cache'   => 'aoeng:captcha:',
        'timeout' => 60,//多少秒可发一次
        'expires' => 10,//多少分钟过期
    ],

    //路由配置
    'route'    => [
        'prefix' => 'api/',
        'domain' => '',
    ],

    // 默认发送配置
    'default'  => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun', 'yunpian',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'yunpian'  => [
            'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
        ],
        'aliyun'   => [
            'access_key_id'     => '',
            'access_key_secret' => '',
            'sign_name'         => '',
            'templates'         => [
                'captcha' => ''
            ]
        ],
        //...
    ],
];
