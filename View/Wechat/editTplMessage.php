<Admintemplate file="Common/Head"/>
<style>
    td {
        padding: 10px 5px;
    }
</style>

<body class="J_scroll_fixed">
<div style="padding-left:20px;padding-top:20px;">
    <form action="{:U('Wechat/Wechat/doEditTplMessage')}" method="post">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2" style="background: #eee;">模板消息</td>
                </tr>
                <tr>
                    <td width="100px"><label for="">标题</label></td>
                    <td><input value="{$data['title']}" name="title" style="width:300px;" class="form-control" type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">英文名</label></td>
                    <td><input value="{$data['name']}" name="name" style="width:300px;" class="form-control" type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">模板ID</label></td>
                    <td><input value="{$data['template_id']}" name="template_id" style="width:300px;" class="form-control" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="100px"><label for="">模板描述</label></td>
                    <td>
                        <textarea  class="form-control" name="description" style="width:300px;" rows="4">{$data['description']}</textarea>
                    </td>
                </tr>

            </table>
        </div>
        <div>
            <input type="hidden" name="app_id" value="{$data['app_id']}">
            <input type="hidden" name="id" value="{$data['id']}">
            <button class="btn btn-primary">保存</button>
        </div>
    </form>
</div>
</body>

</html>