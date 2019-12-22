<?php

namespace app\admin\controller;

class Index extends Admin {

    public function index() {

        $admin = admin_is_login();

        $this->assign('admin', $admin);

        return view();
    }

    public function home() {
        return view();
    }

}
