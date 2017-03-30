<Admintemplate file="Common/Head"/>
<style>
    td {
        padding: 10px 5px;
    }
</style>

<body class="J_scroll_fixed">
<div style="padding-left:20px;padding-top:20px;">
    <form action="{:U('Wechat/Wechat/doCreateTplMessage')}" method="post">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2" style="background: #eee;">模板消息</td>
                </tr>
                <tr>
                    <td width="100px"><label for="">标题</label></td>
                    <td><input value="" name="title" style="width:300px;" class="form-control" type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">模板ID</label></td>
                    <td><input value="" name="template_id" style="width:300px;" class="form-control" type="text">
                    </td>
                </tr>
                <tr>
                    <td width="100px"><label for="">模板描述</label></td>
                    <td>
<!--                        <input value="" name="description" style="width:300px;" class="form-control" type="text">-->
                        <textarea  class="form-control" name="description" style="width:300px;" rows="4"></textarea>
                    </td>
                </tr>

            </table>
        </div>
        <div>
            <input type="hidden" name="app_id" value="{:I('get.app_id')}">
            <button class="btn btn-primary">保存</button>
        </div>
    </form>
</div>
</body>

</html>