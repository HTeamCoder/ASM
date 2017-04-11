/**
 * Created by HungLuongHien on 6/9/2016.
 */
function noResultKho() {
    $("#header-modal-new-item").html("Thêm Kho");
    return "Không tìm thấy. <a class='add-new-item' href='index.php?r=khohang/create'>Nhấn vào đây để thêm Kho</a>";
}
function savingArrivalNotice(data){
    var ajax = new Ajax();
    $.ajax({
        url: "index.php?r=arrivalnotice/save",
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
                    $(".field-arrivalnotice-"+k).addClass('has-error');
                    $(".field-arrivalnotice-"+k+" .help-block").html(v[0]);
                })
            }else{
                if($("#lydothaydoi").html()=="")
                    $("#lydothaydoi").html(
                        '<div class="row">' +
                            '<div class="col-md-12">' +
                                '<div class="form-group field-arrivalnotice-lydothaydoi"> ' +
                                    '<label class="control-label" for="arrivalnotice-lydothaydoi">Lý do thay đổi</label> ' +
                                    '<textarea id="arrivalnotice-lydothaydoi" name="ArrivalNotice[lydothaydoi]" rows="3" class="form-control"></textarea>'+
                                    '<div class="help-block"></div> ' +
                                '</div>' +
                            '</div>' +
                        '</div>'
                    );
                toastr.success(response.message, 'Thông báo');
                themNutIn();
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
function themNutIn() {
    // Thêm nút in phiếu
    var nutIn = " <button id='print-arrival-notice' class='btn btn-success btn-flat'>In</button>";

    if($("#thong-tin-arrival-notice .box-footer button").length == 1)
        $("#thong-tin-arrival-notice .box-footer").append(nutIn);
}
$(document).ready(function () {
    $("#modal-list-hbl").modal('show');
    $(document).on('click', '.btn-chon-Hbl', function () {
        var idHbl = $(this).attr("id");
        return $.ajax({
            url: "index.php?r=housebill/gethbl",
            data: {hbl: idHbl},
            type: 'post',
            dataType: 'json',
            beforeSend: function (data) {
            },
            success: function (data) {
                // View thong tin mBL
                $("#view-hbl").html(data.view_hbl);
                // Update selection Container
                createForm("arrivalnotice/create","#thong-tin-arrival-notice .box-body","#thong-tin-arrival-notice .box-footer");
                autoCompleteModel("#arrivalnotice-kho_id","getkho",formatOptionVessel, formatDisplayVessel, noResultKho);
                setDatePicker();
                if(typeof data.newArrivalNotice.id != 'undefined'){
                    $("#lydothaydoi").html(
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<div class="form-group field-arrivalnotice-lydothaydoi"> ' +
                        '<label class="control-label" for="arrivalnotice-lydothaydoi">Lý do thay đổi</label> ' +
                        '<textarea id="arrivalnotice-lydothaydoi" name="ArrivalNotice[lydothaydoi]" rows="3" class="form-control"></textarea>'+
                        '<div class="help-block"></div> ' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );
                    $.each(data.newArrivalNotice, function (k, v) {
                        $("#arrivalnotice-" + k).val(v);
                    });
                    $("#arrivalnotice-kho_id").html('<option value="'+data.idkho+'" selected="selected">'+data.tenkho+'</option>');
                    // $("#arrivalnotice-kho_id").select2();
                    autoCompleteModel("#arrivalnotice-kho_id","getkho",formatOptionVessel, formatDisplayVessel, noResultKho);

                    $("#datepicker").val(data.newArrivalNotice.arrival_date);
                    themNutIn();
                }
                else
                    $("#lydothaydoi").html("");
                $("#arrivalnotice-hbl_id").val(data.idHbl);
                $("#modal-list-hbl").modal('hide');
            },
            error: function (responsive) {

            }
        })
    });
    $(document).on('click', '.btn-save', function () {
        var data;
        // Test if browser supports FormData which handles uploads
        if (window.FormData) {
            data = new FormData($("#arrival-notice-form")[0]);
        } else {
            // Fallback to serialize
            data = $("#arrival-notice-form").serializeArray();
        }
        savingArrivalNotice(data);
    });
    $(document).on('click', '#print-arrival-notice', function () {
        $.ajax({
            url: "index.php?r=arrivalnotice/print",
            data: {hblId: $("#arrivalnotice-hbl_id").val()},
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $("#print-block-arrival-notice").html(data).printElement();
            }
        })
    })
});