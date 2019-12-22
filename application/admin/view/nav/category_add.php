{extend name="base:base" /}
{block name="body"}


<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">



            <form class="layui-form" action="">
                
                <div class="layui-card">

                    <div class="layui-card-header">
                        <a class="layui-btn layui-btn-primary" href="javascript:history.back();"><i class="layui-icon layui-icon-left"></i>返回</a>
                        <button class="layui-btn layui-btn-normal" lay-filter="myform" lay-submit=""><i class="layui-icon layui-icon-ok"></i>保存</button>
                    </div>
                    <div class="layui-card-body ">
                        <div class="layui-container">
                            {$tpl_form}
                        </div>
                    </div>
                </div>

            </form>



        </div>
    </div>
</div> 





{/block}