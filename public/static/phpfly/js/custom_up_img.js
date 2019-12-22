$(function () {
    'use strict';
    // 初始化
    var $image = $('#image');
    $image.cropper({
        aspectRatio: '1',
        autoCropArea: 0.8,
        preview: '.up-pre-after',

    });


    // 限制裁切的图片宽度最大500px
    function getSize(size) {
        var num = parseInt(size);
        if (num <= 500) {//先要求图片的大小小于300之间
            return num;
        }
        return 500;
        //return getSize(num / 2);
    }

    function getRoundedCanvas(sourceCanvas) {
          var canvas = document.createElement('canvas');
          var context = canvas.getContext('2d');
          var width = sourceCanvas.width;
          var height = sourceCanvas.height;
          width = getSize(width);
          height = width;
          canvas.width = width;
          canvas.height = height;    
        
            // 清除画布
            context.clearRect(0, 0, width, height);
            // 图片压缩
            context.drawImage(sourceCanvas, 0, 0, width, height);        
        
          //context.beginPath();
          //这里是控制裁剪区域的大小（这里也决定你所要生成的图片的大小和形状 我这边用的是圆形的头像 大家有别的需要可以修改）
          //context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI);
          //context.strokeStyle = 'rgba(0,0,0,0)';
          //context.stroke();
          //context.clip();
          //context.drawImage(sourceCanvas, 0, 0, width, height);
          return canvas;
     }

    // 事件代理绑定事件
    $('.docs-buttons').on('click', '[data-method]', function () {

        var $this = $(this);
        var data = $this.data();
        var result = $image.cropper(data.method, data.option, data.secondOption);
        switch (data.method) {
            case 'getCroppedCanvas':
                if (result) {
                    // 显示 Modal
                    $('#cropped-modal').modal().find('.am-modal-bd').html(result);
                    $('#download').attr('href', result.toDataURL('image/jpeg'));
                }
                break;
        }
    });



    // 上传图片
    var $inputImage = $('#inputImage');
    var URL = window.URL || window.webkitURL;
    var blobURL;

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {
                        // Revoke when load complete
                        URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }

            // Amazi UI 上传文件显示代码
            var fileNames = '';
            $.each(this.files, function () {
                fileNames += '<span class="am-badge">' + this.name + '</span> ';
            });
            $('#file-list').html(fileNames);
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

    //绑定上传事件
    $('#up-btn-ok').on('click', function () {

        //var $modal = $('#myModal');
        // var $modal_alert = $('#my-alert');
        var img_src = $image.attr("src");


        if (img_src == "") {
            set_alert_info("没有选择上传的图片");
            //$modal_alert.modal();
            return false;
        }

        //$modal.modal();
        
        var roundedCanvas;

        var url = $(this).attr("url");
        var canvas = $("#image").cropper('getCroppedCanvas');

        //判断图片大小,如果超过1080 则返回
//        if (canvas.width > 1080) {
//            alert("图片过大,请重新选择!");
//            return false;
//        }
        roundedCanvas = getRoundedCanvas(canvas);

        var data = roundedCanvas.toDataURL(); //转成base64
        
        $.ajax({
            url: url,
            dataType: 'json',
            type: "POST",
            data: {"image": data.toString()},
            success: function (res, textStatus) {
               // $modal.modal('hide');
                //set_alert_info(res.data);
                layer.close(layer.index);


                var file_path = res.data;

                if (file_path) {
                    $(".avatar-add img").attr("src", file_path);

                    var img_name = file_path.split('/')[2];

                    $("#pic").text(img_name);
                }


            },
            error: function () {
                // $modal.modal('close');
                set_alert_info("上传文件失败了！");
                //$modal_alert.modal();
                //console.log('Upload error');  
            }
        });

    });

});

function rotateimgright() {
    $("#image").cropper('rotate', 90);
}


function rotateimgleft() {
    $("#image").cropper('rotate', -90);
}

function set_alert_info(content) {

    alert(content)

    // $("#alert_content").html(content);
}




