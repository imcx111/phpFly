<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\index\controller;

use app\common\controller\Base;
use think\Session;

class Message extends Base {

    protected function _initialize() {
        parent::_initialize();

        // 前台登录的判断         
        $member = member_is_login();
        $member_id = (is_array($member)) ? $member['id'] : -1;
        define('MID', $member_id);

        if (MID < 0) {
            //
            $server = request()->server();
            $redirect = $server['PATH_INFO'] ?? '';

            // $this->redirect(url('index/everyone/login', ['redirect' => $redirect]));
            $this->error('请登录', url('index/everyone/login', ['redirect' => $redirect]));
            exit;
        }
    }

    /**
     * @title 单条消息删除
     */
    public function remove() {

        $message_id = request()->post('message_id');

        //
        $msg = model('message')->remove($message_id, MID);
        if (empty($msg)) {
            return ['code' => 0, 'msg' => 'success', 'data' => 1];
        } else {
            return ['code' => 1, 'msg' => 'error', 'data' => 1];
        }
    }

    /**
     * @title 我的消息列表
     */
    public function lists() {

        $lists = db('message')
                ->alias('a')
                ->join('message_text mt', 'mt.id = a.message_id', 'LEFT')
                ->join('member member', 'member.id = a.send_id', 'LEFT')
                ->where('a.recv_id', MID)
                ->order('a.id desc')
                ->limit(20)
                ->field('a.message_id,mt.message,mt.create_time,member.nickname,a.send_id')
                ->select();
        
        // 对消息的一些处理
        $lists2 = [];
        foreach ($lists as $key => $value) {
            
            //             
           $lists2[$key]['id'] = $value['message_id'];
           $lists2[$key]['content'] = '<a href="'.url('/portal/'.$value['send_id']).'" target="_blank">'.$value['nickname'].'</a>' .'：'. $value['message'];
           $lists2[$key]['time'] = date('Y/m/d H:i:s', $value['create_time']);
           
        }
        

        return ['code' => 0, 'msg' => 'success', 'rows' => $lists2];
    }

    /**
     * @title 消息发送
     */
    public function send() {

        $message = request()->post('message');
        $recv_id = request()->post('recv_id');

        $msg = model('message')->send($message, MID, $recv_id);
        if (empty($msg)) {

            return ['code' => 0, 'msg' => 'success', 'data' => $msg];
        } else {

            return ['code' => 1, 'msg' => $msg];
        }

        //
    }

    /**
     * @title 异步加载该用户未读消息数
     * @return type
     */
    public function nums() {
        $count = db('message')->where('recv_id', MID)->where('status', 0)->count();
        return ['code' => 0, 'msg' => 'success', 'count' => $count];
    }

    /**
     * @title 把所有消息设置成已读
     */
    public function read() {
        $affect_rows = db('message')->where('recv_id', MID)->where('status', 0)->setField('status', 1);
        return ['code' => 0, 'msg' => 'success', 'data' => $affect_rows];
    }

}
