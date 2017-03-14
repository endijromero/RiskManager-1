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
<!--                    <div class="form-group">-->
<!--                        <label class="col-xs-4 contact-label-title row-title">Mã dự án</label>-->
<!--                        <div class="form-group input_field_holder">-->
<!--                            <textarea type="text" name="project_id" class="input_field" rows="1" display="none" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Mã loại rủi ro</label>
                        <div class="col-sm-8 col-xs-12">
                        <select  name="risk_type_id" class="e_select_risk_type"
                                 data-url="<?php echo site_url('conflict/get_method_child') ?>">
                            <option value="" selected disabled hidden>Chọn loaị rủi ro</option>
                            <?php foreach ($list_risk_type as $item) { ?>
                                <option value="<?php echo $item->id; ?>"><?php echo $item->code; ?></option>
                            <?php } ?>
                        </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Mã rủi ro</label>
                        <div class="col-sm-8 col-xs-12">
                        <textarea name="code" placeholder="Mã rủi ro" type="text"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">Tên rủi ro</label>
                        <div class="col-sm-8 col-xs-12">
                        <textarea name="name" placeholder="Tên rủi ro" type="text"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label  no-padding-right">
                            Mô tả    </label>
                        <div class="col-sm-8 col-xs-12">
<!--                        <textarea placeholder="Mô tả" rows="7" cols="40"style=" overflow-y: hidden;resize: none;"type="text" name="description" class="col-xs-12" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>-->
                        <textarea rows="7" cols="40" style=" overflow-y: hidden;resize: none;" name="description" class="col-xs-12 " id="description_58c7b6c5e681e" placeholder="Mô tả" rules=""></textarea>
                    </div>
                    </div>
                    </div>


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