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

/**
 * 输出界面
 * @param $pagePath
 * @param array $pageData
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
function SView($pagePath, $pageData = []) {
    return view($pagePath, $pageData);
}

/**
 * 返回 给客户端的 JSON 信息
 * @param $code
 * @param string $msg
 * @param array $data
 * @return string
 */
function ResultClientJson($code, $msg = '', $data = []) {
    return json_encode(['code' => $code, 'msg' => $msg, 'data' => $data]);
}

/**
 * 处理头像地址
 * @param $headImgUrl
 * @return string
 */
function headImgUrl($headImgUrl) {
    if (strpos($headImgUrl, 'images/wxUserHead') === false) {
        return $headImgUrl;
    } else {
        return env('APP_IMG_DOMAIN') . "/" . ltrim($headImgUrl, '/');
    }
}