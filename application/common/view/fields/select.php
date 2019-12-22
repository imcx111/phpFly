<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline">
        <?php // echo $field['result'];   ?>
        <select name="<?php echo $field['name']; ?>" <?php echo $field['extra_attr']; ?>  >
            <option value="">=请选择=</option>
            <?php
            if (isset($field['options'])) {
                echo html_select($field['options'], $field['result']);
            }
            ?>
        </select>
    </div>
</div>