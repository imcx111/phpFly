{extend name="base:base" /}
{block name="body"}
<style>
    .layui-card-header{ overflow: hidden;}
    .layui-card-header .left{
        float: left;
    }
    .layui-card-header .right{
        float: right;
    }   
</style>
<div class="layui-card">
    <div class="layui-card-header">
        <div class="left">
            <a class="layui-btn layui-btn-normal" href="<?php echo url('href_select', ['type' => 'article_cat']) ?>">文章分类</a>
            <a class="layui-btn layui-btn-normal" href="<?php echo url('href_select', ['type' => 'article']) ?>">文章</a>
            <a class="layui-btn layui-btn-normal" href="<?php echo url('href_select', ['type' => 'goods_cat']) ?>">商品分类</a>
            <a class="layui-btn layui-btn-normal" href="<?php echo url('href_select', ['type' => 'goods']) ?>">商品</a>
        </div>
        <div class="right">
            <form class="layui-form layui-col-md12"  method="get" action="">
                <input type="hidden" name="type" value="<?php echo input('get.type', 'article_cat'); ?>" />
                <div class="layui-input-inline">
                    <input type="text" name="keyword" placeholder="搜索关键字" autocomplete="off" value="{$Think.get.keyword}"  class="layui-input" />
                </div>
                <button class="layui-btn layui-btn-normal" lay-submit><i class="layui-icon"></i></button>
            </form>
        </div>
    </div>
    <div class="layui-card-body">
        <input type="hidden" id="inpuuname" />
        <table class="layui-table" lay-skin="nob">
            <colgroup>
                <col width="50">
                <col width="200">
                <col width="150">
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>选择</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                foreach ($lists as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['id'] ?></td>
                        <td><?php echo $value['title'] ?></td>
                        <td><a data-val="<?php echo $value['href'] ?>" class="layui-btn layui-btn-normal layui-btn-sm select">选择</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pages">{$pages}</div>
{/block}
{block name="foot_js"}
<script>
    layui.use(['jquery', 'layer'], function () {
        var layer = layui.layer
                , $ = layui.jquery;
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        parent.layer.iframeAuto(index);
        $('.select').click(function () {
            var val = $(this).data('val');
            if (val === '') {
                parent.layer.msg('请填写标记');
                return;
            }
            // parent.layer.msg('您将标记 [ ' + val + ' ] 成功传送给了父窗口');
            var id = $('#inpuuname').val();
            parent.layui.$('#' + id).attr('value', val);
            parent.layer.close(index);
        });
    });
</script>
{/block}