<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class MemberWishThread extends Base {

    public function model_where($wheres = []) {



        foreach ($wheres as $value) {
            $this->where($value[0], $value[1], $value[2]);
        }

        $this->join('thread t', 't.id = a.thread_id');

        $this->field('a.*,t.title');

        $this->alias('a');

        return $this;
    }

}
