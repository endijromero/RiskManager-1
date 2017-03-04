<div class="form-group ">
    <label class="col-sm-3 col-xs-12 control-label  no-padding-right"
           for="<?php echo $form_item['field'] . "_" . $form_id ?>">
        <?php echo $form_item['label'] ?>
    </label>
    <div class="col-sm-8 col-xs-12">
        <?php
        $placeholder = isset($form_item['form']['placeholder']) ? $form_item['form']['placeholder'] : $form_item['label'];
        $type = isset($form_item['form']['type']) ? $form_item['form']['type'] : "text";
        $class = isset($form_item['form']['class']) ? $form_item['form']['class'] : "";
        $form_attr = " id='$form_item[field]_$form_id' placeholder='$placeholder' ";
        $form_attr .= isset($form_item['form']['attr']) ? $form_item['form']['attr'] : "";
        $form_item['rules'] = is_array($form_item['rules']) ? implode("|", $form_item['rules']) : $form_item['rules'];
        $form_attr .= " rules='$form_item[rules]' ";
        switch ($type) {
            case  "select":
            case "multiple_select":
                $multiple = ($type == "multiple_select") ? "multiple" : "";
                echo "<div class='col-xs-12 no-padding'>";
                echo "<select value='" . htmlentities($value, ENT_QUOTES) . "' name='$form_item[field]' class='select2 col-xs-12 $class' $multiple $form_attr >";
                foreach ($form_item['form']['data_select'] as $s_key => $s_item) {
                    $selected = ($value != NULL && $value == $s_key) ? "selected" : "";
                    echo "<option value='$s_key' $selected>$s_item</option>";
                }
                echo "</select></div>";
                break;
            case "multiple_file":
            case "file":
                $name_suffix = ($type == "multiple_file") ? "[]" : "";
                $multiple = ($type == "multiple_file") ? "multiple" : "";
                $hidden = "";
                $cancel = "";
                if ($value !== NULL) {
                    $src = base_url($value);
                    $hidden = "soft_hide";
                    echo "<div class='e_file_preview_container'>
                            <img class='file_preview $class' src='$src'/>
                            <input type='button' class='e_file_input_change btn btn-default' value='Change'/>
                        </div>";
                    $cancel = "<input type='button' class='e_file_input_change_cancel file_input_container_cancel btn btn-default' value='Cancel'/>";
                }
                echo "<div class='$hidden e_file_input_container file_input_container'>
                        <input value='$value' name='$form_item[field]$name_suffix' type='file' $multiple class='col-xs-12 $class' $form_attr ";
                if (isset($form_item['form']['upload']['allowed_types'])) {
                    echo " data-allowed_types='" . $form_item['form']['upload']['allowed_types'] . "'";
                }
                if (isset($form_item['form']['upload']['max_size'])) {
                    echo " data-max_size='" . ($form_item['form']['upload']['max_size'] * 1024) . "'";
                }
                echo " />$cancel</div>";

                break;
            case "textarea":
                echo "<textarea name='$form_item[field]' class='col-xs-12 $class' $form_attr>" . htmlentities($value, ENT_QUOTES) . "</textarea>";
                break;
            default:
                echo "<input value='" . htmlentities($value, ENT_QUOTES) . "' name='$form_item[field]' type='$type' class='col-xs-12 $class' $form_attr/>";
                break;
        } ?>
    </div>
</div>