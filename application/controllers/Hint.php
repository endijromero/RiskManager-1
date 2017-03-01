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
 * @property M_risk     risk
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
        $this->load->model('M_risk', 'risk');
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
        $data['results'] = $this->_get_table_data($project_id);
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
        $conflict_records = $this->conflict->get_many_by('project_id', $project_id);
        $conflict_risks = $this->_define_risk_conf($methods_in_risks, $conflict_records);
        $group_conflict = $this->_group_conflict($conflict_risks);
        $population = $this->_init_population($pop_beta, $pop_gama, $group_conflict, $methods_in_risks, $conflict_records);
        $buffer = $pop_gama;
        for ($i = 0; $i < GA_MAXITER; $i++) {
            $population = $this->_calc_fitness($population, $methods_in_risks);        // calculate fitness
            $population = $this->_sort_by_fitness($population);    // sort them
            $buffer = $this->_mate($population, $buffer, $conflict_records, $methods_in_risks);        // mate the population together
            $this->_swap($population, $buffer);        // swap buffers
            $this->_calc_fitness($population, $methods_in_risks);        // calculate fitness
            $this->_sort_by_fitness($population);
//            $fits = $this->_print_best($population);

        }
//        exit();
//        echo'<pre>';
        $result = $this->_result($population[0]);
//        var_dump($population[0]);
//        exit();
        return $result;
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
                        foreach ($methods_in_risks as $id => $methods_in_risk) {
                            if ($id == $a) {
                                $pop_alpha = $methods_in_risk;
                                break;
                            }
                        }
                        $methods = $pop_alpha['methods'];
                        $b = rand(0, count($methods) - 1);
                        $key = array_keys($methods)[$b];
                        foreach ($methods as $id => $method) {
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
        foreach ($conflict_records as $id => $conflict_record) {
            if ((($conflict_record->{'method_1_id'} == ($group_risk_confss1)) && ($conflict_record->{'method_2_id'} == ($group_risk_confss2))) || (($conflict_record->{'method_2_id'} == ($group_risk_confss1)) && ($conflict_record->{'method_1_id'} == ($group_risk_confss2)))) {
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
            foreach ($methods_in_risks as $id => $methods_in_risk) {
                $pop_alpha = $methods_in_risk['methods'];
                foreach ($pop_alpha as $id => $pop_al) {
                    if ($pop_al->{'id'} == $a)
                        $fit += $pop_al->{'cost'};
                }
            }
        }
        return $fit;
    }

    private function _sort_by_fitness($population) {
        for ($i = 0; $i < count($population); $i++) {
            for ($j = $i + 1; $j < count($population); $j++) {
                if ($population[$j]['fit'] < $population[$i]['fit']) {
                    //cach trao doi gia tri
                    $tmp = $population[$i];
                    $population[$i] = $population[$j];
                    $population[$j] = $tmp;
                }
            }
        }
        return $population;
    }

    private function _mate($population, $buffer, $conflict_records, $methods_in_risks) {
        $esize = GA_POPSIZE * GA_ELITRATE;
        $spos = 0;
        $i1 = 0;
        $i2 = 0;
        $j = 0;
        $group_risk = array();
        $group_risk_confss = array();
        $popu = array();
        $group_risk = $population[0]['ga_gen'];
        $buffer = $this->_elitism($population, $buffer, $esize);
//	 Mate the rest
        for ($i = 0; $i < count($group_risk); $i++) {
            $group_risk_confs = array();
            for ($h = 0; $h < GA_POPSIZE; $h++) {
                $group_risk = $population[$h]['ga_gen'];
                array_push($group_risk_confs, $group_risk[$i]);
            }
            $tsize = count($group_risk_confs[0]);
            for ($j = 0; $j < GA_POPSIZE - $esize; $j++) {
                $o = array();
                do {

                    $i1 = rand() % (GA_POPSIZE / 2);
                    $i2 = rand() % (GA_POPSIZE / 2);
                    $spos = rand() % $tsize;
                    $a = array();

                    $x1 = $group_risk_confs[$i1];
                    $x2 = $group_risk_confs[$i2];
                    for ($x = 0; $x <= $spos; $x++) {
                        array_push($a, $x1[$x]);
                    }
                    for ($x = $spos + 1; $x < $tsize; $x++) {
                        array_push($a, $x2[$x]);
                    }
                    $o = $a;
                } while ($this->_conflict($o, $conflict_records) == 1);
                do {
                    if (rand() < GA_MUTATION) $o = $this->_mutate($o, $methods_in_risks);
                } while ($this->_conflict($o, $conflict_records) == 1);
                array_push($group_risk_confss, $o);
            }
        }
        $g = count($group_risk_confss) / (GA_POPSIZE - $esize);
        for ($q = 0; $q < (GA_POPSIZE - $esize); $q++) {
            $buff = array();
            $buffs = array();
            $l = $esize;
            for ($s = 0; $s < $g; $s++) {
                array_push($buff, $group_risk_confss[((GA_POPSIZE - $esize) * $s + $q)]);
            }
            array_push($popu, $buff);
            $l++;
        }
        for ($i = 0; $i < GA_POPSIZE - $esize; $i++) {
            $o = array();
            $same = FALSE;
            do {
                $i1 = rand() % (GA_POPSIZE / 2);
                $i2 = rand() % (GA_POPSIZE / 2);
                $tsize = count($popu[$i]);
                $spos = rand() % $tsize;
                $a = array();
                $x1 = $popu[$i1];
                $x2 = $popu[$i2];
                for ($x = 0; $x <= $spos; $x++) {
                    array_push($a, $x1[$x]);
                }
                for ($x = $spos + 1; $x < $tsize; $x++) {
                    array_push($a, $x2[$x]);
                }
                $o = $a;
                for ($h = 0; $h < count($o); $h++) {
                    if ($this->_conflict($o[$h], $conflict_records) == 1)
                        $same = TRUE;
                }
            } while ($same);
            $popu[$i] = $o;
        }

        for ($k = 0; $k < count($popu); $k++) {
            $buff = array();
            $buffs = array();
            $buff = $popu[$k];
            $buffs['ga_gen'] = $buff;
            array_push($buffer, $buffs);
        }

        return $buffer;
    }

    private function _mutate($member, $methods_in_risks) {
        $tsize = count($member);
        $ipos = rand() % $tsize;
        $delta = $member[$ipos];
        foreach ($methods_in_risks as $risk_id => $methods_in_risk) {
            $pop_alpha = $methods_in_risk;
            foreach ($pop_alpha['methods'] as $id => $pop_al_m) {
                if ($id == $delta) {
                    $methods = $pop_alpha['methods'];
                    $b = rand(0, count($methods) - 1);
                    $key = array_keys($methods)[$b];
                    $member[$ipos] = $key;
                }
            }
        }
        return $member;
    }

    private function _print_best($gav) {
        var_dump($gav[0]['ga_gen']);
        echo("Best Fitness:");
        var_dump($gav[0]['fit']);
        return $gav[0]['fit'];
    }

    private function _swap($population, $buffer) {
        $temp = $population;
        $population = $buffer;
        $buffer = $temp;
    }

    private function _elitism($population, $buffer, $esize) {
        for ($i = 0; $i < $esize; $i++) {
            $buffer[$i] = $population[$i];
        }
        return $buffer;
    }

    private function _result($population) {
        $recommend = Array();
        foreach ($population['ga_gen'] as $ge_gen_item) {
            foreach ($ge_gen_item as $method_id) {
                $method_record = $this->method->get($method_id);
                if ($method_record) {
                    $risk_id = $method_record->risk_id;
                    $risk_record = $this->risk->get($risk_id);
                    $recommend[$risk_id] = [
                        'risk'   => $risk_record,
                        'method' => $method_record,
                    ];
                }
            }
        }
        $population['recommend'] = $recommend;
//        echo ('<pre>');
//        var_dump($population);
//        exit();
        return $population;
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
