{extend name="base:base" /}
{block name="body"}
<div class="layui-container fly-marginTop fly-user-main">
    {include file="member/nav" /}
    <div class="fly-panel fly-panel-user" pad20>
        <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
            <button class="layui-btn layui-btn-danger layui-hide" id="LAY_delallmsg">清空全部消息</button>
            <div id="LAY_minemsg" style="margin-top: 10px;">
                <!--<div class="fly-none">您暂时没有最新消息</div>-->
                <ul class="mine-msg">                           
                </ul>
            </div>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<script>
    layui.use(['fly', 'face', 'member'], function () {
        var $ = layui.$
                , member = layui.member
                , fly = layui.fly;
    });
</script>
{/block}