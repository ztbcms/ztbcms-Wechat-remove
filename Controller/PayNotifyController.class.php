<?php

namespace Wechat\Controller;

use Common\Controller\Base;
use Wechat\Service\OpenService;

class PayNotifyController extends Base {
    public function rechargeNotify() {
        $open_service = new OpenService();
        $open_service->wxpayNotify(function ($result) {
        	// result 调用成功回调，不一定是支付成功
            echo 'SUCCESS';
        });
    }
}