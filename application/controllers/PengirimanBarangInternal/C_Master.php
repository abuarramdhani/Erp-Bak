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
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('PengirimanBarangInternal/M_pbi');

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
      $this->load->view('PengirimanBarangInternal/V_Index');
      $this->load->view('V_Footer', $data);
    }

    // ============================INPUT AREA====================================

    public function seksi_tujuan()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_pbi->getSeksi($term));
    }

    public function listCode()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_pbi->listCode($term));
    }

    public function employee()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_pbi->employee($term));
    }

    public function autofill()
    {
      $term = strtoupper($this->input->post('code'));
      echo json_encode($this->M_pbi->autofill($term));
    }

    public function cekComponent()
    {
      $term = strtoupper($this->input->post('code'));
      echo json_encode($this->M_pbi->cekComponent($term));
    }

    public function getSeksiku()
    {
      $no_ind = $this->session->user;
      $data = $this->M_pbi->getSeksiku($no_ind);
      echo json_encode($data);
    }

    public function getSeksimu()
    {
      $no_ind = $this->input->post('code');
      $data = $this->M_pbi->getSeksiku($no_ind);
      echo json_encode($data);
    }

    public function input()
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
      $this->load->view('PengirimanBarangInternal/V_input');
      $this->load->view('V_Footer', $data);
    }

    public function Save()
    {
      //==========generate document_number=====
      $time 				= date('ymd');
      $lastNumber   = $this->M_pbi->lastDocumentNumber('FPB'.$time);
      if (empty($lastNumber[0]['DOC_NUMBER'])) {
          $newNumber = 'FPB'.$time.'001';
      } else {
          $newNumber = $lastNumber[0]['DOC_NUMBER']+1;
          if (strlen($newNumber) < 3) {
              $newNumber = str_pad($newNumber, 3, "00", STR_PAD_LEFT);
          }
          $newNumber = 'FPB'.$time.$newNumber;
      }
      //==========end generate========

      // ======== line data ===========
      $seksi_pengirim = $this->input->post('seksi_pengirim');
      $seksi_tujuan   = $this->input->post('seksi_tujuan'); // SADARNYA BLAKANGAN ~_-
      $user_tujuan    = $this->input->post('employee_seksi_tujuan');
      $tujuan         = $this->input->post('tujuan');
      // ======== line data ===========
      $line           = $this->input->post('line_number');
      $item_code      = $this->input->post('item_code');
      $description    = $this->input->post('description');
      $quantity       = $this->input->post('quantity');
      $uom            = $this->input->post('uom');
      $item_type      = $this->input->post('item_type');

      foreach ($line as $key => $l) {
        $data = [
          'DOC_NUMBER'    => $newNumber,
          'SEKSI_KIRIM'   => $seksi_pengirim,
          'SEKSI_TUJUAN'  => $seksi_tujuan,
          'TUJUAN'        => $tujuan,
          'USER_TUJUAN'   => $user_tujuan,
          'LINE_NUM'      => $line[$key],
          'ITEM_CODE'     => $item_code[$key],
          'ITEM_TYPE'     => $item_type[$key],
          'DESCRIPTION'   => $description[$key],
          'QUANTITY'      => $quantity[$key],
          'UOM'           => $uom[$key],
          'STATUS'        => 0,
          'CREATED_BY'    => $this->session->user
        ];
        $this->M_pbi->insert($data);
      }
      echo '<script type="text/javascript">
              function openWindows(){
                  window.location.replace("'.base_url('PengirimanBarangInternal/Input').'");
                  window.open("'.base_url('PengirimanBarangInternal/Cetak/'.$newNumber).'");
              }
              openWindows();
            </script>';
    }

// =========================MONITORING AREA====================================

    public function monitoring()
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $data['get'] = $this->M_pbi->GetMasterD();
      foreach ($data['get'] as $key => $g) {
        $seksi = $this->M_pbi->getSeksiku($g['USER_TUJUAN']);
        $data['seksi_tujuan'][] = $seksi->seksi;
      }

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('PengirimanBarangInternal/V_monitoring');
      $this->load->view('V_Footer', $data);
    }

    public function Detail()
    {
      $term = strtoupper($this->input->post('nodoc'));
      $data['get'] = $this->M_pbi->Detail($term);

      $this->load->view('PengirimanBarangInternal/V_Detail', $data);
    }
// ========================= END MONITORING AREA====================================

// =========================== CETAKAN AREA ====================================

public function Cetak($doc)
{
    $data['get'] = $this->M_pbi->Cetak($doc);
    $data['seksi_tujuan'] = $this->M_pbi->getSeksiku($data['get'][0]['USER_TUJUAN']);
    $data['nama_pengirim'] = $this->M_pbi->employee($data['get'][0]['CREATED_BY']);
    $data['user_tujuan'] = $this->M_pbi->employee($data['get'][0]['USER_TUJUAN']);
    $jb = $this->M_pbi->jenisBarang($doc);
    foreach ($jb as $key => $j) {
      $jx[] = $j['ITEM_TYPE'];
    }
    $data['jenisbarang'] = implode(' / ', $jx);

    if (!empty($doc)) {
        // ====================== do something =========================
        $this->load->library('Pdf');

        $pdf 		= $this->pdf->load();
        $this->load->library('ciqrcode');
        $pdf 		= new mPDF('utf-8', array(210 , 148), 0, '', 3, 3, 3, 0, 0, 3);

        // ------ GENERATE QRCODE ------
        if (!is_dir('./assets/img/PBIQRCode')) {
            mkdir('./assets/img/PBIQRCode', 0777, true);
            chmod('./assets/img/PBIQRCode', 0777);
        }

        $params['data']		= $data['get'][0]['DOC_NUMBER'];
        $params['level']	= 'H';
        $params['size']		= 5;
        $params['black']	= array(255,255,255);
        $params['white']	= array(0,0,0);
        $params['savename'] = './assets/img/PBIQRCode/'.$data['get'][0]['DOC_NUMBER'].'.png';
        $this->ciqrcode->generate($params);

        ob_end_clean() ;
        $filename 	= 'Cetak_FPB_'.date('d-M-Y').'.pdf';
        $isi 				= $this->load->view('PengirimanBarangInternal/pdf/V_Pdf', $data, true);
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

// =========================== END CETAKAN AREA ====================================


// ============================ CHECK AREA =====================================

  public function cekapi()
  {
    $term = 'CABANG';
    $data = $this->M_pbi->GetMasterD();
    echo "<pre>";
    print_r($data);
    die;
  }

}
