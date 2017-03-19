<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Wechat\Controller;

use Wechat\Service\WechatService;

/**
 * 微信授权后，自动注册并登录
 */
class AutoRegisterController extends AutoLoginController {

    protected function _initialize() {
        parent::_initialize();

        $userinfo = service("Passport")->getInfo();
        if (!$userinfo) {
            $info['username'] = $this->wx_user_info['openid'];
            $info['password'] = $this->wx_user_info['openid'];
            $info['email'] = $this->wx_user_info['openid'] . '_auto@ztbcms.com';
            //微信用户默认自动注册并登陆
            $userid = service("Passport")->userRegister($info['username'], $info['password'], $info['email']);
            $data = array();
            $data['nickname'] = $this->wx_user_info['nickname'];
            $data['sex'] = $this->wx_user_info['sex'];
            $data['userpic'] = $this->wx_user_info['headimgurl'];
            $data['modelid'] = $this->getAutoRegisterMemberModelId(); //根据自己设计设置会员模型
            $data['regdate'] = time(); //注册的时间
            $data['regip'] = get_client_ip(); //注册的ip地址
            $data['checked'] = 1; //默认用户是通过审核
            M('Member')->where("userid='%d'", $userid)->save($data);

            WechatService::changeWechatUserid($this->open_app_id, $this->wx_user_info['openid'], $userid);

            service('Passport')->loginLocal($info['username'], null, 7 * 24 * 60 * 60);
        }
    }

    /**
     * 获取自动注册时的会员模型ID
     *
     * 根据自己的需求进行修改，默认返回第一个会员模型ID（modelid）
     *
     * @return mixed
     */
    protected function getAutoRegisterMemberModelId() {
        $member_model = M('Model')->where(['type' => 2])->find();

        return $member_model['modelid'];
    }

}