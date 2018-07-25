<?php
/**
 * 获取微信配置信息
 * @return array
 */
function getWxConfig() {
    return [
        'app_id' => 'wx11fe145bfca2b25e',
        'secret' => 'b8fdd5d132a3cc9c550ba40d001c6907',

        'response_type' => 'array',

        'token'   => 'weiphp',// Token
//            'aes_key' => 'j87GWXELylXpJuxVGSZrvIm4jqEfYFZHAjm2A56nqAz',// EncodingAESKey，兼容与安全模式下请一定要填写！！！

        'log' => [
            'level' => 'debug',
            'file' => storage_path() . '/wechat.log',
        ],
    ];
}