/**
 * Created by HungLuongHien on 6/7/2016.
 */
function resetForm() {
    $(".select2.form-control").empty();
    autoCompleteModel("#housebill-shipper, #housebill-consignee","getgiaonhanhang",formatRepo, formatRepoSelection, function () {
        $("#header-modal-new-item").html("Thêm đơn vị giao/nhận");
        return "Không tìm thấy. <a class='add-new-item' href='index.php?r=giaonhanhang/create'>Thêm đơn vị giao/nhận</a>";
    });
    $("#form-hbl")[0].reset();
}
function savingHBL(data){
    var ajax = new Ajax();
    $.ajax({
        url: "index.php?r=housebill/save",
        method: 'post',
        async: false,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            ajax.block();
            $(".form-group .help-block").html("");
            $(".form-group").removeClass('has-error');
            $(".thongbao").html("");
        },
        error: function (response) {
        },
        success: function (response) {
            if(response.error == true){
                $.each(response.listError, function (k, v) {
                    $(".field-housebill-"+k).addClass('has-error');
                    $(".field-housebill-"+k+" .help-block").html(v);
                })
            }else{
                console.log(response.message);
                $.pjax.reload({container:'#attached-list',method: 'post', data: "idMbl=chonMbl-"+$("#housebill-mbl-id").val()});
                resetForm();
                toastr.success(response.message, 'Thông báo');
            }
        },
        complete: function (response) {
            ajax.unblock();
        },
        contentType: false,
        cache: false,
        processData: false
    });
}

$(document).ready(function () {
    $("#modal-ds-mbl").modal('show');
    $(document).on('click', '.btn-chon-Mbl', function () {
        var idMbl = $(this).attr("id");
        var ajaxCls = new Ajax();
        
        return $.ajax({
            url: "index.php?r=masterbillofloading/getmbl",
            data: {mbl: idMbl},
            type: 'post',
            dataType: 'json',
            beforeSend: function (data) {
                $(".thongbao").html("");
                ajaxCls.block();
                // $("#attached-list").yiiGridView({data: {idMbl: $(this).attr('id')}});
            },
            success: function (data) {
                $("#modal-ds-mbl").modal('hide');
                // View thong tin mBL
                $("#thong-tin-mbl").html(data.view_mbl);
                // Update selection Container
                $.pjax.reload({container:'#attached-list',method: 'post', data: "idMbl="+idMbl});
                $("#title-dshbl").html("Danh sách HBL của MBL #"+ data.code);
                createForm("housebill/create", "#thong-tin-hbl .box-body", "#thong-tin-hbl .box-footer");
                tag_select2("#housebill-part_id",'autocomplete/getpart');
                tag_select2("#housebill-shipper, #housebill-consignee",'autocomplete/getgiaonhanhang');
                tag_select2("#housebill-unitpakage_id",'autocomplete/getunitpakage');
                tag_select2("#housebill-notify_party_id",'autocomplete/getnotifyparty');
                tag_select2("#housebill-status_bl_id",'autocomplete/getstatusbl');
                tag_select2("#housebill-place_of_delivery, #housebill-place_of_receipt, #housebill-port_of_discharge",'autocomplete/getport');
                initValueSelect2WithTag('#housebill-place_of_delivery',data.port_of_delivery);
                initValueSelect2WithTag('#housebill-port_of_discharge',data.port_of_discharge);
                initValueSelect2WithTag('#housebill-place_of_receipt',data.port_of_receipt);
                $("#housebill-container_mbl_id").empty();
                $("#housebill-container_mbl_id").html("<option>Chọn Container...</option>");
                $.each(data.containers, function (k, v) {
                    $("#housebill-container_mbl_id").append('<option value="'+v.id+'">'+v.name+' ('+v.seal+') '+'</option>');
                });
                $("#housebill-mbl-id").val(data.idMbl);
            },
            error: function (responsive) {
                $('.thongbao').html(responsive.Text);
            },
            complete: function () {
                ajaxCls.unblock();
            }
        })
    });
    $(document).on('click', '.btn-save', function () {
        var data;
        // Test if browser supports FormData which handles uploads
        if (window.FormData) {
            data = new FormData($("#form-hbl")[0]);
        } else {
            // Fallback to serialize
            data = $("#form-hbl").serializeArray();
        }
        savingHBL(data);
    });
    $(document).on('click', '#addFee', function () {
        $("#others-fee").append(
            '<div class="row form-group">' +
                '<div class="col-md-5"> <input type="text" class="form-control" name="nameFee[]" value="" placeholder="Name of fee"></div>' +
                '<div class="col-md-5"> <input type="number" class="form-control" name="valueFee[]" value="0" min="0" step="1.0E-5"></div>' +
                '<div class="col-md-1"> <button type="button" class="btn btn-social-icon btn-bitbucket btn-del-fee"><i class="fa fa-trash"></i></button></div>' +
            '</div>');
    });
    $(document).on('click', '.btn-del-fee',function () {
        $(this).parent().parent().remove();
    });
    $(document).on('click', '.btn-in', function(){
        $.ajax({
            url: "index.php?r=housebill/printarrivalnotice",
            data: {hblId: $(this).attr("id")},
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $("#print-block-arrival-notice").html(data).printElement();
            }
        })
    });
    $(document).on('click', '.btn-inallarrivalnotice', function(){
        $.ajax({
            url: "index.php?r=masterbillofloading/printall",
            data: {mblID: $(this).attr("id")},
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $("#print-block-arrival-notice").html(data).printElement();
            }
        })
    });
    $(document).on('click', '.btn-downloadexcel', function () {
        window.location = 'index.php?r=housebill/export&idhbl='+$(this).attr("id");
        return false;
    })
});