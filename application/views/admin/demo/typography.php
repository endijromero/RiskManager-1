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
        <li class="active">Typography</li>
    </ul><!-- /.breadcrumb -->

    <!-- #section:basics/content.searchbox -->
    <div class="nav-search" id="nav-search">
        <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input"
                                           id="nav-search-input" autocomplete="off"/>
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
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar"/>
                    <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                </div>

                <!-- /section:settings.navbar -->

                <!-- #section:settings.sidebar -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar"/>
                    <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                </div>

                <!-- /section:settings.sidebar -->

                <!-- #section:settings.breadcrumbs -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs"/>
                    <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                </div>

                <!-- /section:settings.breadcrumbs -->

                <!-- #section:settings.rtl -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl"/>
                    <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                </div>

                <!-- /section:settings.rtl -->

                <!-- #section:settings.container -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container"/>
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
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover"/>
                    <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                </div>

                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact"/>
                    <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                </div>

                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight"/>
                    <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                </div>

                <!-- /section:basics/sidebar.options -->
            </div><!-- /.pull-left -->
        </div><!-- /.ace-settings-box -->
    </div><!-- /.ace-settings-container -->

    <!-- /section:settings.box -->
    <div class="page-header">
        <h1>
            Typography
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                This is page-header (.page-header &gt; h1)
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-sm-6">
                    <h4>Headings & Paragraphs</h4>

                    <hr/>
                    <h1>h1. Heading 1</h1>
                    <p class="lead">
                        Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non
                        commodo luctus.
                    </p>
                    <h2>h2. Heading 2</h2>
                    <p>
                        Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                        ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat
                        porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor
                        fringilla.
                    </p>
                    <h3>h3. Heading 3</h3>
                    <p>
                        Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis
                        parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.
                    </p>
                    <h4>h4. Heading 4</h4>
                    <h5>h5. Heading 5</h5>
                    <h6>h6. Heading 6</h6>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                            <h4 class="widget-title">Lists</h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>Unordered List Item</li>

                                            <li>
                                                <small>List Item in small tag</small>
                                            </li>

                                            <li>
                                                <b>List Item in bold tag</b>
                                            </li>

                                            <li>
                                                <i>List Item in italics tag</i>
                                            </li>

                                            <li>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                        Nested List Item
                                                    </li>

                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                        Nested List Item
                                                    </li>

                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                        Nested List Item
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>Unordered List Item which is a longer item and may break into more
                                                lines.
                                            </li>

                                            <li>
                                                <strong>List Item in strong tag</strong>
                                            </li>

                                            <li>
                                                <em>List Item in emphasis tag</em>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-sm-6">
                                        <ol>
                                            <li>Ordered List Item</li>
                                            <li class="text-primary">.text-primary Ordered List Item</li>
                                            <li class="text-danger">.text-danger Ordered List Item</li>

                                            <li class="text-success">
                                                <b>.text-success</b>
                                                Ordered List Item
                                            </li>
                                            <li class="text-warning">.text-warning Ordered List Item</li>
                                            <li class="text-muted">.text-muted Ordered List Item</li>
                                        </ol>
                                    </div>
                                </div>

                                <hr/>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="ace-icon fa fa-bell-o bigger-110 purple"></i>
                                                List with custom icons and more space
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-check bigger-110 green"></i>
                                                Unordered List Item # 2
                                            </li>

                                            <li>
                                                <i class="ace-icon fa fa-times bigger-110 red"></i>
                                                Unordered List Item # 3
                                            </li>
                                        </ul>

                                        <ul class="list-unstyled spaced2">
                                            <li>
                                                <i class="ace-icon fa fa-circle green"></i>
                                                Even more space
                                            </li>

                                            <li class="text-warning bigger-110 orange">
                                                <i class="ace-icon fa fa-exclamation-triangle"></i>
                                                Unordered List Item # 5
                                            </li>

                                            <li class="muted">
                                                <i class="ace-icon fa fa-angle-right bigger-110"></i>
                                                Unordered List Item # 6
                                            </li>

                                            <li>
                                                <ul class="list-inline">
                                                    <li>
                                                        <i class="ace-icon fa fa-share green bigger-110"></i>
                                                        Inline List Item # 1
                                                    </li>
                                                    <li>List Item # 2</li>
                                                    <li>List Item # 3</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div>

            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat">
                            <h4 class="widget-title smaller">
                                <i class="ace-icon fa fa-quote-left smaller-80"></i>
                                BlockQuote & Address
                            </h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <blockquote class="pull-right">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere
                                                erat a ante.</p>

                                            <small>
                                                Someone famous
                                                <cite title="Source Title">Source Title</cite>
                                            </small>
                                        </blockquote>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <blockquote>
                                            <p class="lighter line-height-125">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere
                                                erat a ante.
                                            </p>

                                            <small>
                                                Someone famous
                                                <cite title="Source Title">Source Title</cite>
                                            </small>
                                        </blockquote>
                                    </div>
                                </div>

                                <hr/>
                                <address>
                                    <strong>Twitter, Inc.</strong>

                                    <br/>
                                    795 Folsom Ave, Suite 600
                                    <br/>
                                    San Francisco, CA 94107
                                    <br/>
                                    <abbr title="Phone">P:</abbr>
                                    (123) 456-7890
                                </address>

                                <address>
                                    <strong>Full Name</strong>

                                    <br/>
                                    <a href="mailto:#">first.last@example.com</a>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="widget-box">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title smaller">Definition List</h4>

                                    <div class="widget-toolbar">
                                        <label>
                                            <small class="green">
                                                <b>Horizontal</b>
                                            </small>

                                            <input id="id-check-horizontal" type="checkbox"
                                                   class="ace ace-switch ace-switch-6"/>
                                            <span class="lbl middle"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                        <code class="pull-right" id="dt-list-code">&lt;dl&gt;</code>

                                        <dl id="dt-list-1">
                                            <dt>Description lists</dt>
                                            <dd>A description list is perfect for defining terms.</dd>
                                            <dt>Euismod</dt>
                                            <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem
                                                nec elit.
                                            </dd>
                                            <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                                            <dt>Malesuada porta</dt>
                                            <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                                            <dt>Felis euismod semper eget lacinia</dt>
                                            <dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh,
                                                ut fermentum massa justo sit amet risus.
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="widget-box">
                                <div class="widget-header widget-header-flat">
                                    <h4 class="smaller">
                                        <i class="ace-icon fa fa-code"></i>
                                        Code view
                                    </h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main">
                                                            <pre class="prettyprint linenums">&lt;p class="muted"&gt;Fusce dapibus, tellus ac cursus commodo.&lt;/p&gt;
&lt;p class="text-warning"&gt;Etiam porta sem malesuada.&lt;/p&gt;
&lt;p class="text-error"&gt;Donec ullamcorper nulla non metus auctor fringilla.&lt;/p&gt;
&lt;p class="text-info"&gt;Aenean eu leo quam.&lt;/p&gt;
&lt;p class="text-success"&gt;Duis mollis.&lt;/p&gt;</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function ($) {

        window.prettyPrint && prettyPrint();
        $('#id-check-horizontal').removeAttr('checked').on('click', function () {
            $('#dt-list-1').toggleClass('dl-horizontal').prev().html(this.checked ? '&lt;dl class="dl-horizontal"&gt;' : '&lt;dl&gt;');
        });

    })
</script>