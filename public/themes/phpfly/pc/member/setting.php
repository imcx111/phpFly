{extend name="base:base" /}
{block name="body"}
<div class="layui-container fly-marginTop fly-user-main">
    {include file="member/nav" /}
    <div class="fly-panel fly-panel-user" pad20>
        {eq name="status" value="0"}
        <div class="fly-msg" style="margin-top: 15px;">
            您的邮箱尚未验证，这比较影响您的帐号安全，<a href="<?php echo url('member/activate') ?>">立即去激活？</a>
        </div>
        {/eq}
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li class="layui-this" lay-id="info">我的资料</li>
                <li lay-id="avatar">头像</li>
                <li lay-id="pass">密码</li>
                <li lay-id="bind" class="layui-hide">帐号绑定</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-form-pane layui-tab-item layui-show">
                    <form method="post" action="<?php echo url('index/member/setting') ?>">
                        <div class="layui-form-item">
                            <label for="L_email" class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" name="email" required lay-verify="email" autocomplete="off" value="{$email}" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需<a href="activate.html" style="font-size: 12px; color: #4f99cf;">重新验证邮箱</a>。</div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">昵称</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_username" name="nickname" required lay-verify="required" autocomplete="off" value="{$nickname}" class="layui-input">
                            </div>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="radio" name="sex" value="0" <?php
                                    if ($sex == 0) {
                                        echo 'checked';
                                    }
                                    ?> title="男">
                                    <input type="radio" name="sex" value="1" <?php
                                    if ($sex == 1) {
                                        echo 'checked';
                                    }
                                    ?> title="女">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_city" class="layui-form-label">城市</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_city" name="city" autocomplete="off" value="{$city}" class="layui-input" >
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label for="L_sign" class="layui-form-label">签名</label>
                            <div class="layui-input-block">
                                <textarea placeholder="随便写些什么刷下存在感" id="L_sign"  name="signature" autocomplete="off" class="layui-textarea" style="height: 80px;">{$signature}</textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" key="set-mine" lay-filter="myform" lay-submit>确认修改</button>
                        </div>
                    </form>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <div class="layui-form-item">
                        <div class="avatar-add">
                            <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>                             
                            <img src="<?php
                            if ($avatar)
                                echo res_http($avatar);
                            else
                                echo res_http('sex' . $sex . '.png');
                            ?>" class="avatar_select" data-src="holder.js/168x168?text=上传头像" style="max-width:100%; cursor: pointer;" />                             
                        </div>
                    </div>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <form action="<?php echo url('index/member/password_reset') ?>" method="post">
                        <div class="layui-form-item">
                            <label for="L_nowpass" class="layui-form-label">当前密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="L_nowpass" name="old_password" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_pass" class="layui-form-label">新密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">6到16个字符</div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_repass" class="layui-form-label">确认密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="L_repass" name="repassword" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" key="set-mine" lay-filter="myform" lay-submit>确认修改</button>
                        </div>
                    </form>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <ul class="app-bind">
                        <li class="fly-msg app-havebind">
                            <i class="iconfont icon-qq"></i>
                            <span>已成功绑定，您可以使用QQ帐号直接登录Fly社区，当然，您也可以</span>
                            <a href="javascript:;" class="acc-unbind" type="qq_id">解除绑定</a>
                            <!-- <a href="" onclick="layer.msg('正在绑定微博QQ', {icon:16, shade: 0.1, time:0})" class="acc-bind" type="qq_id">立即绑定</a>
                            <span>，即可使用QQ帐号登录Fly社区</span> -->
                        </li>
                        <li class="fly-msg">
                            <i class="iconfont icon-weibo"></i>
                            <!-- <span>已成功绑定，您可以使用微博直接登录Fly社区，当然，您也可以</span>
                            <a href="javascript:;" class="acc-unbind" type="weibo_id">解除绑定</a> -->
                            <a href="" class="acc-weibo" type="weibo_id"  onclick="layer.msg('正在绑定微博', {icon: 16, shade: 0.1, time: 0})" >立即绑定</a>
                            <span>，即可使用微博帐号登录Fly社区</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="layui-card" style="display: none">
    <div class="layui-card-header">卡片面板</div>
    <div class="layui-card-body up-frame-parent up-frame-radius">
        <input type="file" id="inputImage">
        <hr>
        <div style="overflow: hidden">
            <div class="up-pre-before up-frame-radius pull-left">
                <img alt="" src="" id="image" >
            </div>
            <div class="up-pre-after up-frame-radius pull-right">
            </div>
        </div>
    </div>
    <div class="layui-card-body">
        <button type="button" class="layui-btn layui-btn-default" id="up-btn-ok" url="<?php echo url('index/member/avatar') ?>">保存</button>
    </div>
</div>
{/block}
{block name="foot_js"}
<style>
    .pull-left{
        float: left;
    }
    .pull-right{
        float: right;
    }
</style>
<script src="__PUBLIC__/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="__PUBLIC__/libs/holder/2.9.4/holder.min.js"></script>
<link href="__PUBLIC__/libs/cropper-master/dist/cropper.css" rel="stylesheet" />
<script src="__PUBLIC__/libs/cropper-master/dist/cropper.js"></script>
<script>
layui.use(['jquery', 'layer', 'element'], function () {
    var $ = layui.$,
            layer = layui.layer,
            element = layui.element;
    //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
    var layid = location.hash.replace(/^#user=/, '');
    element.tabChange('user', layid); //假设当前地址为：http://a.com#test1=222，那么选项卡会自动切换到“发送消息”这一项
    //监听Tab切换，以改变地址hash值
    element.on('tab(user)', function () {
        location.hash = 'user=' + this.getAttribute('lay-id');
    });
    $('.avatar_select').on('click', function () {
        index = layer.open({
            type: 1,
            area: ['600px', '500px'], //宽高
            shade: false,
            title: false, //不显示标题
            content: $('.layui-card'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            cancel: function () {
                // layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', {time: 5000, icon: 6});
            }
        });
    });
});
</script>
<link href="__THEME__/css/custom_up_img.css" rel="stylesheet" />
<script src="__THEME__/js/custom_up_img.js"></script>
{/block}