<?php

// +----------------------------------------------------------------------
// | Copyright (c) Zhutibang.Inc 2016 http://zhutibang.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhlhuang <zhlhuang888@foxmail.com>
// +----------------------------------------------------------------------

namespace Wechat\Controller;

use Common\Controller\AdminBase;
use Think\Exception;

/**
 * 微信平台管理
 */
class WechatController extends AdminBase {
    /**
     * 微信用户列表
     */
    public function index() {
        if (IS_POST) {
            $this->redirect('index', $_POST);
        }
        $where = array();
        $search = I('get.search');
        if (!empty($search)) {
            if (I('get.nickname') !== '') {
                $where['nickname'] = array("like", "%" . I('get.nickname') . "%");
                $this->assign('nickname', I('get.nickname'));
            }
            if (I('get.openid') !== '') {
                $where['openid'] = I('get.openid');
                $this->assign('openid', I('get.openid'));
            }
        }
        $count = M("Wechat")->where($where)->count();
        $page = $this->page($count, 20);
        $wx_users = M("Wechat")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('wx_users', $wx_users)->assign('Page', $page->show());
        $this->display('index');
    }

    /**
     * 配置设置页面
     */
    public function setting() {
        if (IS_POST) {
            $post = I('post.');
            foreach ($post as $key => $value) {
                $is_exsit = D('Config')->where("varname='%s'", $key)->find();
                if ($is_exsit) {
                    $data = array('varname' => $key, 'value' => $value);
                    M('Config')->where("id='%d'", $is_exsit['id'])->save($data);
                } else {
                    $data = array('varname' => $key, 'value' => $value);
                    M('Config')->add($data);
                }
            }
            $this->success('设置成功');
        } else {
            $memeber_models = D('Model')->where('type=2')->select();
            $this->assign('config', cache('Config'));
            $this->assign('memeber_models', $memeber_models);
            $this->display('setting');
        }
    }

    /**
     * 开放平台应用列表
     */
    public function appList() {
        $appList = M('WechatApp')->select();
        $this->assign('data', $appList);
        $this->display('appList');
    }

    /**
     * 创建开放平台应用页面
     */
    public function createApp() {
        $this->display('createApp');
    }

    /**
     * 创建开放平台应用操作
     */
    public function doCreateApp() {
        $data = I('post.');
        //若选择为默认时
        if ($data['default']) {
            M('WechatApp')->where(['default' => 1])->save(['default' => 0]);
        }
        $res = M('WechatApp')->add($data);
        if ($res) {
            $this->success('添加成功', U('Wechat/Wechat/appList'));
        } else {
            $this->error('操作失败');
        }

    }

    /**
     * 编辑开放平台应用页面
     */
    public function editApp() {
        $id = I('get.id');
        $wechatApp = M('WechatApp')->where(['id' => $id])->find();
        if (!$wechatApp) {
            throw new Exception('找不到该应用');
        }

        $this->assign('data', $wechatApp);
        $this->display('editApp');
    }

    /**
     * 编辑开放平台应用操作
     */
    public function doEditApp() {
        $data = I('post.');
        $id = $data['id'];
        unset($data['id']);
        if (empty($id)) {
            $this->error('缺少参数 id');

            return;
        }
        //若选择为默认时
        if ($data['default']) {
            M('WechatApp')->where(['default' => 1])->save(['default' => 0]);
        }
        M('WechatApp')->where(['id' => $id])->save($data);

        $this->success('操作成功', U('Wechat/Wechat/appList'));
    }

    /**
     * 删除开放平台应用操作
     */
    public function doDeleteApp() {
        $id = I('id');
        M('WechatApp')->where(['id' => $id])->delete();
        M('WechatMsg')->where(['app_id' => $id])->delete();
        $this->success('操作成功', U('Wechat/Wechat/appList'));
    }

    /**
     * 模板消息列表页面
     */
    public function tplMessages() {
        $app_id = I('get.app_id');
        $list = M('WechatMsg')->where(['app_id' => $app_id])->select();
        $this->assign('data', $list);
        $this->display('tplMessages');
    }

    /**
     * 添加模板消息页
     */
    public function createTplMessage() {
        $this->display();
    }

    /**
     * 添加模板消息操作
     */
    public function doCreateTplMessage() {
        $data = I('post.');
        if (empty($data['template_id'])) {
            throw new Exception('模板ID不能为空');
        }

        $res = M("WechatMsg")->add($data);
        if ($res) {
            $this->success('操作成功', U('Wechat/Wechat/tplMessages',['app_id' => $data['app_id']]));
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 编辑模板消息页
     */
    public function editTplMessage() {
        $app_id = I('get.app_id');
        $id = I('get.id');
        $data = M('WechatMsg')->where(['app_id' => $app_id, 'id' => $id])->find();
        $this->assign('data', $data);
        $this->display('doCreateTplMessage');
    }

    /**
     * 编辑模板消息操作
     */
    public function doEditTplMessage() {
        $data = I('post.');
        $id = $data['id'];
        unset($data['id']);
        if (empty($id)) {
            $this->error('缺少参数 id');

            return;
        }
        M('WechatMsg')->where(['id' => $id])->save($data);

        $this->success('操作成功', U('Wechat/Wechat/tplMessages', ['app_id' => $data['app_id']]));
    }

    /**
     * 删除模板消息操作
     */
    public function doDeleteTplMessage() {
        $app_id = I('post.app_id');
        $id = I('post.id');
        $result = M('WechatMsg')->where(['id' => $id])->delete();
        $this->success('操作成功', U('Wechat/Wechat/tplMessages', ['app_id' => $app_id]));
    }

}