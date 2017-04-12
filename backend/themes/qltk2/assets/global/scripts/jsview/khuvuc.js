function getTreeKhuvuc(data){
    $("#tree_khuvuc").jstree({
        "core" : {
            "themes" : {
                "responsive": false
            },
            // so that create works
            "check_callback" : true,
            'data': data
        },
        "types" : {
            "default" : {
                "icon" : "fa fa-folder icon-state-warning icon-lg"
            },
            "file" : {
                "icon" : "fa fa-file icon-state-warning icon-lg"
            }
        },
        "state" : { "key" : "demo2" },
        "plugins" : [ "dnd", "state", "types" ]
    });
}
function getNewData() {
    return $.ajax({
        url: 'index.php?r=khuvuc/gettree',
        dataType: 'json'
    });
}

function refreshTree() {
    var ajax = getNewData();
    ajax.success(function (data) {
        $('#tree_khuvuc').jstree(true).settings.core.data = data;
        $('#tree_khuvuc').jstree(true).refresh();
    });
}
$(document).ready(function () {
    var ajax = getNewData();
    ajax.success(function (data) {
        getTreeKhuvuc(data);
    });

    $(document).on('click', '#btn-save', function () {
        refreshTree();
    });
    $("#reload-tree").click(function () {
        refreshTree();
    })
});