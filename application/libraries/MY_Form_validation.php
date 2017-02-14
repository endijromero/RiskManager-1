<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form Validation extension with File for Code Igniter
 *
 * Rules supported:
 * file_required
 * file_allowed_types[type]
 * file_disallowed_types[type]
 * file_min_size[size]
 * file_max_size[size]
 * file_image_mindim[x,y]
 * file_image_maxdim[x,y]
 * file_min_height[int_pixel]
 * file_max_height[int_pixel]
 * file_min_width[int_pixel]
 * file_max_width[int_pixel]
 *
 * info:
 * size can be in format of 20KB (kilo Byte) or 20Kb(kilo bit) or 20MB or 20GB or ....
 * size with no unit is assume as KB
 * type is evaluated based on the file extension.
 * type can be given as several types separated by comma
 * type can be one of the groups of: image,application,php_code,word_document,compressed
 *
 * fixes/added:
 * if it is only a file field it still works
 * size can have unit
 * image testing for dimension
 * tests the file for errors before doing anything else, WARNING: this behaviour may change in future.
 *
 */
class MY_Form_validation extends CI_Form_validation {

    function __construct() {
        parent::__construct();
    }

    /**
     * Is Unique
     *
     * Check if the input value doesn't already exist
     * in the specified database field.
     *
     * @param    string $str
     * @param    string $field
     *
     * @return    bool
     */
    public function is_unique($str, $field) {
        sscanf($field, '%[^.].%[^.]', $table, $field);
        $s_fields = explode(",", $field);
        $where = Array(
            $s_fields[0] => $str,
        );
        unset($s_fields[0]);
        if (!isset($this->CI->db)) {
            return FALSE;
        }
        $this->CI->db->limit(1);
        $this->CI->db->where($where);
        foreach ($s_fields as $item) {
            $this->CI->db->where($item);
        }
        $num_rows = $this->CI->db->get($table)->num_rows();
        return $num_rows === 0;
    }

    public function set_rules($field, $label = '', $rules = array(), $errors = array()) {
        if (count($_POST) === 0 AND count($_FILES) > 0)//it will prevent the form_validation from working
        {
            //add a dummy to $_POST
            $_POST['DUMMY_ITEM'] = '';
            parent::set_rules($field, $label, $rules, $errors);
            unset($_POST['DUMMY_ITEM']);
        } else {
            //we are safe just run as is
            parent::set_rules($field, $label, $rules, $errors);
        }
    }

    public function run($group = '') {
        log_message('DEBUG', 'called MY_form_validation:run()');
        if (count($_POST) === 0 AND count($_FILES) > 0)//does it have a file only form?
        {
            //add a dummy $_POST
            $_POST['DUMMY_ITEM'] = '';
            $result = parent::run($group);
            unset($_POST['DUMMY_ITEM']);
        } else {
            //we are safe just run as is
            $result = parent::run($group);
        }

        return $result;
    }

    public function file_upload_error_message($error_code) {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return $this->CI->lang->line('upload_file_exceeds_limit');
            case UPLOAD_ERR_FORM_SIZE:
                return $this->CI->lang->line('upload_file_exceeds_form_limit');
            case UPLOAD_ERR_PARTIAL:
                return $this->CI->lang->line('upload_file_partial');
            case UPLOAD_ERR_NO_FILE:
                return $this->CI->lang->line('upload_no_file_selected');
            case UPLOAD_ERR_NO_TMP_DIR:
                return $this->CI->lang->line('upload_no_temp_directory');
            case UPLOAD_ERR_CANT_WRITE:
                return $this->CI->lang->line('upload_unable_to_write_file');
            case UPLOAD_ERR_EXTENSION:
                return $this->CI->lang->line('upload_stopped_by_extension');
            default:
                return 'Unknown upload error';
        }
    }

    public function _execute($row, $rules, $postdata = NULL, $cycles = 0) {
        log_message('DEBUG', 'called MY_form_validation::_execute ' . $row['field']);

        if (isset($_FILES[$row['field']])) {// it is a file so process as a file
            log_message('DEBUG', 'processing as a file');
            if (!$postdata) {
                $postdata = $_FILES[$row['field']];
                if (is_array($postdata['error'])) {//Check if multiple file
                    $row['is_array'] = TRUE;
                    $this->_field_data[$row['field']]['is_array'] = TRUE;
                    $this->_field_data[$row['field']]['postdata'] = Array();
                    foreach ($postdata['error'] as $key => $item) {
                        $temp_postdata = [
                            'name'     => $postdata['name'][$key],
                            'type'     => $postdata['type'][$key],
                            'tmp_name' => $postdata['tmp_name'][$key],
                            'error'    => $postdata['error'][$key],
                            'size'     => $postdata['size'][$key],
                        ];
                        $this->_field_data[$row['field']]['postdata'][$key] = $temp_postdata;
                        $this->_execute($row, $rules, $temp_postdata, $key);
                    }
                    return;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = $postdata;
                }
            }

            //before doing anything check for errors
            if ($postdata['error'] !== UPLOAD_ERR_OK) {
                $this->_error_array[$row['field']] = $this->file_upload_error_message($postdata['error']);
                return;
            }

            // If the field is blank, but NOT required, no further tests are necessary
            $callback = FALSE;
            if (!in_array('file_required', $rules) AND $postdata['size'] == 0) {
                // Before we bail out, does the rule contain a callback?
                foreach ($rules as &$rule) {
                    if (is_string($rule)) {
                        if (strncmp($rule, 'callback_', 9) === 0) {
                            $callback = TRUE;
                            $rules = array(1 => $rule);
                            break;
                        }
                    } elseif (is_callable($rule)) {
                        $callback = TRUE;
                        $rules = array(1 => $rule);
                        break;
                    } elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                        $callback = TRUE;
                        $rules = array(array($rule[0], $rule[1]));
                        break;
                    }
                }

                if (!$callback) {
                    return;
                }
            }

            // Cycle through each rule and run it
            foreach ($rules as $rule) {
                /// COPIED FROM the original class
                if ($rule == 'required') {
                    continue; //Skip rule required, because it was handled by file_required
                }
                $_in_array = FALSE;
                // We set the $postdata variable with the current data in our master array so that
                // each cycle of the loop is dealing with the processed data from the last cycle
                if ($row['is_array'] === TRUE && is_array($this->_field_data[$row['field']]['postdata'])) {
                    // We shouldn't need this safety, but just in case there isn't an array index
                    // associated with this cycle we'll bail out
                    if (!isset($this->_field_data[$row['field']]['postdata'][$cycles])) {
                        continue;
                    }

                    $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                    $_in_array = TRUE;
                } else {
                    // postdata not have error
                    $postdata = isset($this->_field_data[$row['field']]['postdata']['error']) ? $this->_field_data[$row['field']]['postdata'] : NULL;
                }
                // Is the rule a callback?
                $callback = $callable = FALSE;
                if (is_string($rule)) {
                    if (strpos($rule, 'callback_') === 0) {
                        $rule = substr($rule, 9);
                        $callback = TRUE;
                    }
                } elseif (is_callable($rule)) {
                    $callable = TRUE;
                } elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                    // We have a "named" callable, so save the name
                    $callable = $rule[0];
                    $rule = $rule[1];
                }


                // Strip the parameter (if exists) from the rule
                // Rules can contain a parameter: max_length[5]
                $param = FALSE;
                if (!$callable && preg_match('/(.*?)\[(.*)\]/', $rule, $match)) {
                    $rule = $match[1];
                    $param = $match[2];
                }

                // Call the function that corresponds to the rule
                if ($callback OR $callable !== FALSE) {
                    if ($callback) {
                        if (!method_exists($this->CI, $rule)) {
                            log_message('debug', 'Unable to find callback validation rule: ' . $rule);
                            $result = FALSE;
                        } else {
                            // Run the function and grab the result
                            $result = $this->CI->$rule($postdata, $param);
                        }
                    } else {
                        $result = is_array($rule)
                            ? $rule[0]->{$rule[1]}($postdata)
                            : $rule($postdata);

                        // Is $callable set to a rule name?
                        if ($callable !== FALSE) {
                            $rule = $callable;
                        }
                    }

                    // Re-assign the result to the master data array
                    if ($_in_array === TRUE) {
                        $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                    } else {
                        $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                    }

                    // If the field isn't required and we just processed a callback we'll move on...
                    if (!in_array('required', $rules, TRUE) && $result !== FALSE) {
                        continue;
                    }
                } elseif (!method_exists($this, $rule)) {
                    // If our own wrapper function doesn't exist we see if a native PHP function does.
                    // Users can use any native PHP function call that has one param.
                    if (function_exists($rule)) {
                        // Native PHP functions issue warnings if you pass them more parameters than they use
                        $result = ($param !== FALSE) ? $rule($postdata, $param) : $rule($postdata);

                        if ($_in_array === TRUE) {
                            $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                        } else {
                            $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                        }
                    } else {
                        log_message('debug', 'Unable to find validation rule: ' . $rule);
                        $result = FALSE;
                    }
                } else {
                    $result = $this->$rule($postdata, $param);

                    if ($_in_array === TRUE) {
                        $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                    } else {
                        $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                    }
                }

                //this line needs testing !!!!!!!!!!!!! not sure if it will work
                //it basically puts back the tested values back into $_FILES
                //$_FILES[$row['field']] = $this->_field_data[$row['field']]['postdata'];

                // Did the rule test negatively? If so, grab the error.
                if ($result === FALSE) {
                    // Callable rules might not have named error messages
                    if (!is_string($rule)) {
                        $line = $this->CI->lang->line('form_validation_error_message_not_set') . '(Anonymous function)';
                    } else {
                        $line = $this->_get_error_message($rule, $row['field']);
                    }

                    // Is the parameter we are inserting into the error message the name
                    // of another field? If so we need to grab its "field label"
                    if (isset($this->_field_data[$param], $this->_field_data[$param]['label'])) {
                        $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                    }
                    $file_name = $postdata['name'];
                    // Build the error message
                    $message = $this->_build_error_msg($line, $this->_translate_fieldname($row['label']), $param, $file_name);

                    // Save the error message
                    $this->_field_data[$row['field']]['error'] = $message;

                    if (!isset($this->_error_array[$row['field']])) {
                        $this->_error_array[$row['field']] = $message;
                    } else if ($this->_error_array[$row['field']] != $message) {
                        $this->_error_array[$row['field']] .= "<br/>" . $message;
                    }

                    return;
                }
            }
        } else {
            log_message('DEBUG', 'Called parent _execute');
            parent::_execute($row, $rules, $postdata, $cycles);
        }
    }

    protected function _build_error_msg($line, $field = '', $param = '', $file_name = '') {
        // Check for %s in the string for legacy support.
        if ($file_name) {
            if (strpos($line, '%s') !== FALSE) {
                return sprintf($line, $field, $param, $file_name);
            }
            return str_replace(array('{field}', '{param}', '{file_name}'), array($field, $param, $file_name), $line);
        } else {
            return parent::_build_error_msg($line, $field, $param);
        }

    }

    /**
     * tests to see if a required file is uploaded
     *
     * @param mixed $file
     *
     * @return bool
     */
    public function file_required($file) {
        if ($file['size'] === 0) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * tests to see if a file is within expected file size limit
     *
     * @param mixed $file
     * @param mixed $max_size
     *
     * @return bool
     */
    public function file_max_size($file, $max_size) {
        $max_size_bit = $this->let_to_bit($max_size);
        if ($file['size'] > $max_size_bit) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * tests to see if a file is bigger than minimum size
     *
     * @param mixed $file
     * @param mixed $min_size
     *
     * @return bool
     */
    public function file_min_size($file, $min_size) {
        $min_size_bit = $this->let_to_bit($min_size);
        if ($file['size'] < $min_size_bit) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * tests the file extension for valid file types
     *
     * @param mixed $file
     * @param mixed $type
     *
     * @return bool
     */
    public function file_allowed_types($file, $type) {
        //is type of format a,b,c,d? -> convert to array
        $exts = explode(',', $type);

        //is type a group type? image, application, word_document, code, zip .... -> load proper array
        $ext_groups = array();
        $ext_groups['image'] = array('jpg', 'jpeg', 'gif', 'png');
        $ext_groups['application'] = array('exe', 'dll', 'so', 'cgi');
        $ext_groups['php_code'] = array('php', 'php4', 'php5', 'inc', 'phtml');
        $ext_groups['word_document'] = array('rtf', 'doc', 'docx');
        $ext_groups['excel_document'] = array('xls', 'xlsx');
        $ext_groups['compressed'] = array('zip', 'gzip', 'tar', 'gz');

        foreach ($ext_groups as $key => $value) {
            if (in_array($key, $exts)) {
                $exts = array_merge($exts, $value);
            }
        }
        //get file ext
        $file_ext = strtolower(strrchr($file['name'], '.'));
        $file_ext = substr($file_ext, 1);

        if (!in_array($file_ext, $exts)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function file_disallowed_types($file, $type) {
        $rc = $this->file_allowed_types($file, $type);
        return !$rc;
    }

    /**
     * given an string in format of ###AA converts to number of bits it is assignin
     *
     * @param string $sValue
     *
     * @return integer number of bits
     */
    public function let_to_bit($sValue) {
        // Split value from name
        if (!preg_match('/([0-9]+)([ptgmkb]{1,2}|)/ui', $sValue, $aMatches)) { // Invalid input
            return FALSE;
        }

        if (empty($aMatches[2])) { // No name -> Enter default value
            $aMatches[2] = 'KB';
        }

        if (strlen($aMatches[2]) == 1) { // Shorted name -> full name
            $aMatches[2] .= 'B';
        }

        $iBit = (substr($aMatches[2], -1) == 'B') ? 1024 : 1000;
        // Calculate bits:

        switch (strtoupper(substr($aMatches[2], 0, 1))) {
            case 'P':
                $aMatches[1] *= $iBit;
            case 'T':
                $aMatches[1] *= $iBit;
            case 'G':
                $aMatches[1] *= $iBit;
            case 'M':
                $aMatches[1] *= $iBit;
            case 'K':
                $aMatches[1] *= $iBit;
                break;
        }

        // Return the value in bits
        return $aMatches[1];
    }

    public function file_max_width($file, $max_width) {
        $d = $this->get_image_dimension($file['tmp_name']);
        if (!$d) {
            $this->set_message('file_max_width', '%s dimensions was not detected.');
            return FALSE;
        }
        if ($max_width == 0 || $d[0] < $max_width) {
            return TRUE;
        }
        return FALSE;
    }

    public function file_min_width($file, $min_width) {
        $d = $this->get_image_dimension($file['tmp_name']);
        if (!$d) {
            $this->set_message('file_max_width', '%s dimensions was not detected.');
            return FALSE;
        }
        if ($min_width == 0 || $d[0] > $min_width) {
            return TRUE;
        }
        return FALSE;
    }

    public function file_max_height($file, $max_height) {
        $d = $this->get_image_dimension($file['tmp_name']);
        if (!$d) {
            $this->set_message('file_max_width', '%s dimensions was not detected.');
            return FALSE;
        }
        if ($max_height == 0 || $d[1] < $max_height) {
            return TRUE;
        }
        return FALSE;
    }

    public function file_min_height($file, $min_height) {
        $d = $this->get_image_dimension($file['tmp_name']);
        if (!$d) {
            $this->set_message('file_max_width', '%s dimensions was not detected.');
            return FALSE;
        }
        if ($min_height == 0 || $d[1] > $min_height) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * returns false if image is bigger than the dimensions given
     *
     * @param mixed $file
     * @param array $dim
     *
     * @return bool
     */
    public function file_image_maxdim($file, $dim) {
        log_message('debug', 'MY_form_validation:file_image_maxdim ' . $dim);
        $dim = explode(',', $dim);

        if (count($dim) !== 2) {
            //bad size given
            $this->set_message('file_image_maxdim', '%s has invalid rule expected similar to 150,300 .');
            return FALSE;
        }

        log_message('debug', 'MY_form_validation:file_image_maxdim ' . $dim[0] . ' ' . $dim[1]);

        //get image size
        $d = $this->get_image_dimension($file['tmp_name']);

        log_message('debug', $d[0] . ' ' . $d[1]);

        if (!$d) {
            $this->set_message('file_image_maxdim', '%s dimensions was not detected.');
            return FALSE;
        }
        if (($d[0] == 0 || $d[0] < $dim[0]) && ($d[1] == 0 || $d[1] < $dim[1])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * returns false is the image is smaller than given dimension
     *
     * @param mixed $file
     * @param array $dim
     *
     * @return bool
     */
    public function file_image_mindim($file, $dim) {
        $dim = explode(',', $dim);

        if (count($dim) !== 2) {
            //bad size given
            $this->set_message('file_image_mindim', '%s has invalid rule expected similar to 150,300 .');
            return FALSE;
        }

        //get image size
        $d = $this->get_image_dimension($file['tmp_name']);

        if (!$d) {
            $this->set_message('file_image_mindim', '%s dimensions was not detected.');
            return FALSE;
        }

        log_message('debug', $d[0] . ' ' . $d[1]);

        if (($d[0] == 0 || $d[0] > $dim[0]) && ($d[1] == 0 || $d[1] > $dim[1])) {
            return TRUE;
        }

        return FALSE;
    }

    public function file_upload_path($file, $upload_path) {
        if (!is_writable($upload_path)) {
            return FALSE;
        }
        return TRUE;

    }


    public function add_error($field, $message) {
        $this->_field_data[$field]['error'] = $message;
        if (is_array($message)) {
            $message = implode("<br/>", $message);
        }
        if (!isset($this->_error_array[$field])) {
            $this->_error_array[$field] = $message;
        } else if ($this->_error_array[$field] != $message) {
            $this->_error_array[$field] .= "<br/>" . $message;
        }
    }

    /**
     * attempts to determine the image dimension
     *
     * @param mixed $file_name path to the image file
     *
     * @return array
     */
    public function get_image_dimension($file_name) {
        log_message('debug', $file_name);
        if (function_exists('getimagesize')) {
            $D = @getimagesize($file_name);

            return $D;
        }

        return FALSE;
    }
}