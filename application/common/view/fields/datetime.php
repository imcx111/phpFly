<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline">
        <input type="text" class="layui-input" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" readonly placeholder="点击选择时间" value="<?php echo $field['result']; ?>"  <?php echo $field['extra_attr']; ?> />
    </div>
    <?php
    if (isset($field['options'])) {
        echo '<div class="layui-form-mid layui-word-aux">' . $field['options'] . '</div>';
    }
    ?>
</div>
<script>
    layui.use('laydate', function () {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#<?php echo $field['name']; ?>' //指定元素
            , type: 'date'
        });
    });
</script>