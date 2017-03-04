<div class="form-group ">
    <label class="col-sm-3 col-xs-12 control-label  no-padding-right"
           for="<?php echo $form_item['field'] . "_" . $form_id ?>">
        <?php echo $form_item['label'] ?>
    </label>
    <div class="col-sm-8 col-xs-12 password_container">
        <?php
        $type = isset($form_item['form']['type']) ? $form_item['form']['type'] : "text";
        $class = isset($form_item['form']['class']) ? $form_item['form']['class'] : "";
        $form_attr = " id='$form_item[field]_$form_id' placeholder='$form_item[label]' ";
        $form_attr .= isset($form_item['form']['attr']) ? $form_item['form']['attr'] : "";
        $form_attr .= " rules='$form_item[rules]' ";
        echo "<input name='$form_item[field]' type='$type' class='col-xs-10 $class' $form_attr/>";
        ?>
        <span class="col-xs-2 no-padding">
            <a href="#" class="e_random_password btn btn-sm" type='button'>
                Random
            </a>
        </span>
        <script type="text/javascript">
            $(".e_random_password").click(function () {
                var pass = make_random_string(8);
                $(this).closest(".form-group").find("input[name='password']").val(pass);
                $(this).closest("form").find("input[name='password_conf']").val(pass);
                if (!$(this).closest(".password_container").find(".random_pass").length) {
                    $(this).closest(".password_container").append("<span class='random_pass'><span>");
                }
                $(this).closest(".password_container").find(".random_pass").html("Random pass: <b>" + pass + "</b>");
            });
        </script>
    </div>
</div>
