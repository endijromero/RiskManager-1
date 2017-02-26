<div class="padding-10">
    <div class="widget-box e_widget e_manager_table_container" data-url="">
        <div class="widget-header">
            <h5 class="widget-title bigger-125">
                <i class="ace-icon fa fa-table"></i>
                Kết quả gợi ý
            </h5>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>

            <div class="widget-toolbar actions_content e_actions_content">
                <a href=" " class="btn btn-success btn-sm  add_button">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Gợi ý lại
                </a>
            </div>
        </div>
        <div class="widget-body padding-10">
            Các Rủi ro của dự án <?php echo $project->name ?>
            <ul>
                <?php foreach ($methods_in_risks as $risk_id => $risk) {
                    echo "<li>" . $risk['name'] . "<br/><ul>";
                    $methods = $risk['methods'];
                    foreach ($methods as $method_id => $method) { ?>
                        <li>
                            <span><?php echo $method->name ?></span>
                            -
                            <span><?php echo $method->cost ?></span>
                        </li>
                    <?php }
                    echo "</ul></li>";
                } ?>
            </ul>
        </div>
        <div class="widget-body padding-10">
            Các xung đột của dự án <?php echo $project->name ?>
            <ul>
                <?php foreach ($table_data as $conflict) { ?>
                    <li>
                        <span><?php echo $conflict->method_1_id ?></span>
                        -
                        <span><?php echo $conflict->method_2_id ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>