{extend name="base:base" /}
{block name="body"}



<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card layui-form ">
                 
                <div class="layui-card-header">
                    
                     <a class="layui-btn layui-btn-normal" href="<?php echo url('add') ?>"><i class="layui-icon"></i>添加</a>
                </div>
                <div class="layui-card-body layui-table-body layui-table-main">


                    <table class="layui-table layui-form">

                        {$tpl_list}

                    </table>




                </div>



                <div class="layui-card-body ">
                    
                     <div class="layui-input-inline">
                        <select lay-filter="set_field" href="<?php echo url('set_field', ['field' => 'cid']); ?>">
                            <option value="">转移分类</option>
                            <?php echo html_select(model('nav_cat')->dict()); ?>
                        </select>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div> 

 


{/block}