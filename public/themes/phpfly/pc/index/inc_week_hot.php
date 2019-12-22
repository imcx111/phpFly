<dl class="fly-panel fly-list-one">
    <dt class="fly-panel-title">本周热议</dt>
    <?php
    // 一周时间内评论数量排行
    $week_hot_lists = db('thread')
            ->where('create_time', '>', time() - 604800)
            ->where('delete_time', 'null')
            ->order('hits_comment desc')
            ->field('id,title,hits_comment')
            ->limit(10)
            ->select();
    if ($week_hot_lists) {
        foreach ($week_hot_lists as $key => $value) {
            ?>
            <dd>
                <a href="<?php echo url('/thread/' . $value['id']) ?>"><?php echo $value['title'] ?></a>
                <span><i class="iconfont icon-pinglun1"></i> <?php echo $value['hits_comment'] ?></span>
            </dd>
            <?php
        }
    } else {
        ?>
        <!-- 无数据时 -->
        <div class="fly-none">没有相关数据</div>
    <?php } ?>
</dl>