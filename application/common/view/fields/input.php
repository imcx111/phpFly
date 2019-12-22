
<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-block">
        <input type="text" class="layui-input"  name="<?php echo $field['name']; ?>" value="<?php echo $field['result']; ?>"  <?php echo $field['extra_attr']; ?> placeholder="<?php echo $field['description']; ?>" />
    </div>

</div>