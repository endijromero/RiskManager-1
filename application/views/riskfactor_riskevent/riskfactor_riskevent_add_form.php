<?php
/**
 * Created by PhpStorm.
 * User: taohansamu
 * Date: 08/10/2017
 * Time: 16:18
 */
?>

<div class="modal-dialog">
    <div class="modal-content">
        <form class="form-horizontal e_add_form e_ajax_submit"
              action="<?php echo $save_link; ?>"
              id="<?php echo $form_id; ?>"
              enctype="multipart/form-data"
              method="POST" role="form">
            <div class="modal-header">
                <span type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
                <h4 class="modal-title"><?php echo $form_title; ?></h4>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Code</label>
                <div class="col-sm-8 col-xs-12">
                    <textarea name="code" placeholder="Goal code" type="text"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                </div>
            </div>
            <div class="modal-body bgwhite">
                <div class="widget-body">
                    <?php
                    if($list_risk_factor) {
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Risk factor code</label>
                            <div class="col-sm-8 col-xs-12">
                                <select name="risk_factor_id" class="e_select_risk_factor"
                                        data-url="<?php echo site_url('conflict/get_method_child') ?>">
                                    <option value="" selected disabled hidden>Choose Goal category</option>
                                    <?php foreach ($list_risk_factor as $item) { ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo $item->code; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                        ?>
                    <?php
                    if($list_risk) {
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Risk
                                code</label>
                            <div class="col-sm-8 col-xs-12">
                                <select name="risk_id" class="e_select_risk" ?>">
                                    <option value="" selected disabled hidden>Choose risk</option>
                                    <?php foreach ($list_risk as $item) { ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo $item->code; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">
                            Description    </label>
                        <div class="col-sm-8 col-xs-12">
                            <textarea rows="7" cols="40" style=" overflow-y: hidden;resize: none;" name="description" class="col-xs-12 " id="description_58c7b6c5e681e" placeholder="Description" rules=""></textarea>
                        </div>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="submit" class="b_add b_edit btn btn-success">
                    <i class="ace-icon fa fa-save "></i> Save
                </button>
                <button type="reset" class="b_add btn">Reset</button>
                <button type="button" class="b_view b_add b_edit btn" data-dismiss="modal">Cancle</button>
            </div>
        </form>
    </div>
</div>
