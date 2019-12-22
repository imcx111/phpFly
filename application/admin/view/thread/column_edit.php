
{extend name="base:base" /}


{block name="body"}



<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">



            <form class="layui-form" action="">
                <input type="hidden" name="id" value="{$Think.get.id}" />
                <div class="layui-card">

                    <div class="layui-card-header">
                        <a class="layui-btn layui-btn-primary" href="javascript:history.back();"><i class="layui-icon layui-icon-left"></i>返回</a>
                        <button class="layui-btn layui-btn-normal" lay-filter="myform" lay-submit=""><i class="layui-icon layui-icon-ok"></i>保存</button>
                    </div>
                    <div class="layui-card-body ">
                        <div class="layui-container">
                            {$tpl_form}
                            
                            <div class="layui-form-item vip_group" style="<?php if($join_type != 1){echo 'display: none';}?>">
                                <label class="layui-form-label">VIP级别限制</label>
                                <div class="layui-input-inline">
                                    <select name="vip_limit">
                                        <?php
                                        echo html_select([
                                            1 => 'VIP1',
                                            2 => 'VIP2',
                                            3 => 'VIP3',
                                            4 => 'VIP4',
                                            5 => 'VIP5',
                                        ], $vip_limit);
                                        ?>
                                    </select>
                                </div><div class="check-tips"></div>
                            </div>
                            <div class="layui-form-item points_group" style="<?php if($join_type != 2){echo 'display: none';}?>">
                                <label class="layui-form-label">积分限制</label>
                                <div class="layui-input-inline">
                                    <input type="text"  class="layui-input" name="points_limit" value="{$points_limit}" />
                                </div><div class="check-tips"></div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </form>



        </div>
    </div>
</div> 
{/block}

{block name="foot_js"}


<script>


    layui.use(['jquery', 'layer', 'form', 'element'], function () {
        var $ = layui.$,
                layer = layui.layer,
                form = layui.form,
                element = layui.element;



        //下拉选择监听
        form.on('select(join_type)', function (data) {
            if ('0' == data.value) {                
                $('.vip_group').hide();
                $('.points_group').hide();                
            } else if ('1' == data.value) {                
                $('.vip_group').show();
                $('.points_group').hide();                
            }else if ('2' == data.value) {                
                $('.vip_group').hide();
                $('.points_group').show();
            }
        });

        //表单提交监听
        form.on('submit(quick_add)', function (data) {
            //loading
            var load = layer.msg('请稍候', {
                icon: 16
                , shade: 0.01
            });
            var target, query;
            query = $('form.add').serialize();
            target = $('form.add').get(0).action;
            $.post(target, query, function (result) {

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
            });
            return false;
        });

    });

</script>


{/block}