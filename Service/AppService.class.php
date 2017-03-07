<?php

namespace Wechat\Service;

use EasyWeChat\Foundation\Application;

/**
 * Class AppService
 *
 * 该类依赖于easyWechat
 */
class AppService {

    /**
     * 创建Application示例
     *
     * @return Application
     */
    public function create_app() {
        $config = cache('Config');
        $options = array(
            'app_id' => $config['wx_app_id'], // AppID ，注意配置的模块，如果配置在Wechat/Conf中，其他模块调用可能出问题
            'secret' => $config['wx_secret'], // AppSecret
            'payment' => [],
        );

        return $app = new Application($options);
    }

    /**
     * 创建jssdk 签名
     *
     * @param array $array 配置
     * @param bool  $is_debug
     * @param null  $url
     * @return array|string
     */
    public function getJsSdk($array, $is_debug = true, $url = null) {
        $app = $this->create_app();
        $js = $app->js;
        $js->setUrl($url);

        return $js->config($array, $is_debug);
    }

    /**
     * 企业支付
     *
     * @param string $openid 需要支付的用户openid
     * @param int    $fee    需要支付的金额，分为单位
     * @param null   $trade_no 交易号
     * @return array
     */
    public function merchant_pay($openid, $fee, $trade_no = null) {
        $app = $this->create_app();
        $merchantPay = $app->merchant_pay;
        $merchantPayData = array(
            'partner_trade_no' => $trade_no ? $trade_no : date('YmdHis', time()) . rand(1111, 9999),
            //随机字符串作为订单号，跟红包和支付一个概念。
            'openid' => $openid,
            //收款人的openid
            'check_name' => 'NO_CHECK',
            //文档中有三种校验实名的方法 NO_CHECK OPTION_CHECK FORCE_CHECK
            're_user_name' => '',
            //OPTION_CHECK FORCE_CHECK 校验实名的时候必须提交
            'amount' => $fee,
            //单位为分
            'desc' => '企业付款',
            'spbill_create_ip' => get_client_ip(),
            //发起交易的IP地址
        );
        $result = $merchantPay->send($merchantPayData);
        if ($result['result_code'] == "SUCCESS") {
            //提现成功
            return array('code' => 200, 'msg' => 'ok', 'data' => $result, 'post_data' => $merchantPayData);
        } else {
            //提现失败
            return array('err_code' => 400, 'msg' => $result['return_msg'], 'data' => $result);
        }
    }
}