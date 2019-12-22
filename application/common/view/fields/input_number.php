<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline">
        <input type="number" class="layui-input"  name="<?php echo $field['name']; ?>" value="<?php echo $field['result']; ?>"  <?php echo $field['extra_attr']; ?> />
    </div>
    <div class="layui-form-mid layui-word-aux"><?php echo $field['description'] ?></div>
</div>