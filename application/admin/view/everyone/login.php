<!doctype html>
<html  class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>后台登录</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />

        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/font.css">
        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/login.css">
        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/xadmin.css">

        <script src="__PUBLIC__/libs/layui/layui.js" charset="utf-8"></script>

    </head>
    <body class="login-bg">

        <div class="login layui-anim layui-anim-up">
            <div class="message">phpFly 论坛管理登录</div>
            <div id="darkbannerwrap"></div>

            <form method="post" class="layui-form" >
                <input name="account" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
                <hr class="hr15">
                <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
                <hr class="hr15">
                <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
                <hr class="hr20" >
            </form>
        </div>

        <script>

            layui.use(['jquery', 'form'], function () {
                var $ = layui.$,
                        form = layui.form;
                // layer.msg('玩命卖萌中', function(){
                //   //关闭后的操作
                //   });
                //监听提交
                form.on('submit(login)', function (data) {


 
                    $.ajax({
                        //请求方式
                        type: "POST",
                        //请求的媒体类型
                        contentType: "application/x-www-form-urlencoded",
                        //请求地址
                        url: "{:url('admin/everyone/login')}",
                        //数据，json字符串
                        data: $('form').serialize(),
                        //请求成功
                        success: function (result) {
                            if (result.code == 1) {
                                if (result.msg) {
                                    layer.msg(result.msg);
                                    setTimeout(function () {
                                        if (result.url) {
                                            location.href = result.url;
                                        }
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



                    // alert(888)
//                    layer.msg(JSON.stringify(data.field), function () {
//                        location.href = 'index.html'
//                    });


                });
            });

        </script> 
        <!-- 底部结束 -->

    </body>
</html>