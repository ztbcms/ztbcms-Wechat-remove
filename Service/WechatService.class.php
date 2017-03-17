<?php
namespace Wechat\Service;

use System\Service\BaseService;

/**
 * 微信用户服务
 */
class WechatService extends BaseService {
    /**
     * 通过用户id获取openid
     *
     * @param $userid
     * @return array
     */
    static function getOpenidByUserid($userid) {
        $res = M('Wechat')->where(['userid' => $userid])->find();

        if ($res) {
            return self::createReturn(true, $res['openid']);
        }

        return self::createReturn(true, null, '找不到该用户');
    }

    /**
     * 更新微信绑定的用户
     *
     * @param $openid
     * @param $userid
     * @return array
     */
    static function changeWechatUserid($openid, $userid) {
        //解除该用户与其他微信绑定
        M('Wechat')->where(['userid' => $userid])->save(['userid' => 0]);
        //将指定微信信息绑定
        $res = M('Wechat')->where(['openid' => $openid])->save(['userid' => $userid]);
        if ($res) {
            return self::createReturn(true, $res);
        } else {
            return self::createReturn(false, '', '更新微信绑定的用户失败');
        }
    }
}