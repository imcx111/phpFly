<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class Nav extends Base {

    
    public function getCategoryNameAttr($value, $data) {
        return db('nav_cat')->where('id', $data['cid'])->value('title');
    }

    public function model_where() {

        if (request()->get('keyword'))
            $this->where('title', 'like', '%' . request()->get('keyword') . '%');


        if (request()->get('category'))
            $this->where('cid', request()->get('category'));


        $this->order('listorder asc,id desc');
        
        return $this;
    }

}
