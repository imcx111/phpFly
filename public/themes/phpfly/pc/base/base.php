<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>基于 layui 的极简社区页面模版</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="keywords" content="fly,layui,前端社区">
        <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
        <link rel="stylesheet" href="__PUBLIC__/libs/layui/2.4.5/css/layui.css">
        <link rel="stylesheet" href="__THEME__/css/global.css">
    </head>
    <body>
        {include file="base/header" /} 
        {block name="body"}{/block}
        {include file="base/footer" /} 
    </body>
</html>
<script src="__PUBLIC__/libs/layui/2.4.5/layui.js"></script>
<script>
<?php
$member = member_is_login();
if (is_array($member)) {
    ?>
        layui.cache.page = '';
        layui.cache.user = {
            username: '<?php echo $member['nickname'] ?>'
            , uid: <?php echo $member['id'] ?>
            , avatar: '<?php
    if ($member['avatar'])
        echo res_http($member['avatar']);
    else
        echo res_http('sex' . $member['sex'] . '.png');
    ?>'
            , points: 83
            , sex: '<?php echo $member['sex'] == 0 ? '男' : '女' ?>'
        };
<?php } else { ?>
        layui.cache.page = '';
        layui.cache.user = {
            username: '游客'
            , uid: -1
            , avatar: ''
            , points: 83
            , sex: '男'
        };
<?php } ?>
    layui.define(function (exports) {
        exports('baseUrl', function () {
            return '<?php echo APP_URL; ?>';
        });
    });
    layui.config({
        version: "3.0.0"
        , base: '__THEME__/js/' //这里实际使用时，建议改成绝对路径
    }).extend({
        fly: 'index'
    }).use(['fly']);
    layui.use(['jquery', 'layer', 'form', 'element'], function () {
        var $ = layui.$,
                layer = layui.layer,
                form = layui.form,
                element = layui.element;     
        //监听提交
        form.on('submit(myform)', function (data) {
            //loading
            var load = layer.msg('请稍候', {
                icon: 16
                , shade: 0.01
            });
            //   layedit.sync(index)
            $.ajax({
                //请求方式
                type: "POST",
                //请求的媒体类型
                contentType: "application/x-www-form-urlencoded",
                //请求地址
                url: data.form.action,
                //数据，json字符串
                data: data.field,
                //请求成功
                success: function (result) {
                    if (result.code == 0) {
                        if (result.msg) {
                            layer.msg(result.msg);
                            setTimeout(function () {
                                if (result.url) {
                                    location.href = result.url;
                                }
                                // x_admin_close()
                            }, 1500);
                        } else {
                            if (result.url) {
                                location.href = result.url;
                            }
                        }
                    } else {
                        layer.msg(result.msg);
                    }
                },
                //请求失败，包含具体的错误信息
                error: function (e) {
                    layer.msg('错误信息：' + e.status);
                    console.log(e.responseText);
                }
            });
            return false;
        });
    });
</script>
{block name="foot_js"}{/block}
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?bfca60d8579a0829469bc63e06907200";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
