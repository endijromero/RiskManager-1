/**
 * Created by admin on 2/20/2017.
 */
$(document).ready(function () {
    $(document).on("change", "select.e_select_risk", function () {
        var obj = $(this);
        change_view_choice_risk(obj);
    });
});

function change_view_choice_risk(obj) {
    var url = obj.attr('data-url') + '/' + obj.val();
    show_loading();
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        success : function (dataAll) {
            show_view_choice_method(obj, dataAll.data);
        },
        error   : function (a, b, c) {
            alert(a + b + c);
        },
        complete: function (jqXHR, textStatus) {
            hide_loading();
        }
    });
}

function create_fitness_manage_table_callback(data, obj) {
    default_data_table(data, obj);
    obj.find('.filter-footer').remove();
    if (data.count_rows) {
        obj.find('.widget-toolbox').remove();

    }
}
