<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ThreadComment extends Base {

    // 回复点赞
    public function thread_comment_zan($thread_comment_id, $member_id, $ok) {



        $data['member_id'] = $member_id;
        $data['thread_comment_id'] = $thread_comment_id;
        $data['create_time'] = time();


        Db::startTrans();
        try {

            if ($ok == 'true') {
                // 取赞
                db('thread_comment_hits_zan')->where('member_id', $member_id)->where('thread_comment_id', $thread_comment_id)->delete();
                db('thread_comment')->where('id', $thread_comment_id)->setDec('hits_zan');
            } else {

                db('thread_comment_hits_zan')->insert($data);
                db('thread_comment')->where('id', $thread_comment_id)->setInc('hits_zan');
            }



            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    /**
     * 帖子回复
     * @param type $post
     */
    public function thread_comment_add($post) {


        $data['thread_id'] = $post['thread_id'];
        $data['content'] = $post['content'];
        $data['member_id'] = session('member.id');
        $data['create_time'] = time();


        Db::startTrans();
        try {


            //
            db('thread_comment')->insertGetId($data);

            // 帖子的回复数要+1
            db('thread')->where('id', $data['thread_id'])->setInc('hits_comment');


            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where($where) {

        //field common keyword
        foreach ($where as $value) {
            $this->where($value[0], $value[1], $value[2]);
        }

        if (request()->get('keyword'))
            $this->where('a.content', 'like', '%' . request()->get('keyword') . '%');


        $this->join('member m', 'm.id = a.member_id', 'LEFT');
        $this->join('thread t', 't.id = a.thread_id', 'LEFT');

        $this->where('t.delete_time', 'null');

        $this->alias('a');

        $this->order('a.is_take desc,a.id desc');

        $this->field('a.*,m.id as member_id,m.nickname,m.avatar,m.sex,t.title,t.id as thread_id');

        return $this;
    }

}
