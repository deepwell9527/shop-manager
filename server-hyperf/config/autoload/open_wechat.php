<?php
// +----------------------------------------------------------------------
// | 微信平台信息
// +----------------------------------------------------------------------

return [
    // 第三方
    'third_party_platform' => [
        'app_id' => 'wxd5eaff4095ecc42f',
        'secret' => '93551e4f0cb38c52d1dfadb4f76ccd75',
        // 消息校验Toke
        'token' => 'ki5v$w!*bbtuRPnPYWHli22ETjQi$7Gp',
        // 消息加解密Key
        'aes_key' => 'Kep6ZhSS96fnChEaRubr01Le2HZvfu7GDbK0DEwpzUK',

        'http' => [
            'timeout' => 5.0,
            // 'base_uri' => 'https://api.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri
            'retry' => true, // 使用默认重试配置
            //  'retry' => [
            //      // 仅以下状态码重试
            //      'status_codes' => [429, 500]
            //       // 最大重试次数
            //      'max_retries' => 3,
            //      // 请求间隔 (毫秒)
            //      'delay' => 1000,
            //      // 如果设置，每次重试的等待时间都会增加这个系数
            //      // (例如. 首次:1000ms; 第二次: 3 * 1000ms; etc.)
            //      'multiplier' => 3
            //  ],
        ],
    ],
];
