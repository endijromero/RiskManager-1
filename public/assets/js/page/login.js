/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(function ($) {

    ace.login_theme.set_theme_light();
    
    $(document).on('click', '.toolbar a[data-target]', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });
});
