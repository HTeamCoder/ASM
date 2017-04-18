$("#hocvien-ma").typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/gethocvien', { query: query }, function (data) {
                $.each(data, function (i, state) {
                    states.push(state.ma);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            $.ajax({
                url: 'index.php?r=hocvien/getinfo',
                data: {item: item},
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (field, value) {
                        $("#hocvien-"+field).val(value);
                    })
                }
            })
        }
    });
$("#hocvien-name").typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/gethocvien', { query: query }, function (data) {
                $.each(data, function (i, state) {
                    states.push(state.name);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            $.ajax({
                url: 'index.php?r=hocvien/getinfo',
                data: {item: item},
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (field, value) {
                        $("#hocvien-"+field).val(value);
                    })
                }
            })
        }
    });
function createTypeHeadDonhang(target) {
    var idMe = null;
    $(target).typeahead({
        source: function (query, process) {
            idMe = $(this)[0].$element.context.id;
            var states = [];
            return $.get('index.php?r=autocomplete/getdonhang', { query: query }, function (data) {
                $.each(data, function (i, state) {
                    states.push(state.name);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            var data = {name: item};
            $.ajax({
                url: 'index.php?r=donhang/getrowinfo',
                data: data,
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    var soluonginput = parseInt($("#soluongdonhang").val(), 10) ;
                    var index = $("#"+idMe).parent().parent().find('button').val();
                    $("#"+idMe).parent().parent().find('.donhang').val(data.name);
                    $("#"+idMe).parent().parent().find('.ngaythi').html(data.ngaythi);
                    $("#"+idMe).parent().parent().find('.ngaydo').html(data.ngaydo);
                    var lastMaHang = $(".donhang").last();
                    if(lastMaHang.val() != ""){
                        soluonginput++;
                        $("#soluongdonhang").val(soluonginput);
                        var inputTextMahang = '<input type="text" id="Donhangchitiet-'+soluonginput+'-donhang_id" class="form-control donhang" name="Donhangchitiet['+soluonginput+'][donhang_id]" autocomplete="off">';
                        var inputTextSerial = '<input type="text" id="Donhangchitiet-'+soluonginput+'-ghichu" class="form-control ghichu" name="Donhangchitiet['+soluonginput+'][ghichu]" autocomplete="off">';
                        $("#"+idMe).parent().parent().parent().append('<tr ><td>'+inputTextMahang+'</td><td>'+inputTextSerial+
                            '</td><td class="ngaythi"></td><td class="ngaydo"></td><td class="action text-center btn-action">' +
                            '<button type="button" class="btn btn-sm btn-danger btn-remove" value="'+soluonginput+'"><i class="fa fa-trash"></i></button> </td></td></tr>');
                        createTypeHeadDonhang('#Donhangchitiet-'+soluonginput+'-donhang_id');
                    }
                    $('.donhang').last().focus();
                }
            })
        }
    });
}
createTypeHeadDonhang('.donhang');
$(document).on('click','.btn-dangky',function()
{
    var data = $('#form-hocvien,#form-donhangchitiet').serializeArray();
    $.ajax({
            url: 'index.php?r=tuyendung/luudangky',
            data: data,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                Metronic.blockUI();
                $(".thongbao").html("");
            },
            success: function (data) {
                if (!data.error)
                {
                    $("#form-hocvien,#form-donhangchitiet")[0].reset();
                    $("#table-donhang tbody").html('<tr>' +
                        '<td><input type="text" id="Donhangchitiet-0-donhang_id" class="form-control mahang" name="Donhangchitiet[0][donhang_id]" autocomplete="off"></td>' +
                        '<td><input type="text" id="Donhangchitiet-0-ghichu" class="form-control soserial" name="Donhangchitiet[0][ghichu]" autocomplete="off"></td>' +
                        '<td class="ngaythi"></td><td class="ngaydo"></td></td> <td class="action text-center btn-action"> ' +
                        '<button type="button" class="btn btn-sm btn-danger btn-remove" value="0"><i class="fa fa-trash"></i></button> ' +
                        '</td> </tr>');
                    createTypeHeadDonhang('.donhang');
                    
                    if($("#idhocvien").val() != "")
                        window.location = 'index.php?r=tuyendung/index';

                }
                $('.thongbao').html(data.message);
            },
            error: function (r1, r2) {
                $(".thongbao").html(r1.responseText);
            },
            complete: function () {
                Metronic.unblockUI();
            }
        })
});