<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Wechat\Controller;

/**
 * 测试网页用户授权
 */
class TestWxAuthController extends WxBaseController {

    function index(){
        var_dump($this->wx_user_info);
    }

}