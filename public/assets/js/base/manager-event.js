jQuery(function ($) {
    $(document).on("submit", "form.e_ajax_submit", check_form);


    
});


function check_form(e) {
    var check_all = true;
    var form = $(this);
    var selector = Utils.creat_input_selector(":not(.disable_validate),");
    form.find(selector).each(function () {
        var temp = check_value(e, $(this));
        check_all = check_all && temp;
    });

    if (check_all) {
        ajax_submit_form(form);
    }
    e.preventDefault();
    return false;
}

function ajax_submit_form(form) {
    var btn = form.find("button[type='submit']");
    btn.removeClass('btn-primary');
    btn.addClass('btn-danger');
    btn.html('Loading ...');
    btn.attr('disabled', 'disabled');
    $('body').modalmanager('loading');
    form.ajaxSubmit({
        type: "POST",
        dataType: "text",
        cache: false,
        success: function (dataAll) {
            var temp = dataAll.split($("body").attr("data-barack"));
            var data = {};
            for (var i in temp) {
                temp[i] = $.parseJSON(temp[i]);
                data = $.extend({}, data, temp[i]);
            }
            if (window[data.callback]) {
                console.log("Gọi hàm: ", data.callback);
                window[data.callback](data, form, btn);
            } else {
                console.log("Không tìm thấy hàm yêu cầu:'", data.callback, "'-->Tự động gọi hàm xử lý mặc định 'default_form_submit_respone'");
                default_form_submit_respone(data, form, btn);
            }
        },
        error: function (a, b, c) {
            btn.html('Error');
            btn.removeClass('btn-success');
            btn.removeAttr('disabled');
//            alert(a + b + c);
        },
        complete: function (jqXHR, textStatus) {
            $('body').modalmanager('removeLoading');
        }
    });
}
