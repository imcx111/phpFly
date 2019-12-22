<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


return [
    'view_replace_str' => [
        '__PUBLIC__' => APP_URL,
        '__THEME__' => APP_URL . '/static/' . APP_THEME,
    ],
    'url_common_param' => true,
    'http_exception_template'    =>  [
        // 定义404错误的重定向页面地址
        404 =>  APP_PATH . 'common/view/exception/404.html',
        500 =>  APP_PATH . 'common/view/exception/500.html',
    ],  
    'template' => [
        // 模板引擎类型 支持 php think 支持扩展
        'type' => 'Think',
        // 模板路径
        'view_path' => request()->isMobile() && !APP_RESPONSIVE ? './themes/' . APP_THEME . '/mobile/' : './themes/' . APP_THEME . '/pc/',
        // 模板后缀
        'view_suffix' => 'php',
        // 模板文件名分隔符
        'view_depr' => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin' => '{',
        // 模板引擎普通标签结束标记
        'tpl_end' => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end' => '}',
    ],
];
