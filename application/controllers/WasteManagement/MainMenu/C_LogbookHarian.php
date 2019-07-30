<?php
Defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

/**
 *
 */
class C_LogbookHarian extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->library('form_validation');
    $this->load->library('encrypt');

    $this->load->library('session');
    $this->load->model('M_Index');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('WasteManagement/MainMenu/M_logbookharian');

    if ($this->session->userdata('logged_in')!=true) {
      $this->load->helper('url');
      $this->session->set_userdata('last_page',current_url());
      $this->session->set_userdata('Responsbility','some_value');
    }
  }

  public function getSession(){
    if ($this->session->is_logged) {

    }else{
      redirect('');
    }
  }

  public function index(){
    $this->getSession();

    $user_id = $this->session->userid;

    $data['Title'] = 'Logbook Harian';
    $data['Menu'] = 'Logbook Harian Limbah';
    $data['SubMenuOne'] = 'Logbook Harian Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['log'] = $this->M_logbookharian->getLimbahJenis();
    $data['lokasi'] = $this->M_logbookharian->getLokasi();
    $data['user_name'] = $this->M_logbookharian->getUser();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LogBook/V_index',$data);
		$this->load->view('V_Footer',$data);
  }

  public function Export(){
    $export       = $_POST['export'];
    $periode1     = $_POST['txtPeriodeLog1'];
    $periode2     = $_POST['txtPeriodeLog2'];
    $jenislimbah1 = $_POST['slcJenisLimbahLog1'];
    $jenislimbah2 = $_POST['slcJenisLimbahLog2'];
    $lokasi       = $_POST['slcLokasiKerjaLog'];
    $username     = $_POST['user_name'];

//Untuk Multiple Select Jenis Limbah//
    $jenislimbahNew = '';
    if (isset($jenislimbah1) && !empty($jenislimbah1)) {
        if ($jenislimbah1 == "") {
          $jenislimbahNew = "'".$jenislimbah1['0']."'";
        }else {
          $jenislimbahNew = '';
          for ($i=0; $i < count($jenislimbah1) ; $i++) {
              $jenislimbahNew .= "'".$jenislimbah1[$i]."',";
          }
        }
      }
      $jenislimbahNew = rtrim($jenislimbahNew, ",");

    $jenislimbahNew2 = '';
    if (isset($jenislimbah2) && !empty($jenislimbah2)) {
        if ($jenislimbah2 == "") {
          $jenislimbahNew2 = "'".$jenislimbah2['0']."'";
        }else {
          $jenislimbahNew2 = '';
          for ($i=0; $i < count($jenislimbah2) ; $i++) {
              $jenislimbahNew2 .= "'".$jenislimbah2[$i]."',";
          }
        }
      }
      $jenislimbahNew2 = rtrim($jenislimbahNew2, ",");

//Deklarasi Periode/ Tanggal jika Kosong//
    if(!empty($periode1)){
      $periode1 = explode("-",$periode1);
      $tanggalawal1 = str_replace('/','-',$periode1['0']);
      $tanggalakhir1 = str_replace('/','-',$periode1['1']);
      $tanggalawal1 = date('Y-m-d', strtotime($tanggalawal1));
      $tanggalakhir1 = date('Y-m-d', strtotime($tanggalakhir1));
    }else{
      $tanggalawal1 = "";
      $tanggalakhir1 = "";
    }
    if(!empty($periode2)){
      $periode2 = explode("-",$periode2);
      $tanggalawal2 = str_replace('/','-',$periode2['0']);
      $tanggalakhir2 = str_replace('/','-',$periode2['1']);
      $tanggalawal2 = date('Y-m-d', strtotime($tanggalawal2));
      $tanggalakhir2 = date('Y-m-d', strtotime($tanggalakhir2));
    }else{
      $tanggalawal2 = "" ;
      $tanggalakhir2 = "";
    }

//Untuk Deklarasi Periode Masuk//
    if (empty($periode1)) {
      $allBulanIn = 'All';
    }else {
      $listBulan1 = array();
      $tgl1 = date("Ym",strtotime($tanggalawal1));
        while($tgl1 <= date("Ym", strtotime($tanggalakhir1))) {
          $hasil1 = substr($tgl1, 4);
          array_push($listBulan1, $hasil1);
            if (substr($tgl1, 4, 2) == "12")
              $tgl1 = (date("Y", strtotime($tgl1."01")) +1). "01";
            else
              $tgl1++;
        }

        $listBulanIn = array();
        foreach ($listBulan1 as $i => $bulan) {
          if($bulan == '01') {
            $bulan = 'Januari';
          }elseif($bulan == '02') {
            $bulan = 'Februari';
          }elseif($bulan == '03') {
            $bulan = 'Maret';
          }elseif($bulan == '04') {
            $bulan = 'April';
          }elseif($bulan == '05') {
            $bulan = 'Mei';
          }elseif($bulan == '06') {
            $bulan = 'Juni';
          }elseif($bulan == '07') {
            $bulan = 'Juli';
          }elseif($bulan == '08') {
            $bulan = 'Agustus';
          }elseif($bulan == '09') {
            $bulan = 'September';
          }elseif($bulan == '10') {
            $bulan = 'Oktober';
          }elseif($bulan == '11') {
            $bulan = 'November';
          }elseif($bulan == '12') {
            $bulan = 'Desember';
          }
          array_push($listBulanIn, $bulan);
      }

      $allBulanIn = '';
      $jmlBulanIn = count($listBulanIn);
        for($b = 0; $b < $jmlBulanIn; $b++) {
          if ($b == ($jmlBulanIn-1)) {
            $allBulanIn .= $listBulanIn[$b];
          }else {
            $allBulanIn .= $listBulanIn[$b].', ';
          }
        }
    }

//Untuk Deklarasi Periode Keluar//
    if (empty($periode2)) {
      $allBulanOut = 'All';
    }else {
      $listBulan2 = array();
      $tgl2 = date("Ym",strtotime($tanggalawal2));
        while($tgl2 <= date("Ym", strtotime($tanggalakhir2))) {
          $hasil2 = substr($tgl2, 4);
          array_push($listBulan2, $hasil2);
            if (substr($tgl2, 4, 2) == "12")
              $tgl2 = (date("Y", strtotime($tgl2."01")) +1). "01";
            else
              $tgl2++;
        }

      $listBulanOut = array();
      foreach ($listBulan2 as $i => $bulan) {
        if($bulan == '01') {
          $bulan = 'Januari';
        }elseif($bulan == '02') {
          $bulan = 'Februari';
        }elseif($bulan == '03') {
          $bulan = 'Maret';
        }elseif($bulan == '04') {
          $bulan = 'April';
        }elseif($bulan == '05') {
          $bulan = 'Mei';
        }elseif($bulan == '06') {
          $bulan = 'Juni';
        }elseif($bulan == '07') {
          $bulan = 'Juli';
        }elseif($bulan == '08') {
          $bulan = 'Agustus';
        }elseif($bulan == '09') {
          $bulan = 'September';
        }elseif($bulan == '10') {
          $bulan = 'Oktober';
        }elseif($bulan == '11') {
          $bulan = 'November';
        }elseif($bulan == '12') {
          $bulan = 'Desember';
        }
        array_push($listBulanOut, $bulan);
    }

      $allBulanOut = '';
      $jmlBulanOut = count($listBulanOut);
        for($b = 0; $b < $jmlBulanOut; $b++) {
          if ($b == ($jmlBulanOut-1)) {
            $allBulanOut .= $listBulanOut[$b];
          }else {
            $allBulanOut .= $listBulanOut[$b].', ';
          }
        }
    }

    $data['allBulanIn'] = $allBulanIn;
    $data['allBulanOut'] = $allBulanOut;
    $lokasi1 = $this->M_logbookharian->getLokasiName($lokasi);
    $data['filterMasuk'] = $this->M_logbookharian->filterLimbahMasuk($tanggalawal1, $tanggalakhir1, $jenislimbahNew, $lokasi);
    $data['filterKeluar'] = $this->M_logbookharian->filterLimbahKeluar($tanggalawal2, $tanggalakhir2, $jenislimbahNew2, $lokasi);

    $data['user_name'] = $username;
    $data['allBulanIn'] = $allBulanIn;
    $data['allBulanOut'] = $allBulanOut;
    $data['lokasi'] = $lokasi1['0']['lokasi'];

  //-------------------EXPORT EXCEL--------------------//
    if($export == 'excel'){
      $this->load->library("Excel");
      $this->load->view('WasteManagement/LogBook/V_Excel',$data);
    }
    //-----------------EXPORT PDF--------------------//
    else if ($export == 'pdf'){
      $date = date('d-m-Y');
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      $pdf = new mPDF('utf-8','A4-L',0,'',10,10,10,10,10,10);
      $filename = 'LogBook_Harian_Limbah_B3_'.$date.'.pdf';

      $html = $this->load->view('WasteManagement/LogBook/V_PDF',$data,true);

      $stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
      $pdf->WriteHTML($stylesheet1,1);
      $pdf->WriteHTML($html, 2);
      $pdf->setTitle($filename);
      $pdf->Output($filename, 'I');
    }
  }
}

 ?>
