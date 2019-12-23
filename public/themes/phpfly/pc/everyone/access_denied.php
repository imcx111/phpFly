{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<style>
    .notice {
        width: 600px;
        margin: 30px auto;
        padding: 30px 15px;
        border-top: 5px solid #009688;
        line-height: 30px;
        text-align: center;
        font-size: 16px;
        font-weight: 300;
        color: #999;
        font-size: 18px;
    }
    @media screen and (max-width: 768px) {
        .fly-none {
            padding-top: 0;
        }
        .fly-none .iconfont {
            line-height: 200px;
            font-size: 200px;
        }
        .notice {
            width: auto;
            margin: 20px 15px;
            padding: 30px 0;
        }
    }
</style>
<div class="layui-container fly-marginTop">
    <div class="fly-panel">
        <div class="fly-none">
            <h2><i class="iconfont icon-tishilian"></i></h2>
            <div class="notice">{$msg}</div>
        </div>
    </div>
</div>
{/block}