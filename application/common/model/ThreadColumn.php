<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ThreadColumn extends Base {

    

    public function model_where() {

        if (request()->get('keyword'))
            $this->where('title', 'like', '%' . request()->get('keyword') . '%');

        $this->order('id desc');

        return $this;
    }

}
