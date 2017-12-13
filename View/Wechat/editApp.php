<Admintemplate file="Common/Head"/>
<style>
    td {
        padding: 10px 5px;
    }
</style>

<body class="J_scroll_fixed">
<div style="padding-left:20px;padding-top:20px;">
    <form action="{:U('Wechat/Wechat/doEditApp')}" method="post">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td width="100px"><label for="">应用名称</label></td>
                    <td>
                        <input value="{$data['name']}" name="name" style="width:300px;" class="form-control" type="text" placeholder="微信公众号名称">
                        <input value="{$data['id']}" name="id" style="width:300px;" class="form-control" type="hidden" >
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2" style="background: #eee;">微信配置</td>
                </tr>
                <tr>
                    <td width="100px"><label for="">app_id</label></td>
                    <td><input value="{$data['wx_app_id']}" name="wx_app_id" style="width:300px;" class="form-control" type="text" placeholder="微信公众号后台获取的App ID"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">secret</label></td>
                    <td><input value="{$data['wx_secret_key']}" name="wx_secret_key" style="width:300px;" class="form-control" type="text" placeholder="微信公众号后台获取的App Secret"></td>
                </tr>
            </table>
        </div>
        <div>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2" style="background: #eee;">ztbopen平台配置</td>
                </tr>
                <tr>
                    <td width="100px"><label for="">app_id</label></td>
                    <td><input value="{$data['open_app_id']}" name="open_app_id" style="width:300px;" class="form-control" type="text" placeholder="ztbopen平台后台获取的App ID"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">secret_key</label></td>
                    <td><input value="{$data['open_secret_key']}" name="open_secret_key" style="width:300px;" class="form-control" type="text" placeholder="ztbopen平台后台获取的App Secret">
                    </td>
                </tr>
                <tr>
                    <td width="100px"><label for="">alias</label></td>
                    <td><input value="{$data['open_alias']}" name="open_alias" style="width:300px;" class="form-control" type="text" placeholder="ztbopen平台后台获取的微信公众号微信号"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">默认配置</label></td>
                    <td>
                        <label class="">
                            <input type="radio" name="default" value="1" <?php echo ($data['default'] == 1 ? 'checked':'');?>> 是
                        </label>
                        <label class="">
                            <input type="radio" name="default" value="0" <?php echo ($data['default'] == 0 ? 'checked':'');?>> 否
                        </label>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <button class="btn btn-primary">保存</button>
        </div>
    </form>
</div>
</body>

</html>