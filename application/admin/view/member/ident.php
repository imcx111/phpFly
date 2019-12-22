{extend name="base:base" /}
{block name="body"}

<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">认证信息</label>
                <div class="layui-input-block">
                    <input type="text" name="identification" required value="<?php echo $identification ?>" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">认证级别</label>
                <div class="layui-input-block">

                    <?php echo html_radio('ident', [0 => '未认证', 1 => '黄V认证'], $ident) ?>

                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="myform">更新</button>
                </div>
            </div>
        </form>       
    </div>
</div>


{/block}