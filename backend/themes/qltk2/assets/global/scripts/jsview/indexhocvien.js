 $(document).on('click','.row-hocvien',function(e)
 {
    e.preventDefault();
    window.location = "index.php?r=hocvien/capnhathocvien&id="+$(this).attr('id').split('-')[1];
 })