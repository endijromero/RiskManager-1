<div class="dataTables_wrapper no-footer">
    <table cellpadding="0" cellspacing="0" border="0"
           class="table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable">
        <thead>
        <tr>
            <?php
            foreach ($columns as $key => $value) {
                $class = "";
                if (isset($order_view[$key])) {
                    $temp = $order_view[$key];
                    $class .= " sorting_" . $order_view[$key];
                } else {
                    $temp = "";
                    $class .= " sorting ";
                }

                $more_attr = "";

                if (isset($value['table']['attr'])) {
                    $more_attr = $value['table']['attr'];
                }
                if (isset($value['table']['class'])) {
                    $class .= " " . $value['table']['class'];
                }
                $class = str_replace("'", "", $class);
                $class = str_replace('"', "", $class);
                $order_post = array_search($key, array_keys($order_view));
                ?>
                <th class="<?php echo $class; ?>" <?php echo $more_attr; ?> order="<?php echo $temp; ?>"
                    <?php echo (array_search($key, array_keys($order_view)) !== FALSE) ? "order_pos='" . $order_post . "'" : "" ?>
                    field_name="<?php echo $key; ?>"><?php echo is_string($value) ? $value : $value['label']; ?></th>
            <?php } ?>
        </tr>
        </thead>
        <?php if (sizeof($record)) { ?>
            <tbody>
            <?php foreach ($record as $item) { ?>
                <tr data-id="<?php echo $item->$key_name; ?>">
                    <?php foreach ($columns as $key => $value) {
                        $more_attr = "";
                        $class = "";
                        if (isset($value['table']['attr'])) {
                            $more_attr = $value['table']['attr'];
                        }
                        if (isset($value['table']['class'])) {
                            $class = $value['table']['class'];
                        }
                        $explodeResult = explode(".", $key);
                        $dataKey = end($explodeResult);
                        ?>
                        <td for_key="<?php echo $key . ""; ?>" class="<?php echo $class ?>" <?php echo $more_attr; ?> >
                            <?php echo $item->$dataKey; ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        <?php } ?>
    </table>
    <?php if (!sizeof($record)) { ?>
        <p class="no_record">No records</p>
    <?php } else { ?>
        <div class="row no-magin">
            <div class="col-xs-4 margin-top-5">
                <?php if ($to) { ?>
                    <div class="dataTables_info" id="dataTable_info">Display
                        from <?php echo $from . " to " . $to . " of " . $total; ?> records
                    </div>
                <?php } else { ?>
                    <div class="dataTables_info" id="dataTable_info">Show all <?php echo $total; ?> records</div>
                <?php } ?>

            </div>
            <div class="col-xs-8">
                <div class="dataTables_paginate paging_bootstrap pagination no-margin">
                    <?php echo $paging; ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>