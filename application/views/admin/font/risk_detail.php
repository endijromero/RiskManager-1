<div class="padding-10">
    <div class="widget-box e_widget e_manager_table_container" data-url="">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
               Risk "<?php echo $detail_risk->name ?>" Information
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
            <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('method/manage/'.$risk_id) ?>" class="btn btn-success">
                    <i class="ace-icon fa fa-dashboard"></i>
                    Risk Response Management
                </a>
            </div>
        </div>
        </br>
        <div class="widget-body" id="title-text-font">
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Risk code</label>
                <span><?php echo $detail_risk->code; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Risk name</label>
                <span><?php echo $detail_risk->name; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 ">Quantity of Risk Response</label>
                <span><?php echo $detail_risk->method_quantity == NULL ? 0 : $detail_risk->method_quantity; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Description</label>
                <span><?php echo $detail_risk->description; ?></span>
            </div>

        </div>
    </div>
</div>