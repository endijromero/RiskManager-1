<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed')
        } catch (e) {
        }
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="#">Home</a>
        </li>

        <li>
            <a href="#">UI &amp; Elements</a>
        </li>

        <li>
            <a href="#">Layouts</a>
        </li>
        <li class="active">Default Mobile Menu</li>
    </ul><!-- /.breadcrumb -->

    <!-- #section:basics/content.searchbox -->
    <div class="nav-search" id="nav-search">
        <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
        </form>
    </div><!-- /.nav-search -->

    <!-- /section:basics/content.searchbox -->
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->
    <div class="ace-settings-container" id="ace-settings-container">
        <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
            <i class="ace-icon fa fa-cog bigger-130"></i>
        </div>

        <div class="ace-settings-box clearfix" id="ace-settings-box">
            <div class="pull-left width-50">
                <!-- #section:settings.skins -->
                <div class="ace-settings-item">
                    <div class="pull-left">
                        <select id="skin-colorpicker" class="hide">
                            <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                        </select>
                    </div>
                    <span>&nbsp; Choose Skin</span>
                </div>

                <!-- /section:settings.skins -->

                <!-- #section:settings.navbar -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                    <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                </div>

                <!-- /section:settings.navbar -->

                <!-- #section:settings.sidebar -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                    <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                </div>

                <!-- /section:settings.sidebar -->

                <!-- #section:settings.breadcrumbs -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                    <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                </div>

                <!-- /section:settings.breadcrumbs -->

                <!-- #section:settings.rtl -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                    <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                </div>

                <!-- /section:settings.rtl -->

                <!-- #section:settings.container -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                    <label class="lbl" for="ace-settings-add-container">
                        Inside
                        <b>.container</b>
                    </label>
                </div>

                <!-- /section:settings.container -->
            </div><!-- /.pull-left -->

            <div class="pull-left width-50">
                <!-- #section:basics/sidebar.options -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                    <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                </div>

                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                    <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                </div>

                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                    <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                </div>

                <!-- /section:basics/sidebar.options -->
            </div><!-- /.pull-left -->
        </div><!-- /.ace-settings-box -->
    </div><!-- /.ace-settings-container -->

    <!-- /section:settings.box -->
    <div class="page-header">
        <h1>Default Responsive(mobile) Menu </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="alert alert-info hidden-sm hidden-xs">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                Please note that
                <span class="blue bolder">mobile menu</span>
                is visible only when window size is less than
                <span class="blue bolder">992px</span>
                ,which you can change using CSS builder tool.
            </div>

            <div class="alert alert-info hidden-md hidden-lg">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                When device is smaller than
                <span class="blue bolder">992px</span>
                wide, side menu is hidden and will be visible by clicking on the toggle button.
            </div>

            <div class="hidden-md hidden-lg">
                <a href="#" class="btn btn-primary btn-white btn-bold" id="id-change-style">
                    <i class="ace-icon fa fa-exchange"></i>
                    Show older Ace toggle button
                </a>

                <div class="space-4"></div>

                <div>
                    <label>
                        Push Content :
                        <input type="checkbox" class="ace ace-switch ace-switch-6" id="id-push-content" />
                        <span class="lbl middle"></span>
                    </label>
                </div>

                <div class="hr hr-16"></div>
            </div>

            <!-- #section:basics/sidebar.mobile.style1 -->
            <div class="well well-sm">
                <h4 class="lighter no-margin-bottom">
                    <i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
                    <a href="#basics/sidebar.mobile.style1" class="pink btn-display-help"> Default mobile menu help </a>
                </h4>
            </div>

            <!-- /section:basics/sidebar.mobile.style1 -->

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function ($) {
        $('#id-change-style').on(ace.click_event, function () {
            var toggler = $('#menu-toggler');
            var fixed = toggler.hasClass('fixed');
            var display = toggler.hasClass('display');

            if (toggler.closest('.navbar').length == 1) {
                $('#menu-toggler').remove();
                toggler = $('#sidebar').before('<a id="menu-toggler" data-target="#sidebar" class="menu-toggler" href="#">\
                                                <span class="sr-only">Toggle sidebar</span>\
                                                <span class="toggler-text"></span>\
                                         </a>').prev();

                var ace_sidebar = $('#sidebar').ace_sidebar('ref');
                ace_sidebar.set('mobile_style', 2);

                var icon = $(this).children().detach();
                $(this).text('Hide older Ace toggle button').prepend(icon);

                $('#id-push-content').closest('div').hide();
                $('#id-push-content').removeAttr('checked');
                $('.sidebar').removeClass('push_away');
            } else {
                $('#menu-toggler').remove();
                toggler = $('.navbar-brand').before('<button data-target="#sidebar" id="menu-toggler" class="three-bars pull-left menu-toggler navbar-toggle" type="button">\
                                                <span class="sr-only">Toggle sidebar</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>\
                                        </button>').prev();

                var ace_sidebar = $('#sidebar').ace_sidebar('ref');
                ace_sidebar.set('mobile_style', 1);

                var icon = $(this).children().detach();
                $(this).text('Show older Ace toggle button').prepend(icon);

                $('#id-push-content').closest('div').show();
            }

            if (fixed)
                toggler.addClass('fixed');
            if (display)
                toggler.addClass('display');

            $('.sidebar[data-sidebar-hover=true]').ace_sidebar_hover('reset');
            $('.sidebar[data-sidebar-scroll=true]').ace_sidebar_scroll('reset');

            return false;
        });

        $('#id-push-content').removeAttr('checked').on('click', function () {
            $('.sidebar').toggleClass('push_away');
        });
    });
</script>