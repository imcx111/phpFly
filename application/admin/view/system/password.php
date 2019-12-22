{extend name="base:base" /}
{block name="body"}
<form class="layui-form form-box" method="post" style="padding: 15px; margin-bottom:0px;">
    <div class="layui-form-item">
        <label class="layui-form-label" for="old_password">原始密码:</label>
        <div class="layui-input-inline">
            <input type="text"  required  lay-verify="required"  class="layui-input" id="old_password" name="old_password">
        </div>
        <div class="layui-form-mid layui-word-aux"><b style="color: red">*</b></div>    
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" for="password">新密码:</label>
        <div class="layui-input-inline">
            <input type="text"  required  lay-verify="required" class="layui-input" id="password" name="password">
        </div>
        <div class="layui-form-mid layui-word-aux"><b style="color: red">*</b></div>    
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" for="repassword">重复新密码:</label>
        <div class="layui-input-inline">
            <input type="text"  required  lay-verify="required"  class="layui-input" id="repassword" name="repassword">
        </div>
        <div class="layui-form-mid layui-word-aux"><b style="color: red">*</b></div>    
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-filter="myform" lay-submit><i class="layui-icon layui-icon-ok"></i>保存</button>
        </div>
    </div>
</form>
{/block}
