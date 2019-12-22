<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\controller\Admin;
use think\Db;

class Nav extends Admin {

    /**
     * @title 导航框架
     */
    public function iframe() {
        // 加载内容
        $this->assign('iframe_src', url('admin/nav/index'));
        // 加载分类
        $this->assign('nodes', model('nav_cat')->json_category('title'));
        return $this->fetch('base:iframe');
    }

    /**
     * @title 导航链接的选取
     */
    public function href_select() {

        $type = input('get.type', 'article_cat');
        // 分类
        $lists = [];
        if ($type == 'article_cat') {

            $lists = model('article_cat')->model_where()->lists_tree();
            foreach ($lists as $key => $value) {
                $lists[$key]['href'] = 'index/index/lists?id=' . $value['id'];
            }
        } elseif ($type == 'article') {

            $lists = model('article')->model_where()->paginate(5, false, ['query' => request()->get()]);
            foreach ($lists as $key => $value) {
                $lists[$key]['href'] = 'index/index/views?id=' . $value['id'];
            }
        } else if ($type == 'goods_cat') {

            $lists = model('goods_cat')->model_where()->lists_tree();
            foreach ($lists as $key => $value) {
                $lists[$key]['href'] = 'index/index/lists_goods?id=' . $value['id'];
            }
        } else if ($type == 'goods') {

            $lists = model('goods')->model_where()->paginate(5, false, ['query' => request()->get()]);
            foreach ($lists as $key => $value) {
                $lists[$key]['href'] = 'index/index/views_goods?id=' . $value['id'];
            }
        }

        $this->assign('lists', $lists);

        if ($type == 'article' || $type == 'goods')
            $this->assign('pages', $lists->render());
        else
            $this->assign('pages', '');

        return view();
    }

    /**
     * @title 导航列表
     */
    public function index() {

        $cid = input('get.category', null);
        session('category', $cid);


        $lists = model('nav')->model_where()->select();


        $this->assign('lists', $lists);

        // 分类转移 
        $this->assign('category_select', model('nav_cat')->column('id,title'));
        builder('list')
                ->addItem('id', '#')
                ->addItem('category_name', '分类')
                ->addSortItem('listorder', '排序', 'nav')
                ->addItem('title', '标题')
                ->addItem('image', '图片', 'image')
                ->addItem('href', '链接')
                ->addAction('编辑', 'edit', '<i class="layui-icon layui-icon-edit"></i>')
                ->addAction('删除', 'delete', '<i class="layui-icon layui-icon-delete"></i>', 'ajax-get confirm layui-btn-danger')
                ->build();
        return view();
    }

    /**
     * @title 导航添加
     */
    public function add() {

        if (request()->isPost()) {
            $post = request()->post();

            if (db('nav')->insert($post) !== FALSE) {
                $this->success('', url('index', ['category' => session('category')]));
            } else {
                $this->error('添加失败');
            }
        } else {
            builder('form')
                    ->addItem('cid', 'select', '分类<font color="red">*</font>', model('nav_cat')->column('id,title'), 'lay-verify="required"')
                    ->addItem('title', 'input', '标题<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('image', 'image', '图片', '', '', '', '200x100')
                    ->addItem('href', 'input', '链接', 'href_select')
                    ->addItem('target', 'select', '打开方式', ['_self' => '当前页', '_blank' => '新开页面'])
                    ->addItem('icon', 'input', '图标')
                    ->addItem('description', 'textarea', '描述')
                    ->addItem('expire_time', 'datetime', '过期时间')
                    ->build(['cid' => session('category')]);
            return view();
        }
    }

    /**
     * @title 导航编辑
     */
    public function edit($id) {

        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {
            $post = request()->post();

            if (db('nav')->where('id', $id)->update($post) !== FALSE) {
                $this->success('', url('index', ['category' => session('category')]));
            } else {
                $this->error('添加失败');
            }
        } else {

            $one = db('nav')->where('id', $id)->find();
            builder('form')
                    ->addItem('cid', 'select', '分类', model('nav_cat')->column('id,title'))
                    ->addItem('title', 'input', '标题<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('image', 'image', '图片', '', '', '', '200x100')
                    ->addItem('href', 'input', '链接', 'href_select')
                    ->addItem('target', 'select', '打开方式', ['_self' => '当前页', '_blank' => '新开页面'])
                    ->addItem('icon', 'input', '图标')
                    ->addItem('description', 'textarea', '描述')
                    ->addItem('expire_time', 'datetime', '过期时间')
                    ->build($one);
            return view();
        }
    }

    /**
     * @title 导航删除
     */
    public function delete($id) {

        empty($id) && $this->error('参数不能为空');
        if (db('nav')->where('id', $id)->delete() !== FALSE) {
            $this->success('', url('index'));
        } else {
            $this->error('删除失败');
        }
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

        $affect_rows = db('nav')->where('id', 'in', $ids)->setField($field, $value);

        if ($affect_rows) {
            $this->success('操作成功');
        } else {
            $this->error('没有任何更新');
        }
    }

    /**
     * @title 导航分类
     * @return type
     */
    public function category() {

        $lists = model('nav_cat')->order('listorder, id desc')->select();

        $this->assign('lists', $lists);
        builder('list')
                ->addItem('id', '#')
                ->addSortItem('listorder', '排序', 'nav_cat')
                ->addItem('title', '名称')
                ->addAction('编辑', 'category_edit', '<i class="layui-icon layui-icon-edit"></i>')
                ->addAction('删除', 'category_delete', '<i class="layui-icon layui-icon-delete"></i>', 'ajax-get confirm layui-btn-danger')
                ->build();
        return view();
    }

    /**
     * @导航分类添加
     */
    public function category_add() {

        if (request()->isPost()) {
            $post = request()->post();

            if (db('nav_cat')->insert($post) !== FALSE) {
                $this->success('', url('category'));
            } else {
                $this->error('添加失败');
            }
        } else {
            builder('form')
                    ->addItem('title', 'input', '标题<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('alias', 'input', '别名<font color="red">*</font>', '', 'lay-verify="required"', '', '用于前端调用')
                    ->build();
            return view();
        }
    }

    /**
     * @title 导航分类编辑
     */
    public function category_edit($id) {

        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {
            $post = request()->post();

            if (db('nav_cat')->where('id', $id)->update($post) !== FALSE) {
                $this->success('', url('category'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $one = db('nav_cat')->where('id', $id)->find();
            builder('form')
                    ->addItem('title', 'input', '标题<font color="red">*</font>', '', 'lay-verify="required"')
                    ->addItem('alias', 'input', '别名<font color="red">*</font>', '', 'lay-verify="required"', '', '用于前端调用')
                    ->build($one);
            return view();
        }
    }

    /**
     * @title 导航分类删除
     */
    public function category_delete($id) {

        empty($id) && $this->error('参数不能为空');

        if (db('nav_cat')->where('id', $id)->delete() !== FALSE) {
            $this->success('', url('category'));
        } else {
            $this->error('删除失败');
        }
    }

}
