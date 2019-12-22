<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class MemberFollow extends Base {

    protected $member_fiedls = 'm.id,m.nickname,m.avatar,m.sex,m.signature,m.vip,m.hitsfans,m.hitsfollows,m.hitsthreads,m.create_time,m.city,m.points';

    /**
     * @title 关注的人
     * @param type $member_id
     */
    public function follows_where($member_id) {

        $this->alias('mf');
        $this->join('member m', 'm.id = mf.follow_who', 'LEFT');
        $this->where('mf.who_follow', '=', $member_id);
        $this->field($this->member_fiedls);

        return $this;
    }

    /**
     * @title 我的粉丝
     * @param type $member_id
     */
    public function fans_where($member_id) {

        $this->alias('mf');
        $this->join('member m', 'm.id = mf.who_follow', 'LEFT');
        $this->where('mf.follow_who', '=', $member_id);
        $this->field($this->member_fiedls);

        return $this;
    }

    /**
     * @title 互相关注
     * @param type $member_id
     * 暂时用不上
     */
    public function friends_where($member_id) {

        $this->alias('mf');
        $this->join('member_follow mf2', 'mf2.follow_who = mf.who_follow');
        $this->join('member m', 'm.id = mf.follow_who', 'LEFT');
        $this->where('mf.follow_who = mf2.who_follow');
        $this->where('mf.who_follow', '=', $member_id);
        $this->field($this->member_fiedls);

        return $this;
    }

    /**
     * @title 返回关注的类型
     * @start_id 被关注的人
     * @follow_id 关注者
     * 1偶像2粉丝3好友 
     */
    public function follow_type($star_id, $follow_id) {

        // 关注状态
        $check_1 = $this->where('follow_who', $follow_id)
                ->where('who_follow', $star_id)
                ->count();

        $check_2 = $this->where('follow_who', $star_id)
                ->where('who_follow', $follow_id)
                ->count();

        if ($check_1 && $check_2) {
            $followtype = 3;
        } elseif ($check_1) {
            $followtype = 2;
        } elseif ($check_2) {
            $followtype = 1;
        } else {
            $followtype = 0;
        }

        return $followtype;
    }

   

}
