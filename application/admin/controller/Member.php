<?php

namespace app\admin\controller;

class Member extends Admin {
    
    
    /**
     * @title 推荐/置顶/分类转移
     */
    public function set_field() {

        $ids = input('post.ids');
        $field = input('get.field');
        $value = input('get.value');

        empty($field) && $this->error('更新的字段为空');

        $ids_arr = explode(',', $ids);
        $ids_arr = array_filter($ids_arr);

        if (empty($ids_arr)) {
            $this->error('选择要操作的数据');
        }

        $affect_rows = db('member')->where('id', 'in', $ids)->setField($field, $value);

        if ($affect_rows) {
            $this->success('操作成功');
        } else {
            $this->error('没有任何更新');
        }
    }

    /**
     * @title 会员列表
     * @return type
     */
    public function index() {

        $lists = model('member')->model_where()->paginate(20, false, ['query' => request()->get()]);
        $this->assign('pager', $lists->render());
        $this->assign('lists', $lists);


        builder('list')
                ->addItem('id', '#')
                ->addItem('email', '账号')
                ->addItem('nickname', '昵称')
                ->addItem('avatar', '头像', 'image')
                ->addItem('sex', '性别')
                ->addItem('vip', 'VIP')
                ->addItem('identification', '认证信息')
                ->addItem('create_time', '注册')
                ->addItem('update_time', '更新')
                ->addAction('编辑', 'edit', '<i class="layui-icon layui-icon-edit"></i>')
                ->addAction('删除', 'delete', '<i class="layui-icon layui-icon-delete"></i>', 'ajax-get confirm layui-btn-danger')
                ->addAction('认证', 'ident', '<i class="layui-icon layui-icon-vercode"></i>', 'openbox layui-btn-success')
                ->build();


        return view();
    }

    /**
     * @title 前台会员认证
     */
    public function ident($id) {


        empty($id) && $this->error('参数缺失');


        // 加载认证信息

        if (request()->isPost()) {


            //
            $post = request()->post();

            //
            $msg = model('member')->ident($post, $id);
            if (empty($msg)) {
                $this->success('更新成功');
            } else {
                $this->success('更新失败');
            }
        } else {


            $wheres = [
                    ['a.id', '=', $id]
            ];
            $one = model('member')->model_where($wheres)->find()->toArray();
            
            $this->assign($one);

            return view();
        }
    }

    public function json() {

        return model('member')->json();
    }

}
