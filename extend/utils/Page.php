<?php

namespace utils;

class Page {

    public $total = 0;
    public $page = 1;
    public $limit = 20;
    public $num_links = 8;
    public $url = '';
    public $text_first = '首页';
    public $text_last = '尾页';
    public $text_next = '下一页';
    public $text_prev = '上一页';
    private $parameter = [];

    function __construct() {
        $this->parameter = input('get.');
        $this->page = input('get.page', 1);
    }

    function getUrl() {
        return $this->url;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function getTotal() {
        return $this->total;
    }

    function getLimit() {
        return $this->limit;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setLimit($limit) {
        $this->limit = $limit;
    }

    function getPage() {
        return $this->page;
    }

    function setPage($page) {
        $this->page = $page;
    }

    public function render() {

        /* 生成URL */
        $this->parameter['page'] = '{page}';

        //去重        
        $this->parameter = array_filter($this->parameter);

        /*
          if (strpos($this->url, '?') !== false) {
          $this->url = $this->url . '&' . http_build_query($this->parameter);
          } else {
          $this->url = $this->url . '?' . http_build_query($this->parameter);
          }
          $this->url = str_replace('%7Bpage%7D', '{page}', $this->url);

         */

        // $this->url = url($this->url, $this->parameter);


        $total = $this->total;
        if ($this->page < 1) {
            $page = 1;
        } else {
            $page = $this->page;
        }
        if (!(int) $this->limit) {
            $limit = 10;
        } else {
            $limit = $this->limit;
        }
        $num_links = $this->num_links;
        $num_pages = ceil($total / $limit);
        $output = '<ul class="pagination">';
        $output = $output. "<li class=\"page-item disabled\"><span class=\"page-link total\">共".$this->total."条</span></li>";
        if ($page > 1) {
            $output .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a></li>';
            $output .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', $page - 1, $this->url) . '">' . $this->text_prev . '</a></li>';
        }
        if ($num_pages > 1) {
            if ($num_pages <= $num_links) {
                $start = 1;
                $end = $num_pages;
            } else {
                $start = $page - floor($num_links / 2);
                $end = $page + floor($num_links / 2);
                if ($start < 1) {
                    $end += abs($start) + 1;
                    $start = 1;
                }
                if ($end > $num_pages) {
                    $start -= ($end - $num_pages);
                    $end = $num_pages;
                }
            }
            for ($i = $start; $i <= $end; $i++) {
                if ($page == $i) {
                    $output .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                } else {
                    $output .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a></li>';
                }
            }
        }
        if ($page < $num_pages) {
            $output .= '<li class="page-item"><a class="page-link next" href="' . str_replace('{page}', $page + 1, $this->url) . '">' . $this->text_next . '</a></li>';
            $output .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', $num_pages, $this->url) . '">' . $this->text_last . '</a></li>';
        }
        $output .= '</ul>';       
    
        
        if ($this->total > 0) {
            return $output;
        } else {
            return '';
        }
    }

}
