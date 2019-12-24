{extend name="base:base" /} 
{block name="body"} 






<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card ">

                <form method="post" class="layui-form" action="<?php echo url('config'); ?>" >


                    <input type="hidden" name="category" value="<?php echo $category; ?>" />
                    <input type="hidden" name="title" value="<?php echo $title ?>" />

                    <div class="layui-card-header">
                        <button type="submit" class="layui-btn layui-btn-normal" lay-filter="myform" lay-submit=""><i class="layui-icon layui-icon-ok"></i>保存</button>

                    </div>

                    <div class="layui-card-body ">

                        <div class="layui-row"> 

                            <table id="images" class="layui-table">
                                <col width="200" />
                                <col width="500" />
                                <col width="200"/>
                                <col   />
                                <thead>
                                    <tr>
                                        <th>键</th>
                                        <th>值</th>
                                        <th>备注</th>
                                        <th><a onclick="addImage();" class="add_image layui-btn layui-btn-normal layui-btn-sm"><i class="layui-icon layui-icon-add-1"></i></a> </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php
                                    foreach ($lists[0] as $key2 => $value2) {
                                        ?>
                                        <tr id="gallery-image-row<?php echo $key2; ?>"> 
                                            <td><input type="text" name="configs[<?php echo $key2; ?>][key]" value="<?php echo $lists[1][$key2] ?>" class="layui-input"></td> 
                                            <td><input type="text" name="configs[<?php echo $key2; ?>][value]" value="<?php echo $lists[2][$key2] ?>" class="layui-input"></td> 
                                            <td><input type="text" name="configs[<?php echo $key2; ?>][remark]" value="<?php echo ltrim($lists[4][$key2], '//') ?>" class="layui-input"></td> 
                                            <td><button type="button" onclick="document.getElementById('gallery-image-row<?php echo $key2; ?>').remove();value_row--;" data-toggle="tooltip" class="layui-btn layui-btn-danger layui-btn-sm"><i class="layui-icon">&#xe640;</i></button></td>
                                        </tr>    
                                    <?php } ?>
                                </tbody>		                  
                            </table>


                        </div>
                    </div>


                </form>


            </div>
        </div>
    </div>
</div>



{/block}

{block name="foot_js"}
<script>
    var value_row = <?php echo count($lists[0]); ?>;
    function addImage() {

        var html = '';
        //  html = '<tr id="gallery-image-row' + value_row + '">';
        html += '  <td><input type="text" name="configs[' + value_row + '][key]" value="" class="layui-input" /></td>';
        html += '  <td><input type="text" name="configs[' + value_row + '][value]" value="" class="layui-input" /></td>';
        html += '  <td><input type="text" name="configs[' + value_row + '][remark]" value="" class="layui-input" /></td>';
        html += '  <td><button type="button" onclick="document.getElementById(\'gallery-image-row' + value_row + '\').remove();value_row--;" data-toggle="tooltip" class="layui-btn layui-btn-danger layui-btn-sm"><i class="layui-icon">&#xe640;</i></button></td>';
        //  html += '</tr>';       
        var tr = document.createElement("tr");
        tr.id = "gallery-image-row" + value_row + "";
        tr.innerHTML = html;
        document.getElementById("tbody").appendChild(tr);
        value_row++;

        // Holder.run();
    }
</script>
{/block}