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

    /**
     * 根据open_app_id 和 name获取模板消息
     *
     * @param $open_app_id
     * @param $name
     * @return array
     */
    static function getTemplateIDByName($open_app_id, $name){
        $app = M('WechatApp')->where(['open_app_id' => $open_app_id])->find();
        $res = M('WechatMsg')->where(['app_id' => $app['id'], 'name' => $name])->find();
        if($res){
            return self::createReturn(true, $res['template_id']);
        }else{
            return self::createReturn(false, null);
        }

    }
}