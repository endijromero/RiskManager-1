$(document).ready(function () {
    setup_property();
    var selector = creat_input_selector(":not(.disable_validate),");
    change_view_form();
    $(document).on("click", "a[href='#']", function (e) {
        e.preventDefault();
    });
    $(document).on("change", selector, check_value);
    $(document).on("submit", "form.e_ajax_submit", check_form);
    $(document).on("click", ".e_ajax_link", do_ajax_link);
    $(document).on("change", ".e_check_all", do_check_all);
    $(document).on("click", ".e_reverse_button", reverse_check);
    $(document).on("change", "input[name='_e_check_all']", show_delete_button);
    $(document).on("change", ".e_changer_number_record", bind_ajax_change_table);//Đổi só bản ghi trên trang
    $(document).on("click", ".e_data_paginate li:not(.disabled):not(.active)", bind_ajax_change_table);//Click phân trang
    $(document).on("submit", ".e_filter_form", bind_ajax_change_table);//Search
    $(document).on("click", ".e_data_table thead tr th:not(.disable_sort)", bind_ajax_change_table);//Sort
    $(document).on("keyup", "input[type='number'][number_format]", show_number_format);
    $(document).on("click", '.e_file_input_change', show_file_input);
    $(document).on("click", '.e_file_input_change_cancel', hide_file_input);
    $("input[type='number'][number_format]").each(function () {
        show_number_format(this);
    });
    $(document).on('hidden.bs.modal', ".modal", function () {
        $(this).remove();
    });
    $(document).on('shown.bs.modal', ".modal", function () {
        change_view_form();
        var form_in_modal = $(".e_modal_content").find(creat_input_selector(""));
        if (form_in_modal.length) {
            form_in_modal[0].focus();
        }
    });

    $(".e_manager_table_container").each(function () {
        creat_ajax_table($(this));
    });
    setup_select();
});

function show_file_input() {
    $(this).closest(".e_file_preview_container").hide().siblings(".e_file_input_container").show();
}
function hide_file_input() {
    var file_input = $(this).closest(".e_file_input_container").find("input[type='file']");
    file_input.val("");
    if (file_input.hasClass("ace_file_input")) {
        file_input.ace_file_input('reset_input');
    }
    $(this).closest(".e_file_input_container").hide().siblings(".e_file_preview_container").show();
}

function setup_property() {
    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
    /**
     * Number.prototype.format(n, x, s, c)
     *
     * @param integer n: length of decimal
     * @param integer x: length of whole part
     * @param mixed   s: sections delimiter
     * @param mixed   c: decimal delimiter
     */
    Number.prototype.format = function (n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };
}

function setup_select() {
    //Set jgrowl close template
    $.jGrowl.defaults.closerTemplate = '<div class="alert-info">Close All</div>';

    $("select.select2").select2();
    $('.select2').addClass('tag-input-style');
    //Fix form reset of chosen select
    $("input[type='reset'], button[type='reset']").click(function (e) {
        e.preventDefault();

        var form = $(this).closest('form');
        form.get(0).reset();
        form.find('select').each(function (i, v) {
            $(this).val('').trigger('change');
        });
        form.find('.chosen-select').each(function (i, v) {
            $(this).val('').trigger("chosen:updated");
        });
    });
    //Fix tab in from with select2
    $(document).on('focus', '.select2-container.select2', show_on_focus);
    function show_on_focus() {
        if ($(this).find(".select2-selection--multiple").length) {
            //disable feature with multiple select because it is default
            return;
        }
        $(this).siblings('select').select2('open');
        $(document).off('focus', '.select2-container.select2');
        $(document).on('select2:close', 'select.select2', focus_on_close);
    }

    function focus_on_close() {
        $(this).focus();
        $(document).on('focus', '.select2-container.select2', show_on_focus);
        $(document).off('select2:close', 'select.select2');
    }
}

function show_number_format(e, object) {
    if (typeof object == "undefined") {
        object = $(this);
    }
    var value = object.val();
    var dot = object.attr("number_format");
    value = parseInt(value);
    var StringValue = value.format(0, 3, dot, ",");
    if (object.parent().find(".number_formated").length) {
        object.parent().find(".number_formated").html(StringValue);
    } else {
        object.parent().append("<span class='number_formated'>" + StringValue + "</span>");
    }
}


function bind_ajax_change_table(e) {
    /* Xử lý riêng khu vực phân trang */
    var cancel = false;
    var obj = $(this);
    if (obj.parents(".e_data_paginate").length) {
        obj.siblings().removeClass("active");
        obj.addClass("active");
    }
    /* Xử lý riêng khu vực sắp xếp */
    if (obj.parents("thead").length) {
        if (!obj.hasClass('.disable_sort')) {
            if (obj.hasClass("sorting_asc")) {
                obj.removeClass("sorting_asc");
                obj.addClass("sorting");
                obj.attr("order", "");
                obj.removeAttr("order_pos");
            } else if (obj.hasClass("sorting_desc")) {
                obj.removeClass("sorting_desc");
                obj.addClass("sorting_asc");
                obj.attr("order", "asc");

                var curent_pos = obj.attr("order_pos");
                obj.siblings("th[order_pos]").each(function () {
                    if ($(this).attr("order_pos") > curent_pos) {
                        $(this).attr("order_pos", $(this).attr("order_pos") - 1);
                    }
                });
                obj.attr("order_pos", obj.siblings("th[order_pos]").length);
            } else if (obj.hasClass("sorting")) {
                obj.removeClass("sorting");
                obj.addClass("sorting_desc");
                obj.attr("order", "desc");
                obj.attr("order_pos", obj.siblings("th[order_pos]").length);
            }
        } else {
            cancel = true;
        }
    }

    if (!cancel) {
        e.preventDefault();
        creat_ajax_table($(this).parents(".e_manager_table_container"));
    }
}

function reverse_check(e, source_obj) {
    var obj;
    if (source_obj) {
        obj = source_obj;
    } else {
        obj = $(this);
    }
    obj.parents(".e_manager_table_container").find(".e_data_table tbody input[name='_e_check_all']").each(function () {
        $(this).prop("checked", !$(this).prop("checked"));
    });
    show_delete_button(e, obj);
}

function show_delete_button(e, source_obj) {
    e.preventDefault();
    var obj;
    if (source_obj) {
        obj = source_obj;
    } else {
        obj = $(this);
    }
    if (obj.parents(".e_manager_table_container").find(".e_data_table tbody input[name='_e_check_all']:checked").length) {
        obj.parents(".e_manager_table_container").find(".e_table_header .for_select").show();
    } else {
        obj.parents(".e_manager_table_container").find(".e_table_header .for_select").hide();
        obj.parents(".e_manager_table_container").find(".e_data_table thead .e_check_all").prop("checked", false);
    }

    var temp = [];
    obj.parents(".e_manager_table_container").find(".e_data_table tbody input[name='_e_check_all']:checked").each(function () {
        temp.push($(this).parents("tr").attr("data-id"));
    });
    temp = {list_id: temp};
    temp = JSON.stringify(temp);
    obj.parents(".e_manager_table_container").find(".e_table_header .delete_list_button").attr("data", temp);

}

function do_check_all(e, source_obj) {
    var obj;
    if (source_obj) {
        obj = source_obj;
    } else {
        obj = $(this);
    }
    obj.parents("table").find("input[name='_e_check_all']").prop("checked", obj.prop("checked"));
    show_delete_button(e, obj);
}

function creat_ajax_table(obj) {
    var url = obj.attr("data-url");
    if (!url) {
        return;
    }
    var filter = obj.find(".e_filter_form").serializeObject();
    var limit = obj.find(".e_changer_number_record").val();
    var page = obj.find(".e_data_paginate li.active a").attr("data-page");
    var order = [];
    var temp_order = {};
    obj.find("thead tr th").each(function () {
        if ($(this).attr("order")) {
            if ($(this).attr("order") == "asc" || $(this).attr("order") == "desc") {
                //                order.push($(this).attr("field_name") + " " + $(this).attr("order"));
                temp_order[$(this).attr("order_pos")] = $(this).attr("field_name") + " " + $(this).attr("order");
            }
        }
    });
    for (var i in temp_order) {
        order.push(temp_order[i]);
    }
    order = order.reverse();
    order = order.join(",");
    var data = {
        filter: filter,
        limit: limit,
        page: page,
        order: order
    };
    show_loading();

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "text",
        success: function (dataAll) {
            var temp = dataAll.split($("body").attr("data-barrier"));
            var data = {};
            for (var i = 0; i < temp.length; i++) {
                data = $.extend(true, {}, data, JSON.parse(temp[i]));
            }
            if (window[data.callback]) {
                console.log("Callback: ", data.callback);
                window[data.callback](data, obj);
            } else {
                console.log("Callback function not found:'", data.callback, "'-->Call 'default_data_table' instead of");
                default_data_table(data, obj);
            }
        },
        error: function (a, b, c) {
            alert(a + b + c);
            // window.location = url;
        },
        complete: function (jqXHR, textStatus) {
            hide_loading();
        }
    });

}


function show_loading() {
    $("#loading-overlay").show();
}

function hide_loading() {
    setTimeout(function () {
        $("#loading-overlay").hide();
    }, 200);
}


function do_ajax_link(e, source_obj) {
    e.preventDefault();
    var obj;
    if (source_obj) {
        obj = source_obj;
    } else {
        obj = $(this);
    }
    var url = obj.attr("href");
    var data = obj.attr("data");
    if (data) {
        data = JSON.parse(obj.attr("data"));
    }
    if (obj.hasClass("e_ajax_confirm")) {
        bootbox.dialog({
            message: "<span class='bigger-110'>Dữ liệu không thể khôi phục sau khi làm thao tác này! <br/>"
            + "<b>Bạn chắc chắn sẽ làm điều này chứ?</b></span>",
            buttons: {
                "success": {
                    "label": "Không xoá",
                    "className": "btn-sm btn-success",
                    "callback": function () {
                        //Example.show("great success");
                    }
                },
                "danger": {
                    "label": "<i class='ace-icon fa fa-trash'></i> Ok, Xoá!",
                    "className": "btn-sm btn-danger",
                    "callback": function () {
                        call_ajax_link(url, data, obj);
                    }
                }
            }
        });
    } else {
        call_ajax_link(url, data, obj);
    }
}

function call_ajax_link(url, data, obj) {
    show_loading();
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "text",
        success: function (dataAll) {
            var temp = dataAll.split($("body").attr("data-barrier"));
            var data = {};
            for (var i = 0; i < temp.length; i++) {
                data = $.extend(true, {}, data, JSON.parse(temp[i]));
            }
            if (window[data.callback]) {
                console.log("Callback: ", data.callback);
                window[data.callback](data, obj);
            } else {
                console.log("Callback function not found:'", data.callback, "'-->Call 'default_ajax_link' instead of");
                default_ajax_link(data, obj);
            }
        },
        error: function (a, b, c) {
//            alert(a + b + c);
            window.location = url;
        },
        complete: function (jqXHR, textStatus) {
            hide_loading();
        }
    });
}

function check_form(e) {
    var check_all = true;
    var form = $(this);
    var selector = creat_input_selector(":not(.disable_validate),");
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
    show_loading();
    form.ajaxSubmit({
        type: "POST",
        dataType: "text",
        cache: false,
        success: function (dataAll) {
            var temp = dataAll.split($("body").attr("data-barack"));
            var data = {};
            for (var i = 0; i < temp.length; i++) {
                data = $.extend(true, {}, data, JSON.parse(temp[i]));
            }
            if (window[data.callback]) {
                console.log("Callback: ", data.callback);
                window[data.callback](data, form, btn);
            } else {
                console.log("Callback not found:'", data.callback, "'-->Call 'default_form_submit_respone' instead of");
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
            hide_loading();
        }
    });
}

function check_value(e, source_obj) {
    return true; //TODO: validate in client
    var obj;
    if (source_obj) {
        obj = source_obj;
    } else {
        obj = $(this);
    }
    if (!obj.hasOwnProperty("closest")) {
        return true;
    }
    var parent = obj.closest(".form-group");
    var value = $.trim(obj.val());
    if (obj.attr("type") == "number") {
        if (value.length != 0) {
            if (!(!isNaN(parseFloat(value)) && isFinite(value))) {
                change_error_state(obj, false);
                parent.find("label.help-block").html("Dữ liệu nhập vào là số");
                return false;
            } else {
                change_error_state(obj, true);
            }
        }
    }
    if (obj.attr("required") != undefined && obj.attr("required") != "0") {
        if (value.length == 0) {
            change_error_state(obj, false);
            parent.find("label.help-block").html("Trường này là bắt buộc");
            return false;
        } else {
            change_error_state(obj, true);
        }
    }
    if (obj.attr("minlength") != undefined && obj.attr("minlength") > 1) {
        if (value.length < obj.attr("minlength")) {
            change_error_state(obj, false);
            parent.find("label.help-block").html("Độ dài tối thiểu là " + obj.attr("minlength") + " ký tự");
            return false;
        } else {
            change_error_state(obj, true);
        }
    }
    if (obj.attr("maxlength") != undefined && obj.attr("maxlength") > 1) {
        if (value.length > obj.attr("maxlength")) {
            change_error_state(obj, false);
            parent.find("label.help-block").html("Độ dài tối đa là " + obj.attr("maxlength") + " ký tự");
            return false;
        } else {
            change_error_state(obj, true);
        }
    }

    if (obj.attr("is_email") != undefined && obj.attr("is_email") != 0) {
        if (obj.attr("required") == undefined || obj.attr("required") == "0") {
            change_error_state(obj, true);
        } else {
            if (!is_email(value)) {
                change_error_state(obj, false);
                parent.find("label.help-block").html("Trường này yêu cầu là email!");
                return false;
            } else {
                change_error_state(obj, true);
            }
        }
    }
    if (obj.attr("recheck") != undefined && obj.attr("recheck") != 0) {
        var selector = creat_input_selector("[name='" + obj.attr("recheck") + "']");
        if (value != $(selector).val()) {
            change_error_state(obj, false);
            parent.find("label.help-block").html("Dữ liệu nhập lại không đúng");
            return false;
        } else {
            change_error_state(obj, true);
        }
    }

    if (obj.attr("allow_null") == undefined && obj.prop("tagName") == "SELECT") {
        if (value == 0) {
            change_error_state(obj, false);
            parent.find("label.help-block").html("Trường này không được bỏ trống");
            return false;
        } else {
            change_error_state(obj, true);
        }
    }
    change_error_state(obj, true);
    return true;
}