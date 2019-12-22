<?php

namespace app\common\model;

use think\Model;
use utils\Tree;
use think\Cookie;

class Base extends Model {

    /**
     * 一个字典
     */
    public function dict() {

        return $this->column('title', 'id');
    }

    /**
     * @title 用于树型select赋值
     */
    public function lists_select_tree($where = NULL, $order = 'listorder asc,id asc') {
        $result = $this->where($where)->order($order)->column('id,pid,title');
        $tree = new Tree($result);
        $lists = $tree->getArray(0);
        $lists2 = array();
        foreach ($lists as $key => $value) {
            $lists2[$value['id']] = $value['title'];
        }
        return $lists2;
    }

    /**
     * @title 树型列表
     */
    public function lists_tree($where = NULL, $order = 'listorder asc,id asc') {
        $lists = $this->where($where)->order($order)->select();
        $lists = array_out($lists);
        $tree = new Tree($lists);
        return $tree->getArray(0);
    }

    /**
     * @title 树型分类
     */
    public function json_tree() {
        $lists = $this->all(function($query) {
            $query->field('id,title,pid')->order('id', 'asc');
        });
        $lists = array_out($lists);
        $tree = new Tree($lists);
        $array = $tree->get_tree_array(0);
        $array_json = json_encode($array);
        $array_json = str_replace('title', 'name', $array_json);
        $parent = [
            'id' => 0,
            'name' => '所有分类',
            'spread' => true,
            'children' => json_decode($array_json, true)
        ];
        return json_encode($parent);
    }

    /**
     * @title iframe分类
     */
    public function json_category($name = 'name', $search = NULL) {
        $types = [];
        $lists = $this->where($search)->select();
        foreach ($lists as $key => $value) {
            $types[$key] = [
                'name' => $value[$name],
                'id' => $value['id']
            ];
        }
        $parent = [
            'id' => 0,
            'name' => '所有分类',
            'spread' => true,
            'children' => $types
        ];
        return json_encode($parent);
    }

}
