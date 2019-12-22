/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



layui.extend({
    utils: APP_URL + '/static/admin/js/utils'
})

layui.use(['jquery', 'layer', 'form', 'element', 'utils'], function () {
    var $ = layui.$,
            layer = layui.layer,
            form = layui.form,
            element = layui.element,
            utils = layui.utils;



    $('.openbox').each(function (i) {
        $(this).on('click', function () {
            var index = layer.open({
                type: 2,
                title: $(this).attr('title'),
                shadeClose: true,
                area: ['600px', '600px'],
                content: $(this).attr('href')
            });
            return false;
        })

    });

    $('.openbox_big').on('click', function () {
        var index = layer.open({
            type: 2,
            title: $(this).attr('title'),
            shadeClose: true,
            area: ['90%', '90%'],
            maxmin: true,
            content: $(this).attr('href') //iframe的url
        });
        //重新给指定层设定width、top等
//        layer.style(index, {
//            width: '600px',
//            height: 'auto'
//        });
        //layer.iframeAuto(index) 
        return false;
    });






    /*关闭弹出框口*/
    function layer_box_close() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }




    //正常表单提交
    form.on('submit(myform)', function (data) {
        //loading
        var load = layer.msg('请稍候', {
            icon: 16
            , shade: 0.01
        });

        var target, query;
        query = $('.layui-form').serialize();
        target = $('.layui-form').get(0).action;


        $.ajax({
            //请求方式
            type: "POST",
            //请求的媒体类型
            contentType: "application/x-www-form-urlencoded",
            //请求地址
            url: target,
            //数据，json字符串
            data: query,
            //请求成功
            success: function (result) {
                if (result.code == 0) {
                    if (result.msg) {
                        layer.msg(result.msg);
                        setTimeout(function () {
                            if (result.url) {
                                location.href = result.url;
                            }
                            layer_box_close()
                        }, 1500);
                    } else {
                        if (result.url) {
                            location.href = result.url;
                        }
                    }
                } else {
                    layer.msg(result.msg);
                }
            },
            //请求失败，包含具体的错误信息
            error: function (e) {
                layer.msg('错误信息：' + e.status);
                console.log(e.responseText);
            }
        });

        return false;
    });


    // 选择提交
    form.on('select(set_field)', function (data) {


        // {ids: utils.getCheckBoxVal().join()}        


        var url = $(data.elem).attr('href') + '&value=' + data.value;
        //console.log(tableCheck.getData());
        // return false;
        var load = layer.load(1);
        $.post(url, {ids: utils.getCheckBoxVal().join()}, function (result) {
            layer.close(load);
            if (result.code == 0) {
                location.reload();
            } else {
                layer.msg(result.msg);
            }
        });

        return;
    });

    // 按钮提交
    form.on('submit(button_submit)', function (data) {

        //{ids: utils.getCheckBoxVal().join()}  第2种方法也可以      

        layer.confirm('确认执行此操作吗', {
            btn: ['确认', '取消']
        }, function (index, layero) {

            var load = layer.load(1);
            $.post($(data.elem).attr('href'), data.field, function (result) {
                layer.close(load);
                if (result.code == 0) {
                    location.reload();
                } else {
                    layer.msg(result.msg);
                }
            });


        }, function (index) {

        });

        return;
    });



    // 列表全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });



    //ajax get请求
    $('.ajax-get').click(function () {
        var target;
        var that = this;

        if ($(this).hasClass('confirm')) {
            if (!confirm('确认要执行该操作吗?')) {
                return false;
            }
        }

//        if ($(this).hasClass('confirm')) {
//            layer.confirm('确认执行此操作吗', {
//                btn: ['确认', '取消']
//            }, function (index, layero) {
//                
//            }, function (index) {
//                return false;
//            });
//        }

        var load = layer.msg('请稍候', {
            icon: 16
            , shade: 0.01
        });
        if ((target = $(this).attr('href')) || (target = $(this).attr('url'))) {
            $.get(target, function (data) {

                if (data.code == 0) {

                    if (data.msg) {
                        layer.msg(data.msg);
                        setTimeout(function () {
                            if (data.url) {
                                location.href = data.url;
                            }
                        }, 1500);

                    } else {
                        if (data.url) {
                            location.href = data.url;
                        }
                    }


                } else {
                    layer.msg(data.msg);
                }

                layer.close(load);
            });
        }
        return false;
    });

});