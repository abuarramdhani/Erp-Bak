<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_DeklarasiSehat extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Api/DeklarasiSehat/M_deklarasi');
        $this->load->model('M_index');
        date_default_timezone_set('Asia/Jakarta');
    }

    function loginDS()
    {
        $ret['error'] = 1;
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password_md5 = md5($password);
        $log = $this->M_index->login($username, $password_md5);

        if ($log) {
            $ret['error'] = 0;
            $ret['data'] = $this->M_deklarasi->getDetailPKJ($username);
        }
        echo json_encode($ret);
    }

    function DetailPKJ()
    {
        $ret['error'] = 1;
        $noind = $this->input->get('noind');
        $data = $this->M_deklarasi->getDetailPKJ($noind);
        if (!empty($data)) {
            $ret['error'] = 0;
            $ret['data'] = $data;
        }

        echo json_encode($ret);
    }

    function insertDeklarasi()
    {
        $aspek_1_a = $this->input->post('aspek_1_a');
        $ret['error'] = 1;
        if (empty($aspek_1_a)) {
            echo json_encode($ret);
            return;
        }
        $arr = array(
            'noind' => $this->input->post('noind'),
            'waktu_input' => date('Y-m-d H:i:s'),
            'aspek_1_a' => $this->input->post('aspek_1_a'),
            'aspek_1_b' => $this->input->post('aspek_1_b'),
            'aspek_2_a' => $this->input->post('aspek_2_a'),
            'aspek_2_b' => $this->input->post('aspek_2_b'),
            'aspek_2_c' => $this->input->post('aspek_2_c'),
            'aspek_2_d' => $this->input->post('aspek_2_d'),
            'aspek_2_e' => $this->input->post('aspek_2_e'),
            'aspek_2_f' => $this->input->post('aspek_2_f'),
            'aspek_2_g' => $this->input->post('aspek_2_g'),
            'aspek_2_h' => $this->input->post('aspek_2_h'),
            'aspek_2_i' => $this->input->post('aspek_2_i'),
            'aspek_3_a' => $this->input->post('aspek_3_a'),
        );

        if ($this->M_deklarasi->insDeklarasi($arr) > 0)
            $ret['error'] = 0;

        echo json_encode($ret);
    }

    function ReadDeklarasibyNoind()
    {
        $noind = $this->input->get('noind');
        $ret['data'] = $this->M_deklarasi->getDeklaraibyNoind($noind);

        echo json_encode($ret);
    }

    function ListPernyataan()
    {
        $ret['data'] = $this->M_deklarasi->getAllPernyataan();

        echo json_encode($ret);
    }

    function ReadDeklarasibyID()
    {
        $id = $this->input->get('id');
        $ret['error'] = 1;
        if (!is_numeric($id)) {
            echo json_encode($ret);
            return;
        }
        $data = $this->M_deklarasi->getDeklaraibyID($id);
        $ret['error'] = 0;
        $ret['data'] = $data;

        echo json_encode($ret);
    }

    function UpdateDeklarasi()
    {
        $id = $this->input->post('id');
        $ret['error'] = 1;
        if (!isset($_POST['aspek_1_a']) || empty($id) || !is_numeric($id)) {
            echo json_encode($ret);
            return;
        }
        $arr = array(
            'noind' => $this->input->post('noind'),
            'waktu_input' => date('Y-m-d H:i:s'),
            'aspek_1_a' => $this->input->post('aspek_1_a'),
            'aspek_1_b' => $this->input->post('aspek_1_b'),
            'aspek_2_a' => $this->input->post('aspek_2_a'),
            'aspek_2_b' => $this->input->post('aspek_2_b'),
            'aspek_2_c' => $this->input->post('aspek_2_c'),
            'aspek_2_d' => $this->input->post('aspek_2_d'),
            'aspek_2_e' => $this->input->post('aspek_2_e'),
            'aspek_2_f' => $this->input->post('aspek_2_f'),
            'aspek_2_g' => $this->input->post('aspek_2_g'),
            'aspek_2_h' => $this->input->post('aspek_2_h'),
            'aspek_2_i' => $this->input->post('aspek_2_i'),
            'aspek_3_a' => $this->input->post('aspek_3_a'),
        );

        if ($this->M_deklarasi->updDeklarasi($arr, $id) > 0)
            $ret['error'] = 0;

        echo json_encode($ret);
    }

    function DeleteDeklarasi()
    {
        $id = $this->input->post('id');
        $ret['error'] = 1;
        if (empty($id) || !is_numeric($id)) {
            echo json_encode($ret);
            return;
        }

        $del = $this->M_deklarasi->delDeklarasi($id);
        if ($del)
            $ret['error'] = 0;

        echo json_encode($ret);
    }
}
