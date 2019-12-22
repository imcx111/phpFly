<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div id="citys">
        <span class="layui-input-inline">
            <select lay-ignore  name="province"></select>
        </span>
        <span class="layui-input-inline">
            <select  lay-ignore  name="city"></select>
        </span>
        <span class="layui-input-inline">
            <select  lay-ignore  name="area"></select>
        </span>
    </div>
</div>
<script type="text/javascript">

    layui.use(['jquery', 'element'], function () {
        var $ = layui.$,
                element = layui.element;


        $('#<?php echo $field['name']; ?>').citys({
            valueType: 'name',
            province: '<?php echo isset($field['options']['province'])?$field['options']['province']:''; ?>', city: '<?php echo isset($field['options']['city'])?$field['options']['city']:''; ?>', area: '<?php echo isset($field['options']['area'])?$field['options']['area']:''; ?>',
            required: false,
            nodata: 'disabled',
            dataUrl: '<?php echo url('admin/index/citys') ?>'
        });


    });



</script>