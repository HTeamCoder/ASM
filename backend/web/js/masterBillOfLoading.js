/**
 * Created by HungLuongHien on 6/3/2016.
 */

function getForm(url) {
    $.ajax({
        url: url,
        method: 'GET',
        async: false,
        beforeSend: function () {
        },
        error: function (response) {
        },
        success: function (response) {
            $(".modal-body").html(response.content);
            $(".modal-footer").html(response.footer);
        },
        contentType: false,
        cache: false,
        processData: false
    });
}
function resetForm() {
    $(".select2.form-control").empty();
    autocompleteSelect2();
    $("#form-mbl")[0].reset();
    $("#shipper-addr").val("");
}

function waitting_to_redirect(seconds, url, id, noidung){
    (function addDot() {
        setTimeout(function() {
            if (seconds-- > 0) {
                $(id).html(
                    '<div class="alert alert-success alert-dismissible"> ' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> ' +
                        '<h4><i class="icon fa fa-check"></i> Thông báo!</h4>' + noidung + '<span style="font-size: 15pt">'+seconds + '</span> giây'+
                    '</div>');
                addDot();
            }
            else
                window.location = url;
        }, 1000);
    })();
}

function saving() {
    var data;

    // Test if browser supports FormData which handles uploads
    if (window.FormData) {
        data = new FormData($("#form-mbl")[0]);
    } else {
        // Fallback to serialize
        data = $("#form-mbl").serializeArray();
    }
    var ajax = new Ajax();
    return $.ajax({
        url: "index.php?r=masterbillofloading/save",
        method: 'post',
        data: data,
        async: false,
        dataType: 'json',
        beforeSend: function () {
            ajax.block();
            $(".form-group .help-block").html("");
            $(".form-group").removeClass('has-error');
            $(".thongbao").html("");
        },
        error: function (response) {
            console.log(response);
        },
        complete: function () {
            ajax.unblock();
        },
        contentType: false,
        cache: false,
        processData: false
    });
}
$(document).ready(function () {
    // autocompleteSelect2();
    //Date picker
    setDatePicker();
    tag_select2("#masterbillofloading-dai_ly_id",'autocomplete/getdaily');
    tag_select2("#masterbillofloading-hangvanchuyen_id",'autocomplete/gethangvanchuyen');
    tag_select2(".form-control[role='get-port']",'autocomplete/getport',function (data) {
        return data.name + " ("+data.code+")";
    }, function (data, container) {
        return data.name + " ("+data.code+")";
        
    });
    tag_select2("#masterbillofloading-vessel_id",'autocomplete/getvessel');

    $("#addContainer").on('click', function () {
        $("#info-container").append(
            '<div class="row form-group"> ' +
                '<div class="col-md-4"><input type="text" class="form-control" name="containerName[]" value="" placeholder="Container Name"></div> ' +
                '<div class="col-md-3"><input type="text" class="form-control" name="containerCode[]" value="" placeholder="Type"></div> ' +
                '<div class="col-md-3"><input type="text" class="form-control" name="containerSeal[]" value="" placeholder="Seal"></div> ' +
                '<div class="col-md-1"><button type="button" class="btn btn-social-icon btn-bitbucket btn-del-container"><i class="fa fa-trash"></i></button></div>'+
            '</div>'
        );
    });
    $("div").on('click', '.btn-del-container',function () {
        $(this).parent().parent().remove();
    });
    $("#btn-save-only").click(function(){
        var afterSave = saving();
        afterSave.success(function (response) {
            if(response.error == true){
                $.each(response.listError, function (k, v) {
                    $(".field-masterbillofloading-"+k).addClass('has-error');
                    $(".field-masterbillofloading-"+k+" .help-block").html(v);
                })
            }else{
                resetForm();
                toastr.success(response.message, 'Thông báo');
            }
        })
    });
    $("#btn-save-and-insert-hbl").click(function () {
        var afterSave = saving();
        afterSave.success(function (response) {
            if(response.error == true){
                $.each(response.listError, function (k, v) {
                    $(".field-masterbillofloading-"+k).addClass('has-error');
                    $(".field-masterbillofloading-"+k+" .help-block").html(v);
                })
            }else{
                resetForm();
                toastr.success(response.message, 'Thông báo');
                waitting_to_redirect(10, "index.php?r=housebill/addhbl",".thongbao","Hệ thống sẽ tự động chuyển sang chức năng nhập HBL trong ");
            }
        })
    });
    $(document).on('click', '.add-new-item',function () {
        event.preventDefault();
        $("#modal-add-new-item").modal('show');
        var href = $(this).attr('href');
        getForm(href);
    });

});
