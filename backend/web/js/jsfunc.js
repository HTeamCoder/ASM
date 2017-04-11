/**
 * Created by HungLuongHien on 6/8/2016.
 */
function formatRepo(data) {
    if(typeof data.id == 'undefined' )
        return "Đang tìm....";
    return data.name;
}

function formatRepoSelection(data, container) {
/*    var descriptionShipper = "";
    descriptionShipper+= data.address;
    if(data.tel!="" && data.tel != null)
        descriptionShipper+="\n"+data.tel;
    if(data.fax != "" && data.fax != null)
        descriptionShipper += "\n"+data.fax;*/
/*    if(typeof data.address !='undefined')
        $("#shipper-addr").text(descriptionShipper);*/
    return data.name;
}
function formatSelectionHangvanchuyen(data, container) {
    var descriptionHangvanchuyen = "";
    descriptionHangvanchuyen+= data.address;
    if(data.tel!="" && data.tel != null)
        descriptionHangvanchuyen+="\n"+data.tel;
    if(data.fax != "" && data.fax != null)
        descriptionHangvanchuyen += "\n"+data.fax;
    if(typeof data.address !='undefined')
        $("#shipper-addr").text(descriptionHangvanchuyen);
    return data.name;
}
function formatOptionHangvanchuyen(data) {
    if(typeof data.id == 'undefined' )
        return "Đang tìm....";
    return data.name;
}


function formatOptionVessel(data) {
    if(typeof data.id == 'undefined' )
        return "Đang tìm....";
    var display = "";
    if(typeof data.name != 'undefined'){
        display+= data.name;
        if(data.voyNo != "" && data.voyNo != null)
            display+=" ("+data.voyNo+")";
        return display;
    }
    return data.text;
}
function formatDisplayVessel(data, container) {
    var display = "";
    if(typeof data.name != 'undefined'){
        display+= data.name;
        if(data.voyNo != "" && data.voyNo != null)
            display+=" ("+data.voyNo+")";
        return display;
    }
    return data.text;
}
function formatOptionPort(data) {
    if(typeof data.id == 'undefined' )
        return "Đang tìm....";
    var display = "";
    if(typeof data.name != 'undefined'){
        display+= data.name;
        if(data.code != "" && data.code != null)
            display+=" ("+data.code+")";
        return display;
    }
    return data.text;
}
function formatDisplayPort(data, container) {
    var display = "";
    if(typeof data.name != 'undefined'){
        display+= data.name;
        if(data.code != "" && data.code != null)
            display+=" ("+data.code+")";
        return display;
    }
    return data.text;
}
function noResult(id, notice, action){
    $(id).html(notice);
    return "Không tìm thấy. <a class='add-new-item' href='index.php?r='"+action+">"+notice+"</a>";
}
function noResultDaily() {
    $("#header-modal-new-item").html("Thêm đại lý");
    return "Không tìm thấy. <a class='add-new-item' href='index.php?r=daily/create'>Thêm đại lý</a>";
}
function noResultVessel() {
    $("#header-modal-new-item").html("Thêm tàu");
    return "Không tìm thấy. <a class='add-new-item' href='index.php?r=vessel/create'>Thêm tàu</a>";
}
function noResultHangvanchuyen() {
    $("#header-modal-new-item").html("Thêm hãng vận chuyển");
    return "Không tìm thấy. <a class='add-new-item' href='index.php?r=hangvanchuyen/create'>Thêm hãng vận chuyển</a>";
}
function noResultPort() {
    $("#header-modal-new-item").html("Thêm cảng");
    return "Không tìm thấy. <a class='add-new-item' href='index.php?r=port/create'>Thêm cảng</a>";
}
function autoCompleteModel(idSelection, action, formatItem, formatDisplay, functionNoResult) {
    $(idSelection).select2({
        allowClear: true,
        placeholder: {
            id: "",
            name: "Tìm kiếm và chọn ..."
        },
        ajax: {
            url: "index.php?r=autocomplete/"+action,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.length
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatItem, // omitted for brevity, see the source of this page
        templateSelection: formatDisplay, // omitted for brevity, see the source of this page
        language: {
            noResults: functionNoResult
        }
    });
}
function autocompleteSelect2() {
    autoCompleteModel("#masterbillofloading-dai_ly_id","getdaily",formatRepo, formatRepoSelection, noResultDaily);
    autoCompleteModel("#masterbillofloading-vessel_id","getvessel",formatOptionVessel, formatDisplayVessel, noResultVessel);
    autoCompleteModel("#masterbillofloading-hangvanchuyen_id","gethangvanchuyen",formatOptionHangvanchuyen, formatSelectionHangvanchuyen, noResultHangvanchuyen);
    autoCompleteModel("#masterbillofloading-port_of_loading, #masterbillofloading-port_of_discharge, #masterbillofloading-place_of_delivery, #masterbillofloading-place_of_receipt","getport",formatOptionPort, formatDisplayPort, noResultPort);
}
function submitForm(url, form) {
    var data;
    // Test if browser supports FormData which handles uploads
    if (window.FormData) {
        data = new FormData(form[0]);
    } else {
        // Fallback to serialize
        data = form.serializeArray();
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        async: false,
        beforeSend: function () {
        },
        error: function (response) {
        },
        success: function (response) {
            $("#modal-add-new-item .modal-body").html(response.content);
            $("#modal-add-new-item .modal-footer").html(response.footer);
        },
        contentType: false,
        cache: false,
        processData: false
    });
}
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
            $("#modal-add-new-item .modal-body").html(response.content);
            $("#modal-add-new-item .modal-footer").html(response.footer);
        },
        contentType: false,
        cache: false,
        processData: false
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
function tag_select2(selection, action) {
    $(selection).select2({
        tags: true,
        multiple: false,
        placeholder: "...",
        maximumSelectionSize: 1,
        minimumInputLength: 1,
        tokenSeparators: [",","\n"],
        createTag: function(item) {
            return {
                id: item.term,
                text: item.term
            };
        },
        templateResult: function(item){
            if(typeof item.code != 'undefined')
                return item.name + " (" + item.code + ")";
            return item.name || item.text;
        },
        templateSelection: function(item){
            if(typeof item.code != 'undefined')
                return item.name + " (" + item.code + ")";
            return item.name || item.text;
        },
        escapeMarkup: function (markup) { return markup; },
        ajax: {
            url: "index.php?r="+action,
            dataType: "json",
            global: false,
            cache: true,
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            // templateResult: formatResult, // omitted for brevity, see the source of this page
            // templateSelection: formatSelection // omitted for brevity, see the source of this page
        }
    });
}
function createForm(action, regionBody, regionFooter){
    $.ajax({
        url: "index.php?r="+action,
        method: 'GET',
        async: false,
        beforeSend: function () {
        },
        error: function (response) {
        },
        success: function (response) {
            $(regionBody).html(response.content);
            $(regionFooter).html(response.footer);
        },
        contentType: false,
        cache: false,
        processData: false
    });
}
function initValueSelect2WithTag(region, object) {
    if(object != null)
        $(region).select2({data: [{id: object.id, text: object.name}]});
}
$(document).on('click', '.add-new-item',function () {
    event.preventDefault();
    $("#modal-add-new-item").modal('show');
    var href = $(this).attr('href');
    getForm(href);
});
$(document).on('click', '#modal-add-new-item .modal-footer button[type="submit"]', function () {
    var form = $("#modal-add-new-item .modal-body form");
    var action = form.attr('action');

    submitForm(action, form);
});
$(document).on('click', '[role="modal-remote"]', function () {
    event.preventDefault();
    // Open modal
    var href = $(this).attr('href');
    getForm(href);
});