<div class="padding-10">
    <div class="widget-box e_widget e_manager_table_container" data-url="">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Project "<?php echo $detail_project->name ?>" Information
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        </br>
        <div class="widget-body" id="title-text-font">
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Project code</label>
                <span><?php echo $detail_project->code; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Project name</label>
                <span><?php echo $detail_project->name; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 ">Quantity of risk</label>
                <span><?php echo $detail_project->risk_quantity == NULL ? 0 : $detail_project->risk_quantity; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Description</label>
                <span><?php echo $detail_project->description; ?></span>
            </div>
            <div class="clearfix padding-10">
                <a href="<?php echo site_url('risk/manage/' . $detail_project->id) ?>"
                   class="btn btn-success">
                    <i class="ace-icon fa fa-dashboard"></i>
                    Risk Management
                </a>
                <a href="<?php echo site_url('conflict/manage/' . $detail_project->id) ?>"
                   class="btn btn-success">
                    <i class="fa fa-rebel"></i>
                    Conflict Management
                </a>
                <a href="<?php echo site_url('fitness/manage/' . $detail_project->id) ?>"
                   class="btn btn-success">
                    <i class="fa fa-cog""></i>
                    Weighted fitness function Management
                </a>
                <a href="<?php echo site_url('hint/manage/' . $detail_project->id) ?>"
                   class="btn btn-success">
                    <i class="fa fa-lightbulb-o"></i>
                    Request for help make decisions
                </a>
            </div>
        </div>
    </div>
</div>