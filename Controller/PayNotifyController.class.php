<?php
// +----------------------------------------------------------------------
// | Copyright (c) Zhutibang.Inc 2017 http://zhutibang.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhlhuang <zhlhuang888@foxmail.com>
// | 支付通知处理
// +----------------------------------------------------------------------

namespace Wechat\Controller;

use Common\Controller\Base;
use Wechat\Service\OpenService;

class PayNotifyController extends Base {
    /**
     * open 支付成功后回调的url 根据具体业务写下面逻辑
     */
    public function rechargeNotify() {
        $open_service = new OpenService();
        $open_service->wxpayNotify(function ($result) {
            if($result['status']){
                //签名验证正确
            }else{
                //签名验证错误
            }

            // result 调用成功回调，不一定是支付成功
            echo 'SUCCESS';
            exit();
        });
    }
}