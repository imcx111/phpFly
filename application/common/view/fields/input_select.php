
<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline">
        <input type="text" class="layui-input" id="<?php echo $field['name']; ?>"  name="<?php echo $field['name']; ?>" value="<?php echo $field['result']; ?>"  <?php echo $field['extra_attr']; ?> />
    </div>

    <div class="layui-input-inline">
        <a class="layui-btn layui-btn-normal <?php echo $field['name']; ?>">选择</a>
    </div>
</div>

<script>
    layui.use(['jquery', 'layer', 'form', 'element'], function () {
        var $ = layui.$,
                layer = layui.layer,
                form = layui.form,
                element = layui.element;

        //弹出一个iframe层
        $(document).on("click", ".<?php echo $field['name']; ?>", function () {
            layer.open({
                type: 2,
                title: '选择数据',
                maxmin: true,
                shadeClose: true, //点击遮罩关闭层
                area: ['90%', '90%'],
                content: '<?php echo url($field['options']) ?>',
                success: function (layero, index) {    //成功获得子页面时
                    let body = layer.getChildFrame('body', index);
                    body.find("#inpuuname").val('<?php echo $field['name']; ?>');
                    layui.form.render();
                }
            });
        });
    });
</script>
