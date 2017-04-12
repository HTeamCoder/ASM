/**
 * Created by HungLuongFamily on 1/22/2016.
 */
function Ajax(modelName,targetAlert, controllerName, afterSuccess, afterLoad){
    this.modelName = modelName;
    this.targetAlert = targetAlert;
    this.targetBlock  = "#modal-"+this.modelName+" .modal-body";
    this.btnAdd = "#them-"+this.modelName;
    this.btnUpdate = ".sua-"+this.modelName;
    this.btnSaveAndClose = "#luu-"+this.modelName;
    this.urlLoad = "index.php?r="+this.modelName+"/load";
    this.urlSave = "index.php?r="+this.modelName+"/luu";
    this.targetHidden = "#"+modelName+"_"+modelName+"_key";
    this.modalId = "#modal-"+modelName;
    this.formModel = "#form-"+modelName;
    this.gridViewModel = "#grid-"+modelName;
    this.callback = afterSuccess;
    this.afterLoad = afterLoad;
    this.controllerName = controllerName;
}
Ajax.prototype = {
    constructor: Ajax,
    block : function(options) {
        var globalImgPath = "backend/web/img/";

        options = $.extend(true, {}, options);
        var html = '';
        if (options.animate) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
        } else if (options.iconOnly) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + globalImgPath + 'loading-spinner-grey.gif" align=""></div>';
        } else if (options.textOnly) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
        } else {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + globalImgPath + 'loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
        }

        if (options.target) { // element blocking
            var el = $(options.target);
            if (el.height() <= ($(window).height())) {
                options.cenrerY = true;
            }
            el.block({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                centerY: options.cenrerY !== undefined ? options.cenrerY : false,
                css: {
                    top: '10%',
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        } else { // page blocking
            $.blockUI({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                css: {
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        }
    },
    unblock: function (target) {
        if (target) {
            $(target).unblock({
                onUnblock: function() {
                    $(target).css('position', '');
                    $(target).css('zoom', '');
                }
            });
        } else {
            $.unblockUI();
        }
    },
    getAjax : function(url, data, dataType){
        var me = this;
        return $.ajax({
            url: url,
            data: data,
            dataType: dataType,
            type: "post",
            beforeSend: function(){
                $(me.targetAlert).html("");
                if(me.targetBlock != "")
                    me.block();
            },
            error: function(r1, r2){
                $(me.targetAlert).html(r1.responseText);
            },
            complete: function(){
                if(me.targetBlock != "")
                    me.unblock(me.targetBlock);
            }
        })
    },
    addNewItem : function(){

    },
        btn_click: function(){
        var me = this;

        //Nhấn nút thêm
        $(me.btnAdd).on('click',function(){
            $(me.btnSaveAndClose).html("<i class='fa fa-plus'></i> Thêm mới");
            $(me.targetAlert).html("");
            var valueHidden = $(me.targetHidden).val();
            if(valueHidden!=""){
                $(me.formModel)[0].reset();
                $(me.targetHidden).val("");
            }//dang trong trang thai sua, khi click vao thi reset form va xoa value nay di

        });

        //Nhấn nút lưu
        $(me.btnSaveAndClose).on('click',function(){
            var formData = new FormData($(me.formModel)[0]);
            if(me.controllerName!="")
                me.urlSave = "index.php?r="+me.controllerName+"/luu";
            $.ajax({
                url: me.urlSave,
                data: formData,
                dataType: 'json',
                type: "post",
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                beforeSend: function(){
                    if(me.targetBlock != "")
                        me.block({target: me.targetBlock});
                },
                error: function(r1, r2){
                    $(me.targetAlert).html(r1.responseText);
                },
                success: function(data){
                    $(me.targetAlert).html(data.message);
                    $(me.modalId).modal('hide');
                    $(me.formModel)[0].reset();
                    $(me.targetHidden).val("");
                    // $.pjax.reload({container:me.gridViewModel});
                    $(me.gridViewModel).yiiGridView('applyFilter');

                    if(typeof me.callback == 'function')
                        me.callback();
                },
                complete: function(){
                    if(me.targetBlock != "")
                        me.unblock(me.targetBlock);
                }
            });
        });

        //Nhấn nút sửa
        $(me.btnUpdate).on('click',function(){
            $(me.targetAlert).html("");
            $(me.btnSaveAndClose).html("<i class='fa fa-edit'></i> Sửa lại");
            $(me.formModel)[0].reset();
            var ajaxSend = me.getAjax(me.urlLoad, {id: $(this).attr("id")}, 'json');
            ajaxSend.success(function(data){
                $.each(data, function(attr, value){
                    $("#"+me.modelName+"_"+attr).val(value);
                });
                $(me.targetHidden).val(data.id);
                if(typeof me.afterLoad == 'function')
                    me.afterLoad(data);
            });

        });


    }
};
