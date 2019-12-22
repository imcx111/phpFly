{extend name="base:base" /}
{block name="body"}
<div class="layui-container fly-marginTop">
    <div class="fly-panel" pad20 style="padding-top: 5px;">
        <!--<div class="fly-none">没有权限</div>-->
        <div class="layui-form layui-form-pane">
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title">
                    <li class="layui-this"><?php
                        if ($id) {
                            echo '编辑帖子';
                        } else {
                            echo '发表新帖';
                        }
                        ?><!-- 编辑帖子 -->                       
                    </li>
                </ul>
                <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="{$id}" />
                            <div class="layui-row layui-col-space15 layui-form-item">
                                <div class="layui-col-md3">
                                    <label class="layui-form-label">所在专栏</label>
                                    <div class="layui-input-block">
                                        <select lay-verify="required" name="cid" lay-filter="column"> 
                                            <?php echo html_select(model('thread_column')->dict(), $cid) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-col-md9">
                                    <label for="L_title" class="layui-form-label">标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="L_title" name="title" required lay-verify="required" autocomplete="off" class="layui-input" value="{$title}">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-row layui-col-space15 layui-form-item layui-hide" id="LAY_quiz">
                                <div class="layui-col-md3">
                                    <label class="layui-form-label">所属产品</label>
                                    <div class="layui-input-block">
                                        <select name="project">
                                            <option></option>
                                            <option value="layui">layui</option>
                                            <option value="独立版layer">独立版layer</option>
                                            <option value="独立版layDate">独立版layDate</option>
                                            <option value="LayIM">LayIM</option>
                                            <option value="Fly社区模板">Fly社区模板</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-col-md3">
                                    <label class="layui-form-label" for="L_version">版本号</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="L_version" value="" name="version" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-col-md6">
                                    <label class="layui-form-label" for="L_browser">浏览器</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="L_browser"  value="" name="browser" placeholder="浏览器名称及版本，如：IE 11" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <div class="layui-input-block">
                                    <textarea id="L_content" name="content" required lay-verify="required" placeholder="详细描述" class="layui-textarea fly-editor" style="height: 250px" >{$content}</textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">悬赏积分</label>
                                    <div class="layui-input-inline" style="width: 190px;">
                                        <select name="points">
                                            <?php
                                            echo html_select([
                                                '20' => 20,
                                                '30' => 30,
                                                '50' => 50,
                                                '60' => 60,
                                                '80' => 80,
                                                    ], $points)
                                            ?>
                                        </select>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_vercode" class="layui-form-label">人类验证</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="4位数字验证码" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid" style="padding: 0!important;">
                                  <img src="{:captcha_src()}" alt="验证码，点击图片可更换" style="cursor: pointer" onclick="this.src='{:captcha_src()}?r='+Math.random() " />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <button class="layui-btn" lay-filter="myform" lay-submit>立即发布</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<script>
//    layui.use('layedit', function () {
//        var layedit = layui.layedit;
//        layedit.set({
//            uploadImage: {
//                url: '{:url("index/member/upload_img")}'
//            }
//        });
//        var index = layedit.build('L_content', {
//            height: 280,
//        });
//        layedit.sync(index)
//    });
</script>
{/block}