<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-inline">        
        <img class="openbox_big" 
             title="图片选择"
             id="<?php echo $field['name']; ?>" 
             data-hidden="<?php echo $field['name']; ?>_hidden"
             href="<?php echo url('admin/res/index') ?>?hidden=<?php echo $field['name']; ?>_hidden&thumb=<?php echo $field['name']; ?>"              
             src="<?php echo img_resize($field['result'], 240, 0); ?>" 
             style='cursor:pointer;' 
             data-src="holder.js/<?php echo isset($field['description']) ? $field['description'] : '200x200' ?>?text=选择图片"             
             />
        <input type="hidden" id="<?php echo $field['name']; ?>_hidden" name="<?php echo $field['name']; ?>" value="<?php echo $field['result']; ?>" />
    </div>
</div>
