<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class Message extends Base {

    public function remove($message_id, $member_id) {


        Db::startTrans();
        try {

            if ($message_id) {

                $affect_row = db('message')->where('message_id', $message_id)->where('recv_id', $member_id)->delete();
                $affect_row2 = db('message_text')->where('id', $message_id)->delete();
            } else {
                
                $message_ids = db('message')->where('recv_id', $member_id)->column('message_id');
                
                $affect_row =db('message_text')->where('id', 'in' , $message_ids)->delete();
                $affect_row2 = db('message')->where('recv_id', $member_id)->delete();
                
             }

            if ($affect_row && $affect_row2) {
                
            } else {
                return '删除失败';
            }

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function send($message, $send_id, $recv_id) {


        $data['title'] = '';
        $data['message'] = $message;
        $data['create_time'] = time();

        Db::startTrans();
        try {

            $insert_id = db('message_text')->insertGetId($data);
            if ($insert_id) {

                $data2['send_id'] = $send_id;
                $data2['recv_id'] = $recv_id;
                $data2['message_id'] = $insert_id;
                $data2['status'] = 0;

                $insert_id2 = db('message')->insertGetId($data2);
                if (!$insert_id2) {
                    throw new Exception('消息发送失败');
                }
            } else {
                throw new Exception('消息生成失败');
            }



            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

}
