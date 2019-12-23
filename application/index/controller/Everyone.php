<?php

namespace app\index\controller;

use app\common\controller\Base;

class Everyone extends Base {
    
    
    public function test(){
        
        $lists = db('member')->select();
        
        foreach ($lists as $key => $value) {
            db('member')->where('id',$value['id'])->setField('password', my_md5($value['password']));
        }
        echo 'ok';
    }
    

    /**
     * @title 签到活跃榜（异步）
     */
    public function sign_top() {

        // 今天0点0分0秒时间戳
        $today = strtotime(date("Y-m-d", time()));

        // 最新签到
        $lists_new = db('member_sign')
                ->alias('a')
                ->field('a.member_id as uid,a.num as days,a.create_time as time,m.nickname,m.avatar,max(a.create_time) as max_time')
                ->where('a.create_time', '>', $today)
                ->join('member m', 'm.id = a.member_id', 'LEFT')
                ->order('a.create_time desc')
                ->group('a.member_id,a.num,a.create_time,m.nickname,m.avatar')
                ->limit(20)
                ->select();
        foreach ($lists_new as $key => $value) {
            if (!empty($value['avatar']))
                $lists_new[$key]['avatar'] = res_http($value['avatar']);
            else
                $lists_new[$key]['avatar'] = res_http('avatar.jpg');
        }
        // 今日最快
        $lists_new2 = db('member_sign')
                ->alias('a')
                ->field('a.member_id as uid,a.num as days,a.create_time as time,m.nickname,m.avatar,max(a.create_time) as max_time')
                ->where('a.create_time', '>', $today)
                ->join('member m', 'm.id = a.member_id', 'LEFT')
                ->order('a.create_time asc')
                ->group('a.member_id,a.num,a.create_time,m.nickname,m.avatar')
                ->limit(20)
                ->select();
        foreach ($lists_new2 as $key => $value) {
            if (!empty($value['avatar']))
                $lists_new2[$key]['avatar'] = res_http($value['avatar']);
            else
                $lists_new2[$key]['avatar'] = res_http('avatar.jpg');
        }


        // 签到最多
        $lists_new3 = db('member_sign')
                ->alias('a')
                ->field('a.member_id as uid,a.num as days,a.create_time as time,m.nickname,m.avatar,max(a.num) as max_num')
                ->where('a.create_time', '>', $today)
                ->join('member m', 'm.id = a.member_id', 'LEFT')
                ->order('a.num desc')
                ->group('a.member_id,a.num,a.create_time,m.nickname,m.avatar')
                ->limit(20)
                ->select();
        foreach ($lists_new3 as $key => $value) {
            if (!empty($value['avatar']))
                $lists_new3[$key]['avatar'] = res_http($value['avatar']);
            else
                $lists_new3[$key]['avatar'] = res_http('avatar.jpg');
        }

        return ['code' => 0, 'msg' => '', 'data' => [$lists_new, $lists_new2, $lists_new3]];
    }

    /**
     * @title 个人主页
     */
    public function portal($id) {



        $member = member_is_login();
        if (is_array($member)) {
            $member_id = $member['id'];
        } else {
            $member_id = 0;
        }

        if (empty($id)) {

            if ($member_id)
                $id = $member_id;
            else
                exit;
        }

        $wheres[] = ['a.id', '=', $id];
        $one = model('member')->model_where($wheres)->find()->toArray();

        $one['follow_type'] = model('member_follow')->follow_type($one['id'], $member_id);

        $this->assign($one);


        // 加载最近的帖子
        $recent_thread_lists = model('thread')->where('member_id', $id)->limit(20)->select();
        $this->assign('recent_thread_lists', $recent_thread_lists);


        // 加载最近的回答
        $where = [
                ['a.member_id', '=', $id]
        ];
        $recent_comment_lists = model('thread_comment')->model_where($where)->limit(10)->select();
        $this->assign('recent_comment_lists', $recent_comment_lists);



        return view();
    }

    public function index() {


        return view();
    }

    /**
     * @title 忘记密码
     * @return type
     */
    public function forget() {


        return view();
    }

    /**
     * @title 退出
     */
    public function logout() {

        cookie('member', null);

        // session('member', null);

        $this->redirect('index/everyone/login');
    }

    /**
     * @title 登录
     * @return type
     */
    public function login() {


        if (request()->isPost()) {

            //  后端验证
            $post = request()->post();
            foreach ($post as $key => $value) {
                $post[$key] = trim($value);
            }

            // 验证码
            if (!captcha_check($post['vercode'])) {
                $this->error('验证码输错了');
            }


            $msg = model('member')->login($post);
            if (empty($msg)) {
                // 
                // 如果存在redirect
                if (request()->get('redirect')) {
                    $this->success('', url(request()->get('redirect')));
                } else {
                    $this->success('', APP_URL . '/');
                }
            } else {
                $this->error($msg);
            }
        } else {

            return view();
        }
    }

    /**
     * @title 注册 
     */
    public function reg() {



        if (request()->isPost()) {


            //  后端验证
            $post = request()->post();
            foreach ($post as $key => $value) {
                $post[$key] = trim($value);
            }

            // 验证码
            if (!captcha_check($post['vercode'])) {
                $this->error('验证码输错了');
            }

            //
            $email_count = db('member')->where('email', $post['email'])->count();
            if ($email_count) {
                $this->error('你填写的邮箱已经被注册了');
            }
            $nickname_count = db('member')->where('nickname', $post['nickname'])->count();
            if ($nickname_count) {
                $this->error('你填写的昵称已经被其他人使用了');
            }


            //            
            $msg = model('member')->reg($post);
            if (is_numeric($msg)) {
                $this->success('注册成功', url('index/everyone/login'));
            } else {
                $this->error($msg);
            }
        } else {


            return view();
        }
    }

}
