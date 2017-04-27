<div class="padding-10">
    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Project Information <?php echo $project->name ?>
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
            <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('hint/manage/' . $project->id) ?>"
                   class="btn btn-success add_button">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Hint back
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite padding-10">
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Project code</label>
                <span><?php echo $project->code; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Project name</label>
                <span><?php echo $project->name; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 ">Quantity of risk</label>
                <span><?php echo $project->risk_quantity == NULL ? 0 : $project->risk_quantity; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Description</label>
                <span><?php echo $project->description; ?></span>
            </div>
        </div>
    </div>

    <div class="widget-box margin-top-10">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Risk Information
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite">
            <table class='table table-bordered table-hover no-footer' cellpadding="0" cellspacing="0"
                   border="0">
                <thead>
                <tr>
                    <th>Risk code</th>
                    <th>Risk name</th>
                    <th>Quantity of Risk Response</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($risk as $risk_item) {
                    echo "<tr>";
                    echo "<td>{$risk_item->code}</td>";
                    echo "<td>{$risk_item->name}</td>";
                    echo "<td>{$risk_item->method_quantity}</td>";
                    echo "<td>{$risk_item->description}</td>";
                    echo "<tr>";
                } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box margin-top-10">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Risk Response Information
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite">
            <?php foreach ($methods_in_risks as $methods_in_risks_item) { ?>
                <div class="risk-panel">
                    <h4>Rủi ro <?php echo $methods_in_risks_item['name'] ?></h4>
                    <table class='table table-bordered table-hover no-footer'>
                        <thead>
                        <tr>
                            <th>Risk Response code</th>
                            <th>Risk Response name</th>
                            <th>Cost</th>
                            <th>Difficulty</th>
                            <th>Priority</th>
                            <th>Time</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($methods_in_risks_item['methods'] as $method) {
                            echo "<tr>";
                            echo "<td>{$method->{'code'}}</td>";
                            echo "<td>{$method->{'name'}}</td>";
                            echo "<td>{$method->{'cost'}}</td>";
                            echo "<td>{$method->{'diff'}}</td>";
                            echo "<td>{$method->{'priority'}}</td>";
                            echo "<td>{$method->{'time'}}</td>";
                            echo "<td>{$method->{'description'}}</td>";
                            echo "<tr>";
                        } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="widget-box margin-top-10">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                The values of the GA parameters
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite">
            <table class='table table-bordered table-hover no-footer'>
                <tbody>
                <?php {
                    echo "<tr>";
                    echo "<td>GA_POPSIZE: {$GA_POPSIZE} </td>";
                    echo "<td>GA_MAXITER: {$GA_MAXITER} </td>";
                    echo "<td>GA_ELITRATE: {$GA_ELITRATE} </td>";
                    echo "<td>GA_MUTATION: {$GA_MUTATION} </td>";
                    echo "</tr>";
                }
              ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="widget-box margin-top-10">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Hint
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite">
            <table class='table table-bordered table-hover no-footer'>
                <tbody>
                <?php foreach ($results['recommend'] as $recommend_item) {
                    echo "<tr>";
                    echo "<td>Risk name: {$recommend_item['risk']->name} (Risk code: {$recommend_item['risk']->code})</td>";
                    echo "<td>Risk Response name: {$recommend_item['method']->name} (Risk Response code: {$recommend_item['method']->code })</td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='2'>Fitness value: {$results['fit']}</td></tr>"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>