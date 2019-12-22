<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class SystemUser extends Base {

    /**
     * @title 注册
     * @param type $post
     * @return type
     */
    public function reg($post) {

        $data['account'] = $post['account'] ?? '';
        $data['nickname'] = $post['nickname'] ?? '';
        $data['password'] = $post['password'] ?? '';
        $data['create_time'] = time();
        $data['update_time'] = time();


        $insert_id = db('system_user')->insertGetId($data);

        return $insert_id;
    }

    /**
     * @title 登录
     */
    public function login($post) {

        $account = $post['account'] ?? '';
        $password = $post['password'] ?? '';

        //echo my_md5($password); exit;

        $one = db('system_user')
                ->where('account', $account)
                ->where('password', my_md5($password))
                ->field('id,account,nickname')
                ->find();

        if ($one) {

            // 保存session
            session('admin_session_sign', data_auth_sign($one));

            // 保存cookie
            cookie('admin', authcode(json_encode($one), 'ENCODE', 'PHPFLY'));
        } else {
            return '不存在的用户';
        }
    }

    public function model_where() {



        if (request()->get('keyword'))
            $this->where('nickname', 'like', '%' . request()->get('keyword') . '%');

        $this->order('id desc');

        return $this;
    }

}
