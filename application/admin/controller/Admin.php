<?php

namespace app\admin\controller;

use app\common\controller\Base;

class Admin extends Base {

    protected function _initialize() {
        parent::_initialize();

        // 后台登录的判断         
        $admin = admin_is_login();
        $admin_id = (is_array($admin)) ? $admin['id'] : -1;
        define('UID', $admin_id);

        if (UID < 0) {
            $this->redirect(url('admin/everyone/login'));
            exit;
        }
    }

    /**
     * @title 排序 
     */
    public function listorders($table = '') {

        if ($table) {
            $ids = input('post.listorder/a');
            foreach ($ids as $key => $r) {
                $data['listorder'] = $r;
                db($table)->where('id', $key)->update($data);
            }
            $this->success('排序完成');
        }
    }

}
