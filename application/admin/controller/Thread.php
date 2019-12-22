<?php

namespace app\admin\controller;

class Thread extends Admin {

    /**
     * @title 文章框架
     */
    public function iframe() {
        // 加载内容
        $this->assign('iframe_src', url('admin/thread/index'));
        // 加载分类
        $this->assign('nodes', model('thread_column')->json_category('title'));
        return $this->fetch('base:iframe');
    }
    
    
    
    public function delete($id){
        
        empty($id) && $this->error('帖子不存在');
        
        $affect_row = db('thread')->where('id', $id)->setField('delete_time', time());
        if($affect_row){
            $this->success('');
        }else{
            $this->error('删除失败');
        }
        
    }

    /**
     * @title 帖子列表
     * @return type
     */
    public function index() {



        $cid = input('get.category', NULL);
        session('category', $cid);


        $wheres = [
                ['a.cid', '=', $cid]
        ];
        $lists = model('thread')->model_where($wheres)->paginate(10, false, ['query' => request()->get()]);

        $this->assign('lists', $lists);
        $this->assign('pager', $lists->render());


        // 分类转移 
        // $this->assign('category_select', model('article_cat')->lists_select_tree());
        // 构建列表
        builder('list')
                ->addItem('id', '#')
                ->addItem('column_title', '分类')
                ->addItem('title', '标题')
                ->addItem('nickname', '作者')
                ->addItem('create_time', '时间')
                ->addItem('top', '置顶')
                ->addItem('recommend', '推荐')
                ->addAction('删除', 'delete', '<i class="layui-icon layui-icon-delete"></i>', 'ajax-get confirm layui-btn-danger')
                ->build();


        return view();
    }

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

        $affect_rows = db('thread')->where('id', 'in', $ids)->setField($field, $value);

        if ($affect_rows) {
            $this->success('操作成功');
        } else {
            $this->error('没有任何更新');
        }
    }

    /**
     * @title 论坛栏目管理员
     * 弹出打开
     * @param type $id
     */
    public function column_manager($id) {


        // 加载所有会员
        $lists = model('thread_column_member')->model_where()->select();

        $this->assign('lists', $lists);

        return view();
    }

    /**
     * @title 新增论坛管理员
     */
    public function column_manager_add() {

        $thread_column_id = request()->post('thread_column_id');
        $member_id = request()->post('member_id');

        $data = [
            'member_id' => $member_id,
            'column_id' => $thread_column_id,
            'create_time' => time()
        ];
        db('thread_column_member')->insertGetId($data);

        $this->redirect(url('admin/thread/column_manager', ['id' => $thread_column_id]));
    }

    /**
     * @title 移除管理员
     */
    public function column_manager_remove($id) {

        if (empty($id)) {
            $this->error('参数不完整');
        }

        db('thread_column_member')->where('id', $id)->delete();

        $this->success('');
    }

    /**
     * @title 论坛栏目
     * @return type
     */
    public function column() {


        $lists = model('thread_column')->model_where()->paginate(10, false, ['query' => request()->get()]);
        $this->assign('page', $lists->render());
        $this->assign('lists', $lists);


        builder('list')
                ->addItem('id', '#')
                ->addItem('title', '名称')
                ->addItem('alias', '别名')
                ->addItem('publish_type', '发布权限')
                ->addItem('join_type', '浏览权限')
                ->addAction('编辑', 'column_edit', '<i class="layui-icon layui-icon-edit"></i>')
                ->addAction('删除', 'column_delete', '<i class="layui-icon layui-icon-delete"></i>', 'ajax-get confirm layui-btn-danger')
                ->addAction('管理员', 'column_manager', '<i class="layui-icon layui-icon-group"></i>', 'openbox layui-btn-success')
                ->build();

        return view();
    }

    /**
     * @title 批量删除栏目
     * 
     */
    public function column_delete() {


        $id = input('get.id', 0);
        empty($id) && $this->error('没有选择任何数据');

        // 如果栏目下有帖子也删除不了
        $thread_list = db('thread')->where('cid', $id)->select();
        if (count($thread_list) > 0) {
            $this->error('栏目下存在帖子，无法删除 ');
        }

        $affect_rows = db('thread_column')->where('id', $id)->delete();
        if ($affect_rows) {
            $this->success('', url('admin/thread/column', ['category' => session('category')]));
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * @title 栏目编辑
     * 
     */
    public function column_edit($id) {

        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {

            $data['title'] = request()->post('title');
            $data['alias'] = request()->post('alias');
            
            $data['publish_type'] = request()->post('publish_type');
            $data['join_type'] = request()->post('join_type');
            $data['vip_limit'] = request()->post('vip_limit');
            $data['points_limit'] = request()->post('points_limit');


            $affect_rows = db('thread_column')->where('id', $id)->update($data);
            if (is_numeric($affect_rows)) {
                $this->success('', 'admin/thread/column');
            } else {
                $this->error('添加失败');
            }
        } else {

            $one = db('thread_column')->where('id', $id)->find();           
            $this->assign($one);            

            builder('form')
                    ->addItem('title', 'input', '标题<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('alias', 'input', '别名<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('publish_type', 'radio', '发贴权限', [0 => '所有人可发', 1 => '管理员可发'])
                    ->addItem('join_type', 'select', '浏览权限', [0 => '所有人可进', 1 => '按VIP级别进入', 2 => '按积分值进入'], 'lay-filter="join_type"')
                    ->build($one);

            return view();
        }
    }

    /**
     * @title 论坛栏目添加 
     * @return type
     */
    public function column_add() {


        if (request()->isPost()) {


            // 验证
            $post = request()->post();

            $data['title'] = request()->post('title');
            $data['alias'] = request()->post('alias');
            
            $data['publish_type'] = request()->post('publish_type');
            $data['join_type'] = request()->post('join_type');
            $data['vip_limit'] = request()->post('vip_limit');
            $data['points_limit'] = request()->post('points_limit');

            $insert_id = db('thread_column')->insertGetId($data);

            if (is_numeric($insert_id)) {
                $this->success('', 'admin/thread/column');
            } else {
                $this->error('添加失败');
            }
        } else {


             

            builder('form')
                    ->addItem('title', 'input', '标题<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('alias', 'input', '别名<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('publish_type', 'radio', '发贴权限', [0 => '所有人可发', 1 => '管理员可发'])
                    ->addItem('join_type', 'select', '浏览权限', [0 => '所有人可进', 1 => '按VIP级别进入', 2 => '按积分值进入'], 'lay-filter="join_type"')
                    ->build(['join_type' => 0]); // 默认值



            return view();
        }
    }

}
