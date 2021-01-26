<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('CetakKIBMotorBensin/M_master');
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

        $data['Menu'] = 'Dashboard Cetak KIB Motor Bensin V.1.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CetakKIBMotorBensin/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function Cetak()
    {
        $this->checkSession();
        $user_id             = $this->session->userid;
        $data['username']    = $this->session->user;
        $passwordArr         = $this->db->get_where('sys.sys_user', ['user_id' => $user_id])->row_array();
        $data['password']    = $passwordArr['user_password'];

        $data['Menu'] = 'Cetak KIB Motor Bensin';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $data['get_type'] = $this->M_master->getType();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CetakKIBMotorBensin/V_Cetak', $data);
        $this->load->view('V_Footer', $data);
    }

    public function getFilterByDate($value='')
    {
      $data['range_date'] = $this->input->post('range_date');
      $data['get_po'] = $this->M_master->getPO($data['range_date']);
      if (empty($data['range_date'])) {
        echo 0;
      }else {
        if (!empty($data['get_po'])) {
          $this->load->view('CetakKIBMotorBensin/ajax/V_filter', $data);
        }else {
          echo 10;
        }
      }
    }

    public function getTableEngine()
    {
      $data['no_po'] = $this->input->post('no_po');
      $data['surat_jalan'] = $this->input->post('surat_jalan');
      $no_lppb = $this->M_master->getNoLppb($data['no_po'], $data['surat_jalan']);
      $data['no_lppb'] = !empty($no_lppb['NO_LPPB']) ? $no_lppb['NO_LPPB'] : '-';
      $data['get_engine'] = $this->M_master->getEngine($data['no_po'], $data['surat_jalan']);
      if (!empty($data['get_engine'])) {
        $this->load->view('CetakKIBMotorBensin/ajax/V_table_engine', $data);
      }else {
        echo 0;
      }
    }

    public function getSerial($value='')
    {
      $data['no_po'] = $this->input->post('no_po');
      $data['surat_jalan'] = $this->input->post('surat_jalan');
      $data['segment1'] = $this->input->post('segment1');
      $data['receipt_date'] = $this->input->post('receipt_date');

      $data['get_serial'] = $this->M_master->getSerial($data['no_po'], $data['surat_jalan'], $data['segment1']);
      if (!empty($data['get_serial'])) {
        $this->load->view('CetakKIBMotorBensin/ajax/V_serial', $data);
      }else {
        echo 0;
      }
    }

    // public function getMaster($value='')
    // {
    //   $post =  $this->input->post();
    //   foreach ($post['columns'] as $val) {
    //       $post['search'][$val['data']]['value'] = $val['search']['value'];
    //   }
    //
    //   $countall = $this->M_master->countAll($post)['count'];
    //   $countfilter = $this->M_master->countFiltered($post)['count'];
    //
    //   $post['pagination']['from'] = $post['start'] + 1;
    //   $post['pagination']['to'] = $post['start'] + $post['length'];
    //
    //   $protodata = $this->M_master->selectMaster($post);
    //
    //   $data = [];
    //   foreach ($protodata as $row) {
    //       $sub_array   = [];
    //       $sub_array[] = '<center>'.$row['PAGINATION'].'</center>';
    //       $sub_array[] = $row['PALET'];
    //       $sub_array[] = $row['KODE_SEBELUM'];
    //       $sub_array[] = $row['TYPE_SEBELUM'];
    //       $sub_array[] = $row['KODE_SETELAH'];
    //       $sub_array[] = $row['TYPE_SETELAH'];
    //       $sub_array[] = $row['PRODUK'];
    //       $sub_array[] = $row['WARNA_KIB'];
    //       $sub_array[] = $row['TYPE'];
    //       $sub_array[] = $row['SERIAL'];
    //       // $sub_array[] = '-';
    //       // $sub_array[] = '<a class="btn btn-success btn-sm" target="_blank" href="'.base_url('CetakKIBMotorBensin/CKMB/pdf/'.$row['SERIAL']).'" title="Export"><i class="fa fa-file-pdf-o"></i> Cetak</a>';
    //
    //       $data[] = $sub_array;
    //   }
    //
    //   $output = [
    //       'draw' => $post['draw'],
    //       'recordsTotal' => $countall,
    //       'recordsFiltered' => $countfilter,
    //       'data' => $data,
    //   ];
    //
    //   die($this->output
    //           ->set_status_header(200)
    //           ->set_content_type('application/json')
    //           ->set_output(json_encode($output))
    //           ->_display());
    // }

    public function pdf($no_po, $surat_jalan, $segment1, $receipt_date)
    {
      // $range =  $range1.' - '.$range2;
      $get = $this->M_master->getItem($no_po, $surat_jalan, $segment1, $receipt_date);
      $data['get'] = $get;

      // if (!empty($range1) && !empty($tipe)) {
        ob_start();
          $this->load->library('ciqrcode');
          if (!is_dir('./assets/img/PBIQRCode')) {
              mkdir('./assets/img/PBIQRCode', 0777, true);
              chmod('./assets/img/PBIQRCode', 0777);
          }
          foreach ($get as $key => $value) {
            // ------ GENERATE QRCODE ------
            $params['data']		= $value['SERIAL_NUMBER'];
            $params['level']	= 'H';
            $params['size']		= 5;
            $params['black']	= array(255,255,255);
            $params['white']	= array(0,0,0);
            $params['savename'] = './assets/img/PBIQRCode/'.($value['SERIAL_NUMBER']).'.png';
            $this->ciqrcode->generate($params);
          }
          // ====================== do something =========================
          $this->load->library('Pdf');

          $pdf 		= $this->pdf->load();
          $pdf 		= new mPDF('utf-8', array(210 , 267), 0, 'calibri', 3, 3, 3, 0, 0, 0);

          $doc = 'Cetak-CKMB-'.$range1.'_'.$range2;
          $filename 	= $doc.'.pdf';
          $isi 				= $this->load->view('CetakKIBMotorBensin/pdf/V_pdf', $data, true);
          ob_end_clean() ;
          $pdf->WriteHTML($isi);
          $pdf->Output($filename, 'I');
      // } else {
      //     echo json_encode(array(
      //       'success' => false,
      //       'message' => 'Range date Or Type Engine Can\'t empty'
      //     ));
      // }

      foreach ($get as $key => $value) {
        if (!unlink('./assets/img/PBIQRCode/'.$value['SERIAL'].'.png')) {
            echo("Error deleting");
        }
      }

    }

    public function Checklist($no_po, $surat_jalan, $segment1, $receipt_date)
    {
      // $range =  $range1.' - '.$range2;
      $get_ = $this->M_master->getItem($no_po, $surat_jalan, $segment1, $receipt_date);
      foreach ($get_ as $key => $value) {
        $get_[$key]['KODE_1'] = substr($value['SERIAL_NUMBER'], 0, 3);
        $get_[$key]['KODE_2'] = substr($value['SERIAL_NUMBER'], 3);
      }
      // for ($i=1; $i <= 220; $i++) {
      //   $get_[$i]['TYPE'] = 'GCMX';
      //   $get_[$i]['KODE_1'] = '335';
      //   $get_[$i]['KODE_2'] = '6511';
      //   $get_[$i]['PALET'] = ceil($i/30);
      // }

      //suda dinamis
      $this->load->library('Pdf');
      foreach ($get_ as $key => $value) $count_palet[$value['PALET']] = $value['PALET'];
      foreach ($get_ as $key => $value) $palet[$value['PALET']][] = $value;
      $data['get'] = $palet;
      $data['count'] = $count_palet;
      // echo "<pre>";print_r($count_palet);die;

      $pdf 		= $this->pdf->load();
      $pdf 		= new mPDF('utf-8', array(210 , 267), 0, 'calibri', 3, 3, 15, 0, 0, 0);
      ob_end_clean() ;

      $doc = 'Cetak-CKMB-'.$range1.'_'.$range2;
      $filename 	= $doc.'.pdf';
      if (!empty($data['get'])) {
        $isi 	= $this->load->view('CetakKIBMotorBensin/pdf/V_checklist', $data, true);
      }else {
        $isi 	= 'Data is empty';
      }
      $type_ = explode(' ',$get_[0]['TYPE_SEBELUM']);
      $type_title = $type_[1].' '.$type_[2].' '.$type_[3].' '.$get_[0]['TYPE'];
      $pdf->SetHTMLHeader("<h3 style='padding-top:20px;text-align:center;'>DAFTAR NOMOR MOTOR BENSIN (HONDA) <span style='olor:#016f87'>".$type_title." </span></h3>");
      $pdf->WriteHTML($isi);
      $pdf->Output($filename, 'I');
    }

}
