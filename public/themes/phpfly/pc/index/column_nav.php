<div class="fly-panel fly-column">
    <div class="layui-container">
        <ul class="layui-clear">
            <li class="layui-hide-xs <?php 
            ?>"><a href="<?php echo APP_URL.'/' ?>">首页</a></li> 
            <?php
            $columns = db('thread_column')->select();
            foreach ($columns as $key => $value) {
                $current = '';
                if($value['alias'] == input('param.alias')){
                    $current = 'class="layui-this"';
                }
                ?>
            <li <?php echo $current;?>><a href="<?php echo url('/thread/' . $value['alias']) ?>"><?php echo $value['title'] ?></a></li> 
            <?php } ?>
<!--            <li><a href="jie/index.html">分享<span class="layui-badge-dot"></span></a></li> 
<li><a href="jie/index.html">讨论</a></li> 
<li><a href="jie/index.html">建议</a></li> 
<li><a href="jie/index.html">公告</a></li> 
<li><a href="jie/index.html">动态</a></li> -->
            <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li> 
            <!-- 用户登入后显示 -->
            <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="<?php echo url('index/member/thread') ?>">我发表的贴</a></li> 
            <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="<?php echo url('index/member/thread') ?>#type=wish">我收藏的贴</a></li> 
        </ul> 
        <div class="fly-column-right layui-hide-xs"> 
            <span class="fly-search"><i class="layui-icon"></i></span> 
            <a href="<?php echo url('index/member/thread_add') ?>" class="layui-btn">发表新帖</a> 
        </div> 
        <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;"> 
            <a href="<?php echo url('index/member/thread_add') ?>" class="layui-btn">发表新帖</a> 
        </div> 
    </div>
</div>