<!doctype html>
<html  class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>后台登录</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />

        <script> var APP_URL = '<?php echo APP_URL; ?>';</script>  
        
        <link rel="stylesheet" href="__PUBLIC__/libs/layui/2.4.5/css/layui.css">
        <script src="__PUBLIC__/libs/layui/2.4.5/layui.js" charset="utf-8"></script>


        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/font.css">
        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/login.css">
        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/xadmin.css">


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
                <button class="layui-btn layui-btn-default" lay-submit lay-filter="myform" style="width:100%;" type="submit">登录</button>
                <hr class="hr20" >
            </form>
        </div>
        <script src="__PUBLIC__/static/admin/js/init.js"></script>
        <!-- 底部结束 -->

    </body>
</html>