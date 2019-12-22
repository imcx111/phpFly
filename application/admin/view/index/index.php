<!doctype html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>后台登录-X-admin2.2</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        
        <script> var APP_URL = '<?php echo APP_URL; ?>';</script>  
        
        <link rel="stylesheet" href="__PUBLIC__/libs/layui/2.4.5/css/layui.css">
        <script src="__PUBLIC__/libs/layui/2.4.5/layui.js" charset="utf-8"></script>
        
        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/font.css">
        
        <link rel="stylesheet" href="__PUBLIC__/libs/X-admin/css/xadmin.css">
        <script type="text/javascript" src="__PUBLIC__/libs/X-admin/js/xadmin.js"></script>
        
        <link rel="stylesheet" href="__PUBLIC__/static/admin/css/theme.min.css">
        <link rel="stylesheet" href="__PUBLIC__/static/admin/css/style.css">
        <script>
            // 是否开启刷新记忆tab功能
            // var is_remember = false;
        </script>
    </head>
    <body class="index">
        <!-- 顶部开始 -->
        <div class="container">
            <div class="logo">
                <a href="<?php echo url('admin/index/index') ?>">phpFly v1.0</a></div>
            <div class="left_open">
                <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
            </div>
            <ul class="layui-nav left fast-add layui-hide" lay-filter="">
                <li class="layui-nav-item">
                    <a href="javascript:;">+新增</a>
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a onclick="xadmin.open('最大化', 'http://www.baidu.com', '', '', true)">
                                <i class="iconfont">&#xe6a2;</i>弹出最大化</a></dd>
                        <dd>
                            <a onclick="xadmin.open('弹出自动宽高', 'http://www.baidu.com')">
                                <i class="iconfont">&#xe6a8;</i>弹出自动宽高</a></dd>
                        <dd>
                            <a onclick="xadmin.open('弹出指定宽高', 'http://www.baidu.com', 500, 300)">
                                <i class="iconfont">&#xe6a8;</i>弹出指定宽高</a></dd>
                        <dd>
                            <a onclick="xadmin.add_tab('在tab打开', 'member-list.html')">
                                <i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
                        <dd>
                            <a onclick="xadmin.add_tab('在tab打开刷新', 'member-del.html', true)">
                                <i class="iconfont">&#xe6b8;</i>在tab打开刷新</a></dd>
                    </dl>
                </li>
            </ul>
            <ul class="layui-nav right" lay-filter="">
                <li class="layui-nav-item">
                    <a href="javascript:;"><?php echo $admin['nickname']; ?></a>
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a onclick="xadmin.open('密码修改', '<?php echo url('admin/system/password'); ?>', 500, 300)">密码修改</a></dd>                        
                        <dd>
                            <a class="ajax-get" href="<?php echo url('admin/everyone/logout') ?>">退出</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item to-index">
                    <a href="/">前台首页</a></li>
            </ul>
        </div>
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        <div class="left-nav">
            <div id="side-nav">
                <ul id="nav">
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="会员管理">&#xe6b8;</i>
                            <cite>会员管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('会员列表', '<?php echo url('admin/member/index') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>会员列表</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('论坛栏目', '<?php echo url('admin/thread/column') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>论坛栏目</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('论坛帖子', '<?php echo url('admin/thread/iframe') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>论坛帖子</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('导航', '<?php echo url('admin/nav/iframe') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>导航</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('导航分类', '<?php echo url('admin/nav/category') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>导航分类</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="系统管理">&#xe6b4;</i>
                            <cite>系统管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('系统参数', '<?php echo url('admin/system/config_iframe') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>系统参数</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('文件图片', '<?php echo url('admin/res/iframe') ?>')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>文件图片</cite></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <div class="x-slide_left"></div> -->
        <!-- 左侧菜单结束 -->
        <!-- 右侧主体开始 -->
        <div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
                <ul class="layui-tab-title">
                    <li class="home layui-this">
                        <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
                <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                    <dl>
                        <dd data-type="refresh">刷新当前</dd>
                        <dd data-type="this">关闭当前</dd>
                        <dd data-type="other">关闭其它</dd>
                        <dd data-type="all">关闭全部</dd></dl>
                </div>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src='<?php echo url('admin/index/home') ?>' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                    </div>
                </div>
                <div id="tab_show"></div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <style id="theme_style"></style>
        <!-- 右侧主体结束 -->
        <!-- 中部结束 -->
    </body>
</html>
<script src="__PUBLIC__/static/admin/js/init.js"></script>