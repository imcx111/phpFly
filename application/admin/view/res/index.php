{extend name="base:base" /}
{block name="body"}  
<style>
    .lightbox img{
        margin: 0 auto;
    }   
    .lightbox .img_title{
        position: relative;
        height: 30px;
        line-height: 30px;
        margin-top: -30px;
        background-color:#000;
        opacity:0.5; 
        color: white;
        text-align: center;
    }
    #button-search{
        cursor: pointer;
    }
    ul.common{
        overflow: hidden;
    }
    ul.common li{         
        float: left;
        padding-right: 15px;
    }   
    @media screen and (max-width: 800px) {
        ul.common li{
            float: none;
            padding-bottom: 5px;
            text-align: center;
        }
    }
</style>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <form class="layui-form1" action="">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <ul class="common">
                            <li><a href="<?php echo $data['parent']; ?>" id="button-parent" class="layui-btn layui-btn-primary"><i class="layui-icon layui-icon-up"></i> 上级</a></li>
                            <li><a id="button-refresh" class="layui-btn layui-btn-primary"><i class="layui-icon layui-icon-refresh"></i> 刷新</a></li>
                            <li><button type="button" id="button-folder" class="layui-btn layui-btn-primary"><i class="layui-icon layui-icon-add-1"></i> 目录</button></li>
                            <li><button type="button" id="button-upload" class="layui-btn layui-btn-normal"><i class="layui-icon layui-icon-upload"></i> 上传</button></li>
                            <li><input type="checkbox" lay-ignore name="autoname" value="1" checked="on" /> 自动命名</li>
                            <li><span class="text-success">
                                    <strong>目录：</strong>
                                    <?php
                                    $dir = input('get.directory', '');
                                    echo $dir ? '/' . $dir . '/' : '/';
                                    ?>
                                </span></li>
                            <li>
                                <div class="layui-input-inline">
                                    <input type="text" name="search" placeholder="请输入关键字" autocomplete="off" value="{$Think.get.filter_name}" class="layui-input">
                                </div>            
                                <button class="layui-btn layui-btn-normal" lay-submit><i class="layui-icon layui-icon-search"></i></button>
                            </li>
                        </ul>
                    </div>
                    <div class="layui-card-body ">
                        <div class="">
                            <?php if ($folder == 'image') { ?>
                                <?php if (empty($data['images'])) { ?>
                                    <div class="layui-row text-warning" style="margin: 50px; text-align: center; ">
                                        <i class="layui-icon layui-icon-face-surprised" style="font-size: 26px; font-weight: bold;"></i>   <span style=" font-size: 24px;">没有任何文件</span> 
                                    </div>  
                                <?php } ?>
                                <?php foreach (array_chunk($data['images'], 6) as $image_lists) { ?>
                                    <div class="layui-row" style="margin-bottom: 20px;">
                                        <?php foreach ($image_lists as $image) { ?>
                                            <div class="layui-col-md2 layui-col-sm4 text-center">
                                                <?php if ($image['category'] == 'directory') { ?>
                                                    <div class="text-center" >
                                                        <a href="<?php echo $image['href']; ?>" class="directory">
                                                            <i class="layui-icon layui-icon-carousel" style="font-size: 6em; color: #1E9FFF;"></i>   
                                                        </a>
                                                        <label>
                                                            <input  class="ids" type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
                                                            <?php echo $image['name']; ?>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($image['category'] == 'image') { ?>
                                                    <div class="image" style="margin:10px;border: 1px solid #BBB5B5">
                                                        <a href="<?php echo $image['href']; ?>" class="lightbox" style="display: block;" > 
                                                            <img src="<?php echo $image['thumb']; ?>" 
                                                                 alt="<?php echo $image['name']; ?>"  
                                                                 class='img-responsive thumbnail'
                                                                 width="300"
                                                                 title="<?php echo $image['name']; ?>" />
                                                            <div class="img_title"><?php echo $image['name']; ?></div>
                                                        </a>
                                                        <label style="word-break:break-all;">     
                                                            <input  class="ids" type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />                                
                                                            <button class="layui-btn layui-btn-primary layui-btn-xs copy" data-clipboard-text="<?php echo res_http($image['path']); ?>">复制路径</button>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="layui-row">
                                    <table class="layui-table">
                                        <thead>
                                            <tr  class="active">
                                                <td>名称</td>
                                                <td>日期</td>
                                                <td>大小</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['images'] as $image) { ?>
                                                <?php if ($image['category'] == 'directory') { ?>
                                                    <tr>
                                                        <td><input class="ids" type="checkbox"   name="path[]" value="<?php echo $image['path']; ?>" />
                                                            <a style="vertical-align: middle;" href="<?php echo $image['href']; ?>"  ><i class="layui-icon layui-icon-add-circle-fine" style="color: #1E9FFF;font-weight: bold;"></i>    <?php echo $image['name']; ?></a></td>
                                                        <td><?php echo $image['time']; ?></td>
                                                        <td>文件夹</td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($image['category'] == 'image') { ?>
                                                    <tr >
                                                        <td>
                                                            <input class="ids" type="checkbox"   name="path[]" value="<?php echo $image['path']; ?>" />
                                                            <a data-val="<?php echo $image['path']; ?>" class="select" style="cursor: pointer" ><?php echo $image['name']; ?></a>
                                                            <button class="layui-btn layui-btn-primary layui-btn-xs copy" data-clipboard-text="<?php echo res_http($image['path']); ?>">复制路径</button>
                                                            <a class="layui-btn layui-btn-primary layui-btn-xs" href="<?php echo $image['href']; ?>" >下载文件</a>
                                                        </td>
                                                        <td><?php echo $image['time']; ?></td>
                                                        <td><?php echo $image['size']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="inpuuname" value="" />
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="layui-card-body">
                        <ul class="common">
                            <li><input class="all-file" type="checkbox"/> 全选  </li>
                            <li><button id="button-delete" class="layui-btn layui-btn-danger"><i class="fa fa-remove"></i> 删除</button></li>
                            <li><button class="layui-btn layui-btn-primary ajax-get" href="<?php echo url('admin/res/clear') ?>"><i class="fa fa-trash"></i> 清缓存</button></li>
                            <li><span class="text-danger">
                                    <strong> 限制格式：</strong><?php
                                    if (isset($ext_arr[$category])) {
                                        echo implode('/', $ext_arr[$category]);
                                    }
                                    ?>
                                    <strong> 限制大小：</strong><?php echo format_bytes($file_size); ?>/<?php echo ini_get('upload_max_filesize'); ?>/<?php echo ini_get('post_max_size'); ?>
                                </span></li>
                            <li><?php echo $pagination; ?></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
{/block}
{block name="foot_js"}
<script type="text/javascript" src="__PUBLIC__/libs/jquery/2.0.0/jquery.min.js"></script>
<!--复制-->
<script type="text/javascript" src="__PUBLIC__/libs/jquery.clipboard/clipboard.min.js"></script>
<!--LAYER-->
<script type="text/javascript" src="__PUBLIC__/libs/layer/3.0/layer.js"></script>
<!--lightBox-->
<link rel="stylesheet" href="__PUBLIC__/libs/jquery-lightbox/css/simplelightbox.min.css"/>
<script type="text/javascript" src="__PUBLIC__/libs/jquery-lightbox/js/simple-lightbox.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('a.lightbox').simpleLightbox();
    });
    $(function () {
        function parent_img_select(thumb, hidden) {
            //注意：parent 是 JS 自带的全局对象，可用于操作父页面
            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
<?php if ($data['thumb']) { ?>
                parent.layui.$('#<?php echo $data['thumb']; ?>').attr('src', thumb);
<?php } ?>
<?php if ($data['hidden']) { ?>
                parent.layui.$('#<?php echo $data['hidden']; ?>').attr('value', hidden);
<?php } ?>
            parent.layer.close(index);
        }
        //图片给父页面传值
        $('a.lightbox').on('click', function () {
            parent_img_select($(this).find('img').attr('src'), $(this).parent().find('input').attr('value'));
        });
        // 文件给父页面传值 
        function parent_file_select(val) {
            //var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
            //parent.layer.iframeAuto(index);
            var index = parent.layer.getFrameIndex(window.name);
            if (val === '') {
                parent.layer.msg('请填写标记');
                return;
            }
            // parent.layer.msg('您将标记 [ ' + val + ' ] 成功传送给了父窗口');
            var id = $('#inpuuname').val();
            parent.layui.$('#' + id).attr('value', val);
            parent.layer.close(index);
        }
        $('.select').click(function () {
            parent_file_select($(this).data('val'));
        });
        var clipboard = new ClipboardJS('.copy');
        clipboard.on('success', function (e) {
            alert("复制成功！")
        });
        clipboard.on('error', function (e) {
            alert("复制失败！请手动复制")
        });
        $('input[name=\'search\']').on('keydown', function (e) {
            if (e.which == 13) {
                $('#button-search').trigger('click');
            }
        });
        $('#button-refresh').on('click', function (e) {
            // alert(location.href)
            location.href = location.href;
        });
        var urls = {
            search: '{:url("index")}?category={$category}&directory={$data["directory"]}',
            upload: '{:url("res/index_upload")}?category={$category}&directory={$data["directory"]}',
            folder: '{:url("res/index_folder")}?category={$category}&directory={$data["directory"]}',
            delete: '{:url("res/index_delete")}'
        };
        $('#button-search').on('click', function (e) {
            var url = urls.search;
            var filter_name = $('input[name=\'search\']').val();
            if (filter_name) {
                url += '&filter_name=' + encodeURIComponent(filter_name);
            }
            url += '&thumb=' + '<?php echo $data['thumb']; ?>';
            url += '&hidden=' + '<?php echo $data['hidden']; ?>';
            console.log(url);
            location.href = url;
            return false;
         });
        $('#button-upload').on('click', function () {
            var that = this;
            //alert($('input[name=autoname]:checked').length);
            //return false;
            $('#form-upload').remove();
            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="files[]" multiple value="" /></form>');
            $('#form-upload input[name=\'files[]\']').trigger('click');
            if (typeof timer != 'undefined') {
                clearInterval(timer);
            }
            timer = setInterval(function () {
                if ($('#form-upload input[name=\'files[]\']').val() != '') {
                    clearInterval(timer);
                    $.ajax({
                        url: urls.upload + '&autoname=' + $('input[name=autoname]:checked').length,
                        type: 'post',
                        dataType: 'json',
                        data: new FormData($('#form-upload')[0]),
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#button-upload i').replaceWith('<i class="layui-icon layui-icon-loading"></i>');
                            $('#button-upload').prop('disabled', true);
                        },
                        complete: function () {
                            $('#button-upload i').replaceWith('<i class="layui-icon layui-icon-upload"></i>');
                            $('#button-upload').prop('disabled', false);
                        },
                        success: function (result) {
                            if (result.code == 0) {
<?php if ($folder == 'image') { ?>
                                    if (result.data) {
                                        parent_img_select(result.data, $(that).parent().find('input').attr('value'));
                                    }
<?php } else { ?>
                                    if (result.data) {
                                        parent_file_select(result.data);
                                    }
<?php } ?>
                                if (result.msg) {
                                    layer.msg(result.msg);
                                    setTimeout(function () {
                                        location.href = location.href;
                                    }, 1500);
                                } else {
                                    location.href = location.href;
                                }
                            } else {
                                if (result.msg) {
                                    layer.msg(result.msg);
                                }
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#button-upload i').replaceWith('<i class="layui-icon layui-icon-upload"></i>');
                            $('#button-upload').prop('disabled', false);
                            layer.msg(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            }, 500);
        });
        //新建文件夹
        $('#button-folder').click(function () {
            layer.prompt({title: '文件夹名称', value: '{:date("Y-m-d")}'}, function (val, index) {
                if (escape(val).indexOf("%u") != -1) {
                    layer.msg('文件夹名称不能含有中文');
                    return false;
                }
                // layer.close(index);
                $.ajax({
                    url: urls.folder,
                    type: 'post',
                    dataType: 'json',
                    data: 'folder=' + encodeURIComponent(val),
                    beforeSend: function () {
                        $('#button-folder').prop('disabled', true);
                    },
                    complete: function () {
                        $('#button-folder').prop('disabled', false);
                    },
                    success: function (result) {
                        if (result.code == 0) {
                            location.reload();
                        } else {
                            layer.msg(result.msg);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        layer.msg(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            });
        });
        $('#button-delete').on('click', function (e) {
            if (confirm('确认删除吗')) {
                $.ajax({
                    url: urls.delete,
                    type: 'post',
                    dataType: 'json',
                    data: $('input[name^=\'path\']:checked'),
                    beforeSend: function () {
                        $('#button-delete').prop('disabled', true);
                    },
                    complete: function () {
                        $('#button-delete').prop('disabled', false);
                    },
                    success: function (result) {
                        if (result.code == 0) {
                            location.href = location.href;
                        } else {
                            layer.msg(result.msg);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        layer.msg(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        });
        $(".all-file").click(function () {
            $(".ids").prop("checked", this.checked);
        });
    }
    );
</script> 
<style>
    .uploader-list{ overflow: hidden; }
    .file-item{ float: left; width: 10%; margin: 5px;}
    .file-item{ word-break: break-all;}
    .thumbnail {
        display: block;
        max-width: 100%;
    }
    .pagination {
        display: inline-block;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 0px 12px;
        color: #1E9FFF;
        line-height: 1.5;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination > li.active > span{
        background-color: #1E9FFF;
        color: #fff;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
    }
    .layui-card-header{
        display: flex;
        align-items: center;
        /*            justify-content: center;*/
    }
    .text-center a{
        display: block;
        margin: 0 auto;
        /*         border: 1px solid red;*/
        text-align: center;
        line-height: 2;
    }
    .text-center label{
        text-align: center;
    }
    label{
        display: block;
    }
</style>
{/block}