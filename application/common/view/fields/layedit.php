<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-block">
        
        <textarea id="<?php echo $field['name']; ?>" style="display: none;"><?php echo $field['result']; ?></textarea>

    </div>
    <div class="check-tips"></div>
</div>
<script>
layui.use('layedit', function(){
  var layedit = layui.layedit;
  layedit.build('<?php echo $field['name']; ?>'); //建立编辑器
});
</script>