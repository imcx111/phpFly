<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-block">
        <?php
        if (isset($field['options'])) {
            echo html_checkbox($field['name'], $field['options'], $field['result']);
        }
        ?>
    </div><div class="check-tips"><?php echo $field['description']; ?></div>
</div>