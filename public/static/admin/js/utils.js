/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 扩展一个Util模块
 **/

layui.define('jquery', function (exports) {

    var $ = layui.$;

    var utils = {};


    utils.onresize = function (func) {
        if (typeof func === 'function') {
            $(window).on('resize', func);
            func();
        }
    };

    utils.getCheckBoxVal = function (parent) {
        var elems, values = [];
        if (parent == null)
            elems = $('.layui-form-checked');
        else
            elems = $(parent).find('.layui-from-checked');
        $.each(elems, function (index) {
            var elem = elems.eq(index);
            var input = elem.prev('input');
            values.push(input.val());
        });
        return values;
    }

    //输出test接口
    exports('utils', utils);
});    