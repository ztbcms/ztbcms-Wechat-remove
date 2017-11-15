<?php

// +----------------------------------------------------------------------
// | Copyright (c) Zhutibang.Inc 2017 http://zhutibang.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhlhuang <zhlhuang888@foxmail.com>
// | ztbOpen操作
// +----------------------------------------------------------------------

namespace Wechat\Service;

use System\Service\BaseService;
use Think\Log;

/**
 * 主题邦第三方微信平台服务
 */
class OpenService extends BaseService {

    private $domain = 'http://open.ztbopen.cn';
    private $open_app = null;

    function __construct($open_app_id = null) {
        if (!$open_app_id) {
            //如果传null 这是默认的app
            $this->open_app = M('WechatApp')->order('`default` DESC')->find();
        } else {
            $this->open_app = M('WechatApp')->where(['open_app_id' => $open_app_id])->find();
        }
    }

    /**
     * [主题邦第三方平台支付]支付结果通知处理
     *
     * @param callable $callback 处理回调
     * @return mixed
     */
    public function wxpayNotify(callable $callback) {
        $data = I('post.');
        Log::write('wxpayNotify:'.json_encode($data));
        //获取到支付回调订单，open返回的。
        $open_sign = $data['open_sign'];
        $local_sign = md5($data['sign'] . $this->open_app['open_secret_key'] . $data['open_time']);
        if ($open_sign == $local_sign) {
            //签名成功
            // 获取微信支付订单信息
            $res = $this->getPayInfo($data['out_trade_no']);
            if ($res['status']) {
                //调用成功
                WxpayService::updateWxpayOrderInfo($res['data']);
            }

            return $callback(self::createReturn(true, $data, '签名验证通过'));
        } else {
            //签名失败
            return $callback(self::createReturn(false, $data, '签名验证失败'));
        }
    }

    /**
     * [微信原生支付]支付结果通知处理
     *
     * @param callable $callback
     */
    public function wxpayRawNotify(callable $callback){
        //获取通知的数据
        $xml = file_get_contents('php://input');
        Log::write('wxpayRawNotify:'.$xml);
        try{
            $result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

            //TODO 实现签名验证参数校验逻辑

            $callback(self::createReturn(true, $result, '校验成功'));
        }catch (\Exception $exception){
            $callback(self::createReturn(false, $xml, '解析异常'));
        }
    }


    /**
     * 获取支付订单信息
     *
     * @param $out_trade_no
     * @return mixed
     */
    public function getPayInfo($out_trade_no) {
        $time = time(); //当前时间戳
        $sign = $this->getSign($time);
        $api_url = $this->domain . "/api/wxpay_api/get_pay_info/app_id/" . $this->open_app['open_app_id'] . ".html?time={$time}&sign={$sign}";
        $res_json = $this->httpGet($api_url, ['out_trade_no' => $out_trade_no]);
        $res = json_decode($res_json, 1);
        if ($res) {
            return self::createReturn(true, $res, 'ok');
        } else {
            return self::createReturn(false, $res_json, '');
        }
    }

    /**
     * 获取微信支付配置
     *
     * @param string $openid       支付用户id
     * @param string $out_trade_no 支付订单号
     * @param int $fee          支付金额 单位：分
     * @param string $notify_url   回调地址
     * @param string $body         支付标题
     * @param string $detail       支付详情
     * @return bool|mixed
     */
    public function getWxpayConfig($openid, $out_trade_no, $fee, $notify_url = '', $body = '', $detail = '') {
        $time = time(); //当前时间戳
        $sign = $this->getSign($time);
        $api_url = $this->domain . "/api/wxpay_api/get_prepay_info/app_id/" . $this->open_app['open_app_id'] . ".html?time={$time}&sign={$sign}";
        $send_data = array(
            'openid' => $openid,
            'out_trade_no' => $out_trade_no,
            'fee' => $fee,
            'notify_url' => $notify_url,
            'body' => $body,
            'detail' => $detail,
        );
        $res_json = $this->httpPost($api_url, $send_data);
        $res = json_decode($res_json, 1);

        if ($res) {
            return self::createReturn(true, $res, '操作成功');
        } else {
            return self::createReturn(false, $res_json, '操作失败');
        }
    }

    /**
     * 通过img_id 获取人脸识别信息
     *
     * @param $img_id string 图片id face++唯一图片id
     * @return mixed
     */
    public function getFaceDetectInfo($img_id) {
        $time = time(); //当前时间戳
        $sign = $this->getSign($time);
        $api_url = $this->domain . "/api/face_api/get_detect_info/app_id/" . $this->open_app['open_app_id'] . ".html?time={$time}&sign={$sign}";
        $send_data = array(
            'img_id' => $img_id,
        );

        $res_json = $this->httpPost($api_url, $send_data);
        $res = json_decode($res_json, 1);

        if ($res) {
            return self::createReturn(true, $res, 'ok');
        } else {
            return self::createReturn(false, $res_json, '');
        }
    }

    /**
     * 人脸识别中，获取基本的脸部信息
     *
     * @param  $img_url string 需要识别的图片url
     * @return mixed
     */
    public function getFaceDetect($img_url) {
        $time = time(); //当前时间戳
        $sign = $this->getSign($time);
        $api_url = $this->domain . "/api/face_api/detect/app_id/" . $this->open_app['open_app_id'] . ".html?time={$time}&sign={$sign}";
        $send_data = array(
            'img_url' => $img_url,
        );

        $res_json = $this->httpPost($api_url, $send_data);
        $res = json_decode($res_json, 1);

        if ($res) {
            return self::createReturn(true, $res, 'ok');
        } else {
            return self::createReturn(false, $res_json, '');
        }
    }

    /**
     * 发送模板消息
     *
     * @param $openid       string 接收用户的openid
     * @param $template_id  string 发送模板消息的id
     * @param $data         array  模板需要发送的key和value
     * @param $url          string 点击模板消息的跳转链接，不设置则不跳转
     * @param $topcolor     string 颜色16进制
     * @return mixed
     */
    public function sendTemplate($openid, $template_id, $data, $url = null, $topcolor = '#f7f7f7') {
        $time = time();//当前时间戳
        //注意配置的模块，如果配置在Wechat/Conf中，其他模块调用可能出问题
        $sign = $this->getSign($time);
        $api_url = $this->domain . "/api/template_api/send_template/app_id/" . $this->open_app['open_app_id'] . ".html?time={$time}&sign={$sign}";
        $send_data = array(
            'touser' => $openid,
            'template_id' => $template_id,
            'url' => $url,
            'topcolor' => $topcolor,
            'data' => json_encode($data)
        );
        $res_json = $this->httpPost($api_url, $send_data);
        $res = json_decode($res_json, 1);

        if ($res) {
            return self::createReturn(true, $res, 'ok');
        } else {
            return self::createReturn(false, $res_json, '');
        }
    }

    public function getSign($time) {
        return md5($this->open_app['open_app_id'] . $time . $this->open_app['open_secret_key']);
    }

    /**
     * get method
     *
     * @param string $url
     * @param array  $param
     * @return mixed
     */
    function httpGet($url, $param = array()) {
        if (!is_array($param)) {
            return false;
        }
        $p = '';
        foreach ($param as $key => $value) {
            $p = $p . $key . '=' . $value . '&';
        }
        if (preg_match('/\?[\d\D]+/', $url)) {
            //matched ?c
            $p = '&' . $p;
        } else {
            if (preg_match('/\?$/', $url)) {
                //matched ?$
//                $p = $p;
            } else {
                $p = '?' . $p;
            }
        }
        $p = preg_replace('/&$/', '', $p);
        $url = $url . $p;
        //echo $url;
        $httph = curl_init($url);
        curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_HEADER, 0);
        $rst = curl_exec($httph);
        curl_close($httph);

        return $rst;
    }

    /**
     * post method
     *
     * @param       $url
     * @param array $param
     * @return bool|mixed
     */
    function httpPost($url, $param = array()) {
        if (empty($param)) {
            return false;
        }
        $httph = curl_init($url);
        curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
        curl_setopt($httph, CURLOPT_POST, 1); //设置为POST方式
        curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_HEADER, 0); //这里我们已经忽略http报文头的显示
        $rst = curl_exec($httph);
        curl_close($httph);

        return $rst;
    }
}