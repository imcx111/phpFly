<div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
                <a class="layui-btn layui-btn-normal layui-btn-fluid ajax-get" url="<?php echo $field['description']; ?>" id="<?php echo $field['name']; ?>"><?php echo $field['title']; ?></a>
            </div>
            <?php
            if (isset($field['options'])) {
                echo '<div class="layui-form-mid layui-word-aux">' . $field['options'] . '</div>';
            }
            ?>
        </div>