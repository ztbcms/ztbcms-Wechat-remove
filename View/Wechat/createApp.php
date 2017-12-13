<Admintemplate file="Common/Head"/>
<style>
    td {
        padding: 10px 5px;
    }
</style>

<body class="J_scroll_fixed">
<div style="padding-left:20px;padding-top:20px;">
    <form action="{:U('Wechat/Wechat/doCreateApp')}" method="post">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td width="100px"><label for="">应用名称</label></td>
                    <td><input value="" name="name" style="width:300px;" class="form-control" type="text" placeholder="微信公众号名称"></td>
                </tr>
            </table>
        </div>
        <div>
            <table style="width: 100%;">
                <tr>
                    <td colspan="2" style="background: #eee;">微信公众号配置</td>
                </tr>
                <tr>
                    <td width="100px"><label for="">app_id</label></td>
                    <td><input value="" name="wx_app_id" style="width:300px;" class="form-control" type="text" placeholder="微信公众号后台获取的App ID"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">secret</label></td>
                    <td><input value="" name="wx_secret_key" style="width:300px;" class="form-control" type="text" placeholder="微信公众号后台获取的App Secret"></td>
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
                    <td><input value="" name="open_app_id" style="width:300px;" class="form-control" type="text" placeholder="ztbopen平台后台获取的App ID"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">secret_key</label></td>
                    <td><input value="" name="open_secret_key" style="width:300px;" class="form-control" type="text" placeholder="ztbopen平台后台获取的App Secret">
                    </td>
                </tr>
                <tr>
                    <td width="100px"><label for="">alias</label></td>
                    <td><input value="" name="open_alias" style="width:300px;" class="form-control" type="text" placeholder="ztbopen平台后台获取的微信公众号微信号"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">默认配置</label></td>
                    <td>
                        <label class="">
                            <input type="radio" name="default" value="1" checked> 是
                        </label>
                        <label class="">
                            <input type="radio" name="default" value="0"> 否
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