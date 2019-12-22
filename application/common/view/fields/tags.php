
<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline" id="tags">
        <input type="text" class="layui-input" name="<?php echo $field['name']; ?>" id="inputTags" placeholder="回车生成标签" autocomplete="off" value="<?php echo $field['result']; ?>" />
    </div>
    <div class="layui-form-mid layui-word-aux"><?php echo $field['description'] ?></div>

</div>
