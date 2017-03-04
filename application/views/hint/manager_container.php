<div class="padding-10">
    <div class="widget-box">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Kết quả gợi ý dự án <?php echo $project->name ?>
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
            <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('hint/manage/' . $project->id) ?>"
                   class="btn btn-success btn-sm  add_button">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Gợi ý lại
                </a>
            </div>
            <div class="widget-toolbar actions_content e_actions_content">
                <a href="<?php echo site_url('fitness/manage/' . $project->id) ?>" class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Thiết lập gía trị trọng số của hàm thích nghi
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite padding-10">
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Mã dự án</label>
                <span><?php echo $project->code; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Loại rủi ro</label>
                <span><?php echo $project->code; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Mã dự án</label>
                <span><?php echo $project->code; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Tên dự án</label>
                <span><?php echo $project->name; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 ">Số lượng rủi ro</label>
                <span><?php echo $project->risk_quantity == NULL ? 0 : $project->risk_quantity; ?></span>
            </div>
            <div class="form-group">
                <label class="col-xs-4 contact-label-title row-title">Mô tả</label>
                <span><?php echo $project->description; ?></span>
            </div>
        </div>
    </div>

    <div class="widget-box margin-top-10">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Thông tin các rủi ro của dự án
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
                    <th>Mã Rủi Ro</th>
                    <th>Tên Rủi Ro</th>
                    <th>Mô tả</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($risk as $risk_item) {
                    echo "<tr>";
                    echo "<td>{$risk_item->code}</td>";
                    echo "<td>{$risk_item->name}</td>";
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
                Thông tin các phương pháp giải quyết rủi ro của dự án
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
                            <th>Mã phương pháp</th>
                            <th>Tên phương pháp</th>
                            <th>Chi phí</th>
                            <th>Độ khó</th>
                            <th>Độ ưu tiên</th>
                            <th>Thời gian</th>
                            <th>Mô tả</th>
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
                Gợi ý phương pháp ứng với rủi ro
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="widget-body bgwhite">
            <table class='table table-bordered table-hover no-footer'>
                <thead>
                <tr>
                    <th>Tên Rủi Ro</th>
                    <th>Gợi ý Phương pháp xử lí</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($results['recommend'] as $recommend_item) {
                    echo "<tr>";
                    echo "<td>{$recommend_item['risk']->name} (Code: {$recommend_item['risk']->code})</td>";
                    echo "<td>{$recommend_item['method']->name} (Code: {$recommend_item['method']->code })</td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='2'>Fitness: {$results['fit']}</td></tr>"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>