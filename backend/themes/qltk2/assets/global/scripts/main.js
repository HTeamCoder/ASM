/**
 * Created by HungLuongHien on 6/23/2016.
 */
function getAjax(controllerAction, data, callbackBeforeSend, target){
    return $.ajax({
        url: 'index.php?r='+controllerAction,
        data: data,
        type: 'post',
        dataType: 'json',
        beforeSend: callbackBeforeSend,
        error: function (r1, r2) {
            var text = r1.responseText;
            $(".thongbao").html(text.replace('',''));
        },
        complete: function () {
            Metronic.unblockUI(target);
        }
    })
}
function createTypeHead(target, action, callbackAfterSelect){
    $(target).typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/'+action, { query: query }, function (data) {
                $.each(data, function (i, state) {
                    states.push(state.name);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            if(typeof callbackAfterSelect != 'undefined')
                callbackAfterSelect(item);
            /*$.ajax({
             url: 'index.php?r=khachhang/getdiachi',
             data: {name: item},
             type: 'post',1
             dataType: 'json',
             success: function (data) {
             $("#diachikhachhang").val(data);
             }
             })*/
        }
    });
}
function setDatePicker() {
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'vi',
        todayBtn: true,
        todayHighlight: true,
    });
}

jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar
    // $(".tien-te").maskMoney({thousands:",", allowZero:true, /*suffix: " VNĐ",*/precision:3});

});
$('#ajaxCrudModal').attr('tabindex','');