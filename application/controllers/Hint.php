<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
//#define PHP_RAND_MAX RAND_MAX;
/**
 * Class Hint
 *
 * @property M_method   method
 * @property M_conflict conflict
 */
class Hint extends Manager_base {

    public function __construct() {

        define('GA_POPSIZE', 50);        // ga population size
        define('GA_MAXITER', 100);
        define('GA_ELITRATE', 0.10);
        define('GA_MUTATIONRATE', 0.25);
        define('GA_MUTATION', getrandmax() * GA_MUTATIONRATE);
        define('GA_MAX', 200);
        define('CONFLICT_MAX', 100);
        parent::__construct();
        $this->load->model('m_method', 'method');
        $this->load->model('M_conflict', 'conflict');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "hint",
            "view"   => "hint",
            "model"  => "m_project",
            "object" => "Gợi ý",
        );
    }

    function manage($project_id) {
        $data['project'] = $this->model->get($project_id);
        $data['table_data'] = $this->_get_table_data($project_id);
        $content = $this->load->view("hint/manager_container", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }

    private function _get_table_data($project_id) {
        $population = array();
        $buffer = array();
        $pop_beta = array();
        $pop_gama = array();
        $methods_in_risks = $this->_get_methods_in_risks($project_id);
        echo "<pre>";
        var_dump($methods_in_risks);
        $conflict_records = $this->conflict->get_many_by('project_id', $project_id);
        var_dump($conflict_records);
        $conflict_risks = $this->_define_risk_conf($methods_in_risks, $conflict_records);
        echo "<pre>";
        var_dump($conflict_risks);
        echo "<pre>";
        $group_conflict = $this->_group_conflict($conflict_risks);
        var_dump($group_conflict);
        $population = $this->_init_population($pop_beta, $pop_gama, $group_conflict, $methods_in_risks, $conflict_records);
        echo "-------------";
        $buffer = $pop_gama;
        var_dump($population);
        for ($i = 0; $i < GA_MAXITER; $i++) {
            $population= $this->_calc_fitness($population, $methods_in_risks);        // calculate fitness
            var_dump($population);
            exit();
            $this->_sort_by_fitness($population);    // sort them
            $this->_mate($population, $buffer, $conflict_records, $methods_in_risks);        // mate the population together
            $this->_swap($population, $buffer);        // swap buffers
            $this->_calc_fitness($population, $methods_in_risks);        // calculate fitness
            $this->_sort_by_fitness($population);
        }
        return $conflict_risks;
    }

    private function _unset_and_change_key($conflict_risks, $i) {
        foreach ($conflict_risks as $key => $value) {
            if ($key == $i) {
                unset($conflict_risks[$key]);
            }
            if ($key > $i) {
                $conflict_risks[$key - 1] = $value;
                unset($conflict_risks[$key]);
            }
        }
        return $conflict_risks;
    }

    private function _define_risk_conf($methods_in_risks, $conflict_records) {
        $result = Array();
        foreach ($conflict_records as $conflict_record) {
            $result_item = Array();
            foreach ($methods_in_risks as $risk_id => $risk) {
                $method_ids = array_keys($risk['methods']);
                foreach ($method_ids as $method_id) {
                    if ($method_id == $conflict_record->method_1_id OR $method_id == $conflict_record->method_2_id) {
                        $result_item[] = $risk_id;
                    }
                }
            }
            $result[] = $result_item;
        }
        return $result;
    }

    private function _group_conflict($conflict_risks) {
        $nosame = TRUE;
        $eoa = FALSE;
        $focus = 0;
        while (!$eoa) {
            $nosame = TRUE;
            for ($i = $focus + 1; $i < count($conflict_risks); $i++) {
                $k = 0;
                $x = $this->_has_same_element($conflict_risks[$focus], $conflict_risks[$i]);
                if ($x == 1) {
                    $conflict_risks[$focus] = $this->_merge($conflict_risks[$focus], $conflict_risks[$i]);
                    $conflict_risks = $this->_unset_and_change_key($conflict_risks, $i);
                    $i--;
                    $nosame = FALSE;
                }
            }
            if ($nosame) {
                $focus++;
                if ($focus == count($conflict_risks)) {
                    break;
                }
            }
        }
        return $conflict_risks;
    }

    private function _has_same_element($conflict_risks1, $conflict_risks2) {
        for ($i = 0; $i < count($conflict_risks1); $i++) {
            for ($j = 0; $j < count($conflict_risks2); $j++) {
                if (array_values($conflict_risks2)[$j] == array_values($conflict_risks1)[$i]) {
                    return 1;
                    break;
                }
            }
        }
        return 0;
    }

    private function _merge($conflict_risks1, $conflict_risks2) {
        for ($i = 0; $i < count($conflict_risks1); $i++) {
            for ($j = 0; $j < count($conflict_risks2); $j++) {
                if (array_values($conflict_risks2)[$j] == array_values($conflict_risks1)[$i]) {
                    ;
                    $conflict_risks2 = $this->_unset_and_change_key($conflict_risks2, $j);
                    $j--;
                }
            }
        }
        for ($i = 0; $i < count($conflict_risks2); $i++) {
            array_push($conflict_risks1, array_values($conflict_risks2)[$i]);
        }
        return $conflict_risks1;
    }

    private function _init_population($pop_beta, $pop_gama, $group_conflict, $methods_in_risks, $conflict_records) {
        $group_risk_confs = array();
        $group_risk_confss = array();
        $k = 0;
        do {
            $group_risk = array();;
            for ($i = 0; $i < count($group_conflict); $i++) {
                $group_risk_confs = $group_conflict[$i];
                do {
                    $group_risk_confss = array();
                    for ($j = 0; $j < count($group_risk_confs); $j++) {
                        $a = array_values($group_risk_confs)[$j];
                        var_dump($a);
                        foreach ($methods_in_risks as $id =>  $methods_in_risk){
                            if($id == $a){
                                $pop_alpha =  $methods_in_risk;
                                break;
                            }
                        }
                        var_dump($pop_alpha);
                        $methods = $pop_alpha['methods'];
                        $b = rand(0,count($methods)-1);
                        $key = array_keys($methods)[$b];
                        var_dump($key);
                        foreach ($methods as $id => $method){
                          if ($id == $key) {
                              $c = $method->{'id'};
                              break;
                          }
                        }
                        array_push($group_risk_confss, $c);
                    }
                } while ($this->_conflict($group_risk_confss, $conflict_records) == 1);
                array_push($group_risk, array_values($group_risk_confss));
            }
            $k++;
            $buffer = array();
            $buffer = [
                'ga_gen' => $group_risk,
                'fit'    => 0,
            ];
            array_push($pop_beta, $buffer);
        } while ($k < GA_POPSIZE);
        $pop_gama = array(GA_POPSIZE);
        return $pop_beta;
    }

    private function _conflict($group_risk_confss, $conflict_records) {
        var_dump(count($group_risk_confss));
        var_dump(count($conflict_records));
        for ($i = 0; $i < count($group_risk_confss); $i++) {
            for ($j = $i + 1; $j < count($group_risk_confss); $j++) {
                if ($this->_has_conflict(array_values($group_risk_confss)[$j], array_values($group_risk_confss)[$i], $conflict_records)) {
                    return 1;
                    break;
                }
            }
        }
        return 0;
    }

    private function _has_conflict($group_risk_confss1, $group_risk_confss2, $conflict_records) {
        foreach ($conflict_records as $id => $conflict_record ){
            if ((($conflict_record->{'method_1_code'} == ($group_risk_confss1)) && ($conflict_record->{'method_2_code'} == ($group_risk_confss2))) || (($conflict_record->{'method_2_code'} == ($group_risk_confss1)) && ($conflict_record->{'method_1_code'} == ($group_risk_confss2)))) {
                return 1;
                break;
        }
        }
        return 0;
    }

    private function _calc_fitness($population, $methods_in_risks) {
        $group_risk = array();
        $fit = 0;
        for ($i = 0; $i < GA_POPSIZE; $i++) {
            $fit = 0;
            $group_risk = $population[$i]['ga_gen'];
                for ($j = 0; $j < count($group_risk); $j++) {
                    $fit += $this->_calcfitness($group_risk[$j], $methods_in_risks);
                }
            $population[$i]['fit'] = $fit;
        }
        return $population;
    }

    private function _calcfitness($group_risk_confs, $methods_in_risks) {
        $fit = 0;
        for ($i = 0; $i < count($group_risk_confs); $i++) {
            $a = array_values($group_risk_confs)[$i];
            foreach ($methods_in_risks as $id =>$methods_in_risk){
                $pop_alpha = $methods_in_risk['methods'];
                foreach ($pop_alpha as $id => $pop_al){
                    if ($pop_al->{'id'} == $a)
                        $fit += $pop_al->{'cost'};
                }
            }
        }
        return $fit;
    }

    private function _get_methods_in_risks($project_id) {
        $this->db->where('p.id', $project_id);
        $method_records = $this->method->get_all();
        $methods_in_risks = Array();
        foreach ($method_records as $record) {
            if (!isset($methods_in_risks[$record->risk_id])) {
                $methods_in_risks[$record->risk_id] = [
                    'id'      => $record->risk_id,
                    'code'    => $record->risk_code,
                    'name'    => $record->risk_name,
                    'methods' => [],
                ];
            }
            $methods_in_risks[$record->risk_id]['methods'][$record->id] = $record;
        }
        return $methods_in_risks;
    }
}
