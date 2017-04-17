
createTypeHead('.khuvuchuyen','getkhuvuchuyen');
createTypeHead('.khuvuctinh','getkhuvuctinh');
createTypeHead('.nhommau','getnhommau');
createTypeHead('.benhvien','getbenhvien');
createTypeHead('.trinhdohocvan','gettrinhdohocvan');
createTypeHead('.congtacvien','getcongtacvien');
createTypeHead('.noicap','getnoicap');
createTypeHead('.noihoctap','getnoihoctap');
createTypeHead('.noisinh','getnoisinh');
createTypeHead('.khoahoc','getkhoahoc');
createTypeHead('.lophoc','getlophoc');
createTypeHead('.donhang','getdonhang');
function createTypeHeadKhuvucxa(target) {
    $(target).typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/getkhuvucxa', { query: query }, function (data) {
                $.each(data, function (i, state) {
                    states.push(state.name);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            var data = {name: item};
                $.ajax({
                    url: 'index.php?r=khuvuc/getrowinfo',
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data.quanhuyen != '')
                        {
                            $('.khuvuchuyen').val(data.quanhuyen);
                        }
                        if (data.tinhthanh != '')
                        {
                            $('.khuvuctinh').val(data.tinhthanh);
                        }
                    }
                })
            
        }
    });
}
createTypeHeadKhuvucxa('.khuvucxa');
$('#hocvien-name').focus();
 $(document).on('click', '.btn-save', function (e) {
        e.preventDefault();
        var data;
        if (window.FormData) {
            data = new FormData($("#form-hocvien")[0]);
        } else {
            data = $("#form-hocvien").serializeArray();
        }

        $.ajax({
            url: 'index.php?r=hocvien/luuhocvien',
            data: data,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                Metronic.blockUI();
            },
            success: function (data) {
                if (!data.error)
                {
                    $("#form-hocvien")[0].reset();
                    $('#hocvien-name').focus();
                }
                if ($('#hocvien-id').length>0)
                {
                    if($('#hocvien-id').val()!='')
                        window.location = 'index.php?r=hocvien';
                }
                $('.thongbao').html(data.message);
            },
            error: function (r1, r2) {
                $(".thongbao").html(r1.responseText);
            },
            complete: function () {
                Metronic.unblockUI();
            },
            contentType: false,
            cache: false,
            processData: false,
        })
    });
$(document).on('click', '.btn-remove', function (e) {
        e.preventDefault();
        if($("#table-donhang tbody tr").length > 0){
            if(confirm("Bạn có chắc chắn muốn xóa không?"))
            {
                $(this).parent().parent().remove();
            }
        }
    });
$(document).on('click', '.btn-themdonhang', function (e) {
        e.preventDefault();
        var index = $('#soluongdonhang').val();
       $("#table-donhang tbody").append('<tr><td><input type="text" class="form-control donhang" name=Donhangchitiet['+index+'][donhang_id]" autocomplete="off"></td><td><input type="text" class="form-control ghichu" name=Donhangchitiet['+index+'][ghichu]"></td><td class="text-center"><a class="btn-remove btn btn-sm btn-danger " href="#"><i class="fa fa-trash"></i></a></td></tr>');
       index++;
        $('#soluongdonhang').val(index);
        createTypeHead('.donhang','getdonhang');
});