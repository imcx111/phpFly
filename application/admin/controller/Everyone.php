<?php

namespace app\admin\controller;

class Everyone extends \app\common\controller\Base {

    
    
    
     /**
     * @title 退出
     */
    public function logout() {
        
        cookie('admin', null);
        
        session('admin', null);

        $this->success('退出成功', url('admin/everyone/login'));
    }

    /**
     * @title 登录
     * @return type
     */
    public function login() {


        if (request()->isPost()) {

            //  后端验证
            $post = request()->post();


            $msg = model('system_user')->login($post);
            if (empty($msg)) {
                // 
                $this->success('登录成功', url('admin/index/index'));
            } else {
                $this->error($msg);
            }
        } else {

            return view();
        }
    }
    
    
    

}
