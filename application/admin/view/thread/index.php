
{extend name="base:base" /}


{block name="body"}



<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card layui-form">

                <div class="layui-card-body">


                    <form class=" layui-col-space5">

                        <div class="layui-input-inline layui-show-xs-block">
                            <input class="layui-input" placeholder="标题" name="title" id="title">
                        </div>

                        <div class="layui-input-inline layui-show-xs-block">
                            <select name="contrller">
                                <option value="">帖子状态</option>
                                <option value="0">置顶</option>
                                <option value="1">推荐</option>
                                <option value="2">锁定</option>
                            </select>
                        </div>

                        <div class="layui-input-inline layui-show-xs-block">
                            <button class="layui-btn" lay-submit="" lay-filter="search">
                                <i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>

                </div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        {$tpl_list}
                    </table>
                </div>
                <div class="layui-card-body ">
                    
                    <div class="page" style="float: right">
                        {$pager}                         
                    </div>
                    
                    <button class="layui-btn layui-btn-danger" lay-submit lay-filter="button_submit" href="<?php echo url('admin/thread/column_deletes'); ?>" ><i class="layui-icon"></i>批量删除</button>

                    <div class="layui-input-inline">
                        <select lay-filter="set_field" href="<?php echo url('set_field', ['field' => 'recommend']); ?>">
                            <option value="">是否推荐</option>
                            <?php
                            echo html_select([
                                0 => '不推荐',
                                1 => '推荐',
                            ]);
                            ?>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select lay-filter="set_field" href="<?php echo url('set_field', ['field' => 'top']); ?>">
                            <option value="">是否置顶</option>
                            <?php
                            echo html_select([
                                0 => '不置顶',
                                1 => '置顶',
                            ]);
                            ?>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select lay-filter="set_field" href="<?php echo url('set_field', ['field' => 'cid']); ?>">
                            <option value="">转移分类</option>
                            <?php echo html_select(model('thread_column')->dict()); ?>
                        </select>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div> 
{/block}

{block name="foot_js"}


{/block}