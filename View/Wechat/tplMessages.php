<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <form class="J_ajaxForm" action="" method="post">
        <a class="btn btn-success" href="{:U('Wechat/Wechat/createTplMessage', ['app_id' => I('get.app_id')])}">添加模板消息</a>
        <div class="table_list" style="margin-top: 12px;">
            <table width="100%">
                <thead>
                <tr>
                    <td align="center" width="50px">ID</td>
                    <td align="center" width="150px">标题</td>
                    <td align="center" width="160px">英文名</td>
                    <td align="center">模板ID</td>
                    <td align="center">描述</td>
                    <td align="center">管理操作</td>
                </tr>
                </thead>
                <volist name="data" id="vo">
                    <tr>
                        <td align="center">{$vo['id']}</td>
                        <td align="center">{$vo['title']}</td>
                        <td align="center">{$vo['name']}</td>
                        <td align="center">{$vo['template_id']}</td>
                        <td align="center">{$vo['description']}</td>

                        <td align="center">
                            <a class="btn btn-primary" href="javascript:;" onclick="sendTplMessage('{:I("get.app_id")}', '{$vo["id"]}')">测试发送</a>
                            <a class="btn btn-primary" href="{:U('Wechat/Wechat/editTplMessage', ['app_id' => I('get.app_id'), 'id' => $vo['id']])}">编辑</a>
                            <a class="btn btn-danger" href="javascript:deleteItem('{:I("get.app_id")}', '{$vo["id"]}')">删除</a>
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
        window.deleteItem = function (app_id, id) {
            if (confirm('确认删除?')) {
                $.ajax({
                    url: "{:U('Wechat/Wechat/doDeleteTplMessage')}",
                    type:'post',
                    data: {
                        'id': id,
                        'app_id' : app_id
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

    function sendTplMessage(app_id, id){
        layer.open({
            title: '发送模版消息',
            type: 2,
            content: "{:U('Wechat/Wechat/sendTplMessage')}&app_id="+app_id+'&id='+id,
            area: ['60%', '80%']
        });
    }
</script>
</body>
</html>
