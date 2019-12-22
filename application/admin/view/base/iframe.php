{extend name="base:base" /}
{block name="body"}
<div id="categroys">
    <div id="tree"></div>
</div>
<div id="categroys_content">
    <iframe id="iframe_list" 
            src="<?php echo $iframe_src; ?>" 
            width="100%" height="100%" frameborder="0"></iframe>
</div>
{/block}
{block name="foot_js"}
<script>
    
    layui.use(['jquery', 'layer', 'tree', 'utils'], function () {
        var $ = layui.$
                , layer = layui.layer
                , form = layui.form
                , utils = layui.utils;

        // 加载前显示loading         
        var loading = layer.load(1);
        // 加载完毕隐藏loading        
        $('#iframe_list').on('load', layer.close(loading));

        layui.tree({
            elem: '#tree' //传入元素选择器
            , nodes: [<?php echo $nodes; ?>],
            click: function (node) {
                if (node.id) {
                    $('#iframe_list').attr('src', '<?php echo $iframe_src; ?>?category=' + node.id);
                } else {
                    $('#iframe_list').attr('src', '<?php echo $iframe_src; ?>');
                }
            }
        });
        utils.onresize(function () {
            $('#categroys').css('height', $(window).height());
            $('#categroys_content').css('height', $(window).height());
        });
    });
</script>
{/block}