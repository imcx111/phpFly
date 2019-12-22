<?php

namespace utils;

/**
 * 通用的树型类
 * @date 2015年10月28日15:14
 */
class Tree {

    /**
     * 生成树型结构所需要的2维数组
     */
    var $arr = array();

    /**
     * 生成树型结构所需修饰符号，可以换成图片
     * @var Array
     */
    //var $icon = array('│', '├', ' └', '&nbsp; ');
    var $icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ', '&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; ');

    /**
     * @access private
     */
    var $ret = '';

    /**
     *
     * @var type 
     */
    var $str = '';

    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     * array(
     *      1 => array('id'=>'1','pid'=>0,'title'=>'一级栏目一'),
     *      2 => array('id'=>'2','pid'=>0,'title'=>'一级栏目二'),
     *      3 => array('id'=>'3','pid'=>1,'title'=>'二级栏目一'),
     *      4 => array('id'=>'4','pid'=>1,'title'=>'二级栏目二'),
     *      5 => array('id'=>'5','pid'=>2,'title'=>'二级栏目三'),
     *      6 => array('id'=>'6','pid'=>3,'title'=>'三级栏目一'),
     *      7 => array('id'=>'7','pid'=>3,'title'=>'三级栏目二')
     *      )
     */
    public function __construct($arr = array()) {
        $this->arr = $arr;
        $this->ret = NULL;
        return is_array($arr);
    }

    public function tree($arr = array()) {
        $this->arr = $arr;
        $this->ret = NULL;
        return is_array($arr);
    }

    public function init($arr = array()) {
        $this->arr = $arr;
        $this->ret = NULL;
        return is_array($arr);
    }

    /**
     * 得到父级数组
     * @param int
     * @return array
     */
    function get_parent($myid) {
        $newarr = array();
        if (!isset($this->arr[$myid]))
            return false;
        $pid = $this->arr[$myid]['pid'];
        $pid = $this->arr[$pid]['pid'];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['pid'] == $pid)
                    $newarr[$id] = $a;
            }
        }
        return $newarr;
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    function get_child($myid) {
        $a = $newarr = array();
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['pid'] == $myid)
                    $newarr[$id] = $a;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 得到当前位置数组
     * @param int
     * @return array
     */
    function get_pos($myid, &$newarr) {
        $a = array();
        if (!isset($this->arr[$myid]))
            return false;
        $newarr[] = $this->arr[$myid];
        $pid = $this->arr[$myid]['pid'];
        if (isset($this->arr[$pid])) {
            $this->get_pos($pid, $newarr);
        }
        if (is_array($newarr)) {
            krsort($newarr);
            foreach ($newarr as $v) {
                $a[$v['id']] = $v;
            }
        }
        return $a;
    }

    /**
     *  得到树型结构
     * @param $myid 表示获得这个ID下的所有子级
     * @param $str 生成树形结构基本代码, 例如: "<option value=\$id \$select>\$spacer\$title</option>"
     * @param $sid 被选中的ID, 比如在做树形下拉框的时候需要用到
     * @param $adds
     * @param $str_group
     */
    function get_tree($myid, $str, $sid = 0, $adds = '', $str_group = '') {
        $pid = 0;
        $number = 1;
        $child = $this->get_child($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                    $k = $adds ? $this->icon[3] : '';
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                $selected = $id == $sid ? 'selected' : '';



                $test = extract($a);

                // print_r($test);exit;

                $pid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
                $this->ret .= $nstr;
                $this->get_tree($id, $str, $sid, $adds . $k . '&nbsp;', $str_group);
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * 同上一方法类似,但允许多选
     */
    function get_tree_multi($myid, $str, $sid = 0, $adds = '') {
        $number = 1;
        $child = $this->get_child($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                    $k = $adds ? $this->icon[3] : '';
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($a);
                eval("\$nstr = \"$str\";");
                $this->ret .= $nstr;
                $this->get_tree_multi($id, $str, $sid, $adds . $k . '&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    function have($list, $item) {
        return(strpos(',,' . $list . ',', ',' . $item . ','));
    }

    /**
     * 格式化数组
     */
    function getArray($myid = 0, $sid = 0, $adds = '') {
        $number = 1;
        $child = $this->get_child($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                    $k = $adds ? $this->icon[3] : '';
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                @extract($a);

                $a['title'] = $spacer . ' ' . $a['title'];

                $this->ret[$a['id']] = $a;

                $fd = $adds . $k . '&nbsp;';
                $this->getArray($id, $sid, $fd);
                $number++;
            }
        }

        return empty($this->ret) ? [] : $this->ret;
    }

    /**
     * @param integer $myid 要查询的ID
     * @param string $str   第一种HTML代码方式
     * @param string $str2  第二种HTML代码方式
     * @param integer $sid  默认选中
     * @param integer $adds 前缀
     */
    public function get_tree_category($myid, $str, $str2, $sid = 0, $adds = '') {
        $number = 1;
        $child = $this->get_child($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($a);
                if (empty($html_disabled)) {
                    eval("\$nstr = \"$str\";");
                } else {
                    eval("\$nstr = \"$str2\";");
                }
                $this->ret .= $nstr;
                $this->get_tree_category($id, $str, $str2, $sid, $adds . $k . '&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * 同上一类方法，jquery treeview 风格，可伸缩样式（需要treeview插件支持）
     * @param $myid 表示获得这个ID下的所有子级
     * @param $effected_id 需要生成treeview目录数的id
     * @param $str 末级样式
     * @param $str2 目录级别样式
     * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
     * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
     * @param $currentlevel 计算当前层级，递归使用 适用改函数时不需要用该参数
     * @param $recursion 递归使用 外部调用时为FALSE
     */
    function get_treeview($myid, $effected_id = 'example', $str = "<span class='file'>\$title</span>", $str2 = "<span class='folder'>\$title</span>", $showlevel = 0, $style = 'filetree ', $currentlevel = 1, $recursion = FALSE) {
        $child = $this->get_child($myid);
        if (!defined('EFFECTED_INIT')) {
            $effected = ' id="' . $effected_id . '"';
            define('EFFECTED_INIT', 1);
        } else {
            $effected = '';
        }
        $placeholder = '<ul><li><span class="placeholder"></span></li></ul>';
        if (!$recursion)
            $this->str .= '<ul' . $effected . '  class="' . $style . '">';
        foreach ($child as $id => $a) {

            @extract($a);
            if ($showlevel > 0 && $showlevel == $currentlevel && $this->get_child($id))
                $folder = 'hasChildren'; //如设置显示层级模式@2011.07.01
            $floder_status = isset($folder) ? ' class="' . $folder . '"' : '';
            $this->str .= $recursion ? '<ul><li' . $floder_status . ' id=\'' . $id . '\'>' : '<li' . $floder_status . ' id=\'' . $id . '\'>';
            $recursion = FALSE;
            //判断是否为终极栏目
            if ($child == 1) {
                eval("\$nstr = \"$str2\";");
                $this->str .= $nstr;
                if ($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
                    $this->get_treeview($id, $effected_id, $str, $str2, $showlevel, $style, $currentlevel + 1, TRUE);
                } elseif ($showlevel > 0 && $showlevel == $currentlevel) {
                    $this->str .= $placeholder;
                }
            } else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }
            $this->str .= $recursion ? '</li></ul>' : '</li>';
        }
        if (!$recursion)
            $this->str .= '</ul>';
        return $this->str;
    }

    /**
     * 同上一类方法，jquery treeview 风格，可伸缩样式（需要treeview插件支持）
     * @param $myid 表示获得这个ID下的所有子级
     * @param $effected_id 需要生成treeview目录数的id
     * @param $str 末级样式
     * @param $str2 目录级别样式
     * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
     * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
     * @param $currentlevel 计算当前层级，递归使用 适用改函数时不需要用该参数
     * @param $recursion 递归使用 外部调用时为FALSE
     * @param $dropdown 有子元素时li的class
     */
    function get_treeview_menu($myid, $effected_id = 'example', $str = "<span class='file'>\$title</span>", $str2 = "<span class='folder'>\$title</span>", $showlevel = 0, $ul_class = "", $li_class = "", $style = 'filetree ', $currentlevel = 1, $recursion = FALSE, $dropdown = 'hasChild') {

        $child = $this->get_child($myid);
        if (!defined('EFFECTED_INIT')) {
            $effected = ' id="' . $effected_id . '"';
            define('EFFECTED_INIT', 1);
        } else {
            $effected = '';
        }
        $placeholder = '<ul><li><span class="placeholder"></span></li></ul>';
        if (!$recursion) {
            $this->str .= '<ul' . $effected . '  class="' . $style . '">';
        }

        foreach ($child as $id => $a) {

            @extract($a);
            if ($showlevel > 0 && is_array($this->get_child($a['id']))) {
                $floder_status = " class='$dropdown $li_class'";
            } else {
                $floder_status = " class='$li_class'";
                ;
            }
            $this->str .= $recursion ? "<ul class='$ul_class'><li  $floder_status id= 'menu-item-$id'>" : "<li  $floder_status   id= 'menu-item-$id'>";
            $recursion = FALSE;
            //判断是否为终极栏目
            if ($this->get_child($a['id'])) {
                eval("\$nstr = \"$str2\";");
                $this->str .= $nstr;
                if ($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
                    $this->get_treeview_menu($a['id'], $effected_id, $str, $str2, $showlevel, $ul_class, $li_class, $style, $currentlevel + 1, TRUE);
                } elseif ($showlevel > 0 && $showlevel == $currentlevel) {
                    //$this->str .= $placeholder;
                }
            } else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }
            $this->str .= $recursion ? '</li></ul>' : '</li>';
        }
        if (!$recursion)
            $this->str .= '</ul>';
        return $this->str;
    }

    /**
     * 获取子栏目json
     * Enter description here ...
     * @param unknown_type $myid
     */
    public function get_tree_array($myid) {
        $data = [];
        $sub_cats = $this->get_child($myid);
        $n = 0;
        if (is_array($sub_cats))
            foreach ($sub_cats as $c) {

                // $data[$n]['id'] = iconv('gb2312', 'utf-8', $c['pid']);
                $data[$n]['id'] = $c['id'];
                $data[$n]['title'] = $c['title'];

                if ($this->get_child($c['id'])) {
                    //$data[$n]['hasChildren'] = true;
                    //$data[$n]['liclass'] = 'hasChildren';
                    $data[$n]['children'] = $this->get_tree_array($c['id']);
                    //$data[$n]['classes'] = 'folder';
                    //$data[$n]['text'] = iconv('gb2312', 'utf-8', $c['title']);
                    $data[$n]['title'] = $c['title'];
                } else {

                    // $data[$n]['hasChildren'] = false;
                }
                $n++;
            }
        return $data;
    }

}

?>