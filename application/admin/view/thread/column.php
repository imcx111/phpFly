
{extend name="base:base" /}


{block name="body"}



<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card layui-form">

                <div class="layui-card-header">
                    <a class="layui-btn layui-btn-normal" href="<?php echo url('admin/thread/column_add') ?>"><i class="layui-icon"></i>添加</a>

                </div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        {$tpl_list}
                    </table>
                </div>
                <div class="layui-card-body ">
                    <button class="layui-btn layui-btn-danger" lay-submit lay-filter="tableCommon" href="<?php echo url('admin/thread/column_deletes'); ?>" ><i class="layui-icon"></i>批量删除</button>
                    <div class="page">

                        {$page}

                    </div>
                </div>

            </div>
        </div>
    </div>
</div> 
{/block}

