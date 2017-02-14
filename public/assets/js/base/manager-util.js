(function (undefined) {
    if (!('Utils' in window)) {
        window['Utils'] = {};
    }


    Utils.creat_input_selector = function (more) {
        var input = "input,select,radio,textarea";
        var temp = input.split(",");
        var selector = "";
        if (more.substr(more.length - 1) != ",") {
            selector = temp.join(more + ",") + more;
        } else {
            selector = temp.join(more) + more.slice(0, more.length - 1);
        }
        return selector;
    };


    Utils.make_alias = function ($title, $separator, $lowercase) {
        if ($separator === undefined) {
            $separator = "-";
        }
        if ($lowercase === undefined) {
            $lowercase = true;
        }
        $title = $.trim($title);
        $title = $title.replace(/\s+/gi, ' ');
        $title = $title.replace(/á|à|ạ|ả|ã|ă|ắ|ằ|ặ|ẳ|ẵ|â|ấ|ầ|ậ|ẩ|ẫ/g, "a");
        $title = $title.replace(/Á|À|Ạ|Ả|Ã|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ/g, "A");
        $title = $title.replace(/ó|ò|ọ|ỏ|õ|ô|ố|ồ|ộ|ổ|ỗ|ơ|ớ|ờ|ợ|ở|ỡ/g, "o");
        $title = $title.replace(/Ô|Ố|Ồ|Ộ|Ổ|Ỗ|Ó|Ò|Ọ|Ỏ|Õ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ/g, "O");
        $title = $title.replace(/é|è|ẹ|ẻ|ẽ|ê|ế|ề|ệ|ể|ễ/g, "e");
        $title = $title.replace(/Ê|Ế|Ề|Ệ|Ể|Ễ|É|È|Ẹ|Ẻ|Ẽ/g, "E");
        $title = $title.replace(/ú|ù|ụ|ủ|ũ|ư|ứ|ừ|ự|ử|ữ/g, "u");
        $title = $title.replace(/Ư|Ứ|Ừ|Ự|Ử|Ữ|Ú|Ù|Ụ|Ủ|Ũ/g, "U");
        $title = $title.replace(/í|ì|ị|ỉ|ĩ/g, "i");
        $title = $title.replace(/Í|Ì|Ị|Ỉ|Ĩ/g, "I");
        $title = $title.replace(/ý|ỳ|ỵ|ỷ|ỹ/g, "y");
        $title = $title.replace(/Ý|Ỳ|Ỵ|Ỷ|Ỹ/g, "Y");
        $title = $title.replace(/đ/g, "d");
        $title = $title.replace(/Đ/g, "D");

        $title = $title.replace(/\{|\}|\$|\||\\|`|!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, $separator);
        $title = $title.replace(/\-+/g, $separator);
        $title = $title.replace(/^\-+|\-+$/g, "");
        $title = $title.replace(/[^0-9A-Za-z\-]/g, "");

        if ($lowercase) {
            $title = $title.toLowerCase();
        }
        return $title;
    };

    /**
     * Hàm kiểm tra email có hợp lệ hay không
     * @param {String} email
     * @returns {boolean}
     */
    Utils.is_email = function (email) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(email);
    };
})();