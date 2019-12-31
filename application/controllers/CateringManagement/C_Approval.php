<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class C_Approval extends CI_Controller
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

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('CateringManagement/Pesanan/M_pesanan');

    $this->checkSession();
    date_default_timezone_set('Asia/Jakarta');
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect(base_url('PerizinanDinas/AtasanApproval'));
    }
  }

  public function index()
  {
    $user = $this->session->user;
    $user_id = $this->session->userid;
    $today = date('Y-m-d');

    $data['Title'] = 'Approval Tambahan';
    $data['Menu'] = 'Approval Tambahan';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $this->M_pesanan->updateStatus($today);

    $base = base_url();
    if (empty($data['UserMenu'])) {
      header("location: $base ");
    }

    $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
    $data['today'] = date("d M Y");
	$data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);
    $data['ambilapprove'] = $this->M_pesanan->ambilapprove($today);

    $data['dataTambahan'] = $this->M_pesanan->dataTambahan($today);

    if (!empty($data['ambilapprove'])) {
      $explod = explode(" ",$data['ambilapprove']['0']['keterangan']);
      $data['ket'] = implode(", ", $explod);
    }

    $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
    $lok = '';
    if ($lokasiApprove == '01') {
        $lok = "AND tp.jenis_izin in ('1', '3')";
        $lokasiAsal = "AND tpri.lokasi_kerja in ('01', '03')";
    }elseif ($lokasiApprove == '02') {
        $lok = "AND tp.jenis_izin = '2'";
        $lokasiAsal = "AND tpri.lokasi_kerja in ('02')";
    }else {
        $lok = "";
        $lokasiAsal = "";
    }

    $belum = $this->M_pesanan->getDataBelumDiProses($lok);
    $newData = array();
    $dataTerproses = array();
    foreach ($belum as $key) {
        if($key['diproses'] == 0){
            $newData[] = $key;
        }elseif ($key['diproses'] == 1) {
            $dataTerproses[] = $key;
        }
    }
    $data['BelumProses'] = $newData;

    if (!empty($dataTerproses)) {
        $real = array();
        $RealMin = array();
        foreach ($dataTerproses as $key) {
            $dataDinas = $this->M_pesanan->getDataDinas($lok, $key['noind']);
            $dataMin = $this->M_pesanan->getDataDinasMin($lokasiAsal, $key['noind']);
            if (!empty($dataDinas)) {
                $real[] = $key;
            }
            if (!empty($dataMin)) {
                $RealMin[] = $key;
            }
        }

        if (!empty($real)) {
            $new = array_column($real, 'tujuan');
            foreach ($new as $key) {
                $data['dataDinas'][$key][] = $key;
            }
        }

        if (!empty($RealMin)) {
            $kurang = array_column($RealMin, 'tempat_makan');
            foreach ($kurang as $key) {
                $data['kurang'][$key][] = $key;
            }
        }
    }else {
        $data['dataDinas'] = '';
        $data['kurang'] = '';
    }

    $data['user'] = $this->session->user;
    $data['sie'] = $this->M_pesanan->getNamaSie();
    $data['hidden'] = '';
    if($data['user'] != 'J1256' && $data['user'] != 'F2324' && $data['user'] != 'B0720' && $data['user'] != 'B0799'){
      $data['hidden'] = 'hidden';
    }

	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
    $this->load->view('CateringManagement/V_approval');
	$this->load->view('V_Footer',$data);
  }

  public function Detail()
  {
    $id = $_POST['id'];
    $data = $this->M_pesanan->ambildetail($id);
    $getSeksi = $this->M_pesanan->getSeksi($data['0']['kodesie']);
		$ket = explode(", ",$data['0']['keterangan']);
		if ($ket > 1) {
			for ($i=0; $i < count($ket) ; $i++) {
				$nama[] = $this->M_pesanan->getNamaa(true, $ket[$i])[0]['nama'];
			}
			$nama = implode(', ',$nama);
		}else {
			$ket = $data['0']['keterangan'];
			$nama = $this->M_pesanan->getNamaa(false, $ket)[0]['nama'];
		}
    $data['0']['seksi'] = $getSeksi;
    $data['0']['nama'] 	= $nama;
    $data['0']['nama1'] 	= $data['0']['nama1'];
    echo json_encode($data);
  }

  public function Approval()
  {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $setuju = $this->M_pesanan->updateapproval($id, $status);

    $link = base_url("CateringTambahan/Seksi");

    $today        = date('Y-m-d');
    $kd_shift     = $_POST['Shift_Tambahan'];
    $lokasi       = $_POST['lokasi_kerja'];
    $tempat_makan = $_POST['tempat_makan'];
    $tambahan     = $_POST['plus'];

    if ($kd_shift == '4') {
      unset($kd_shift);
      $kd_shift = '1';
    }

    $pesanan = $this->M_pesanan->ambilPesananHariIni();
    $usermail = $this->M_pesanan->getUserforMail($id);
    $imail = $this->M_pesanan->getMail($usermail);
    print_r($imail);

    $insertTambah = array(
      'fd_tanggal' => $today,
      'fs_tempat_makan' => $tempat_makan,
      'fs_kd_shift' => $kd_shift,
      'fn_jumlah_pesanan' => $tambahan,
      'fb_keterangan' => 1
    );
    $this->M_pesanan->insertTambahPesan($insertTambah);

    $jumlah = $pesanan['0']['jml_bukan_shift']+$tambahan;
    $jmltotal = $pesanan['0']['jml_total']+$tambahan;

    if ($status == '2') {
      $alert = "Telah di <b>Approve</b>";
    }elseif ($status == '3') {
      $alert = "Telah di <b>Reject</b>";
    }elseif ($status == '4') {
      $alert = "<b>Tidak Terbaca</b>";
    }

    $update_erp = $this->M_pesanan->editTotalPesanan($jmltotal, $kd_shift, $tempat_makan, $jumlah);
    $this->sendMail($imail, $link, $alert);

  }

  public function index_Rekap()
  {
    $user = $this->session->user;
    $user_id = $this->session->userid;
    $today = date('Y-m-d');

    $data['Title'] = 'Rekap Tambahan';
    $data['Menu'] = 'Rekap Tambahan';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $this->M_pesanan->updateStatus($today);

    $base = base_url();
    if (empty($data['UserMenu'])) {
      header("location: $base ");
    }

    $data['user'] = $this->session->user;
    $data['sie'] = $this->M_pesanan->getNamaSie();
    $data['hidden'] = '';
    if($data['user'] != 'J1256' && $data['user'] != 'F2324' && $data['user'] != 'B0720' && $data['user'] != 'B0799'){
      $data['hidden'] = 'hidden';
    }

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('CateringManagement/V_RekapTambahan');
    $this->load->view('V_Footer',$data);
  }

  public function rekapDinas()
  {
    $user = $this->session->user;
    $today = date('Y-m-d');
    $tanggal = $this->input->post('tanggal');
    $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
    $lok = '';
    if ($lokasiApprove == '01') {
      $lok = "AND tp.jenis_izin in ('1', '3')";
      $lokasiAsal = "AND tpri.lokasi_kerja in ('01', '03')";
    }elseif ($lokasiApprove == '02') {
      $lok = "AND tp.jenis_izin = '2'";
      $lokasiAsal = "AND tpri.lokasi_kerja in ('02')";
    }else {
      $lok = "";
      $lokasiAsal = "";
    }

    $kurang ='';

    if (!empty($tanggal)) {
		$explode = explode(' - ', $tanggal);
		$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
		$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

		if ($periode1 == $periode2) {
            $periodeTa = date('d F Y', strtotime($periode1));
            $data['tanggal'] = $periodeTa;
			$periode = "AND cast(tpt.fd_tanggal as date) IN ('$periode1')";
            $rekapDinas1 = $this->M_pesanan->getRekapAllDinas($lok, $periode);
            $kurang = $this->M_pesanan->getPekerjaAsal($periode, $lokasiAsal);
		}else if($periode1 != $periode2){
            $periodeTa = date('d F Y', strtotime($periode1));
            $periodeTa1 = date('d F Y', strtotime($periode2));
            $data['tanggal'] = $periodeTa.' - '.$periodeTa1;
			$periode = "AND cast(tpt.fd_tanggal as date) between '$periode1' and '$periode2'";
            $rekapDinas1 = $this->M_pesanan->getRekapAllDinas($lok, $periode);
            $kurang = $this->M_pesanan->getPekerjaAsal($periode, $lokasiAsal);
		}
	}else {
      $param = '';
      $rekapDinas1 = $this->M_pesanan->getRekapAllDinas($lok, $param);
      $kurang = $this->M_pesanan->getPekerjaAsal($param, $lokasiAsal);
	}

    if (!empty($rekapDinas1) || !empty($kurang)) {
        $nuRekap = array();
        $table = '';
        foreach ($rekapDinas1 as $key) {
            $nuRekap[date('Y-m-d', strtotime($key['fd_tanggal']))][] = $key;
        }

        $table.= '<div class="form-group">
                    <center>
                    <div class="col-lg-12 form-group bg-info" style=" font-weight:bold; margin-bottom: 15px;">';
        if(isset($data['tanggal'])){$table .= "====================== Rekap Data Tambah Kurang Makan Perizinan Dinas Tanggal : ".$data['tanggal']."======================";}else {
            $table .=  "======================== Rekap Data Tambah Kurang Makan Perizinan Dinas========================";
        }
        $table .= '</center><br></div>';

        if (empty($nuRekap)) {
            $table .= '';
        }else {
            $table .= '<hr>
                        <br>
                        <center>
                        <label style="font-size:18px; text-align:center" class="bg-primary">Rekap Tambahan Pesanan Makan Pekerja Dinas</label><br>
                        </center>
                        <br>';
            $i = 0 ;
            foreach ($nuRekap as $key) {
                $table .= '<b>Tanggal : '.array_keys($nuRekap)[$i].'</b>';
                $table .= '<table class="datatable approveCatering table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
                            <thead class="bg-primary">
                            <tr>
                            <th style="width: 30px;">No</th>
                            <th>Tempat Makan</th>
                            <th>Tambahan</th>
                            </tr>
                            </thead>
                            <tbody>';

                $nuRekapan = null;
                foreach ($key as $nu) {
                    $nuRekapan[$nu['fs_tempat_makan']][] = $nu;
                }

                if (!empty($nu)) {
                    $no=1;
                    foreach ($nuRekapan as $val) {
                        $table .= '<tr title="Click for Detail" type="button" class="detailPekerjaDinasPlus" value="'.$val['0']['fs_tempat_makan']."|".array_keys($nuRekap)[$i].'">
                        <td>'.$no.'</td>
                        <td>'.$val['0']['fs_tempat_makan'].'</td>
                        <td>'.count($val).'</td>
                        </tr>';
                        $no++;
                    }
                }
                $table .= '</tbody></table>';
                $i++;
            }
        }

        foreach ($kurang as $key) {
            $nuKurang[date('Y-m-d', strtotime($key['fd_tanggal']))][] = $key;
        }

        if (!empty($nuKurang)) {
            $table .= '<hr>
                        <br>
                        <center>
                        <label style="font-size:18px; text-align:center" class="bg-primary">Rekap Pengurangan Pesanan Makan Pekerja Dinas</label><br>
                        </center>
                        <br>';
            $i = 0 ;
            foreach ($nuKurang as $key) {
                $table .= '<b>Tanggal : '.array_keys($nuKurang)[$i].'</b>';
                $table .= '<table class="datatable approveCatering table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
                            <thead class="bg-primary">
                            <tr>
                            <th style="width: 5%;">No</th>
                            <th>Tempat Makan</th>
                            <th>Pengurangan</th>
                            </tr>
                            </thead>
                            <tbody>';

                $nuRekapan1 = null;
                foreach ($key as $nu) {
                    $nuRekapan1[$nu['fs_tempat_makan']][] = $nu;
                }

                if (!empty($nuRekapan1)) {
                    $no=1;
                    foreach ($nuRekapan1 as $item) {
                        $table .= '<tr title="Click for Detail" type="button" class="detailPekerjaDinasMin" value="'.$item['0']['fs_tempat_makan']."|".array_keys($nuKurang)[$i].'">
                        <td>'.$no.'</td>
                        <td>'.$item['0']['fs_tempat_makan'].'</td>
                        <td>'.count($item).'</td>
                        </tr>';
                        $no++;
                    } };
                    $table .= '</tbody></table></div>';
                    $i++;
                }
        }

        echo json_encode($table);
    }else {
        echo json_encode('Kosong');
    }
  }

  public function getDetailPekerjaDinasPlus()
  {
      $user = $this->session->user;
      $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
      $lok = '';
      if ($lokasiApprove == '01') {
          $lok = "AND tp.jenis_izin in ('1', '3')";
      }elseif ($lokasiApprove == '02') {
          $lok = "AND tp.jenis_izin = '2'";
      }else {
          $lok = "";
      }

      $isi = $this->input->post('value');
      $explode = explode("|", $isi);
      $tempat = $explode[0];
      $tanggal = $explode[1];

      $detail = $this->M_pesanan->getDetailPekerjaDinasPlus($tempat, $tanggal, $lok);
      if (!empty($detail)){
          echo '<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Detail Pesanan Tambahan</h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered table-hover table-striped text-center" id="tabelDinas">
              <thead>
                  <th>NO</th>
                  <th>NO. INDUK</th>
                  <th>NAMA</th>
                  <th>TUJUAN</th>
                  <th>KEPERLUAN</th>
              </thead>
              </div>';
          $i = 1;
          foreach($detail as $key){
              echo '<tr>
              <td>'.$i.'</td>
              <td>'.$key["fs_noind"].'</td>
              <td>'.$key["fs_nama"].'</td>
              <td>'.$key["fs_tempat_makan"].'</td>
              <td>'.$key["fs_ket"].'</td>
              </tr>';
              $i++;
          }
          echo '</table>';
      }
  }

  public function getDetailPekerjaDinasMin()
  {
      $user = $this->session->user;
      $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
      $lokasiAsal = '';
      if ($lokasiApprove == '01') {
          $lokasiAsal = "AND tpri.lokasi_kerja in ('01', '03')";
      }elseif ($lokasiApprove == '02') {
          $lokasiAsal = "AND tpri.lokasi_kerja in ('02')";
      }else {
          $lokasiAsal = "";
      }

      $isi = $this->input->post('value');
      $explode = explode("|", $isi);
      $tempat = $explode[0];
      $tanggal = $explode[1];
      $param = '';
      if (count($explode) > 2) {
          $param = $explode[2];
      }

      $detail = $this->M_pesanan->getDetailPekerjaDinasMin($tempat, $tanggal, $lokasiAsal);
      if (!empty($detail)){
          if (!empty($param)) {
              echo '<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Detail Pengurangan Catering</h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered table-hover table-striped text-center" id="tabelDinas">
              <thead>
              <th>NO</th>
              <th>NO. INDUK</th>
              <th>NAMA</th>
              <th>TEMPAT MAKAN</th>
              <th>KEPERLUAN</th>
              </thead>
              </div>';
              $i = 1;
              foreach($detail as $key){
                  echo '<tr>
                  <td>'.$i.'</td>
                  <td>'.$key["fs_noind"].'</td>
                  <td>'.$key["fs_nama"].'</td>
                  <td>'.$key["fs_tempat_makan"].'</td>
                  <td>'.$key["fs_ket"].'</td>
                  </tr>';
                  $i++;
              }
              echo "</table>";
          }else {
              echo '<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Detail Pekerja</h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered table-hover table-striped text-center" id="tabelDinas">
              <thead>
              <th>NO</th>
              <th>NO. INDUK</th>
              <th>NAMA</th>
              <th>TEMPAT MAKAN</th>
              <th>KEPERLUAN</th>
              </thead>
              </div>';
              $i = 1;
              foreach($detail as $key){
                  echo '<tr>
                  <td>'.$i.'</td>
                  <td>'.$key["fs_noind"].'</td>
                  <td>'.$key["fs_nama"].'</td>
                  <td>'.$key["fs_tempat_makan"].'</td>
                  <td>'.$key["fs_ket"].'</td>
                  </tr>';
                  $i++;
              }
              echo "</table>";
          }
      }
  }

  public function sendMail($imail, $link, $alert){
       $Quick = [
           'mailtype'  => 'html',
           'charset'   => 'utf-8',
           'protocol'  => 'smtp',
           'smtp_host' => 'mail.quick.com',
           'smtp_user' => 'no-reply@quick.com',
           'smtp_pass' => '123456',
           'smtp_port' => 587,
           'crlf'      => "\r\n",
           'newline'   => "\r\n"
       ];
       $this->load->library('email', $Quick);
       $this->email->from('no-reply', 'Responses Catering');
           // $this->email->to($address);
       $this->email->to($imail);
       $this->email->subject('Pemberitahuan Pesanan Catering Tambahan');
       $this->email->message("Pesanan yang anda ajukan ".$alert." oleh Kasie General Affair
           Klik <a href=".$link.">Link</a> untuk Melihat Pesanan disini <br>
           ");
       $this->email->send();
   }

   public function exportDinas()
   {
       $user = $this->session->user;
       $today = date('Y-m-d');
       $tanggal = $this->input->get('tanggal');
       $jenis = $this->input->get('jenis');
       $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
       $lok = '';
       if ($lokasiApprove == '01') {
         $lok = "AND tp.jenis_izin in ('1', '3')";
         $lokasiAsal = "AND tpri.lokasi_kerja in ('01', '03')";
       }elseif ($lokasiApprove == '02') {
         $lok = "AND tp.jenis_izin = '2'";
         $lokasiAsal = "AND tpri.lokasi_kerja in ('02')";
       }else {
         $lok = "";
         $lokasiAsal = "";
       }

       $kurang ='';

       if (!empty($tanggal)) {
   		$explode = explode(' - ', $tanggal);
   		$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
   		$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));
       		if ($periode1 == $periode2) {
               $periodeTa = date('d F Y', strtotime($periode1));
       		   $periode = "AND cast(tpt.fd_tanggal as date) IN ('$periode1')";
               $data['tambahan'] = $this->M_pesanan->getRekapAllDinas($lok, $periode);
               $data['kurang'] = $this->M_pesanan->getPekerjaAsal($periode, $lokasiAsal);
       		}else if($periode1 != $periode2){
               $periodeTa = date('d F Y', strtotime($periode1));
               $periodeTa1 = date('d F Y', strtotime($periode2));
       		   $periode = "AND cast(tpt.fd_tanggal as date) between '$periode1' and '$periode2'";
               $data['tambahan'] = $this->M_pesanan->getRekapAllDinas($lok, $periode);
               $data['kurang'] = $this->M_pesanan->getPekerjaAsal($periode, $lokasiAsal);
       		}
       	}else {
             $param = '';
             $data['tambahan'] = $this->M_pesanan->getRekapAllDinas($lok, $param);
             $data['kurang'] = $this->M_pesanan->getPekerjaAsal($param, $lokasiAsal);
       	}

        if (!empty($data['tambahan']) || !empty($data['kurang'])) {
            if ($jenis == 'Excel') {
                $this->load->library("Excel");
                $this->load->view('CateringManagement/V_ExcelDinas',$data);
            }elseif ($jenis == 'PDF') {
                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                $pdf = new mPDF('utf-8','A4-P', 8, 5, 20, 15, 20, 15, 8, 20);
                $filename = 'Rekap Makan Pekerja Dinas'.$tanggal.'.pdf';

                $html = $this->load->view('CateringManagement/V_PDFDinas',$data, true);

                $pdf->WriteHTML($html, 2);
                $pdf->setTitle($filename);
                $pdf->Output($filename, 'I');
            }
        }else {
            echo "<script type='text/javascript'>
                    alert('Mohon Maaf Data Tidak Ada')
                    window.location.href = 'index_Rekap'
                    </script>";
        }
    }

    public function PemrosesCatering()
    {
        $belum = $this->M_pesanan->getDataBelumDiProses();
        $newData = array();
        foreach ($belum as $key) {
            if($key['diproses'] == 0){
                $newData[] = $key;
            }
        }
        $data['BelumProses'] = $newData;

        if (!empty($data['BelumProses'])) {
            //Tambah Pesanan
            foreach ($data['BelumProses'] as $key) {
                $countNew[$key['tujuan']][] = $key;
                $countNewKurang[$key['tempat_makan']][] = $key;
            }


            foreach ($countNew as $key) {
                $getdatapesanantambah = $this->M_pesanan->getDataPEsanantoday($key[0]['tujuan']);
                if (empty($getdatapesanantambah)) {
                    //insert tambahan
                    $data = array(
                        'fd_tanggal'        => date('Y-m-d'),
                        'fs_tempat_makan'   => $key[0]['tujuan'],
                        'fs_kd_shift'       => '1',
                        'fn_jumlah_pesanan' => count($key),
                    );
                    $inTambahan = $this->M_pesanan->insertTambahCateringDinas($data);

                    //cari data yang baru di insert
                    $find = $this->M_pesanan->getDataPEsanantoday($key[0]['tujuan']); // hanya diambil idnya
                    if (!empty($find)) {
                        //cari absensi perorang yang makan di sana
                        foreach ($key as $value) {
                            $cek = $this->M_pesanan->checking($value['noind']);
                            $cekData = $this->M_pesanan->checkingPekerjaDinas($find[0]['id_tambahan'], $value['noind'], $value['nama'], $value['keterangan']);
                            if (empty($cekData)) {
                                $perorang = array(
                                    'id_tambahan'   => $find[0]['id_tambahan'],
                                    'fs_noind'      => $value['noind'],
                                    'fs_nama'       => $value['nama'],
                                    'fs_ket'        => $value['keterangan']
                                );
                                $this->M_pesanan->insertToDetail($perorang);
                            }
                        }
                    }

                }else {
                    //cari data yang baru di insert
                    foreach ($key as $value) {
                        $cek = $this->M_pesanan->checking($value['noind']);
                        $cekData = $this->M_pesanan->checkingPekerjaDinas($getdatapesanantambah[0]['id_tambahan'], $value['noind'], $value['nama'], $value['keterangan']);
                        if (empty($cekData)) {
                            $perorang = array(
                                'id_tambahan'   => $getdatapesanantambah[0]['id_tambahan'],
                                'fs_noind'      => $value['noind'],
                                'fs_nama'       => $value['nama'],
                                'fs_ket'        => $value['keterangan']
                            );
                            $this->M_pesanan->insertToDetail($perorang);
                        }
                    }
                    // update di tpesanan tambahan erp
                    $countBaru = $this->M_pesanan->countPekerjaDinas($getdatapesanantambah[0]['id_tambahan']);
                    $this->M_pesanan->updateJumlahCatering($getdatapesanantambah[0]['id_tambahan'], $getdatapesanantambah[0]['fs_tempat_makan'], $countBaru[0]['count']);
                }
                //Update tambahan di tpesanan_erp
                $jumlah_plus = $this->M_pesanan->getDetailJumlah($key[0]['tujuan']);
                $this->M_pesanan->UpdatePesanan($key[0]['tujuan'], $jumlah_plus[0]['pesanan']);
            }

            //Pengurangan Pesanan


            foreach ($countNewKurang as $KeyMin) {
                $getdatapesanankurang = $this->M_pesanan->getDataPengurangantoday($KeyMin[0]['tempat_makan']);
                if (empty($getdatapesanankurang)) {
                    //insert tambahan
                    $dataMin = array(
                        'fd_tanggal'        => date('Y-m-d'),
                        'fs_tempat_makan'   => $KeyMin[0]['tempat_makan'],
                        'fs_kd_shift'       => '1',
                        'fn_jml_tdkpesan' => count($KeyMin),
                    );
                    // print_r($dataMin);die;
                    $inPengurangan = $this->M_pesanan->insertPenguranganCateringDinas($dataMin);

                    //cari data yang baru di insert
                    $findMin = $this->M_pesanan->getDataPengurangantoday($KeyMin[0]['tempat_makan']); // hanya diambil idnya
                    if (!empty($findMin)) {
                        //cari absensi perorang yang makan di sana
                        foreach ($KeyMin as $value) {
                            $cekMin = $this->M_pesanan->checking($value['noind']);
                            $cekDataMin = $this->M_pesanan->checkingPekerjaDinasMin($findMin[0]['id_pengurangan'], $value['noind'], $value['nama'], $value['keterangan']);
                            if (empty($cekDataMin)) {
                                if (!empty($cekMin)) {
                                    $minus = array(
                                        'id_pengurangan'   => $findMin[0]['id_pengurangan'],
                                        'fs_noind'      => $value['noind'],
                                        'fs_nama'       => $value['nama'],
                                        'fs_ket'        => $value['keterangan']
                                    );
                                    $this->M_pesanan->insertToDetailKurang($minus);
                                }
                            }
                        }
                    }

                }else {
                    //cari data yang baru di insert
                    foreach ($KeyMin as $value) {
                        $cekMin = $this->M_pesanan->checking($value['noind']);
                        $cekDataMin = $this->M_pesanan->checkingPekerjaDinasMin($getdatapesanankurang[0]['id_pengurangan'], $value['noind'], $value['nama'], $value['keterangan']);
                        if (empty($cekDataMin)) {
                            if (!empty($cekMin)) {
                                $minus = array(
                                    'id_pengurangan'   => $getdatapesanankurang[0]['id_tambahan'],
                                    'fs_noind'      => $value['noind'],
                                    'fs_nama'       => $value['nama'],
                                    'fs_ket'        => $value['keterangan']
                                );
                                $this->M_pesanan->insertToDetailKurang($minus);
                            }
                        }
                    }
                    // update di tpesanan tambahan erp
                    $countBaruMin = $this->M_pesanan->countPekerjaDinasMin($getdatapesanankurang[0]['id_tambahan']);
                    $this->M_pesanan->updateJumlahCateringMin($getdatapesanankurang[0]['id_pengurangan'], $getdatapesanankurang[0]['fs_tempat_makan'], $countBaruMin[0]['count']);
                }
                //Update tambahan di tpesanan_erp
                $jumlah_min = $this->M_pesanan->getDetailJumlah($KeyMin[0]['tempat_makan']);
                $this->M_pesanan->UpdatePesanan($KeyMin[0]['tempat_makan'], $jumlah_min[0]['pesanan']);
            }
        redirect('ApprovalTambahan');
        }
    }

}

?>
