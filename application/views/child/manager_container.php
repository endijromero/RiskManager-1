<div class="padding-10">
    <div class="widget-box e_widget e_manager_table_container" data-url="<?php echo $ajax_data_link; ?>">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                <?php echo $title; ?>
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
            <div class="widget-toolbar actions_content e_actions_content">
                <button href="<?php echo $add_link; ?>" class="btn btn-success btn-sm e_ajax_link add_button">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Thêm
                </button>
            </div>
            <?php if (isset($toolbar)) {
                echo $toolbar;
            } ?>
        </div>
        <div class="widget-body">
            <div class="e_filter clearfix padding-10">
                <?php echo $filter_html; ?>
            </div>
            <hr class="no-margin"/>
            <div class="table_header e_table_header clearfix ">
                <?php echo $table_header; ?>
            </div>
            <div class="data_table e_data_table">

            </div>
        </div>
    </div>
</div>