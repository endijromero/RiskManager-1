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
                        <label class="col-xs-4 contact-label-title row-title">Mã dự án</label>
<!--                        <span>--><?php //echo $detail_project->code; ?><!--</span>-->
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Mã xung đột</label>
<!--                        <span>--><?php //echo $detail_project->code; ?><!--</span>-->
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Tên xung đột</label>
<!--                        <span>--><?php //echo $detail_project->name; ?><!--</span>-->
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Phương pháp 1</label>
                        <div class="col-xs-9">
                            <div class="input_field_holder">
                                <div class="form-group iblock no-gap-row">
                            <span data-name="cat_name" class="span_field">
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Phương pháp 2</label>
                        <div class="col-xs-9">
                            <div class="input_field_holder">
                                <div class="form-group iblock no-gap-row">
                            <span data-name="cat_name" class="span_field">
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Mô tả</label>
<!--                        <span>--><?php //echo $detail_project->description; ?><!--</span>-->
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="b_add b_edit btn btn-success">
                    <i class="ace-icon fa fa-save "></i> Lưu
                </button>
                <button type="reset" class="b_add btn">Nhập lại</button>
                <button type="button" class="b_view b_add b_edit btn" data-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>