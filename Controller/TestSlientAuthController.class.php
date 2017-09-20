<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Wechat\Controller;

/**
 * 测试静默授权
 */
class TestSlientAuthController extends SilentWxBaseController {

    function index(){
        var_dump($this->wx_openid);
    }

}