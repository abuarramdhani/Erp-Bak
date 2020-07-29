<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        //load the login model
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->model('M_Index');
        $this->load->library('upload');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('WorkInProcessPackaging/M_wipp');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    //------------------------show the dashboard-----------------------------
    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Index');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    // ============================Job Manager====================================
    public function JobManager()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Job_Manager');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function cekNojob()
    {
        echo json_encode($this->M_wipp->ceknojob($this->input->post('nojob')));
    }

    public function lishRKH()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $data['pp'] =  $this->M_wipp->getLR();
            $this->load->view('WorkInProcessPackaging/ajax/V_List_RKH', $data);
        }
    }

    public function getitembykodeitem()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $data['get'] =  $this->M_wipp->getJob($this->input->post('kode_item'));
            // echo "<pre>";
            // print_r($data['get'] );
            $this->load->view('WorkInProcessPackaging/ajax/V_Job_Released_List', $data);
        }
    }

    public function SaveJobList()
    {
        $date = $this->input->post('date');
        $waktu_shift = $this->input->post('waktu_shift');
        $data = $this->input->post('data');
        $j = $this->input->post('jenis');
        $jenis = substr($j, 0, 1);
        // echo "<pre>";print_r($data);die;
        if (!empty($date)) {
            $cekk = $this->db->select('date_target')
                         ->where('date_target', $date)
                         ->where('type', $jenis)
                         ->get('wip_pnp.job_list')
                         ->row();
            if (empty($cekk->date_target)) {
                foreach ($data as $key => $d) {
                    $n195 = $this->M_wipp->savenewRKH([
                      'date_target' => $date,
                      'waktu_satu_shift' => $waktu_shift,
                      'type' => $jenis,
                      'no_job' => $d[1],
                      'kode_item' => $d[2],
                      'nama_item' => $d[3],
                      'qty' => $d[4],
                      'usage_rate' => $d[5],
                      'scedule_start_date' => $d[6],
                      'qty_parrent' => $d[7]
                    ]);
                }
                echo json_encode($n195);
            } else {
                echo json_encode(2);
            }
        } else {
            echo json_encode('fail');
        }
    }

    public function productPriority()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $data['pp'] =  $this->M_wipp->getPP();
            $this->load->view('WorkInProcessPackaging/ajax/V_Product_Priority', $data);
        }
    }

    public function JobReleased()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $data_a = $this->M_wipp->getItem();
            $data_b = $this->M_wipp->getJobAll();
            $priority = $this->M_wipp->getPP();

            foreach ($data_b as $key1 => $value1) {
              foreach ($data_a as $key => $value) {
               if ($value1['KODE_COMP'] == $value['KODE_ASSY']) {
                 $get_job[$value1['KODE_ASSY']] = $value1;
               }
              }
            }

            foreach ($data_a as $key => $value) {
              $data_a[$key]['PRIORITY'] = 0;
              foreach ($get_job as $key2 => $gj) {
                if ($gj['KODE_COMP'] === $value['KODE_ASSY']) {
                  foreach ($priority as $key3 => $pr) {
                    if ($pr['kode_item'] === $gj['KODE_ASSY']) {
                      $tampung_priority[] = $value;
                    }
                  }
                }
              }
            }


            if (!empty($tampung_priority)) {

                //pengecekan di jika itu priority = 1
                foreach ($tampung_priority as $key => $pr) {
                    $tampung_priority[$key]['PRIORITY'] = 1;
                }
                // hapus item yang ada sama di produk prioritas
                foreach ($data_a as $key0 => $value) {
                    foreach ($tampung_priority as $key2 => $v) {
                        if ($value['KODE_ASSY'] == $v['KODE_ASSY']) {
                            $tampung_priority_reedition[] = $v;
                            unset($data_a[$key0]);
                        }
                    }
                }
                // gabungkan data dengan produk prioritas di awal index
                $data1_1 = array_merge($tampung_priority_reedition, $data_a);
            } else {
                $data1_1 = $data_a;
            }

            foreach ($data1_1 as $key => $val) {
                $minmax = $this->M_wipp->minMax($val['KODE_ASSY']);
                if (!empty($minmax)) {
                    $data1_1[$key]['MIN'] = $minmax[0]['MIN'];
                    $data1_1[$key]['MAX'] = $minmax[0]['MAX'];
                } else {
                    $data1_1[$key]['MIN'] = '-';
                    $data1_1[$key]['MAX'] = '-';
                }
            }
            $data['get_unique'] = $data1_1;
            $this->load->view('WorkInProcessPackaging/ajax/V_Job_Released', $data);
        }
    }

    public function JobReleasedEdit()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $data_a = $this->M_wipp->getItem();

            foreach ($data_a as $key => $val) {
                $data_a[$key]['PRIORITY'] = 0;
                $minmax = $this->M_wipp->minMax($val['KODE_ASSY']);
                if (!empty($minmax)) {
                    $data_a[$key]['MIN'] = $minmax[0]['MIN'];
                    $data_a[$key]['MAX'] = $minmax[0]['MAX'];
                } else {
                    $data_a[$key]['MIN'] = '-';
                    $data_a[$key]['MAX'] = '-';
                }
            }
            $data['get_unique'] = $data_a;
            $this->load->view('WorkInProcessPackaging/ajax/V_Job_Released', $data);
        }
    }

    public function JobReleaseSelected()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_wipp->getDetailItem($term));
    }

    public function productPriorityDelete()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            echo json_encode($this->M_wipp->productPriorityDelete([
          'id' => $this->input->post('id')
        ]));
        }
    }

    public function productPrioritySave()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            echo json_encode($this->M_wipp->productPrioritySave([
          'kode_item' => $this->input->post('kode'),
          'nama_item' => $this->input->post('nama')
        ]));
            // echo json_encode(1);
        }
    }

    public function ArrangeJobList($l)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['param'] = $l;
        $x = explode('_', $l);
        $get_wss = $this->db->select('waktu_satu_shift')->where('date_target', $x[0])->where('type', $x[1])->get('wip_pnp.job_list')->row_array();
        $data['wss'] = $get_wss['waktu_satu_shift'];

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Arrange');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function setTarget_Pe()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang !!";
        } else {
            echo json_encode($this->M_wipp->setTarget_Pe($this->input->post('param')));
        }
    }

    public function updateTarget_Pe()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang !!";
        } else {
            $response = $this->M_wipp->updateTarget_Pe($this->input->post('param'), $this->input->post('data'));
            echo json_encode($response);
        }
    }

    public function cekLineSaved($value='')
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang !!";
        } else {
            $response = $this->M_wipp->cekLineSaved($this->input->post('date'));
            echo json_encode($response);
        }
    }

    public function bedaindosNbukandos()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Dilarang !!";
        } else {
            $data = $this->input->post('data');
            if (!empty($data)) {
                foreach ($data as $key => $l) {
                    $list[] = $l[2]; //kode item
                }
                $list_unique = array_unique($list);

                foreach ($data as $key => $l) {
                    $cek = $this->M_wipp->getDetailBom($l[2]);
                    if (empty($cek)) {
                        $data[$key]['dicek'] = 3;
                    } else {
                        $data[$key]['dicek'] = 1;
                        $dicek = '';
                        foreach ($cek as $key2 => $c) {
                            if (strpos($c['DESCRIPTION'], 'DOS') !== false) {
                                $dicek = 0;
                                $data[$key]['dicek'] = $dicek;
                                break;
                            }
                        }
                    }
                }
                // echo "<pre>";
                // print_r($data);
                foreach ($data as $key => $d) {
                    if ($d['dicek'] === 0) {
                        $adados[] = $d;
                    }
                    if ($d['dicek'] === 1) {
                        $gaadados[] = $d;
                    }
                }
                $data_final = [
              'adados' => !empty($adados)?$adados:[],
              'gaadados' => !empty($gaadados)?$gaadados:[]
            ];
                echo json_encode($data_final);
            }
        }
    }

    public function setArrange()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $date = $this->input->post('date');
            $listRKH = $this->M_wipp->getListRKH($date);
            $get_target_pe = $this->M_wipp->setTarget_Pe('');

            if (!empty($listRKH)) {
                foreach ($listRKH as $key => $l) {
                    $list[] = $l['kode_item'];
                }
                $list_unique = array_unique($list);

                foreach ($listRKH as $key => $l) {
                    $cek = $this->M_wipp->getDetailBom($l['kode_item']);
                    foreach ($cek as $key => $c) {
                        if (strpos($c['DESCRIPTION'], 'DOS') !== false) {
                            $dicek = 1;
                            break;
                        } else {
                            $dicek = 0;
                        }
                    }
                    $dos[] = [
                        'no_job' => $l['no_job'],
                        'id_job_list' => $l['id'],
                        'kode_item' => $l['kode_item'],
                        'qty' => $l['qty'],
                        'target_pe' => ($l['qty']/($l['waktu_satu_shift']/$l['usage_rate']))*100/100,
                        'dos' => $dicek
                     ];
                }

                foreach ($dos as $key => $d) {
                    if ($d['dos']) {
                        $adados[] = $d;
                    }
                    if ($d['dos'] === 0) {
                        $gaadados[] = $d;
                    }
                }

                //LINE 4
                if (!empty($adados)) {
                    usort($adados, function ($a, $b) {
                        return $a['target_pe'] > $b['target_pe'] ? 1 : -1;
                    });

                    $line_4_target_max = $get_target_pe[3]['target_max'];
                    $line_4_count = 0;
                    $line_4 = [];
                    foreach ($adados as $key4 => $val4) {
                        $line_4_count += $val4['target_pe'];
                        if ($line_4_count < $line_4_target_max && ! array_key_exists($val4['no_job'], $line_4)) {
                            $line_4[$val4['no_job']] = $val4;
                        }
                    }
                    //UNSET LINE 4
                    if (!empty($line_4)) {
                        foreach ($line_4 as $key4a => $val4a) {
                            $keys4= array_keys(array_column($adados, 'id_job_list'), $val4a['id_job_list']);
                            $unset4[] = $keys4[0];
                        }
                        foreach ($unset4 as $key4b => $al4b) {
                            unset($adados[$al4b]);
                        }
                        $adados_line4 = array_values($adados);
                    } else {
                        $line_4 = [];
                    }
                }
                if (empty($line_4)) {
                    $line_4 = [];
                }

                //LINE 5
                if (!empty($line_4)) {
                    if (!empty($adados_line4)) {
                        $line_5_target_max = $get_target_pe[4]['target_max'];
                        $line_5_count = 0;
                        $line_5 = [];
                        foreach ($adados_line4 as $key5 => $val5) {
                            $line_5_count += $val5['target_pe'];
                            if ($line_5_count < $line_5_target_max && ! array_key_exists($val5['no_job'], $line_5)) {
                                $line_5[$val5['no_job']] = $val5;
                            }
                        }
                        //UNSET LINE 5
                        if (!empty($line_5)) {
                            foreach ($line_5 as $key5a => $val5a) {
                                $keys5= array_keys(array_column($adados_line4, 'id_job_list'), $val5a['id_job_list']);
                                $unset5[] = $keys5[0];
                            }
                            foreach ($unset5 as $key5b => $al5b) {
                                unset($adados_line4[$key5b]);
                            }
                            $adados_line5 = array_values($adados_line4);
                        } else {
                            $line_5 = [];
                        }
                    }
                }
                if (empty($line_5)) {
                    $line_5 = [];
                }

                // LINE1
                if (!empty($gaadados)) {
                    usort($gaadados, function ($a, $b) {
                        return $a['target_pe'] > $b['target_pe'] ? 1 : -1;
                    });

                    $line_1_target_max = $get_target_pe[0]['target_max'];
                    $line_1_count = 0;
                    $line_1 = [];
                    foreach ($gaadados as $key1 => $val1) {
                        $line_1_count += $val1['target_pe'];
                        if ($line_1_count < $line_1_target_max && ! array_key_exists($val1['no_job'], $line_1)) {
                            $line_1[$val1['no_job']] = $val1;
                        }
                    }
                    //UNSET LINE 1
                    if (!empty($line_1)) {
                        foreach ($line_1 as $key1a => $val1a) {
                            $keys1= array_keys(array_column($gaadados, 'id_job_list'), $val1a['id_job_list']);
                            $unset1[] = $keys1[0];
                        }
                        foreach ($unset1 as $key1b => $al1b) {
                            unset($gaadados[$al1b]);
                        }
                        $gaadados_line1 = array_values($gaadados);
                    } else {
                        $line_1 = [];
                    }
                }
                if (empty($line_1)) {
                    $line_1 = [];
                }

                //LINE 2
                if (!empty($gaadados_line1)) {
                    $line_2_target_max = $get_target_pe[1]['target_max'];
                    $line_2_count = 0;
                    $line_2 = [];
                    foreach ($gaadados_line1 as $key2 => $val2) {
                        $line_2_count += $val2['target_pe'];
                        if ($line_2_count < $line_2_target_max && ! array_key_exists($val2['no_job'], $line_2)) {
                            $line_2[$val2['no_job']] = $val2;
                        }
                    }
                    //UNSET LINE 2
                    if (!empty($line_2)) {
                        foreach ($line_2 as $key2a => $val2a) {
                            $keys2= array_keys(array_column($gaadados_line1, 'id_job_list'), $val2a['id_job_list']);
                            $unset2[] = $keys2[0];
                        }
                        foreach ($unset2 as $key2b => $al2b) {
                            unset($gaadados_line1[$al2b]);
                        }
                        $gaadados_line2 = array_values($gaadados_line1);
                    } else {
                        $line_2 = [];
                    }
                }
                if (empty($line_2)) {
                    $line_2 = [];
                }

                //LINE 3
                if (!empty($gaadados_line2)) {
                    $line_3_target_max =$get_target_pe[2]['target_max'];
                    $line_3_count = 0;
                    $line_3 = [];
                    foreach ($gaadados_line2 as $key3 => $val3) {
                        $line_3_count += $val3['target_pe'];
                        if ($line_3_count < $line_3_target_max && ! array_key_exists($val3['no_job'], $line_3)) {
                            $line_3[$val3['no_job']] = $val3;
                        }
                    }
                    //UNSET LINE 3
                    if (!empty($line_3)) {
                        foreach ($line_3 as $key3a => $val3a) {
                            $keys3= array_keys(array_column($gaadados_line2, 'id_job_list'), $val3a['id_job_list']);
                            $unset3[] = $keys3[0];
                        }
                        foreach ($unset3 as $key3b => $al3b) {
                            unset($gaadados_line2[$al3b]);
                        }
                        $gaadados_line3 = array_values($gaadados_line2);
                    } else {
                        $line_3 = [];
                    }
                }
                if (empty($line_3)) {
                    $line_3 = [];
                }

                // foreach ($line_1 as $key => $value) {$line_1[$key]['PPIC'] = $value['qty']*$value['target_pe'];}
                // foreach ($line_2 as $key => $value) {$line_2[$key]['PPIC'] = $value['qty']*$value['target_pe'];}
                // foreach ($line_3 as $key => $value) {$line_3[$key]['PPIC'] = $value['qty']*$value['target_pe'];}
                // foreach ($line_4 as $key => $value) {$line_4[$key]['PPIC'] = $value['qty']*$value['target_pe'];}
                // foreach ($line_5 as $key => $value) {$line_5[$key]['PPIC'] = $value['qty']*$value['target_pe'];}



                foreach ($line_1 as $key => $value) {
                    $line_1[$key]['PPIC'] = $value['target_pe'];
                }
                foreach ($line_2 as $key => $value) {
                    $line_2[$key]['PPIC'] = $value['target_pe'];
                }
                foreach ($line_3 as $key => $value) {
                    $line_3[$key]['PPIC'] = $value['target_pe'];
                }
                foreach ($line_4 as $key => $value) {
                    $line_4[$key]['PPIC'] = $value['target_pe'];
                }
                foreach ($line_5 as $key => $value) {
                    $line_5[$key]['PPIC'] = $value['target_pe'];
                }

                $data['line_1'] = $line_1;
                $data['line_2'] = $line_2;
                $data['line_3'] = $line_3;
                $data['line_4'] = $line_4;
                $data['line_5'] = $line_5;

                $data['PPIC_1'] = array_sum(array_column($line_1, 'PPIC'));
                $data['PPIC_2'] = array_sum(array_column($line_2, 'PPIC'));
                $data['PPIC_3'] = array_sum(array_column($line_3, 'PPIC'));
                $data['PPIC_4'] = array_sum(array_column($line_4, 'PPIC'));
                $data['PPIC_5'] = array_sum(array_column($line_5, 'PPIC'));

                // echo "<pre>";
                // print_r($line_1);
                // echo "<pre>";
                // print_r($line_2);
                // echo "<pre>";
                // print_r($data['PPIC_1']);
                // echo "<pre>";
                // print_r($data['PPIC_2']);
                // die;
                // die;
                $this->load->view('WorkInProcessPackaging/ajax/V_Lines', $data);
            } else {
                $line_1 = [];
                $line_2 = [];
                $line_3 = [];
                $line_4 = [];
                $line_5 = [];
            }
        }
    }

    public function getSavedLineData()
    {
        $date = $this->input->post('date');
        $line_1 = $this->M_wipp->getline1($date);
        $line_2 = $this->M_wipp->getline2($date);
        $line_3 = $this->M_wipp->getline3($date);
        $line_4 = $this->M_wipp->getline4($date);
        $line_5 = $this->M_wipp->getline5($date);

        foreach ($line_1 as $key => $value) {
            $line_1[$key]['PPIC'] = $value['target_pe'];
        }
        foreach ($line_2 as $key => $value) {
            $line_2[$key]['PPIC'] = $value['target_pe'];
        }
        foreach ($line_3 as $key => $value) {
            $line_3[$key]['PPIC'] = $value['target_pe'];
        }
        foreach ($line_4 as $key => $value) {
            $line_4[$key]['PPIC'] = $value['target_pe'];
        }
        foreach ($line_5 as $key => $value) {
            $line_5[$key]['PPIC'] = $value['target_pe'];
        }

        $data['line_1'] = $line_1;
        $data['line_2'] = $line_2;
        $data['line_3'] = $line_3;
        $data['line_4'] = $line_4;
        $data['line_5'] = $line_5;

        $data['PPIC_1'] = array_sum(array_column($line_1, 'PPIC'));
        $data['PPIC_2'] = array_sum(array_column($line_2, 'PPIC'));
        $data['PPIC_3'] = array_sum(array_column($line_3, 'PPIC'));
        $data['PPIC_4'] = array_sum(array_column($line_4, 'PPIC'));
        $data['PPIC_5'] = array_sum(array_column($line_5, 'PPIC'));


        // echo "<pre>";
        // print_r($line_1);
        //
        // echo "<pre>";
        // print_r($data['PPIC_1']);
        // die;
        $this->load->view('WorkInProcessPackaging/ajax/V_Lines', $data);
    }

    public function getTargetMaxPE()
    {
        $get_target_pe = $this->M_wipp->setTarget_Pe('');
        echo json_encode($get_target_pe);
    }

    public function saveLine()
    {
        $get_target_pe = $this->M_wipp->setTarget_Pe('');
        $this->M_wipp->ceklineaja($this->input->post('param'));
        // line 1
        $job1 =  $this->input->post('job1');
        $item1 =  $this->input->post('item1');
        $qty1 =  $this->input->post('qty1');
        $target1 =  $this->input->post('target1');
        $id_job1 =  $this->input->post('id_job_list1');
        $id_split1 =  $this->input->post('id_split1');
        $date = $this->input->post('param');
        $x = explode('_', $date);
        foreach ($job1 as $key => $j1) {
            $this->M_wipp->insert_data_line([
            'date_target' => $x[0],
            'type' => $x[1],
            'no_job' => $j1,
            'kode_item' => $item1[$key],
            'qty' => $qty1[$key],
            'target_pe' => $target1[$key],
            'target_pe_max' => $get_target_pe[0]['target_max'],
            // 'id_split' => trim($id_split1[$key]),
            'id_job_list' => trim($id_job1[$key]),
            'line' => 1
        ]);
        }

        // line 2
        $job2 =  $this->input->post('job2');
        $item2 =  $this->input->post('item2');
        $qty2 =  $this->input->post('qty2');
        $target2 =  $this->input->post('target2');
        $id_job2 =  $this->input->post('id_job_list2');
        $id_split2 =  $this->input->post('id_split2');
        foreach ($job2 as $key => $j2) {
          $this->M_wipp->insert_data_line([
          'date_target' => $x[0],
          'type' => $x[1],
          'no_job' => $j2,
          'kode_item' => $item2[$key],
          'qty' => $qty2[$key],
          'target_pe' => $target2[$key],
          'target_pe_max' => $get_target_pe[1]['target_max'],
          // 'id_split' => $id_split2[$key],
          'id_job_list' => $id_job2[$key],
          'line' => 2
        ]);
        }

        // line 3
        $job3 =  $this->input->post('job3');
        $item3 =  $this->input->post('item3');
        $qty3 =  $this->input->post('qty3');
        $target3 =  $this->input->post('target3');
        $id_job3 =  $this->input->post('id_job_list3');
        $id_split3 =  $this->input->post('id_split3');

        foreach ($job3 as $key => $j3) {
        $this->M_wipp->insert_data_line([
          'date_target' => $x[0],
          'type' => $x[1],
          'no_job' => $j3,
          'kode_item' => $item3[$key],
          'qty' => $qty3[$key],
          'target_pe' => $target3[$key],
          'target_pe_max' => $get_target_pe[2]['target_max'],
          // 'id_split' => trim($id_split3[$key]),
          'id_job_list' => trim($id_job3[$key]),
          'line' => 3
        ]);
        }

        // line 4
        $job4 =  $this->input->post('job4');
        $item4 =  $this->input->post('item4');
        $qty4 =  $this->input->post('qty4');
        $target4 =  $this->input->post('target4');
        $id_job4 =  $this->input->post('id_job_list4');
        $id_split4 =  $this->input->post('id_split4');
        foreach ($job4 as $key => $j4) {
            $this->M_wipp->insert_data_line([
          'date_target' => $x[0],
          'type' => $x[1],
          'no_job' => $j4,
          'kode_item' => $item4[$key],
          'qty' => $qty4[$key],
          'target_pe' => $target4[$key],
          'target_pe_max' => $get_target_pe[3]['target_max'],
          // 'id_split' => $id_split4[$key],
          'id_job_list' => $id_job4[$key],
          'line' => 4
        ]);
        }

        // line 5
        $job5 =  $this->input->post('job5');
        $item5 =  $this->input->post('item5');
        $qty5 =  $this->input->post('qty5');
        $target5 =  $this->input->post('target5');
        $id_job5 =  $this->input->post('id_job_list5');
        $id_split5 =  $this->input->post('id_split5');

        foreach ($job5 as $key => $j5) {
            $this->M_wipp->insert_data_line([
          'date_target' => $x[0],
          'type' => $x[1],
          'no_job' => $j5,
          'kode_item' => $item5[$key],
          'qty' => $qty5[$key],
          'target_pe' => $target5[$key],
          'target_pe_max' => $get_target_pe[4]['target_max'],
          // 'id_split' => $id_split5[$key],
          'id_job_list' => $id_job5[$key],
          'line' => 5
        ]);
        }

        redirect('WorkInProcessPackaging/JobManager/ArrangeJobList/'.$this->input->post('param'));
    }

    public function lishArrange($l)
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $date = $l;
            $line1 = $this->M_wipp->getline1($date);
            $line2 = $this->M_wipp->getline2($date);
            $line3 = $this->M_wipp->getline3($date);
            $line4 = $this->M_wipp->getline4($date);
            $line5 = $this->M_wipp->getline5($date);

            if (!empty($line1) || !empty($line4) || !empty($line2) || !empty($line3)) {
                $tampung = array_merge($line1, $line2, $line3, $line4, $line5);

                foreach ($tampung as $h) {
                    $tampung_1[] = [
                    'id_job_list' => $h['id_job_list']
                  ];
                }
                $split = $this->M_wipp->getListRKH($l);
                // echo "<pre>";
                // print_r($split);
                // echo "<pre>";
                // print_r($tampung_1);
                // die;
                foreach ($split as $key1 => $t) {
                    foreach ($tampung_1 as $key2 => $q) {
                        if ($t['id']=== $q['id_job_list']) {
                            unset($split[$key1]);
                            // echo "<pre>";
                            // print_r($split[$key1]);
                        }
                    }
                }
                $data['get'] = $split;
            } else {
                $data['get'] = $this->M_wipp->getListRKH($l);
            }

            $this->load->view('WorkInProcessPackaging/ajax/V_List_Arrange', $data);
        }
    }

    public function getSplit()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $data['get'] = $this->M_wipp->getSplit($this->input->post('nojob'), $this->input->post('date'));
            $this->load->view('WorkInProcessPackaging/ajax/V_Row_Split', $data);
        }
    }

    public function SaveSplit()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $nojob = $this->input->post('nojob');
            $item = $this->input->post('item');
            $dt = $this->input->post('date');
            $x = explode('_', $dt);
            $date = $x[0];
            $qty = $this->input->post('qty');
            $target_pe = $this->input->post('target_pe');
            $ca = $this->input->post('created_at');

            $cek_job = $this->M_wipp->cek_job($nojob);
            $id_parent_hapus = $cek_job[0]['id'];

            $cek = $this->db->select('date_target, no_job')
                        ->where('date_target', $date)
                        ->where('type', $x[1])
                        ->where('no_job', $nojob)
                        ->get('wip_pnp.job_list')
                        ->row();
            if (!empty($cek->no_job)) {
                $this->db->delete('wip_pnp.job_list', ['no_job' => $nojob]);
            }
            foreach ($qty as $key => $q) {
                $data = $this->M_wipp->insertSplit([
                'date_target' => $date,
                'type' => $x[1],
                'nama_item' => $cek_job[0]['nama_item'],
                'usage_rate' => $cek_job[0]['usage_rate'],
                'scedule_start_date' => $cek_job[0]['scedule_start_date'],
                'waktu_satu_shift' => $cek_job[0]['waktu_satu_shift'],
                'photo' => $cek_job[0]['photo'],
                'no_job' => $nojob,
                'kode_item' => $item,
                'qty' => $qty[$key],
                'qty_parrent' => !empty($cek_job[0]['qty_parrent'])?$cek_job[0]['qty_parrent']:$cek_job[0]['qty'],
                // 'target_pe' => $target_pe[$key],
              ], !empty($ca[$key])?$ca[$key]:'2010-05-28 08:28:16');
            }

            $this->M_wipp->delete_parent_job($id_parent_hapus);
            // echo "<pre>";
            // print_r($data);
            // die;
            echo json_encode($data);
        }
    }

    public function SaveSplit_()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            $date = $this->input->post('date');
            $wss = $this->input->post('wss');
            if (!empty($date) && !empty($wss)) {
                $nojob = $this->input->post('nojob');
                $cekk = $this->db->select('date_target, no_job')
                           ->where('date_target', $date)
                           ->where('no_job', $nojob)
                           ->get('wip_pnp.job_list')
                           ->row();
                if (!empty($cekk->date_target)) {
                    echo json_encode(3);
                } else {
                    $item = $this->input->post('item');
                    $item_dec = $this->input->post('item_name');
                    $qty = $this->input->post('qty');
                    $target_pe = $this->input->post('target_pe');
                    $urs = $this->input->post('urs');
                    $ssd = $this->input->post('ssd');
                    $qty_parrent = $this->input->post('qty_parrent');

                    foreach ($qty as $key => $q) {
                        $data = $this->M_wipp->insertSplit_([
                      'date_target' => $date,
                      'nama_item' => $item_dec,
                      'usage_rate' => $urs,
                      'scedule_start_date' => $ssd,
                      'waktu_satu_shift' => $wss,
                      'no_job' => $nojob,
                      'kode_item' => $item,
                      'qty' => $qty[$key],
                      'qty_parrent' => $qty_parrent,
                    ], '2012-12-12 12:12:12');
                    }
                    echo json_encode($data);
                }
            } else {
                echo json_encode(2);
            }
        }
    }

    public function Label($date)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $line1 = $this->M_wipp->getline1($date);
        $line2 = $this->M_wipp->getline2($date);
        $line3 = $this->M_wipp->getline3($date);
        $line4 = $this->M_wipp->getline4($date);
        $line5 = $this->M_wipp->getline5($date);

        // line 1
        foreach ($line1 as $key => $value) {
          $description = $this->M_wipp->cek_job_id($value['id_job_list']);
          $line1[$key]['DESCRIPTION'] = $description[0]['nama_item'];
        }

        foreach ($line1 as $key => $ln1) {
          $bom_ln1 = $this->M_wipp->getDetailBom2($ln1['kode_item']);
          usort($bom_ln1, function ($a, $b) {
              return $a['QTY'] > $b['QTY'] ? 1 : -1;
          });
          if (!empty($bom_ln1)) {
            $ln1_tampng[] = $bom_ln1[0];
          }else {
            $ln1_tampng[] = NULL;
          }
        }
        if (!empty($ln1_tampng)) {
          foreach ($ln1_tampng as $key => $bln1) {
            $line1[$key]['QTY_BOM'] = $bln1['QTY'];
            $line1[$key]['DESCRIPTION_BOM'] = $bln1['DESCRIPTION'];
          }
        }
        // line 2
        foreach ($line2 as $key => $value) {
          $description = $this->M_wipp->cek_job_id($value['id_job_list']);
          $line2[$key]['DESCRIPTION'] = $description[0]['nama_item'];
        }

        foreach ($line2 as $key => $ln1) {
          $bom_ln1 = $this->M_wipp->getDetailBom2($ln1['kode_item']);
          usort($bom_ln1, function ($a, $b) {
              return $a['QTY'] > $b['QTY'] ? 1 : -1;
          });
          if (!empty($bom_ln1)) {
            $ln2_tampng[] = $bom_ln1[0];
          }else {
            $ln2_tampng[] = NULL;
          }
        }
        if (!empty($ln2_tampng)) {
          foreach ($ln2_tampng as $key => $bln1) {
            $line2[$key]['QTY_BOM'] = $bln1['QTY'];
            $line2[$key]['DESCRIPTION_BOM'] = $bln1['DESCRIPTION'];
          }
        }
        // line 3
        foreach ($line3 as $key => $value) {
          $description = $this->M_wipp->cek_job_id($value['id_job_list']);
          $line3[$key]['DESCRIPTION'] = $description[0]['nama_item'];
        }
        foreach ($line3 as $key => $ln1) {
          $bom_ln1 = $this->M_wipp->getDetailBom2($ln1['kode_item']);
          usort($bom_ln1, function ($a, $b) {
              return $a['QTY'] > $b['QTY'] ? 1 : -1;
          });
          if (!empty($bom_ln1)) {
            $ln3_tampng[] = $bom_ln1[0];
          }else {
            $ln3_tampng[] = NULL;
          }
        }
        if (!empty($ln3_tampng)) {
          foreach ($ln3_tampng as $key => $bln1) {
            $line3[$key]['QTY_BOM'] = $bln1['QTY'];
            $line3[$key]['DESCRIPTION_BOM'] = $bln1['DESCRIPTION'];
          }
        }
        // line 4
        foreach ($line4 as $key => $value) {
          $description = $this->M_wipp->cek_job_id($value['id_job_list']);
          $line4[$key]['DESCRIPTION'] = $description[0]['nama_item'];
        }

        foreach ($line4 as $key => $ln1) {
          $bom_ln1 = $this->M_wipp->getDetailBom2($ln1['kode_item']);
          usort($bom_ln1, function ($a, $b) {
              return $a['QTY'] > $b['QTY'] ? 1 : -1;
          });
          if (!empty($bom_ln1)) {
            $ln4_tampng[] = $bom_ln1[0];
          }else {
            $ln4_tampng[] = NULL;
          }
        }
        if (!empty($ln4_tampng)) {
          foreach ($ln4_tampng as $key => $bln1) {
            $line4[$key]['QTY_BOM'] = $bln1['QTY'];
            $line4[$key]['DESCRIPTION_BOM'] = $bln1['DESCRIPTION'];
          }
        }
        // line 5
        foreach ($line5 as $key => $value) {
          $description = $this->M_wipp->cek_job_id($value['id_job_list']);
          $line5[$key]['DESCRIPTION'] = $description[0]['nama_item'];
        }

        foreach ($line5 as $key => $ln1) {
          $bom_ln1 = $this->M_wipp->getDetailBom2($ln1['kode_item']);
          usort($bom_ln1, function ($a, $b) {
              return $a['QTY'] > $b['QTY'] ? 1 : -1;
          });
          if (!empty($bom_ln1)) {
            $ln5_tampng[] = $bom_ln1[0];
          }else {
            $ln5_tampng[] = NULL;
          }
        }
        
        if (!empty($ln5_tampng)) {
          foreach ($ln5_tampng as $key => $bln1) {
            $line5[$key]['QTY_BOM'] = $bln1['QTY'];
            $line5[$key]['DESCRIPTION_BOM'] = $bln1['DESCRIPTION'];
          }
        }
        // echo "<pre>";print_r($line1);
        // die;
        $data['param'] = $date;
        $data['line_1'] = $line1;
        $data['line_2'] = $line2;
        $data['line_3'] = $line3;
        $data['line_4'] = $line4;
        $data['line_5'] = $line5;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Label');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function LabelKecil($do)
    {
        $d = explode('_', $do);
        $doc = $d[0];
        $qty = $d[1];
        // echo "<pre>";
        // print_r($d);
        // die;
        if (!empty($doc)) {
            $data['row'] = $this->M_wipp->LabelKecil($doc);
            $data['qty'] = $qty;
            // ====================== do something =========================
            $this->load->library('Pdf');
            $pdf 		= $this->pdf->load();
            $pdf 		= new mPDF('utf-8', array(93.98,39.878), 0, '', 0, 0, 0, 0, 0, 0);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/PBIQRCode')) {
                chmod('./assets/img/PBIQRCode', 0777);
            }
            $this->load->library('ciqrcode');

            $params['data']		= $doc;
            $params['level']	= 'H';
            $params['size']		= 4;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);

            $params['savename'] = './assets/img/PBIQRCode/'.$doc.'.png';
            $this->ciqrcode->generate($params);

            // echo "<pre>";
            // print_r($this->ciqrcode->generate($params));
            // die;

            ob_end_clean() ;
            $filename 	= $doc.'.pdf';
            $isi 				= $this->load->view('WorkInProcessPackaging/pdf/V_Pdf', $data, true);
            $pdf->WriteHTML($isi);
            $pdf->Output($filename, 'I');
        } else {
            echo json_encode(array(
            'success' => false,
            'message' => 'id is null'
          ));
        }

        if (!unlink($params['savename'])) {
            echo("Error deleting");
        } else {
            unlink($params['savename']);
        }
    }

    public function LabelBesar($do)
    {
        $d = explode('_', $do);
        $doc = $d[0];
        $qty = $d[1];
        // echo "<pre>";
        // print_r($d);
        // die;
        if (!empty($doc)) {
            $data['row'] = $this->M_wipp->LabelKecil($doc);
            $data['qty'] = $qty;
            // ====================== do something =========================
            $this->load->library('Pdf');
            $pdf 		= $this->pdf->load();
            $pdf 		= new mPDF('utf-8', array(71.12,40.64), 0, '', 0, 0, 0, 0, 0, 0);
            $this->load->library('ciqrcode');

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/PBIQRCode')) {
                mkdir('./assets/img/PBIQRCode', 0777, true);
                chmod('./assets/img/PBIQRCode', 0777);
            }

            $params['data']		= $doc;
            $params['level']	= 'H';
            $params['size']		= 4;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/PBIQRCode/'.$doc.'.png';
            $this->ciqrcode->generate($params);

            // echo "<pre>";
            // print_r($this->ciqrcode->generate($params));
            // die;

            ob_end_clean() ;
            $filename 	= $doc.'.pdf';
            $isi 				= $this->load->view('WorkInProcessPackaging/pdf/V_Pdf_Besar', $data, true);
            $pdf->WriteHTML($isi);
            $pdf->Output($filename, 'I');
        } else {
            echo json_encode(array(
            'success' => false,
            'message' => 'id is null'
          ));
        }
        if (!unlink($params['savename'])) {
            echo("Error deleting");
        } else {
            unlink($params['savename']);
        }
    }

    public function JobRelease()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_wipp->JobRelease();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Monitoring_Job');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function getDetailBom()
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->M_wipp->getDetailBom2($this->input->post('kode_item')));
        }
    }

    // =========================Photo Manager====================================

    public function PhotoManager()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Photo_Manager_Choose');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function Type($param)
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['param'] = $param;
        $data['get'] = $this->M_wipp->getPhoto($param);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WorkInProcessPackaging/V_Photo_Manager');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }


    public function delete_photo()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang!!!";
        } else {
            echo json_encode($this->M_wipp->delete_photo($this->input->post('id')));
        }
    }

    public function Save()
    {
        // echo "<pre>";
        // print_r($_FILES);
        // die;
        $item = $this->input->post('kode_komponen');
        $nama_comp = $this->input->post('nama_komponen');
        $param = $this->input->post('type_gambar');

        if (!empty($_FILES['filenyagan']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/wipp')) {
                mkdir('./assets/upload/wipp', 0777, true);
                chmod('./assets/upload/wipp', 0777);
            }
            $config['upload_path'] = './assets/upload/wipp/'.$param;
            $config['allowed_types'] = '*';
            $config['overwrite'] 	= true;
            $config['file_name'] = $item.'.png';
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('filenyagan')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            $path = $config['upload_path'].'/'.$config['file_name'];
        } else {
            $path = null;
        }
        if (!empty($path)) {
            $save = [
              'kode_item' => $item,
              'nama_item' => $nama_comp,
              'photo' => $path,
              'type' => $param
            ];

            $this->M_wipp->insertPhoto($save);
        } else {
            $save = [
            'kode_item' => $item,
            'nama_item' => $nama_comp,
            'type'      => $param,
            'id'        => $this->input->post('id_photo')
          ];
            $this->M_wipp->UpdatePhoto($save);
        }

        redirect('WorkInProcessPackaging/PhotoManager/Type/'.$param);
    }

    public function getappendToJobList()
    {
        if (!$this->input->is_ajax_request()) {
            echo "Akses anda dilarang";
        } else {
            $data = $this->M_wipp->cek_job_id($this->input->post('id_job'));
            echo json_encode($data);
        }
    }

    public function SaveJobListEdit()
    {
        $date = $this->input->post('date');
        $waktu_shift = $this->input->post('waktu_shift');
        $data = $this->input->post('data');
        // echo "<pre>";
        // print_r($data);
        // die;
        $j = $this->input->post('jenis');
        $jenis = substr($j, 0, 1);
        if (!empty($date)) {
            $cek = $this->db->select('no_job')
                         ->where('date_target', $date)
                         ->where('type', $jenis)
                         ->get('wip_pnp.job_list')
                         ->result_array();

                foreach ($data as $key => $d) {
                  foreach ($cek as $key2 => $c) {
                    if ($d[1] === $c['no_job']) {
                       $cekk = $d[1];
                       break 2;
                    }else {
                      $cekk = 0;
                    }
                  }
                }

                if($cekk === 0) {
                foreach ($data as $key => $d) {
                    $n195 = $this->M_wipp->savenewRKH([
                      'date_target' => $date,
                      'waktu_satu_shift' => $waktu_shift,
                      'type' => $jenis,
                      'no_job' => $d[1],
                      'kode_item' => $d[2],
                      'nama_item' => $d[3],
                      'qty' => $d[4],
                      'usage_rate' => $d[5],
                      'scedule_start_date' => $d[6],
                      'qty_parrent' => $d[7]
                    ]);
                  }
                  echo json_encode($n195);
                }else {
                  echo json_encode($cekk);
                }

        } else {
            echo json_encode('fail');
        }
    }

    // ============================ CHECK AREA =====================================

    public function cekapi()
    {
        // $data_a = $this->M_wipp->getJob('EGBA08000000-0');
        $data_a = $this->M_wipp->getItem();
        // $data_b = $this->M_wipp->getJobAll();
        // $priority = $this->M_wipp->getPP();
        // foreach ($get_job as $key => $value) {
        //   foreach ($priority as $key2 => $value2) {
        //     if ($value['KODE_ASSY'] === $value2['kode_item']) {
        //       $tampung_priority[] = $value;
        //     }
        //   }
        // }
        echo "<pre>";
        print_r($data_a);
        echo sizeof($data_a);
        // echo "<pre>";
        // print_r($data_b);
        // echo sizeof($data_b);
        die;
    }
}
