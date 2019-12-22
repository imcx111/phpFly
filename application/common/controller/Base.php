<?php

namespace app\common\controller;

use think\Controller;
use think\Loader;

class Base extends Controller {

    protected function _initialize() {
        parent::_initialize();

        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers:x-requested-with,content-type,tk-uid,tk-token');

        $this->assign('seo', [
            'title' => '',
            'keywords' => '',
            'description' => '',
        ]);

        

        
    }

}
