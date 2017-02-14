<form class="form-horizontal e_filter_form " novalidate
      action=""
      id="<?php echo $form_id; ?>"
      enctype="multipart/form-data"
      method="POST" role="form">
    <!-- #section:elements.form -->
    <?php foreach ($filter as $item) {
        echo $item['html'];
    } ?>
    <div class="clearfix"></div>
    <hr class="no-margin"/>
    <div class="filter-footer align-center padding-10 no-padding-bottom">
        <button type="submit" class="b_add b_edit btn btn-primary">
            <i class="ace-icon fa fa-search "></i>
            Search
        </button>
        <button type="reset" class="b_add btn">
            <i class="ace-icon fa fa-refresh "></i>
            Nhập lại
        </button>
    </div>
</form>