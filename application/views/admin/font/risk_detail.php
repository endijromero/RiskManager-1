<div class="padding-10">
    <div class="widget-box e_widget e_manager_table_container" data-url="">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Chi Tiết Dự Án
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>

            <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('hint') ?>" class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-leaf"></i>
                    Đưa ra gợi ý
                </a>
            </div>
            <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('risk_type') ?>" class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-leaf"></i>
                    Quản lí loại rủi ro
                </a>
            </div> <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('risk') ?>" class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-leaf"></i>
                    Quản lí rủi ro
                </a>
            </div>
        </div>
        </br>
        <div class="widget-body">
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Mã dự án</label>
                <input type="text" class="shadow_input contact_input" name="code">
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Tên dự án</label>
                <input type="text" class="shadow_input contact_input" name="name">
            </div>
            <div class="form-group">
                <label class="col-xs-4 ">Số lượng rủi ro</label>
                <input type="text" class="shadow_input contact_input" name="risk_quantity">
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Mô tả</label>
                <input type="text" class="shadow_input contact_input" name="description">
            </div>

        </div>
    </div>
</div>