<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\builder;

/**
 * @title 表单构建器
 */
class BuilderForm extends Builder {

    private $formItems = [];  // 表单项目   
    private $formLabel = 'tpl_form';

    /**
     * @title 设置替换的标称
     * @param type $value
     * @return $this
     */
    public function setLabel($value) {

        $this->formLabel = $value;

        return $this;
    }

    /**
     * 加入一个表单项
     * @param $name 名称
     * @param $type 表单类型(取值参考系统配置form_item_type)
     * @param $title 表单标题
     * @param $description 表单项描述说明
     * @param $options 表单options
     * @param $extra_attr 表单项额外属性
     * @param $extra_class 表单项是否隐藏
     * @return $this
     */
    public function addItem($name, $type, $title, $options = null, $extra_attr = '', $extra_class = '', $description = '') {
        $field = [
            'name' => $name,
            'type' => $type,
            'title' => $title,
            'options' => $options,
            'extra_attr' => $extra_attr,
            'extra_class' => $extra_class,
            'description' => $description
        ];
        $this->formItems[$name] = $field;

        return $this;
    }

    /**
     * 字段模版
     * @param  array $field [description]
     * @return [type] [description]
     * @date   2017-10-20
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function fieldType($field = []) {

        if (!is_array($field)) {
            $field = $field->toArray();
        }

        $this->assign('field', $field);

        $field_template = '../application/common/view/fields/' . $field['type'] . '.' . config('template.view_suffix');
        return parent::fetch($field_template);
    }

    /**
     * @title 数据替换
     */
    public function build($default_values = NULL) {

        $form_html = '';

        foreach ($this->formItems as $key => $field) {

            if (isset($default_values[$key]) && $default_values[$key] !== '') {
                $field['result'] = $default_values[$key];
            } else {
                $field['result'] = '';
            }

            $form_html .= action('common/BuilderForm/fieldType', ['field' => $field], 'builder');
        }

        $this->assign($this->formLabel, $form_html);
    }

}
