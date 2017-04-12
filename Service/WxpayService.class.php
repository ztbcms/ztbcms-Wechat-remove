<?php
namespace Wechat\Service;

class WxpayService {
    static function updateWxpayOrderInfo($data) {
        $is_exist = M('WechatPayOrder')->where(['out_trade_no' => $data['out_trade_no']])->find();
        if ($is_exist) {
            //如果存在
            M('WechatPayOrder')->where(['id' => $is_exist['id']])->save($data);
        } else {
            M('WechatPayOrder')->add($data);
        }
    }
}