<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline">
        <select multiple class="form-control" name="<?php echo $field['name']; ?>[]" size="10">
            <?php
            //$c = $key . '_values';
            if (isset($field['options'])) {
                echo html_select($field['options'], $field['result']);
            }
            ?>
        </select>
    </div><div class="check-tips"><?php echo $field['description']; ?></div>
</div>