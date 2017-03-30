<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <form class="J_ajaxForm" action="" method="post">
        <a class="btn btn-success" href="{:U('Wechat/Wechat/createApp')}">添加开放平台应用</a>
        <div class="table_list" style="margin-top: 12px;">
            <table width="100%">
                <thead>
                <tr>
                    <td align="center" width="50px">ID</td>
                    <td align="center" width="150px">名称</td>
                    <td align="center">微信 app_id</td>
                    <td align="center">微信 secret_key</td>
                    <td align="center">开放平台 app_id</td>
                    <td align="center">开放平台 secret_key</td>
                    <td align="center">开放平台 alias</td>
                    <td align="center">是否默认</td>
                    <td align="center">管理操作</td>
                </tr>
                </thead>
                <volist name="data" id="vo">
                    <tr>
                        <td align="center">{$vo['id']}</td>
                        <td align="center">{$vo['name']}</td>
                        <td align="center">{$vo['wx_app_id']}</td>
                        <td align="center">{$vo['wx_secret_key']}</td>
                        <td align="center">{$vo['open_app_id']}</td>
                        <td align="center">{$vo['open_secret_key']}</td>
                        <td align="center">{$vo['open_alias']}</td>
                        <td align="center">
                            <if condition="$vo['default'] EQ 1">
                                是
                                <else/>
                                否
                            </if>
                        </td>

                        <td align="center">
                            <a class="btn btn-primary" href="{:U('Wechat/Wechat/tplMessages', ['app_id' => $vo['id']])}">模板消息</a>
                            <a class="btn btn-primary" href="{:U('Wechat/Wechat/editApp', ['id' => $vo['id']])}">编辑</a>
                            <a class="btn btn-danger" href="javascript:deleteApp('{$vo["id"]}')">删除</a>
                        </td>
                    </tr>
                </volist>
            </table>
            <div class="p10">
                <div class="pages"> {$Page}</div>
            </div>

        </div>
    </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>

<script>
    ;
    (function ($, window) {
        window.deleteApp = function (id) {
            if (confirm('确认删除改微信应用以及关联信息（如模板消息）?')) {
                $.ajax({
                    url: "{:U('Wechat/Wechat/doDeleteApp')}",
                    type: 'post',
                    data: {
                        'id': id
                    },
                    dataType: 'json',
                    success: function (res) {
                        if (res.status) {
                            alert('删除成功');
                            window.location.reload();
                        }else{
                            alert(res.msg || res.info);
                        }
                    },
                    error: function () {
                        alert('网络繁忙, 请稍候再试');
                    }
                });
            }
        }
    })(jQuery, window);
</script>
</body>
</html>
