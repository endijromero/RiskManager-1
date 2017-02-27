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
                <a href="<?php echo site_url('hint/manage/' . $project->id) ?>"
                   class="btn btn-success btn-sm  add_button">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Gợi ý lại
                </a>
            </div>
        </div>
        <div class="table_text_font" id="title-text-font">
            <div class="widget-body padding-10">
                Quản lí rủi ro <?php echo $project->name ?> khi có các xung đột giữa các phương pháp xử lí của các rủi
                ro khác nhau.
            </div>

            <?php
            echo "<table style=\"width:50%\">
           <tr>
            <th>Tên Rủi Ro</th>
            <th>Gợi ý Phương pháp xử lí</th>
           </tr>";
            foreach ($results['recommend'] as $recommend_item) {
                echo "<tr>";

                echo "<td>{$recommend_item['risk']->name} (Code: {$recommend_item['risk']->code})</td>";
                echo "<td>{$recommend_item['method']->name} (Code: {$recommend_item['method']->code })</td>";
                echo "<tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</div>