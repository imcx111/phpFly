<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $field['title']; ?></label>
    <div class="layui-input-block">
        <table id="images" class="layui-table">
            <col />
            <col />
            <col width="100" />
            <col width="100" />
            <thead>
                <tr>
                    <th>图片选择</th>
                    <th>图片描述</th>
                    <th>排序</th>
                    <th><a onclick="addImage();" class="add_image layui-btn layui-btn-normal layui-btn-sm"><i class="layui-icon layui-icon-add-1"></i></a> </th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php
                foreach ($field['options'] as $key2 => $value2) {
                    ?>
                    <tr id="gallery-image-row<?php echo $key2; ?>"> 
                        <td>                                    
                            <img class="open-img-res" data-hidden="image_hidden<?php echo $key2; ?>" id="image_thumb<?php echo $key2; ?>" src="<?php echo img_resize($value2['image'], 100, 0); ?>" data-src="holder.js/60x60?text=图丢了" />
                            <input type="hidden" name="image_ids[<?php echo $key2; ?>][image]" value="<?php echo $value2['image']; ?>" id="image_hidden<?php echo $key2; ?>"> 
                        </td> 
                        <td><input type="text" name="image_ids[<?php echo $key2; ?>][description]" value="<?php echo $value2['description']; ?>" class="layui-input"></td> 
                        <td><input type="text" name="image_ids[<?php echo $key2; ?>][listorder]" value="<?php echo $value2['listorder']; ?>" class="layui-input"></td> 
                        <td><button type="button" onclick="document.getElementById('gallery-image-row<?php echo $key2; ?>').remove();image_row--;" data-toggle="tooltip" class="layui-btn layui-btn-danger layui-btn-sm"><i class="layui-icon">&#xe640;</i></button>
                        </td>
                    </tr>    
                <?php } ?>
            </tbody>		                  
        </table>

    </div>
</div>
<script>
    var image_row = <?php echo count($field['options']); ?>;
    function addImage() {
        if (image_row > 9) {
            alert('最多添加10条');
            return false;
        }
        var html = '';
        //  html = '<tr id="gallery-image-row' + image_row + '">';
        html += '  <td> <img class="open-img-res" src="' + APP_URL + '/static/admin/images/image_select.png" data-hidden="image_hidden' + image_row + '" id="image_thumb' + image_row + '" /><input type="hidden" name="image_ids[' + image_row + '][image]" value="" id="image_hidden' + image_row + '" /></td>';
        html += '  <td><input type="text" name="image_ids[' + image_row + '][description]" value="" class="layui-input" /></td>';
        html += '  <td><input type="text" name="image_ids[' + image_row + '][listorder]" value="' + image_row + '" class="layui-input" /></td>';
        html += '  <td><button type="button" onclick="document.getElementById(\'gallery-image-row' + image_row + '\').remove();image_row--;" data-toggle="tooltip" class="layui-btn layui-btn-danger layui-btn-sm"><i class="layui-icon">&#xe640;</i></button></td>';
        //  html += '</tr>';       
        var tr = document.createElement("tr");
        tr.id = "gallery-image-row" + image_row + "";
        tr.innerHTML = html;
        document.getElementById("tbody").appendChild(tr);
        image_row++;
        // Holder.run();
    }
</script>  