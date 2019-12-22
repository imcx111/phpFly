<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
use app\common\builder\Builder;

/**
  +----------------------------------------------------------
 * UBB 解析
  +----------------------------------------------------------
 * @return string
  +----------------------------------------------------------
 */
function null_filter($arr) {
    foreach ($arr as $key => &$val) {
        if (is_array($val)) {
            $val = null_filter($val);
        } else {
            if ($val === null) {
                unset($arr[$key]);
            }
        }
    }
    return $arr;
}

/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转地址
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function ShowMsg($msg, $gourl, $onlymsg = 0, $limittime = 0) {
    if (empty($GLOBALS['cfg_plus_dir']))
        $GLOBALS['cfg_plus_dir'] = '..';

    $htmlhead = "<html>\r\n<head>\r\n<title>提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
    $htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>" . "\r\n<center>\r\n<script>\r\n";
    $htmlfoot = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

    $litime = ($limittime == 0 ? 1000 : $limittime);
    $func = '';

    if ($gourl == '-1') {
        if ($limittime == 0)
            $litime = 5000;
        $gourl = "javascript:history.go(-1);";
    }

    if ($gourl == '' || $onlymsg == 1) {
        $msg = "<script>alert(\"" . str_replace("\"", "“", $msg) . "\");</script>";
    } else {
        //当网址为:close::objname 时, 关闭父框架的id=objname元素
        if (preg_match('/close::/', $gourl)) {
            $tgobj = trim(preg_replace('/close::/', '', $gourl));
            $gourl = 'javascript:;';
            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
        }

        $func .= "var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
        $rmsg = $func;
        $rmsg .= "document.write(\"<br /><div style='width:80%;padding:0px;border:1px solid #DADADA;'>";
        $rmsg .= "<div style='padding:6px;border-bottom:1px solid #DADADA;background:#E0E0E0';'><b>提示信息！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='padding:6px;height:130px;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"" . str_replace("\"", "“", $msg) . "\");\r\n";
        $rmsg .= "document.write(\"";

        if ($onlymsg == 0) {
            if ($gourl != 'javascript:;' && $gourl != '') {
                $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
                $rmsg .= "<br/></div>\");\r\n";
                $rmsg .= "setTimeout('JumpUrl()',$litime);";
            } else {
                $rmsg .= "<br/></div>\");\r\n";
            }
        } else {
            $rmsg .= "<br/><br/></div>\");\r\n";
        }
        $msg = $htmlhead . $rmsg . $htmlfoot;
    }
    echo $msg;
}

/**
 * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
 * @param string $user_name 姓名
 * @return string 格式化后的姓名
 */
function priv_name($user_name) {
    $strlen = mb_strlen($user_name, 'utf-8');
    $firstStr = mb_substr($user_name, 0, 1, 'utf-8');
    $lastStr = mb_substr($user_name, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

/**
 * 获取构建器实例
 * @param  string $type 类型（list|form）
 * @return [type] [description]
 * @date   2018-02-02
 * @author 心云间、凝听 <981248356@qq.com>
 */
function builder($type = '') {
    $builder = Builder::run($type);
    return $builder;
}

/**
 * @title 配置读取
 * @param type $tag
 * @param type $default_value
 * @return type
 */
function config_value($tag, $default_value) {
    $arr = config($tag);
    return isset($arr[$default_value]) ? $arr[$default_value] : '';
}

/**
 * @title 是否移动端
 * @return boolean
 */
function is_mobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
 * @title http请求
 * @param type $url
 * @return type
 */
function https_request($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    if (curl_errno($curl)) {
        return 'ERROR ' . curl_error($curl);
    }
    curl_close($curl);
    return $data;
}

/**
 * @title 后台管理员登录状态
 * @return string
 */
function admin_is_login() {

    // 登录判断
    $admin = cookie('admin');
    if (empty($admin)) {
        return '请登录';
    }

    $admin = authcode($admin, 'DECODE', 'PHPFLY');
    $admin = json_decode($admin, true);

    if (session('admin_session_sign') != data_auth_sign($admin)) {
        return '请登录';
    }

    return $admin;
}

/**
 * @title 前台会员登录状态
 * @return string
 */
function member_is_login() {

    // 登录判断
    $member = cookie('member');
    if (empty($member)) {
        return '请登录';
    }

    $member = authcode($member, 'DECODE', 'PHPFLY');
    $member = json_decode($member, true);

    if (session('member_session_sign') != data_auth_sign($member)) {
        return '请登录';
    }

    return $member;
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * @title 自定义md5
 * @param type $value
 * @return type
 */
function my_md5($value, $salt = 'mumaniu') {
    $password = md5(md5($value) . $salt);
    return $password;
}

/**
 * @title 一维数组转多维数组
 */
function node_merge($node, $access = null, $pid = 0) {
    $arr = array();
    foreach ($node as $v) {
        if (is_array($access)) {
            $v['access'] = in_array($v['id'], $access) ? 1 : 0;
        }
        if ($v['pid'] == $pid) {
            $v['child'] = node_merge($node, $access, $v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * @title 生成一个优化的url
 * @param type $url
 * @return type
 */
function my_url($url) {
    if (strpos($url, 'http') !== false || strpos($url, 'javascript') !== false || strpos($url, 'tel') !== false || strpos($url, 'mail') !== false) {
        return $url;
    } elseif (empty($url)) {
        return APP_URL . '/';
    } else {
        $url = url($url);
        $url = str_replace('.html', '/', $url);
        return $url;
    }
}

/**
 * @title 获取IP地址
 * @staticvar type $ip
 * @param type $type
 * @param type $adv
 * @return type
 */
function get_client_ip($type = 0, $adv = false) {
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL)
        return $ip[$type];
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos)
                unset($arr[$pos]);
            $ip = trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 数组对象转数组
 * @param type $target
 * @return type
 */
function array_out($target) {
    $result = array();
    foreach ($target as $value) {
        $result[] = json_decode($value, true);
    }
    return $result;
}

/**
 * curl请求指定url
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = []) {
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * @title 解析配置文件的注释
 * @param type $cnt
 */
function parse_config_title($cnt) {
    $regx_title = '/@(\w+)\s+(.*?)\s+(.*?)\s+(.*)/i';
    preg_match($regx_title, $cnt, $arr);
    if (isset($arr[2])) {
        return $arr[2];
    } else {
        return '';
    }
    print_r($cnt);
    exit;
}

/**
 * 替代scan_dir的方法
 * @param string $pattern 检索模式 搜索模式 *.txt,*.doc; (同glog方法)
 * @param int $flags
 */
function my_scan_dir($pattern, $flags = null) {
    $files = array_map('basename', glob($pattern, $flags));
    return $files;
}

/**
 * 	解决php自带的basename函数不支持中文
 */
function get_basename($filename) {
    return preg_replace('/^.+[\\\\\\/]/', '', $filename);
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++)
        $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/*
 * 下划线转驼峰
 */

function underline_to_hump($str) {
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function($matches) {
        return strtoupper($matches[2]);
    }, $str);
    return $str;
}

/*
 * 驼峰转下划线
 */

function hump_to_underline($str) {
    $str = preg_replace_callback('/([A-Z]{1})/', function($matches) {
        return '_' . strtolower($matches[0]);
    }, $str);
    return $str;
}

/**
 * 动态生成下拉菜单
 * @param  array $arr 列表数组 int $selected_id当前被选中ID
 */
function html_select($arr, $selected_id = '', $mode = false) {
    if (strpos($selected_id, ',') != false) {
        $selected_id = explode(',', $selected_id);
    }
    $str = '';
    if (is_array($arr) && count($arr) > 0) {
        foreach ($arr as $key => $value) {
            //特殊情况
            if (is_array($value)) {
                $value = $value['title'];
            }
            if ($selected_id !== '' && $selected_id == $key) {
                $str = $str . '<option value="' . $key . '" selected="selected">' . $value . '</option>';
            } elseif (is_array($selected_id) && in_array($key, $selected_id)) {
                $str = $str . '<option value="' . $key . '" selected="selected">' . $value . '</option>';
            } else {
                $str = $str . '<option value="' . $key . '">' . $value . '</option>';
            }
        }
    }
    return $str;
}

/**
 * 动态生成单选框
 * @param  array $arr 列表数组 int $selected_id当前被选中ID
 */
function html_radio($name, $arr, $selected_id = 1) {
    $str = '';
    foreach ($arr as $key => $val) {
        if ($selected_id == $key) {
            $str = $str . ' <input type="radio" name="' . $name . '" id="' . $name . $key . '" value="' . $key . '" title="' . $val . '" checked="checked" /> ' . chr(10);
        } else {
            $str = $str . ' <input type="radio" name="' . $name . '" id="' . $name . $key . '" value="' . $key . '" title="' . $val . '" /> ' . chr(10);
        }
    }
    return $str;
}

/**
 * @title 生成check box
 */
function html_checkbox($name, $arr, $selected_id = '') {
    if (!is_array($selected_id)) {
        $selected_id = explode(',', $selected_id);
    }
    $str = '';
    foreach ($arr as $key => $val) {
        if (in_array($key, $selected_id)) {
            $str = $str . '<input type="checkbox" name="' . $name . '[]" id="' . $name . $key . '" value="' . $key . '" title="' . $val . '" checked="checked" /> ' . chr(10);
        } else {
            $str = $str . '<input type="checkbox" name="' . $name . '[]" id="' . $name . $key . '" value="' . $key . '" title="' . $val . '" /> ' . chr(10);
        }
    }
    return $str;
}

/**
 * 动态生成单选框
 * @param  array $arr 列表数组 int $selected_id当前被选中ID
 */
function html_radio_bootstrap($name, $arr, $selected_id = 1) {
    $str = '';
    foreach ($arr as $key => $val) {
        if ($selected_id == $key) {
            $str = $str . '<div class="radio"> <label><input type="radio" name="' . $name . '" id="' . $name . $key . '" value="' . $key . '" title="" checked="checked" />' . $val . ' </label></div>' . chr(10);
        } else {
            $str = $str . '<div class="radio"> <label><input type="radio" name="' . $name . '" id="' . $name . $key . '" value="' . $key . '" title="" />' . $val . ' </label></div>' . chr(10);
        }
    }
    return $str;
}

/**
 * @title 生成check box  bootstrap版
 * @param type $name
 * @param type $arr
 * @param type $selected_id
 * @return string
 */
function html_checkbox_bootstrap($name, $arr, $selected_id = '') {
    if (!is_array($selected_id)) {
        $selected_id = explode(',', $selected_id);
    }
    $str = '';
    foreach ($arr as $key => $val) {
        if (in_array($key, $selected_id)) {
            $str = $str . '<div class="checkbox"><label><input type="checkbox" name="' . $name . '[]" id="' . $name . $key . '" value="' . $key . '" title="' . $val . '" checked="checked" /> ' . $val . ' </label></div>' . chr(10);
        } else {
            $str = $str . '<div class="checkbox"><label><input type="checkbox" name="' . $name . '[]" id="' . $name . $key . '" value="' . $key . '" title="' . $val . '" /> ' . $val . ' </label></div>' . chr(10);
        }
    }
    return $str;
}

/**
 * @title 生成图片的缩略图
 * @param type $filename
 * @param type $width
 * @param type $height
 * @return boolean
 */
function img_resize($filename, $width, $height, $default = '') {
    //define('$res_path','E:/xampp552/htdocs/vv_mythink1.0/Res/');
    //define('RES_HTTP','http://127.0.0.1:8080/vv_mythink1.0/Res/');
    $res_path = APP_DIR . '/uploads/' . APP_THEME . '/';
    $res_http = APP_URL . '/uploads/' . APP_THEME . '/';
    //import('Common.Org.Image');
    if (!is_file($res_path . $filename)) {
        // echo 'eeee'. $res_path . $filename;exit;
        if (strpos($filename, 'http') !== false) {
            return $filename;
        } else {
            if (APP_IMG_CDN != '') {
                return APP_IMG_CDN . '/' . $filename;
            } else {
                return $filename;
            }
        }
        //return false;
    }
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $old_image = $filename;
    $new_image = 'cache/' . iconv_substr($filename, 0, iconv_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
    //print_r(filemtime($res_path . $old_image));
    // print_r('<br />');
    // print_r(filemtime($res_path . $new_image));f
    if (is_file($res_path . $new_image)) {
        return $res_http . $new_image;
    } else {
        $path = '';
        $directories = explode('/', dirname(str_replace('../', '', $new_image)));
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;
            if (!is_dir($res_path . $path)) {
                @mkdir($res_path . $path, 0777);
            }
        }
        if (!is_file($res_path . $old_image)) {
            return '';
        }
        list($width_orig, $height_orig) = @getimagesize($res_path . $old_image);
        if ($height == 0) {
            $height = $width * $height_orig / $width_orig;
        }
        if ($width == 0) {
            $width = $height * $width_orig / $height_orig;
        }
        if ($width_orig == $width && $height_orig == $height) {
            copy($res_path . $old_image, $res_path . $new_image);
        } else {
            $image = new utils\Image($res_path . $old_image);
            $image->resize($width, $height, $default);
            $image->save($res_path . $new_image, 75);
        }
        return $res_http . $new_image;
    }
}

function res_http($res_path) {
    if (is_file(APP_DIR . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . APP_THEME . DIRECTORY_SEPARATOR . $res_path)) {
        return APP_URL . '/uploads/' . APP_THEME . '/' . $res_path;
    }
}

/**
 * @title 仿laravel打印数据 
 * @param type $value
 */
function dd($value) {
    print_r($value);
    exit;
}

/**
 * zouhao619@gmail.com 	zouhao
 * 一些验证方法
 */

/**
 * 是否是手机号码
 *
 * @param string $phone	手机号码
 * @return boolean
 */
function is_phone($phone) {
    if (strlen($phone) != 11 || !preg_match('/^1[3|4|5|8|7][0-9]\d{4,8}$/', $phone)) {
        return false;
    } else {
        return true;
    }
}

/**
 * 验证字符串是否为数字,字母,中文和下划线构成
 * @param string $username
 * @return bool
 */
function is_check_string($str) {
    if (preg_match('/^[\x{4e00}-\x{9fa5}\w_]+$/u', $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为一个合法的email
 * @param sting $email
 * @return boolean
 */
function is_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为一个合法的url
 * @param string $url
 * @return boolean
 */
function is_url($url) {
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为一个合法的ip地址
 * @param string $ip
 * @return boolean
 */
function is_ip($ip) {
    if (ip2long($ip)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为整数
 * @param int $number
 * @return boolean
 */
function is_number($number) {
    if (preg_match('/^[-\+]?\d+$/', $number)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为正整数
 * @param int $number
 * @return boolean
 */
function is_positive_number($number) {
    if (ctype_digit($number)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为小数
 * @param float $number
 * @return boolean
 */
function is_decimal($number) {
    if (preg_match('/^[-\+]?\d+(\.\d+)?$/', $number)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为正小数
 * @param float $number
 * @return boolean
 */
function is_positive_decimal($number) {
    if (preg_match('/^\d+(\.\d+)?$/', $number)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否为英文
 * @param string $str
 * @return boolean
 */
function is_english($str) {
    if (ctype_alpha($str))
        return true;
    else
        return false;
}

/**
 * 是否为中文
 * @param string $str
 * @return boolean
 */
function is_chinese($str) {
    if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $str))
        return true;
    else
        return false;
}

/**
 * 判断是否为图片
 * @param string $file	图片文件路径
 * @return boolean
 */
function is_image($file) {
    if (file_exists($file) && getimagesize($file === false)) {
        return false;
    } else {
        return true;
    }
}

/**
 * 是否为合法的身份证(支持15位和18位)
 * @param string $card
 * @return boolean
 */
function is_card($card) {
    if (preg_match('/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/', $card) || preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/', $card))
        return true;
    else
        return false;
}

/**
 * 验证日期格式是否正确
 * @param string $date
 * @param string $format
 * @return boolean
 */
function is_date($date, $format = 'Y-m-d') {
    $t = date_parse_from_format($format, $date);
    if (empty($t['errors'])) {
        return true;
    } else {
        return false;
    }
}

/**
 * 函数authcode($string, $operation, $key, $expiry)中的$string：字符串，明文或密文；$operation：DECODE表示解密，其它表示加密；$key：密匙；$expiry：密文有效期。
 * @param type $string
 * @param type $operation
 * @param type $key
 * @param type $expiry
 * @return string
 * 
 * 1 $str = 'abcdef'; 
  2 $key = 'www.fyunw.com';
  3 $authcode =  authcode($str,'ENCODE',$key,0); //加密
  4 echo $authcode;
  5 echo authcode($authcode,'DECODE',$key,0); //解密
 * 
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
    $ckey_length = 4;

    // 密匙   
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);

    // 密匙a会参与加解密   
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证   
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文   
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
            substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙   
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
//解密时会通过这个密匙验证数据完整性   
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿   
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分   
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符   
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        // 验证数据有效性，请看未加密明文的格式   
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}
