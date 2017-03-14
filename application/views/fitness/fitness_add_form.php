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
                        <label class="col-xs-4 contact-label-title row-title">Trọng số chi phí</label>
                        <textarea placeholder="Trọng số chi phí" name="cost" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Trọng số độ khó</label>
                        <textarea placeholder="Trọng số độ khó"name="diff" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Trọng số độ ưu tiên</label>
                        <textarea placeholder="Trọng số độ ưu tiên"name="priority" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 contact-label-title row-title">Trọng số thời gian</label>
                        <textarea placeholder="Trọng số thời gian"name="time" type="number"  class="input_field" rows="1" style="height: 34px; overflow-y: hidden;resize: none;"></textarea>
                    </div>
                    <h5 style="color: cornflowerblue">Chú ý : Tổng giá trị các trọng số phải bằng 100</h5>
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