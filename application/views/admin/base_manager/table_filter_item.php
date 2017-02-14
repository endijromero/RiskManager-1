<div class="col-sm-6">
    <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label no-padding-right no-padding-left"
               for="<?php echo $form_item['field'] . "_" . $form_id ?>">
            <?php echo $form_item['label'] ?>
        </label>
        <div class="col-sm-9 col-xs-12">
            <?php
            $type = isset($form_item['filter']['type']) ? $form_item['filter']['type'] : "text";
            $class = isset($form_item['filter']['class']) ? $form_item['filter']['class'] : "";
            $form_attr = " id='$form_item[field]_$form_id' placeholder='$form_item[label]' ";
            $form_attr .= isset($form_item['filter']['attr']) ? $form_item['filter']['attr'] : "";
            switch ($type) {
                case  "select":
                case "multiple_select":
                    $multiple = ($type == "multiple_select") ? "multiple" : "";
                    echo "<div class='col-xs-12 no-padding'>";
                    echo "<select name='$form_item[field]' class='select2 col-xs-12 col-md-10 $class' $multiple $form_attr >";
                    foreach ($form_item['filter']['data_select'] as $s_key => $s_item) {
                        echo "<option value='$s_key'>$s_item</option>";
                    }
                    echo "</select></div>";
                    break;
                default:
                    echo "<input name='$form_item[field]' type='$type' class='col-xs-12 col-md-10 $class' $form_attr/>";
                    break;
            } ?>
        </div>
    </div>
</div>