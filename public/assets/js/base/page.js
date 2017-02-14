jQuery(function ($) {
    (function (undefined) {
        //Set colslap menu
        $(".nav-list > li").each(function () {
            var obj = $(this);
            if (obj.find("ul.submenu").length) {
                obj.children("a").attr("href", "#");
                obj.children("a").addClass("dropdown-toggle");
                obj.children("a").append("<b class='arrow fa fa-angle-down'></b>");
            }
        });
        //Set active menu
        var url = window.location.href;
        url = url.replace(/[\/\\]$/, "");
        url = url.replace(/[\/\\]\?/, "?");
        var url_path = url.split("?");
        var active_menu = null;
        var active_prioty = 0;//90: 100% match, 50: match Uri and param, 20: match Uri without param
        $(".nav-list a").each(function () {
            var href = $(this).attr('href');
            href = href.replace(/[\/\\]$/, "");
            href = href.replace(/[\/\\]\?/, "?");
            var href_path = href.split("?");
            if (href === url) {
                active_menu = $(this);
                active_prioty = 90;
                return false;
            }
            if (active_prioty < 50) {
                if (href_path[0] === url_path[0]) {
                    active_menu = $(this);
                    active_prioty = 50;
                }
            }
            if (active_prioty < 20) {
                var n1 = href.search(url);
                var n2 = url.search(href);
                if (n1 !== -1 || n2 !== -1) {
                    active_menu = $(this);
                    active_prioty = 20;
                }
            }
        });
        if (active_menu != null) {
            active_menu.closest('li').addClass('active');
            active_menu.closest('li').parents("li").addClass("active open");
        }
    })();

    ace.login_theme = {};

    ace.login_theme.set_theme_light = function (e) {
        $('body').attr('class', 'login-layout light-login');
        $('#id-text2').attr('class', 'grey');
        $('#id-company-text').attr('class', 'blue');
        if (typeof e != "undefined") {
            e.preventDefault();
        }

    }
    ace.login_theme.set_theme_dark = function (e) {
        $('body').attr('class', 'login-layout');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'blue');
        if (typeof e != "undefined") {
            e.preventDefault();
        }
    }
    ace.login_theme.set_theme_blue = function (e) {
        $('body').attr('class', 'login-layout blur-login');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'light-blue');
        if (typeof e != "undefined") {
            e.preventDefault();
        }
    }

    jQuery(function ($) {
        $('#btn-login-dark').on('click', ace.login_theme.set_theme_dark);
        $('#btn-login-light').on('click', ace.login_theme.set_theme_light);
        $('#btn-login-blur').on('click', ace.login_theme.set_theme_blue);
    });

    $('[data-rel=tooltip]').tooltip({container: 'body'});
    $('[data-rel=popover]').popover({container: 'body'});

    // $('textarea[class*=autosize]').autosize({append: "\n"});
    autosize($($('textarea[class*=autosize]')));
    $('textarea.limited').inputlimiter({
        remText: '%n character%s remaining...',
        limitText: 'max allowed : %n.'
    });

    $.mask.definitions['~'] = '[+-]';
    $('.input-mask-date').mask('99/99/9999');
    $('.input-mask-phone').mask('(999) 999-9999');
    $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
    $(".input-mask-product").mask("a*-999-a999", {
        placeholder: " ",
        completed: function () {
            alert("You typed the following: " + this.val());
        }
    });

    //datepicker plugin
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function () {
        $(this).prev().focus();
    });

    //or change it into a date range picker
    $('.input-daterange').datepicker({autoclose: true});

    $('input.date-range-picker').daterangepicker({
        'applyClass': 'btn-sm btn-success',
        'cancelClass': 'btn-sm btn-default',
        locale: {
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
        }
    }).prev().on(ace.click_event, function () {
        $(this).next().focus();
    });

    $('.timepicker').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    }).next().on(ace.click_event, function () {
        $(this).prev().focus();
    });

    $('.date-timepicker').datetimepicker().next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
    $('.colorpicker').colorpicker();
    $('.simple-colorpicker').ace_colorpicker();
    $(".knob").knob();

    if (!ace.vars['touch']) {
        $('.chosen-select').chosen({allow_single_deselect: true});
        //resize the chosen on window resize

        $(window)
            .off('resize.chosen')
            .on('resize.chosen', function () {
                $('.chosen-select').each(function () {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                })
            }).trigger('resize.chosen');
        //resize chosen on sidebar collapse/expand
        $(document).on('settings.ace.chosen', function (e, event_name, event_val) {
            if (event_name != 'sidebar_collapsed')
                return;
            $('.chosen-select').each(function () {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            });
        });


        $('#chosen-multiple-style .btn').on('click', function (e) {
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            if (which == 2) {
                $('#form-field-select-4').addClass('tag-input-style');
            } else {
                $('#form-field-select-4').removeClass('tag-input-style');
            }
        });
    }
});