<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Wechat\Controller;

use Wechat\Service\WechatService;

/**
 * 微信授权后自动登录
 *
 * 用户已经授权，如果有openid绑定到用户userid时，自动登录。
 *
 */
class AutoLoginController extends WxBaseController {


    protected function _initialize() {
        parent::_initialize();

        $userinfo = service("Passport")->getInfo();

        if(!$userinfo){
            //未登录
            $result = WechatService::getUserid($this->open_app_id, $this->wx_user_info['openid']);
            if(!$result['status']){
                //没有该用户, 不做操作
                return;
            }else{
                $userid = $result['data'];
                $bindMember = M('Member')->where(['userid' => $userid])->find();
                //自动登录
                service('Passport')->loginLocal($bindMember['username'], '', 7 * 24 * 60 * 60);
            }
        }
    }

}