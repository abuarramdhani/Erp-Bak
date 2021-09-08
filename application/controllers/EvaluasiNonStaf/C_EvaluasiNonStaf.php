<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class C_EvaluasiNonStaf extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('General');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('KonversiBulan');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('EvaluasiNonStaf/M_evaluasinonstaf');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }

  public function index() // Monitoring non staf
  {
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Evaluasi Non Staf - Quick ERP', 'Monitoring Pekerja Non Staf', 'Monitoring Non Staf', 'Monitoring Non Staf');

    $data['monitoring_nonstaf'] = $this->M_evaluasinonstaf->getDataMonitoringNonStaf();
    $data['monitoring_cabang']  = $this->M_evaluasinonstaf->getDataMonitoringcabang();
    $data['monitoring_ospp']    = $this->M_evaluasinonstaf->getDataMonitoringospp();
    $data['monitoring_khusus']  = $this->M_evaluasinonstaf->getDataMonitoringkhusus();
    $data['monitoring_pkl']     = $this->M_evaluasinonstaf->getDataMonitoringpkl();
    $data['blangko_not_send']   = $this->M_evaluasinonstaf->blangko_not_send();
    $data['notif_today']        = $this->M_evaluasinonstaf->AllData_notif();
    $data['flag_today']         = $this->M_evaluasinonstaf->AllData_flag();
    $data['today']              = date('Y-m-d');
    // echo "<pre>";print_r($data);exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('EvaluasiNonStaf/Monitoring/V_Monitoring', $data);
    $this->load->view('V_Footer',$data);
  }
  
  public function Monitoring_staf() // Monitoring staf
  {
    $user = $this->session->username;
    $data 	=	$this->general->loadHeaderandSidemenu('Evaluasi Non Staf - Quick ERP', 'Monitoring Pekerja Staf', 'Monitoring Staf', 'Monitoring Staf');

    $data['monitoring_staf']    = $this->M_evaluasinonstaf->getDataMonitoringStaf();
    $data['monitoring_tkpw']    = $this->M_evaluasinonstaf->getDataMonitoringTKPW();
    $data['blangko_not_send']   = $this->M_evaluasinonstaf->blangko_not_send_staf();
    $data['notif_today']        = $this->M_evaluasinonstaf->AllData_notif_staf();
    $data['flag_today']         = $this->M_evaluasinonstaf->AllData_flag_staf();
    $data['today']              = date('Y-m-d');
    // echo "<pre>";print_r($data);exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('EvaluasiNonStaf/Monitoring/V_Monitoring_Staf', $data);
    $this->load->view('V_Footer',$data);
  }

  public function create()
  {
    $data 	=	$this->general->loadHeaderandSidemenu('Evaluasi Non Staf - Quick ERP', 'Create Evaluasi', 'Create', 'Create');

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('EvaluasiNonStaf/Monitoring/V_Create');
    $this->load->view('V_Footer',$data);
  }

  public function getTabel()
  {
    $periode  = $this->input->post('periode');
    $noind    = $this->input->post('jenis');
    $periode  = date('Y-m-d', strtotime($periode));

    $data['create'] = $this->M_evaluasinonstaf->getCreatePekerja($noind, $periode);
    $view = $this->load->view('EvaluasiNonStaf/Monitoring/V_TabelCreate', $data);
    echo json_encode($view);
  }

  public function save()
  {
    $noind = $this->input->post('noind');
    $jenis = $this->input->post('jenis');
    $day = date('Y-m-d', strtotime($this->input->post('mulai')));

    if ($jenis == 'H') {
      $selesai_orientasi = date('Y-m-d', strtotime($day. '+44 day'));
      $kirim_blangko = date('Y-m-d', strtotime($selesai_orientasi. '-14 day'));
      $perpanjang = date('Y-m-d', strtotime($selesai_orientasi. '+30 day'));
      $lm_trainee = '75';
    }elseif ($jenis == 'C') {
      $selesai_orientasi = date('Y-m-d', strtotime($day. '+74 day'));
      $kirim_blangko = date('Y-m-d', strtotime($selesai_orientasi. '-14 day'));
      $perpanjang = date('Y-m-d', strtotime($selesai_orientasi. '+60 day'));
      $lm_trainee = '75';
    }elseif ($jenis == 'T') {
      $selesai_orientasi = date('Y-m-d', strtotime($day. '+44 day'));
      $kirim_blangko = date('Y-m-d', strtotime($selesai_orientasi. '-14 day'));
      $lm_trainee = '45';
    }elseif ($jenis == 'P' || $jenis == 'F') {
      $selesai_orientasi = date('Y-m-d', strtotime($day. '+29 day'));
      $kirim_blangko = date('Y-m-d', strtotime($day. '+14 day'));
      $lm_trainee     = '30';
    }elseif ($jenis == 'J' || $jenis == 'G') {
      $selesai_orientasi = date('Y-m-d', strtotime($day. '+179 day'));
      $kirim_blangko = date('Y-m-d', strtotime($day. '+14 day'));
      $perpanjang = date('Y-m-d', strtotime($selesai_orientasi. '+30 day'));
      $lm_trainee = '180';
    }
    
    if ($noind > 1) {
      $ex = implode("', '", $noind);
      $data = $this->M_evaluasinonstaf->getAllData($ex, true);
    }else {
      $data = $this->M_evaluasinonstaf->getAllData($noind, false);
    }

    foreach ($data as $key) {
      $array = array(
        'noind'             => $key['noind'],
        'kodesie'           => $key['kodesie'],
        'lm_trainee'        => $lm_trainee,
        'gol'               => trim($key['gol']),
        'tgl_masuk'         => $key['tgl_masuk'],
        'tgl_sls_orientasi' => $selesai_orientasi,
        'tgl_krm_blangko'   => $kirim_blangko,
        'perpanjangan'      => $perpanjang,
        'jenis'             => $jenis,
        'job_des'           => $key['pekerjaan'],
        'created_date'      => 'now()',
      );
      $this->M_evaluasinonstaf->savePekerjaCreate($array);
    };
  }

  public function updateNow()
  {
    $id = $this->input->post('id');
    $share = $this->input->post('share');
    $today = date('Y-m-d');
    $peringatan1 = date('Y-m-d', strtotime($today. '+3 day'));
    $peringatan2 = date('Y-m-d', strtotime($today. '+6 day'));
    $peringatan3 = date('Y-m-d', strtotime($today. '+5 day'));
    // print_r($id);die;

    if ($id > 1 && $share == 1) {
      $ex = implode("', '", $id);
      $data = $this->M_evaluasinonstaf->getDataID($ex, true);
      $update = $this->M_evaluasinonstaf->updateToday($data[0]['jenis'], $ex, $today, $peringatan1, $peringatan2, $peringatan3, true);
    }elseif ($id == 1 && $share == 1) {
      $data = $this->M_evaluasinonstaf->getDataID($id, false);
      $update = $this->M_evaluasinonstaf->updateToday($data[0]['jenis'], $id, $today, $peringatan1, $peringatan2, $peringatan3, false);
    }else {
      $data = $this->M_evaluasinonstaf->getDataID($id, false);
      $update = $this->M_evaluasinonstaf->updateToday($data[0]['jenis'], $id, $today, $peringatan1, $peringatan2, $peringatan3, false);
    }

  }

  public function updateBlangkoMasuk()
  {
    $id = $this->input->post('id');
    $today = date('Y-m-d');

    $data = $this->M_evaluasinonstaf->getDataID($id, false);
    if (!empty($data[0]['terkirim'])) {
        $update = $this->M_evaluasinonstaf->updateBlangko($id, $today);
    }elseif (empty($data[0]['terkirim'])) {
        print_r('No');
    }
  }
  
  public function update_hubker_seleksi()
  {
    $id = $this->input->post('id');
    $today = date('Y-m-d');
    $update = $this->M_evaluasinonstaf->update_hubker_seleksi($id, $today);
  }

	public function get_atasan_trainee()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_evaluasinonstaf->getatasan($term);
		echo json_encode($data);
	}

  public function import_kirim_nilai(){
    $data['id'] = $this->input->post('id');
    $data['noind'] = $this->input->post('noind');
    $this->load->view('EvaluasiNonStaf/Monitoring/V_Kirim_Nilai', $data);
  }

  public function submit_nilai_training(){
    $format = explode(".", $_FILES['file_nilai']['name']);
    $nilai  = 'Nilai_'.$this->input->post('id').$this->input->post('noind').'.'.$format[1].'';
    if(!is_dir('./assets/upload/EvaluasiNonStaf/Nilai_Training'))
    {
      mkdir('./assets/upload/EvaluasiNonStaf/Nilai_Training', 0777, true);
      chmod('./assets/upload/EvaluasiNonStaf/Nilai_Training', 0777);
    }
    
    $filename = './assets/upload/EvaluasiNonStaf/Nilai_Training/'.$nilai.''; // save inspection report
    move_uploaded_file($_FILES['file_nilai']['tmp_name'],$filename);
    $this->M_evaluasinonstaf->update_nilai_training($this->input->post('id'), $nilai, $this->input->post('atasan'));
    redirect(base_url('EvaluasiPekerjaNonStaf/Monitoring'));
  }
  
  public function update_lulus_gugur()
  {
    $id = $this->input->post('id');
    $alasan = $this->input->post('alasan');
    $update = $this->M_evaluasinonstaf->update_lulus_gugur($id, $alasan);
  }

  public function getBlangkoBelumTerkirim()
  {
    $lokasi = $this->input->post('lokasi');

    $data = $this->M_evaluasinonstaf->getPekerjaInLokasi($lokasi);
    $new = '';
    // echo "<pre>";print_r($data);die;
    foreach ($data as $key) {
      $new[$key['tempat']][] = $key;
    }

    if (empty($new)) {
      $table = 'kosong';
    }else {
      $table = '';

      $i = 0;
      // echo "<pre>";print_r($new);die;
      foreach($new as $item):
        $table .= array_keys($new)[$i]."<br>";
        $table .= "<table class='table table-bordered table-responsive-xs table-sm nambahTabel' style='width: 100%;' ><thead class='bg-primary'>
        <tr>
        <td style='width: 5%;'><input type='checkbox' class='check_all'></td>
        <td style='width: 20%;'>No. Induk</td>
        <td style='width: 35%;'>Nama</td>
        <td style='width: 20%;'>Status</td>
        <td style='width: 20%;'>Tanggal Kirim Blangko</td>
        </tr>
        </thead><tbody>";
        foreach($item as $key):
          $wrap = (date('Y-m-d') >= $key['tgl_krm_blangko']) ? '<tr>' : '<tr>';
          // class="blinkblink"
          $table .= "$wrap";
          // echo "<pre>";print_r($a);die;
          $a = ($key['jenis'] == 'H') ? 'Kontrak Non Staf':(($key['jenis'] == 'T') ? 'Kontrak Non Staf Khusus' : (($key['jenis'] == 'C') ? 'Pekerja Cabang' : (($key['jenis'] == 'P') ? 'Outsourcing & Pemborongan' : (($key['jenis'] == 'F') ? 'PKL' : '-'))));
          $table .= "<td style='width: 5%;'><input class='checkbox_table' type='checkbox' value='".$key['id']."' name='checkbox_checked[]'></td>
          <td style='width: 20%;'>".$key['noind']."</td>
          <td style='width: 35%;'>".$key['nama']."</td>
          <td style='width: 20%;'>".$a."</td>
          <td style='width: 20%;'>".date('d/m/Y', strtotime($key['tgl_krm_blangko']))."</td>";
          $table .= "</tr>";
        endforeach;
        $table .= "</tbody></table>";
        $i++;
      endforeach;
      $table .= "<button type='buton' id='EPNS_buttonKirim' class='btn btn-success text-center form-control'>Kirim</button>";
    }


    echo $table;
  //  print_r($new);die;
  }

  
  public function getBlangkoBelumTerkirimStaf()
  {
    $lokasi = $this->input->post('lokasi');

    $data = $this->M_evaluasinonstaf->getPekerjaInLokasiStaf($lokasi);
    $new = '';
    // echo "<pre>";print_r($data);die;
    foreach ($data as $key) {
      $new[$key['tempat']][] = $key;
    }

    if (empty($new)) {
      $table = 'kosong';
    }else {
      $table = '';

      $i = 0;
      // echo "<pre>";print_r($new);die;
      foreach($new as $item):
        $table .= array_keys($new)[$i]."<br>";
        $table .= "<table class='table table-bordered table-responsive-xs table-sm nambahTabel' style='width: 100%;' ><thead class='bg-primary'>
        <tr>
        <td style='width: 5%;'><input type='checkbox' class='check_all'></td>
        <td style='width: 20%;'>No. Induk</td>
        <td style='width: 35%;'>Nama</td>
        <td style='width: 20%;'>Status</td>
        <td style='width: 20%;'>Tanggal Kirim Blangko</td>
        </tr>
        </thead><tbody>";
        foreach($item as $key):
          $wrap = (date('Y-m-d') >= $key['tgl_krm_blangko']) ? '<tr>' : '<tr>';
          // class="blinkblink"
          $table .= "$wrap";
          // echo "<pre>";print_r($a);die;
          $a = ($key['jenis'] == 'H') ? 'Kontrak Non Staf':(($key['jenis'] == 'T') ? 'Kontrak Non Staf Khusus' : (($key['jenis'] == 'C') ? 'Pekerja Cabang' : (($key['jenis'] == 'P') ? 'Outsourcing & Pemborongan' : (($key['jenis'] == 'F') ? 'PKL' : '-'))));
          $table .= "<td style='width: 5%;'><input class='checkbox_table' type='checkbox' value='".$key['id']."' name='checkbox_checked[]'></td>
          <td style='width: 20%;'>".$key['noind']."</td>
          <td style='width: 35%;'>".$key['nama']."</td>
          <td style='width: 20%;'>".$a."</td>
          <td style='width: 20%;'>".date('d/m/Y', strtotime($key['tgl_krm_blangko']))."</td>";
          $table .= "</tr>";
        endforeach;
        $table .= "</tbody></table>";
        $i++;
      endforeach;
      $table .= "<button type='buton' id='EPNS_buttonKirim' class='btn btn-success text-center form-control'>Kirim</button>";
    }


    echo $table;
  //  print_r($new);die;
  }

  public function Perpanjang()
  {
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      $pdf = new mPDF('utf-8','A4-L', 8, 5, 10, 10, 10, 10, 8, 20);
      $filename = 'Pekerja Terpotong Lelayu'.$date.'.pdf';

      $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_PKL',$data,true);
    // $pdf->setHTMLHeader('
	// 			<table width="100%">
	// 				<tr>
	// 					<td width="50%"><h2><b>Data Pekerja Yang Terkena Potongan SPSI</b></h2></td>
	// 					<td><h4>Dicetak Oleh '.$noind.' - '.$nama.' pada Tanggal '.$today.'</h4></td>
	// 				</tr>
    //       <tr>
    //         <td colspan="2"><h4>Lelayu dari : '.$jk.ucwords(mb_strtolower($pekerja[0]['nama'])).'('.$pekerja[0]['noind'].')</h4></td>
    //       </tr>
	// 				<tr>
	// 					<td colspan="2"><h4>Seksi : '.ucwords(mb_strtolower($pekerja[0]['seksi'])).'</h4></td>
	// 				</tr>
	// 				<tr>
	// 					<td colspan="2"><h4> Tanggal Lelayu : '.$tanggalLelayu.'</h4></td>
	// 				</tr>
	// 			</table>
	// 		');

      $pdf->WriteHTML($html, 2);
      $pdf->setTitle($filename);
      $pdf->Output($filename, 'I');
  }

  public function getExport($id_encrypt)
  {
        $id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encrypt);
		$id	=	$this->encrypt->decode($id);

        $cek = $this->M_evaluasinonstaf->getDataID($id, false);
        $data['data'] = $cek;
        $data['bulanNow'] = $this->konversibulan->KonversiAngkaKeBulan(date('m'));
        $data['day_in'] = explode('-', $cek[0]['tgl_masuk']);
        $data['day_out'] = explode('-', $cek[0]['tgl_sls_orientasi']);
        $data['month_in'] = $this->konversibulan->KonversiAngkaKeBulan($data['day_in'][1]);
        $data['month_out'] = $this->konversibulan->KonversiAngkaKeBulan($data['day_out'][1]);
        // echo "<pre>";print_r($data);exit();
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8','A4-L', 8, 5, 10, 10, 10, 10, 8, 20);
        if ($cek[0]['jenis'] == 'H') {
            $filename = 'Blangko Evaluasi Non Staf-'.$cek[0]['noind'].'.pdf';
            $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_NS',$data,true);
        }elseif ($cek[0]['jenis'] == 'T') {
            $filename = 'Blangko Evaluasi Non Staf Khusus-'.$cek[0]['noind'].'.pdf';
            $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_NS2',$data,true);
        }elseif ($cek[0]['jenis'] == 'C') {
            $filename = 'Blangko Evaluasi Cabang-'.$cek[0]['noind'].'.pdf';
            $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_NS',$data,true);
        }elseif ($cek[0]['jenis'] == 'F') {
            $filename = 'Blangko Evaluasi PKL-'.$cek[0]['noind'].'.pdf';
            $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_PKL',$data,true);
        }elseif ($cek[0]['jenis'] == 'P') {
            $filename = 'Blangko Evaluasi OS-'.$cek[0]['noind'].'.pdf';
            $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_OS',$data,true);
        }elseif ($cek[0]['jenis'] == 'J' || $cek[0]['jenis'] == 'G') {
          $filename = 'Blangko Evaluasi Staf-'.$cek[0]['noind'].'.pdf';
          $html = $this->load->view('EvaluasiNonStaf/Monitoring/V_Blangko_Staf',$data,true);
        }

        $pdf->WriteHTML($html, 2);
        $pdf->setTitle($filename);
        $pdf->Output($filename, 'I');
  }


}
