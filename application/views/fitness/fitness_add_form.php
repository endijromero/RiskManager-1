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
            <div class="modal-body bgwhite">
                <div class="widget-body">
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Cost weighting</label>
                        <div class="col-sm-8 col-xs-12">
                        <textarea placeholder="Cost weighting" name="cost" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Difficulty weighting</label>
                        <div class="col-sm-8 col-xs-12">
                        <textarea placeholder="Difficulty weighting"name="diff" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Priority weighting</label>
                        <div class="col-sm-8 col-xs-12">
                        <textarea placeholder="Priority weighting"name="priority" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Time weighting</label>
                        <div class="col-sm-8 col-xs-12">
                        <textarea placeholder="Time weighting"name="time" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                        </div>
                    <h5 style="color: cornflowerblue">Notice: Sum of weights must be 100.</h5>
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