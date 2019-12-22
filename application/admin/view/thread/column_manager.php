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

        <form class="layui-form layui-col-md12"  method="post" action="">
            <input type="hidden" name="thread_column_id" value="{$Think.get.id}"  />
            <input type="hidden" name="member_id" id="member_id"  />
            <div class="layui-input-inline">
                <input type="text" name="keyword" id="keyword" placeholder="搜索关键字" autocomplete="off" value="{$Think.get.keyword}"  class="layui-input" />
            </div>
            <button class="layui-btn layui-btn-normal" lay-submit><i class="layui-icon">&#xe615;</i></button>
        </form>

    </div>
    <div class="layui-card-body">
        <table class="layui-table" lay-skin="nob">

            <thead>
                <tr>
                    <th>#</th>
                    <th>管理员名称</th>
                    <th>添加时间</th>
                    <th>移除</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                foreach ($lists as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['id'] ?></td>
                        <td><?php echo $value['nickname'] ?></td>
                        <td><?php echo $value['create_time'] ?></td>
                        <td><a class="layui-btn layui-btn-danger layui-btn-sm ajax-get" url='<?php echo url('admin/thread/column_manager_remove', ['id' => $value['id']]) ?>'>移除</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
{/block}
{block name="foot_js"}
<link rel="stylesheet" type="text/css" href="__PUBLIC__/libs/jquery.autocomplete/jquery.autocomplete.css"></link>
<script type="text/javascript" src="__PUBLIC__/libs/jquery.autocomplete/jquery.autocomplete.min.js"></script>
<script>
    $('#keyword').AutoComplete({
        'data': "<?php echo url('admin/member/json') ?>",
        'ajaxDataType': 'json',
        'listStyle': 'iconList',
        'maxItems': 10,
        'itemHeight': 55,
        'width': 300,
        'async': true,
        'matchHandler': function (keyword, data) {
            return true
        },
        'afterSelectedHandler': function (data) {
            $('#member_id').val(data.id);
            $('form').attr('action', "{:url('admin/thread/column_manager_add')}");
            $('form').submit();
        },
        'onerror': function (msg) {
            alert(msg);
        }
    });
</script>

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