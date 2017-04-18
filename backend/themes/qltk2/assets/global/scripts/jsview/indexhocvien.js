 $(document).on('click','.row-hocvien',function(e)
 {
    e.preventDefault();
    var data = {mahocvien:$(this).attr('id').split('-')[1]};
    $.ajax({
            url: 'index.php?r=hocvien/chitiethocvien',
            data: data,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                Metronic.blockUI();
            },
            success: function (data) {
                if (data)
                {
                    $('.box-chitiethocvien').html(data);
                    $('#chitiethocvien').modal('show');
                }
                
            },
            error: function (r1, r2) {
                $(".thongbao").html(r1.responseText);
            },
            complete: function () {
                Metronic.unblockUI();
            }
        })
 })
 $(document).on('click pjax:success','.btn-remove-hocvien',function(e)
 {
    e.preventDefault();
    var data = {mahocvien:$(this).attr('id').split('-')[1]};
    if (confirm('Bạn có chắc chắn muốn xóa học viên này không ?'))
    {
          $.ajax({
            url: 'index.php?r=hocvien/xoahocvien',
            data: data,
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                Metronic.blockUI();
            },
            success: function (data) {
                if (!data.error)
                {
                    $('#chitiethocvien').modal('hide');
                    $.pjax.reload({container: "#crud-datatable-pjax"});
                    $('#crud-datatable-pjax').on('pjax:success',function()
                    {
                         $(".thongbao").html(data.message);
                    });
                }
                $(".thongbao").html(data.message);
            },
            error: function (r1, r2) {
                $(".thongbao").html(r1.responseText);
            },
            complete: function () {
                Metronic.unblockUI();
            }
        })
    }
  
 })