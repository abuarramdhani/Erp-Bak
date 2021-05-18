<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Import extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        $this->load->library('Excel');
        date_default_timezone_set('Asia/Jakarta');
        // $this->load->model('CetakKIBMotorBensin/M_master');
        $this->load->model('SystemAdministration/MainMenu/M_user');

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
            redirect('');
        }
    }

    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard Laporan Produksi Harian V.0.1';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanProduksiHarian/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function import($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard Laporan Produksi Harian V.0.1';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('LaporanProduksiHarian/V_Import', $data);
      $this->load->view('V_Footer', $data);
    }

    public function submit_import($value='')
    {
      $file_data = $_FILES['excel_file']['tmp_name'];
      $load = PHPExcel_IOFactory::load($file_data);
      $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
      $jml = count($sheets) + 1;
      echo "<pre>";print_r($sheets);die;
      // for ($i=2; $i < $jml; $i++) {
      //     $arrayData[] = array(
      //              'product_component_code'	   => $sheets[$i]['B'],
      //              'component_code'					   => $sheets[$i]['C'],
      //              'component_name'					   => $sheets[$i]['D'],
      //              'revision'									 => $sheets[$i]['E'],
      //              'revision_date'						 => $sheets[$i]['F'],
      //              'material_type' 					   => $sheets[$i]['G'],
      //              'weight'									   => $sheets[$i]['H'],
      //              'status'									   => $sheets[$i]['I'],
      //              'information'							 => $sheets[$i]['J'],
      //              'qty' 											 => $sheets[$i]['K'],
      //              'component_memo_destination'=> $sheets[$i]['L'],
      //              'product_id'								 => $sheets[$i]['M'],
      //              'same_product'							 => $sheets[$i]['N'],
      //              'jenis'										 => 'Product'
      //              );
      //     $this->M_report->setProductImport($arrayData[$i-2]);
      //     $code = $sheets[$i]['C'];
      //     $cekproduk = $this->M_report->checkproductimport($code);
      //
      //     if ($cekproduk>0) {
      //         $this->M_report->updateproductimport($arrayData[$i-2], $code);
      //     } else {
      //         $this->M_report->setProductImport($arrayData[$i-2]);
      //     }
      // }
      // redirect('ProductComponent/Master');
    }

    public function getmon($value='')
    {
      $this->load->view('LaporanProduksiHarian/ajax/V_mon_rko');
    }

}
