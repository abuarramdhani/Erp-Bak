<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Simulasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('parser');


        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MuatanTruk/M_simulasi');

        // $this->checkSession();
    }


    function random_color_part()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function index()
    {
        $kendaraan = $this->M_simulasi->getKendaraan(); //dipasang di Thead table

        for ($h = 0; $h < sizeof($kendaraan); $h++) {
            // $kendaraan[$h]['WARNA'] =  $this->random_color_part();
            if ($kendaraan[$h]['KENDARAAN'] == 'Engkel') {
                $kendaraan[$h]['WARNA'] = '#ca8a8b';
            } else  if ($kendaraan[$h]['KENDARAAN'] == 'Rhino') {
                $kendaraan[$h]['WARNA'] = '#9fe6a0';
            } else  if ($kendaraan[$h]['KENDARAAN'] == 'Fuso6-7M') {
                $kendaraan[$h]['WARNA'] = '#7b113a';
            } else  if ($kendaraan[$h]['KENDARAAN'] == 'Tronton10M') {
                $kendaraan[$h]['WARNA'] = '#a6d6d6';
            } else  if ($kendaraan[$h]['KENDARAAN'] == 'Fuso8M/Tronton9M') {
                $kendaraan[$h]['WARNA'] = '#3d84b8';
            } else  if ($kendaraan[$h]['KENDARAAN'] == 'Container20') {
                $kendaraan[$h]['WARNA'] = '#00adb5';
            } else  if ($kendaraan[$h]['KENDARAAN'] == 'Container40') {
                $kendaraan[$h]['WARNA'] = '#f3bda1';
            }
        }

        $produknondiesel = $this->M_simulasi->getProduk(); //buat foreach ambil data
        $produkdiesel = $this->M_simulasi->getProduk2(); //buat foreach ambil data
        $produk = array();
        for ($p = 0; $p < sizeof($produknondiesel); $p++) {
            $a = array(
                'jns' => 'Traktor',
                'produk' => $produknondiesel[$p]['MUATAN']
            );
            array_push($produk, $a);
        };
        for ($p = 0; $p < sizeof($produkdiesel); $p++) {
            $a = array(
                'jns' => 'Diesel',
                'produk' => $produkdiesel[$p]['MUATAN']
            );
            array_push($produk, $a);
        };

        // echo "<pre>";
        // print_r($kendaraan);
        // exit();

        $coba = array();
        for ($i = 0; $i < sizeof($produk); $i++) {
            for ($j = 0; $j < sizeof($kendaraan); $j++) {
                $dataperkendaraan[$j] = $this->M_simulasi->getDatabyProduk($produk[$i]['produk'], $kendaraan[$j]['KENDARAAN']);
                if (count($dataperkendaraan[$j]) != 3) {
                    for ($r = 1; $r < 3; $r++) {
                        $dataperkendaraan[$j][$r] = array(
                            'MUATAN' => $produk[$i]['produk'],
                            'JENIS_MUATAN' => 'disable',
                            'KENDARAAN' => $kendaraan[$j]['KENDARAAN'],
                            'PROSENTASE' => null,
                        );
                    }
                }
            }

            $array = array(
                'jenis' => $produk[$i]['jns'],
                'item' => $produk[$i]['produk'],
                'kendaraan' => $dataperkendaraan,
            );
            array_push($coba, $array);
        }




        // echo "<pre>";
        // print_r($coba);
        // exit();

        $data['kendaraan'] = $kendaraan;
        $data['DataSimulasi'] = $coba;


        $content['BaseUrl'] = base_url();

        $data['BaseUrl']   = base_url();
        $data['Header']    = 'Simulasi';
        $data['Title']     = 'Simulasi Muatan Truk';
        $data['Link']      = 'MuatanTruk/Simulasi';
        $data['Content']   = $this->parser->parse('MuatanTruk/V_Simulasi', $data, TRUE);
        $data['Copyright'] = '<strong>Copyright &copy; Quick 2015-' . date('Y') . '.</strong> All rights reserved.';
        $data['JSVersion'] = filemtime('assets/js/customSMTR.js');

        $this->parser->parse('MuatanTruk/V_Template', $data);
    }
}
