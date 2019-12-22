<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function is_in_array($str, $array, $rs) {
    if (in_array($str, $array)) {
        return $rs;
    }
}

function getSignTip($member_id = -1) {

    //$member_id = session('member.id');

    $sign_tip = "";
    $today = strtotime(date("Y-m-d", time()));
    $sign_info = db("member_sign")->where('member_id', $member_id)->where('sign_time', $today)->field("num")->find();

    //判断是否今天已签到
    if (empty($sign_info)) {
        // 今天没签
        $yesterday = $today - 3600 * 24;
        $sign_yesterday_info = db("member_sign")->where('member_id', $member_id)->where('sign_time', $yesterday)->field("num")->find();

        if ($sign_yesterday_info['num'] >= 30) {
            $sign_tip = "可获得 <cite>20</cite> 积分";
        } elseif ($sign_yesterday_info['num'] >= 15) {
            $sign_tip = "可获得 <cite>15</cite> 积分";
        } elseif ($sign_yesterday_info['num'] >= 5) {
            $sign_tip = "可获得 <cite>10</cite> 积分";
        } else {
            $sign_tip = "可获得 <cite>5</cite> 积分";
        }
    } else {
        //今天已签到
        if ($sign_info['num'] >= 29) {
            $sign_tip = "明日签到可领 <cite>20</cite> 积分";
        } elseif ($sign_info['num'] >= 14) {
            $sign_tip = "明日签到可领 <cite>15</cite> 积分";
        } elseif ($sign_info['num'] >= 4) {
            $sign_tip = "明日签到可领 <cite>10</cite> 积分";
        } else {
            $sign_tip = "明日签到可领 <cite>5</cite> 积分";
        }
    }

    if (empty($sign_info['num'])) {
        $sign_info['num'] = 0;
    }

    return ["num" => $sign_info['num'], "tip" => $sign_tip];
}

function getCanlendar() {

    $canlendar = array();

    $year = date('Y');
    //如果没有传入月份则获取当前系统月份
    $month = date('m');

    //获取当前月有多少天
    $days = date('t', strtotime("" . $year . "-" . $month . "-1"));
    //当前1号是星期几
    $week = date('w', strtotime("" . $year . "-" . $month . "-1"));
    for ($i = 1 - $week; $i <= $days;) {
        for ($j = 0; $j < 7; $j++) {
            $canlendar[] = $i;
            $i++;
        }
    }
    $canlendar_new = array();
    //实现上一月和上一年
    if ($month == 1) {
        $premonth = 12;
        $preyear = $year - 1;
    } else {
        $premonth = $month - 1;
        $preyear = $year;
    }

    //实现下一月和下一年
    if ($month == 12) {
        $nextmonth = 1;
        $nextyear = $year + 1;
    } else {
        $nextmonth = $month + 1;
        $nextyear = $year;
    }
    //上月天数
    $premonth_days = date('t', strtotime("{$preyear}-{$premonth}-1"));

    $i = 0;
    foreach ($canlendar as $v) {
        if ($v <= 0) {
            $canlendar_new[$i]['day'] = $premonth_days - abs($v);
            $canlendar_new[$i]['date'] = $preyear . "-" . $premonth . "-" . $canlendar_new[$i]['day'];
        } elseif ($v > $days) {
            $canlendar_new[$i]['day'] = $v - $days;
            $canlendar_new[$i]['date'] = $nextyear . "-" . $nextmonth . "-" . $canlendar_new[$i]['day'];
        } else {
            $canlendar_new[$i]['day'] = $v;
            $canlendar_new[$i]['date'] = $year . "-" . $month . "-" . $canlendar_new[$i]['day'];
        }
        $canlendar_new[$i]['num'] = $v;
        $i++;
    }
    return $canlendar_new;
}

/**
 * @title 分类的导航
 * @param type $cid
 */
function get_nav($cid = 0) {

    $result = db("nav")->where('cid', $cid)->order("listorder asc, id asc")->select();

    if ($result) {
        foreach ($result as $key => $value) {
            // 处理href
            $result[$key]['href'] = my_url($result[$key]['href']);
        }
    }
    return $result;
}
