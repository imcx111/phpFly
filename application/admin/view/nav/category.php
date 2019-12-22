{extend name="base:base" /}
{block name="body"}



<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card layui-form">
                
                <div class="layui-card-header">
                    <a class="layui-btn layui-btn-normal" href="<?php echo url('category_add') ?>"><i class="layui-icon"></i>添加</a>
                    
                </div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        {$tpl_list}
                    </table>
                </div>
                
               
            </div>
        </div>
    </div>
</div>


 
{/block}