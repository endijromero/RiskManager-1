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
                <?php foreach ($form as $item) {
                    echo $item['html'];
                } ?>
                <div class="clearfix"></div>
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