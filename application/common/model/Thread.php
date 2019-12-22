<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;
use traits\model\SoftDelete;

class Thread extends Base {
    
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    

    public function thread_edit($post) {

        $id = $post['id'] ?? 0;

        $data['cid'] = $post['cid'] ?? '';
        $data['title'] = $post['title'] ?? '';
        $data['content'] = $post['content'] ?? '';
        $data['points'] = $post['points'] ?? '';
        $data['update_time'] = time();
        $data['member_id'] = session('member.id');

        if ($id) {

            return db('thread')->where('id', $id)->update($data);
        } else {

            return 'ID缺失';
        }
    }

    public function thread_add($post) {


        $data['cid'] = $post['cid'] ?? '';
        $data['title'] = $post['title'] ?? '';
        $data['content'] = $post['content'] ?? '';
        $data['points'] = $post['points'] ?? '';
        $data['status'] = 0;
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['member_id'] = session('member.id');

         

        // 
        $insert_id = db('thread')->insertGetId($data);

        return $insert_id;
    }

    
    
    
    public function model_where($wheres = []) {

        foreach ($wheres as $key => $value) {
            $this->where($value[0], $value[1], $value[2]);
        }

     


        if (request()->get('keyword'))
            $this->where('title', 'like', '%' . request()->get('keyword') . '%');


        $this->join('member m', 'm.id = a.member_id', 'LEFT');
        $this->join('member_ident mi', 'mi.member_id = m.id', 'LEFT');
        $this->join('thread_column tc', 'tc.id = a.cid', 'LEFT');
       // $this->join('member m2', 'm2.id = tc.member_id', 'LEFT');

        $this->alias('a');

        $this->order('a.top desc,a.id desc');

        $this->field('a.*,m.id as member_id,m.nickname,m.avatar,m.sex,m.vip,m.ident,mi.identification,tc.title as column_title');


        return $this;
    }

}
