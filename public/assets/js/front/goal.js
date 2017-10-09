/**
 * Created by admin on 2/20/2017.
 */
$(document).ready(function () {
    $(document).on("change", "select.e_select_goal", function () {
        var obj = $(this);
        change_view_choice_goal(obj);
    });
});

function change_view_choice_goal(obj) {
    var url = obj.attr('data-url') + '/' + obj.val();
    show_loading();
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (dataAll) {
            show_view_choice_method(obj, dataAll.data);
        },
        error: function (a, b, c) {
            alert(a + b + c);
        },
        complete: function (jqXHR, textStatus) {
            hide_loading();
        }
    });
}
function show_view_choice_method(obj, data) {
    var child = obj.parents('div.form-group').find('.e_select_method_child');
    if (data.length) {
        var html = '<option value="" selected disabled hidden>Chọn phương thức</option>';
        for (var i = 0; i < data.length; i++) {
            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
        }
        child.html(html);
        child.fadeIn(500);
        child.attr('name', obj.attr('name'));
        obj.removeAttr('name');
    } else {
        child.html('');
        child.fadeOut(500);
        obj.attr('name', child.attr('name'));
        child.removeAttr('name');
    }
}

