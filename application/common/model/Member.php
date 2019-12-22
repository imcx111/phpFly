<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class Member extends Base {

    public function json() {

        if (request()->get('keyword')) {
            $this->where('py.py|nickname|email', 'like', '%' . request()->get('keyword') . '%');
        }

        $this->join('pinyin py', 'CONV(HEX(LEFT(CONVERT(nickname USING GBK),1)),16,10) BETWEEN py.begin AND py.end', 'LEFT');

        $lists = $this->field('id,nickname as label,avatar as image')->limit(10)->select();
        foreach ($lists as $key => $value) {
            if ($value['image'])
                $lists[$key]['image'] = APP_HOST . img_resize($value['image'], 50, 50);
            else
                $lists[$key]['image'] = '';
        }
        return json($lists);
    }

    /**
     * @title 前台会员认证
     * @param type $post
     */
    public function ident($post, $id) {


        $data['member_id'] = $id;
        $data['identification'] = $post['identification'];
        $data['update_time'] = time();

        Db::startTrans();
        try {

            $count = db('member_ident')->where('member_id', $id)->count();
            if ($count) {

                db('member_ident')->where('member_id', $id)->setField('identification', $data['identification']);
            } else {

                db('member_ident')->insertGetId($data);
            }


            db('member')->where('id', $id)->setField('ident', $post['ident']);

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    // 
    public function follow_add($member_id, $member_id_who) {


        //检查是否已经关注过，如果已关注，再次操作为 取关            
        $wheres = [
            'follow_who' => ['=', $member_id],
            'who_follow' => ['=', $member_id_who],
        ];

        //检查是否已经赞过了
        $count = model('member_follow')->where($wheres)->count();
        if ($count) {

            //关注过的话就取关 - 取关
            $affect_rows = model('member_follow')->where($wheres)->delete();

            if ($affect_rows) {


                //粉丝的关注数 -1
                $this->_reduce('follows', $member_id_who);
                //偶像的粉丝数 -1
                $this->_reduce('fans', $member_id);

                return 0;
            } else {

                return '取关失败';
            }
        } else {



            $data['follow_who'] = $member_id;
            $data['who_follow'] = $member_id_who;
            $data['create_time'] = time();

            $insert_id = db('member_follow')->insertGetId($data);
            if ($insert_id) {


                //粉丝的关注数 +1
                $this->_increase('follows', $member_id_who);
                //偶像的粉丝数 +1
                $this->_increase('fans', $member_id);


                //给偶像发一条消息
                //插入一条通知
                $nickname = model('member')->where('id', $member_id_who)->value('nickname');

                model('message')->send('关注了你', $member_id_who, $member_id);

                return 1;
            } else {
                return '关注失败';
            }
        }
    }

    /**
     * @title 用户的粉丝和偶像的减1
     * @param type $id
     */
    public function _reduce($type, $id) {
        switch ($type) {
            case 'fans': model('member')->where('id', $id)->setDec('hitsfans');
                break;
            case 'follows': model('member')->where('id', $id)->setDec('hitsfollows');
                break;
        }
    }

    /**
     * @title 用户的粉丝和偶像的加1
     * @param type $id
     */
    public function _increase($type, $id) {
        switch ($type) {
            case 'fans': model('member')->where('id', $id)->setInc('hitsfans');
                break;
            case 'follows': model('member')->where('id', $id)->setInc('hitsfollows');
                break;
        }
    }

    /**
     * @title 修改密码
     * @param type $post
     */
    public function password_reset($post, $id) {

        $old_password = $post['old_password'];

        $count = db('member')->where('id', $id)->where('password', $old_password)->count();
        if (empty($count)) {
            return '旧密码不正确';
        }

        return db('member')->where('id', $id)->setField('password', $post['password']);
    }

    /**
     * @title 更新个人资料
     */
    public function member_update($post, $id) {


        $data['email'] = $post['email'] ?? '';
        $data['nickname'] = $post['nickname'] ?? '';
        $data['city'] = $post['city'] ?? '';
        $data['sex'] = $post['sex'] ?? '';
        $data['signature'] = $post['signature'] ?? '';

        $data['update_time'] = time();

        return model('member')->save($data, ['id' => $id]);
    }

    /**
     * @title 注册
     * @param type $post
     * @return type
     */
    public function reg($post) {

        $data['email'] = $post['email'];
        $data['nickname'] = $post['nickname'];
        $data['password'] = my_md5($post['password']);
        $data['create_time'] = time();
        $data['update_time'] = time();

        $insert_id = db('member')->insertGetId($data);

        return $insert_id;
    }

    /**
     * @title 登录
     */
    public function login($post) {

        $email = $post['email'] ?? '';
        $password = $post['password'] ?? '';

        $member = db('member')
                ->where('email', $email)
                ->where('password', my_md5($password))
                ->field('id,email,nickname,avatar,sex')
                ->find();

        if ($member) {
            $this->session_update($member['id']);
        } else {
            return '登录失败';
        }
    }

    /**
     * @title 刷新会话
     * 当修改了个人资料后
     * 账号 昵称 头像 性别 VIP 积分 认证信息
     * 上面的每一项如果发生了改变，都必须刷新SESSION，否则强制退出
     */
    public function session_update($member_id) {

        $member = db('member')
                ->alias('a')
                ->where('a.id', $member_id)
                ->join('member_ident mi', 'mi.member_id = a.id', 'LEFT')
                ->field('a.id,a.email,a.nickname,a.avatar,a.sex,a.vip,a.points,mi.identification')
                ->find();

        // 保存session
        session('member_session_sign', data_auth_sign($member));
        //
        session('member', $member);
        // 保存cookie
        cookie('member', authcode(json_encode($member), 'ENCODE', 'PHPFLY'));
        //
    }

    public function model_where($wheres = []) {

        foreach ($wheres as $value) {
            $this->where($value[0], $value[1], $value[2]);
        }

        if (request()->get('start'))
            $this->where('a.create_time', '>', strtotime(request()->get('start')));

        if (request()->get('end'))
            $this->where('a.create_time', '<', strtotime(request()->get('end')));

        if (request()->get('keyword'))
            $this->where('a.email|a.nickname', 'like', '%' . request()->get('keyword') . '%');


        $this->join('member_ident mi', 'mi.member_id = a.id', 'LEFT');

        $this->alias('a');

        $this->field('a.*,mi.identification');

        $this->order('a.id desc');

        return $this;
    }

}
