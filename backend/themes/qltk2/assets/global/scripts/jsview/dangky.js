createTypeHead('.khuvuchuyen','getkhuvuchuyen');
createTypeHead('.khuvuctinh','getkhuvuctinh');
createTypeHead('.nhommau','getnhommau');
createTypeHead('.benhvien','getbenhvien');
createTypeHead('.trinhdohocvan','gettrinhdohocvan');
createTypeHead('.congtacvien','getcongtacvien');
createTypeHead('.noicap','getnoicap');
createTypeHead('.noihoctap','getnoihoctap');
createTypeHead('.noisinh','getnoisinh');
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
                        $('#hocvien-noisinh').focus();
                    }
                })
            
        }
    });
}
createTypeHeadKhuvucxa('.khuvucxa');
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
                    $.each(data.hocvien, function (field, value) {
                        
                        if (field != 'khuvuc_id')
                        {
                            if (field == 'anhdaidien')
                            {
                                $('.anhdaidien').attr('src','anhhocvien/'+value);
                            }else {
                                $("#hocvien-"+field).val(value);
                            }
                            
                        }
                    });
                    $.each(data.diachi, function (field, value) {
                        $("#hocvien-"+field).val(value);
                    });
                  
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
                    $.each(data.hocvien, function (field, value) {
                        
                        if (field != 'khuvuc_id')
                        {
                            if (field == 'anhdaidien')
                            {
                                $('.anhdaidien').attr('src','anhhocvien/'+value);
                            }else {
                                $("#hocvien-"+field).val(value);
                            }
                            
                        }
                    });
                    $.each(data.diachi, function (field, value) {
                        $("#hocvien-"+field).val(value);
                    });
                }
            })
        }
    });
$('#hocvien-name').focus();
$(document).on('click','.btn-dangky',function()
{
    var me = $(this);
    var data;
        if (window.FormData) {
            data = new FormData($("#form-hocvien")[0]);
        } else {
            data = $("#form-hocvien").serializeArray();
        }
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
                    $('#hocvien-name').focus();
                    $("#form-hocvien")[0].reset();
                    $('.anhdaidien').attr('src',$('#urlanhdaidien').val());
                    if(($("#idhocvien").val() != "" )||($(me).attr('data-type') == 'old'))
                    {
                        window.location = 'index.php?r=hocvien/index';
                    }

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