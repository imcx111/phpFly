<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-block">
        <!-- 加载编辑器的容器 -->
        <script name="<?php echo $field['name']; ?>" type="text/plain" id="<?php echo $field['name']; ?>" style="width:100%;"><?php echo $field['result']; ?></script>
    </div>
    <div class="check-tips"></div>
</div>

<script type="text/javascript" src="__PUBLIC__/libs/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__PUBLIC__/libs/ueditor/ueditor.all.js"></script>
<script type="text/javascript">

    layui.use(['jquery', 'form', 'element'], function () {
        var $ = layui.$,
                form = layui.form,
                element = layui.element;

        var ue = UE.getEditor('<?php echo $field['name']; ?>', {

            <?php 
            if($field['extra_class'] == 'simple'){
            ?>
            toolbars: [['fullscreen', 'source', '|', 'undo', 'redo', '|', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|', 'simpleupload', 'insertimage', '|', 'selectall', 'cleardoc']],
            <?php 
            }
            ?>            
            initialFrameHeight: '<?php echo $field['extra_attr']; ?>',
            scaleEnabled: true,
            serverUrl: "{:url('admin/ueditor/index')}",
        });
    });
</script>