{extend name="base:base" /}


{block name="body"}

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card layui-form">
                <div class="layui-card-body ">
                    <form class="layui-col-space5">
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start" value="<?php echo input('get.start') ?>">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end" value="<?php echo input('get.end') ?>">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="keyword"  placeholder="请输入账号" autocomplete="off" class="layui-input" value="<?php echo input('get.keyword') ?>">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn layui-btn-sm"  lay-submit="" lay-filter="search"><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                    <button class="layui-btn" onclick="xadmin.open('添加用户', './member-add.html', 600, 400)"><i class="layui-icon"></i>添加</button>
                </div>
                <div class="layui-card-body layui-table-body layui-table-main">


                    <table class="layui-table layui-form">

                        {$tpl_list}

                    </table>




                </div>



                <div class="layui-card-body ">

                    
                    <div class="page" style="float: right">
                        {$pager}                         
                    </div>
                    
                    <div class="layui-input-inline">
                        <select lay-filter="set_field" href="<?php echo url('set_field', ['field' => 'vip']); ?>">
                            <option value="">设置VIP会员</option>
                            <?php
                            echo html_select([
                                0 => '普通',
                                1 => 'VIP1',
                                2 => 'VIP2',
                                3 => 'VIP3',
                                4 => 'VIP4',
                                5 => 'VIP5',
                            ]);
                            ?>
                        </select>
                    </div>

                    
                </div>


            </div>
        </div>
    </div>
</div> 

{/block}

{block name="foot_js"}

<script>
    layui.use(['laydate', 'form'], function () {
        var laydate = layui.laydate;
        var form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function (data) {

            if (data.elem.checked) {
                $('tbody input').prop('checked', true);
            } else {
                $('tbody input').prop('checked', false);
            }
            form.render('checkbox');
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });


    });

    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要停用吗？', function (index) {

            if ($(obj).attr('title') == '启用') {

                //发异步把用户状态进行更改
                $(obj).attr('title', '停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!', {icon: 5, time: 1000});

            } else {
                $(obj).attr('title', '启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!', {icon: 5, time: 1000});
            }

        });
    }

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!', {icon: 1, time: 1000});
        });
    }



    function delAll(argument) {
        var ids = [];

        // 获取选中的id 
        $('tbody input').each(function (index, el) {
            if ($(this).prop('checked')) {
                ids.push($(this).val())
            }
        });

        layer.confirm('确认要删除吗？' + ids.toString(), function (index) {
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
    }
</script>

{/block}