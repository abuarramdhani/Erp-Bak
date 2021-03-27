<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

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
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('BarangBekas/M_master');
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

        $data['Menu'] = 'Dashboard Pengiriman Barang Bekas V.1.3';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);

        $admin = ['a'=>'B0724', 'b'=>'T0012', 'c'=>'B0713'];
        if (empty(array_search($this->session->user, $admin))) {
          unset($data['UserMenu'][2]);
        }

        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BarangBekas/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function pbbs($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Pengiriman Barang Bekas V.1.3';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);

      $admin = ['a'=>'B0724', 'b'=>'T0012', 'c'=>'B0713'];
      if (empty(array_search($this->session->user, $admin))) {
        unset($data['UserMenu'][2]);
      }

      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      // $this->form_validation->set_rules('seksi_n_cc', 'Seksi & Cost Center', 'required');

      // if ($this->form_validation->run() === FALSE) {

          $data['seksi'] = $this->M_master->getSeksi();
          $data['io'] = $this->M_master->get_io();

          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('BarangBekas/V_PBBS', $data);
          $this->load->view('V_Footer', $data);

      // }else {
      //
      // }

    }

    public function SubInv($value='')
    {
      $check_io = $this->M_master->checkSubInv($this->input->post('io'));
      // echo "<pre>";print_r($check_io);die;
      if (!empty($check_io[0]['OPEN_FLAG'])) {
        if ($check_io[0]['OPEN_FLAG'] === 'Y') {
          $data = $this->M_master->SubInv($this->input->post('io'));
          $tampung[] = '<option value="">Select..</option>';
          foreach ($data as $key => $value) {
            $tampung[] = '<option value="'.$value['SUBINV'].' - '.$value['ORGANIZATION_ID'].'">'.$value['SUBINV'].' - '.$value['DESCRIPTION'].'</option>';
          }
          if (empty($tampung)) $tampung = [];
          echo json_encode(implode('', $tampung));
        }else {
          echo json_encode(0);
        }
      }else {
        echo json_encode(0);
      }


    }

    public function submit_pbbs($value='')
    {
      $res = $this->M_master->insertPBBS($this->input->post());
      if (!empty($res)) {
        echo $res;
      }else {
        echo 11;
      }
    }

    public function item()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_master->item($term, $this->input->post('subinv'), $this->input->post('locator'), $this->input->post('org_id')));
    }

    public function item_pbbns($value='')
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_master->item_pbbns($term));
    }

    public function locator($value='')
    {
      $data = $this->M_master->locator($this->input->post('subinv'), $this->input->post('org_id'));
      foreach ($data as $key => $value) {
        if (!empty($value['LOCATOR'])) {
          $s[] = '<option value="'.$value['INVENTORY_LOCATION_ID'].'">'.$value['LOCATOR'].'</option>';
        }
      }
      if (!empty($s)) {
        echo json_encode(implode($s, ''));
      }else {
        echo json_encode(0);
      }
    }

    public function onhand($value='')
    {
      echo json_encode($this->M_master->onhand($this->input->post('org_id'), $this->input->post('inv_item_id'), $this->input->post('subinv'), $this->input->post('locator_id')));
    }

    public function pbbns($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Pengiriman Barang Bekas V.1.3';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);

      $admin = ['a'=>'B0724', 'b'=>'T0012', 'c'=>'B0713'];
      if (empty(array_search($this->session->user, $admin))) {
        unset($data['UserMenu'][2]);
      }

      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      // $this->form_validation->set_rules('seksi_n_cc', 'Seksi & Cost Center', 'required');

      // if ($this->form_validation->run() === FALSE) {

          $data['seksi'] = $this->M_master->getSeksi();

          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('BarangBekas/V_PBBNS', $data);
          $this->load->view('V_Footer', $data);

      // }else {
      //   $res = $this->M_master->insertPBBNS($this->input->post());
      //   if (!empty($res)) {
      //     $this->session->set_flashdata('message_pbbns', '<div class="alert alert-success alert-dismissible" role="alert">
      //                                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      //                                                         <span aria-hidden="true">
      //                                                           <i class="fa fa-close"></i>
      //                                                         </span>
      //                                                       </button>
      //                                                       <span>Data berhasil disimpan dengan no dokumen <strong>'.$res.' </strong></span>
      //                                                     </div>');
      //
      //     echo '<script type="text/javascript">
      //           function openWindows(){
      //               window.open("'.base_url('BarangBekas/pbbns/pdf/'.$res).'");
      //               window.location.replace("'.base_url('BarangBekas/pbbns').'");
      //           }
      //           openWindows();
      //         </script>';
      //
      //   }
      // }

    }

    public function submit_pbbns($value='')
    {
      $res = $this->M_master->insertPBBNS($this->input->post());
      if (!empty($res)) {
        echo $res;
      }else {
        echo 11;
      }
    }

    public function transact($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Pengiriman Barang Bekas V.1.3';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);

      $admin = ['a'=>'B0724', 'b'=>'T0012', 'c'=>'B0713'];
      if (empty(array_search($this->session->user, $admin))) {
        unset($data['UserMenu'][2]);
      }

      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      // $this->form_validation->set_rules('seksi_n_cc', 'Seksi & Cost Center', 'required');

      // if ($this->form_validation->run() === FALSE) {
          $data['item'] = $this->M_master->getItemTujuan();
          // $data['document_number'] = $this->M_master->no_document();

          $this->load->view('V_Header', $data);
          $this->load->view('V_Sidemenu', $data);
          $this->load->view('BarangBekas/V_Transact', $data);
          $this->load->view('V_Footer', $data);

      // }else {
      //   echo "<pre>";
      //   print_r($_POST);
      //   die;
      // }

    }

    public function geDocBy($value='')
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_master->geDocBy($term));
    }

    public function detail_document()
    {
      $doc_num = $this->input->post('doc_num');
      $data['get'] = $this->M_master->detail_document($doc_num);
      if (!empty($data['get'])) {
        $this->load->view('BarangBekas/ajax/V_Item_Table', $data);
      }else {
        echo "item tidak ada di mtl_system_items_b (102)";
      }
    }

    public function transact_beneran($value='')
    {
      $doc_num = $this->input->post('doc_num');
      $cek = $this->M_master->cek_apakah_sudah_trasact($doc_num);

      if (empty($cek['DOCUMENT_NUMBER'])) {
        $imir = $this->M_master->insert_misc_issue_receipt($this->input->post());
        if ($imir) {
          $res = $this->M_master->pbb_transact($doc_num);
        }else {
          $res = 86;
        }
      }else {
        $res = 76;
      }

      echo json_encode($res);
    }

    public function ambilItem()
    {
      echo json_encode($this->M_master->ambilItem($this->input->post('id')));
    }

    public function updateBeratTimbang($value='')
    {
      echo json_encode($this->M_master->updateBeratTimbang($this->input->post()));
    }

    public function pdf($no_doc)
    {
      $data_ = $this->M_master->detail_document($no_doc);
      $data['get'] = $data_;
      if (!empty($data['get'])) {
          ob_start();
          $this->load->library('ciqrcode');
          if (!is_dir('./assets/img/PBIQRCode')) {
              mkdir('./assets/img/PBIQRCode', 0777, true);
              chmod('./assets/img/PBIQRCode', 0777);
          }
          // ------ GENERATE QRCODE ------
          $params['data']		= $data_[0]['DOCUMENT_NUMBER'];
          $params['level']	= 'H';
          $params['size']		= 5;
          $params['black']	= array(255,255,255);
          $params['white']	= array(0,0,0);
          $params['savename'] = './assets/img/PBIQRCode/'.($data_[0]['DOCUMENT_NUMBER']).'.png';
          $this->ciqrcode->generate($params);

          // ====================== do something =========================
          $this->load->library('Pdf');

          $pdf 		= $this->pdf->load();
          $pdf 		= new mPDF('utf-8', array(210, 148), 0, 'calibri', 3, 3, 3, 0, 0, 0);

          $doc = 'DOC_'.$data_[0]['TYPE_DOCUMENT'].'_'.date('d-m-Y').'';
          $filename 	= $doc.'.pdf';
          $isi 				= $this->load->view('BarangBekas/pdf/V_pdf', $data, true);
          ob_end_clean();
          $pdf->WriteHTML($isi);
          $pdf->Output($filename, 'I');
      } else {
          echo json_encode(array(
            'success' => false,
            'message' => 'Nomor Dokumen '.$no_doc.' Tidak Ditemukan'
          ));
      }

      if (!unlink('./assets/img/PBIQRCode/'.$data_[0]['DOCUMENT_NUMBER'].'.png')) {
          echo("Error deleting");
      }

    }








// ++++++++++++++++++++++++++++++++ kerrr ++++++++++++++++++++++++++++++++//

    public function updateSerial($value='')
    {
      echo json_encode($this->M_master->updateSerial($this->input->post()));
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






}
