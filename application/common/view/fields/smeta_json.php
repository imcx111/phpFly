<?php
// 从extra中获取配置字段
if (!empty($field['options']))
    foreach ($field['options'] as $key => $value) {

        // 解析result的值 到每个字段
        if ($field['result'])
            extract(json_decode($field['result'], true));
        ?>


        <div class="layui-form-item">

            <label class="layui-form-label"><?php echo $value; ?></label>
            <div class="layui-input-block">
                <input type="text" class="layui-input"  name="<?php echo $key; ?>" value="<?php echo $$key ?? ''; ?>"  <?php echo $field['extra_attr']; ?>  />
            </div>

        </div>

        <?php
    }?>