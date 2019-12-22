<ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
    <li class="layui-nav-item <?php
    if (request()->action() == 'index') {
        echo 'layui-this';
    }
    ?>" >
        <a href="<?php echo url('/portal/0') ?>">
            <i class="layui-icon">&#xe609;</i>
            我的主页
        </a>
    </li>
    <li class="layui-nav-item <?php
    if (request()->action() == 'thread') {
        echo 'layui-this';
    }
    ?>" >
        <a href="<?php echo url('index/member/thread') ?>">
            <i class="layui-icon">&#xe612;</i>
            发贴管理 
        </a>
    </li>
    <li class="layui-nav-item <?php
    if (request()->action() == 'setting') {
        echo 'layui-this';
    }
    ?>" >
        <a href="<?php echo url('index/member/setting') ?>">
            <i class="layui-icon">&#xe620;</i>
            基本设置
        </a>
    </li>
    <li class="layui-nav-item <?php
    if (request()->action() == 'message') {
        echo 'layui-this';
    }
    ?> ">
        <a href="<?php echo url('index/member/message') ?>">
            <i class="layui-icon">&#xe611;</i>
            我的消息
        </a>
    </li>
    <li class="layui-nav-item <?php
    if (request()->get('type') == '1') {
        echo 'layui-this';
    }
    ?> ">
        <a href="<?php echo url('index/member/follow', ['type' => 1]) ?>">
            <i class="layui-icon">&#xe770;</i>
            我的关注
        </a>
    </li>
    <li class="layui-nav-item <?php
        if (request()->get('type') == '2') {
            echo 'layui-this';
        }
    ?> ">
        <a href="<?php echo url('index/member/follow', ['type' => 2]) ?>">
            <i class="layui-icon">&#xe770;</i>
            我的粉丝
        </a>
    </li>
</ul>
<div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
</div>
<div class="site-mobile-shade"></div>
<div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
</div>
<div class="site-mobile-shade"></div>