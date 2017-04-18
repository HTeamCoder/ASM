function createTypeHeadHocVien(id, field) {
    $(id).typeahead({
        source: function (query, process) {
            var states = [];
            return $.get('index.php?r=autocomplete/gethocvien', { query: query }, function (data) {
                $.each(data, function (i, state) {
                    if(field == 'ma')
                        states.push(state.ma);
                    else
                        states.push(state.name);
                });
                return process(states);
            }, 'json');
        },
        afterSelect: function (item) {
            var data = {'item': item};
            $.ajax({
                url: 'index.php?r=hocvien/getinfo',
                data: data,
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
}