<?php
namespace Wechat\Service;

use System\Service\BaseService;

/**
 * 微信用户服务
 */
class WechatService extends BaseService {

    /**
     * 获取userid
     *
     * @param $open_app_id
     * @param $openid
     * @return array
     */
    static function getUserid($open_app_id, $openid) {
        $res = M('Wechat')->where(['open_app_id' => $open_app_id, 'openid' => $openid])->find();

        if ($res) {
            return self::createReturn(true, $res['userid']);
        }

        return self::createReturn(true, null, '找不到该用户');
    }

    /**
     * 更新openid绑定的用户ID(userid)
     *
     * @param $open_app_id
     * @param $openid
     * @param $userid
     * @return array
     */
    static function changeWechatUserid($open_app_id, $openid, $userid) {
        //将指定微信信息绑定
        $res = M('Wechat')->where(['open_app_id' => $open_app_id, 'openid' => $openid])->save(['userid' => $userid]);
        if ($res) {
            return self::createReturn(true, $res);
        } else {
            return self::createReturn(false, '', '更新微信绑定的用户失败');
        }
    }
}