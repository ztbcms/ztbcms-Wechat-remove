<?php
// +----------------------------------------------------------------------
// | Copyright (c) Zhutibang.Inc 2017 http://zhutibang.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhlhuang <zhlhuang888@foxmail.com>
// | 微信支付相关操作
// +----------------------------------------------------------------------

namespace Wechat\Service;

use System\Service\BaseService;

class WxpayService extends BaseService {
    /**
     * 更新从微信获取支付订单的信息
     *
     * @param $data
     */
    static function updateWxpayOrderInfo($data) {
        $is_exist = M('WechatPayOrder')->where(['out_trade_no' => $data['out_trade_no']])->find();
        if ($is_exist) {
            //如果存在
            $res = M('WechatPayOrder')->where(['id' => $is_exist['id']])->save($data);
        } else {
            $res = M('WechatPayOrder')->add($data);
        }
        if ($res) {
            self::createReturn(true, $res, 'ok');
        } else {
            self::createReturn(false, '', 'fail');
        }
    }
}