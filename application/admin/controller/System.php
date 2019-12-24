<?php

namespace app\admin\controller;

class System extends Admin {

    /**
     * @title 密码修改
     */
    public function password() {

        if (request()->isPost()) {
            $old_password = input('post.old_password');
            $password = input('post.password');
            $repassword = input('post.repassword');

            if ($password != $repassword)
                $this->error('两次输入的密码不一致');

            if ($old_password && $password) {

                if (my_md5($old_password) == db('system_user')->where('id', UID)->value('password')) {

                    if (db('system_user')->where('id', UID)->setField('password', my_md5($password)) !== FALSE) {
                        $this->success("密码修改成功");
                    }
                } else {
                    $this->error('旧密码有误');
                }
            }
        } else {
            return view();
        }
    }

    /**
     * @title 导航框架
     */
    public function config_iframe() {
        // 加载内容
        $this->assign('iframe_src', url('admin/system/config'));
        // 加载分类
        $this->assign('nodes', $this->_config_category());
        return $this->fetch('base:iframe');
    }

    /**
     * @title 配置列表
     */
    public function config() {
        $base_dir = APP_DIR . '/../application/extra/';

        if (request()->isPost()) {
            
            $category = input('post.category');
            $category_root = $base_dir . $category;
            if (is_file($category_root)) {

                $post = input('post.');
                $configs = $post['configs'];

                $title = $post['title'];

                if (empty($title)) {
                    $this->error('配置名称不能为空');
                }

                $array_str = '<?php ' . chr(10) . chr(10) . '/**' . chr(10) . ' * @title ' . $title . '' . chr(10) . ' */' . chr(10) . 'return [' . chr(10);

                foreach ($configs as $key => $value) {
                    if ($value['remark'])
                        $array_str .= chr(9) . "'" . $value['key'] . "' => '" . $value['value'] . "', //" . $value['remark'] . "" . chr(10);
                    else
                        $array_str .= chr(9) . "'" . $value['key'] . "' => '" . $value['value'] . "'," . chr(10);
                }

                $array_str = $array_str . '];';

                /*  【直接保存到文件】  */
                $check = file_put_contents($category_root, $array_str);
                if ($check > 0) {
                    $this->success("保存成功", url('config'));
                } else {
                    $this->error("内容为空");
                }
            } else {
                $this->error("请选择一个有效模板文件");
            }
        } else {
            /*  【当前的配置文件名称】  */
            $category = input('get.category', 'base.php');
            $this->assign('category', $category);
            /*  【通过当前name获取配置文件的内容】  */
            $config_content = file_get_contents($base_dir . $category);


            // 解析配置
            // preg_match_all("/\'?([^']*)\'? => \'(.*)\',\s*(\/\/[^\r\n]*)?/i", $config_content, $matches);
            //preg_match_all("/(['\"]?)(.*?)\1\s*=>\s*(['\"]?)(.*?)\3,(\/\/)?([^\r\n]*)/i", $config_content, $matches);
            preg_match_all("/\s*[\'\"]?(.*?)[\'\"]?\s*=>\s*[\'\"]?(.*?)[\'\"]?,(\s*\/\/)?([^\r\n]*)/", $config_content, $matches);
            // dd($matches);
            $this->assign('lists', $matches);

            preg_match('/\@title\s*([^\r\n]*)?/i', $config_content, $matches2);
            $title = isset($matches2[1]) ? $matches2[1] : $category;
            $this->assign('title', $title);

            //$lists = parse_config_cnt($content_2);
            $this->assign('config_content', $config_content);
            return $this->fetch();
        }
    }

    public function _config_category() {
        $base_dir = APP_DIR . '/../application/extra/';
        $file_list = my_scan_dir($base_dir . "*.php");
        $navs = array();
        /*  【通过文件名，依次解析title】  */
        foreach ($file_list as $key => $value) {
            $content = file_get_contents($base_dir . $value);
            $array = parse_config_title($content);
            if ($array) {
                $navs[$value] = $array;
            }
        }
        $types = [];
        foreach ($navs as $key => $value) {
            $types[] = [
                'name' => $value,
                'id' => $key,
            ];
        }
        $parent = [
            'id' => '',
            'name' => '所有',
            'spread' => true,
            'children' => $types
        ];
        return json_encode($parent);
    }

}
