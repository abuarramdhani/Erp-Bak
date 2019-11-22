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
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
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
    $lok = '';
    if ($lokasiApprove == '01') {
      $lok = "AND tp.jenis_izin in ('1', '3')";
    }elseif ($lokasiApprove == '02') {
      $lok = "AND tp.jenis_izin = '2'";
    }else {
      $lok = "";
    }
    $dataDinas = $this->M_pesanan->getDataDinas($lok);
    $new = array_column($dataDinas, 'tujuan');
    foreach ($new as $key) {
      $data['dataDinas'][$key][] = $key;
    }

    $data['dataTambahan'] = $this->M_pesanan->dataTambahan($today);

    if (!empty($data['ambilapprove'])) {
      $explod = explode(" ",$data['ambilapprove']['0']['keterangan']);
      $data['ket'] = implode(", ", $explod);
    }else {

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

  public function rekapDinas()
  {
    $user = $this->session->user;
    $today = date('Y-m-d');
    $tanggal = $this->input->post('tanggal');
    $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
    $lok = '';
    if ($lokasiApprove == '01') {
      $lok = "AND tp.jenis_izin in ('1', '3')";
    }elseif ($lokasiApprove == '02') {
      $lok = "AND tp.jenis_izin = '2'";
    }else {
      $lok = "";
    }

    if (!empty($tanggal)) {
			$explode = explode(' - ', $tanggal);
			$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
			$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

			if ($periode1 == $periode2) {
        $periodeTa = date('d F Y', strtotime($periode1));
        $data['tanggal'] = $periodeTa;
				$periode = "AND cast(ti.created_date as date) = '$periode1'";
        $rekapDinas1 = $this->M_pesanan->getRekapAllDinas($today, $lok, $periode);
			}else if($periode1 != $periode2){
        $periodeTa = date('d F Y', strtotime($periode1));
        $periodeTa1 = date('d F Y', strtotime($periode2));
        $data['tanggal'] = $periodeTa.' - '.$periodeTa1;
				$periode = "AND cast(ti.created_date as date) between '$periode1' and '$periode2'";
        $rekapDinas1 = $this->M_pesanan->getRekapAllDinas($today, $lok, $periode);
			}
		}else {
      $param = '';
      $rekapDinas1 = $this->M_pesanan->getRekapAllDinas($today, $lok, $param);
		}

    $rekapan = array_column($rekapDinas1, 'tujuan');
    foreach ($rekapan as $key) {
      $data['rekapan'][$key][] = $key;
    }
    $view = $this->load->view('CateringManagement/V_RekapDinas', $data);
    echo json_encode($view);
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

    $lokasiApprove = $this->M_pesanan->getLokasiApprove($user);
    $data['today'] = date("d M Y");
    $data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);
    $data['ambilapprove'] = $this->M_pesanan->ambilapprove($today);
    $lok = '';
    if ($lokasiApprove == '01') {
      $lok = "AND tp.jenis_izin in ('1', '3')";
    }elseif ($lokasiApprove == '02') {
      $lok = "AND tp.jenis_izin = '2'";
    }else {
      $lok = "";
    }
    $dataDinas = $this->M_pesanan->getDataDinas($lok);
    $new = array_column($dataDinas, 'tujuan');
    foreach ($new as $key) {
      $data['dataDinas'][$key][] = $key;
    }

    $data['dataTambahan'] = $this->M_pesanan->dataTambahan($today);

    if (!empty($data['ambilapprove'])) {
      $explod = explode(" ",$data['ambilapprove']['0']['keterangan']);
      $data['ket'] = implode(", ", $explod);
    }else {

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
}

?>
