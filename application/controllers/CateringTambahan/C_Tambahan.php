<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Tambahan extends CI_Controller
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
		$this->load->model('CateringTambahan/M_pesanan');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Pesanan Tambahan';
		$data['Menu'] = 'Pesanan Tambahan ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$today = date('Y-m-d');
		$data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);
		$data['getnoind'] = $this->M_pesanan->ambilnoind();
		$data['getnoindberkas'] = $this->M_pesanan->ambiltberkas();
		$data['getkasie'] = $this->M_pesanan->getkasie();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringTambahan/V_Tambah');
		$this->load->view('V_Footer',$data);
	}

	public function tempatMakan()
	{
		$p = strtoupper($this->input->get('term'));

		$data = $this->M_pesanan->ambilTempatMakan($p);

		echo json_encode($data);
	}

	public function simpan()
	{
		// echo "<pre>";
		 //print_r($_POST);exit;
		$tgl_pesanan = date('Y-m-d');
		$kd_shift = $this->input->post('shift_pesanan');
		$lokasi_kerja = $this->input->post('lokasi_pesanan');
		$tempat_makan = $this->input->post('tempat_makan');
		$tambahan = $this->input->post('tambahan_pesanan');
		$pengurangan = $this->input->post('pengurangan_pesanan');
		$keperluan = $this->input->post('keperluan');
		$ket = $this->input->post('ketnoind');
		$implode = $this->input->post('implode');
		if($implode == 1){
			$in = implode(", ", $ket);
		}else{
			$in = $ket;
		}

		//keperluan e-mail
		$noind = $this->session->user;
		$object = $this->M_pesanan->getNama($noind);
		$seksi = $this->M_pesanan->getSieEmail($noind);
		$link = base_url('ApprovalTambahan');

		$jenis = "";
		if (empty($jenis)) {
			if ($tambahan > 0 && empty($pengurangan)) {
				$jenis = "Tambahan";
			}elseif (empty($tambahan) && $pengurangan > 0) {
				$jenis = "Pengurangan";
			}
		}

		$jumlah = "";
		if (empty($jumlah)) {
			if (!empty($tambahan)) {
				$jumlah = $tambahan;
			}else {
				$jumlah = $pengurangan;
			}
		}

		$user = $this->session->username;

		$array = array(
					'tgl_pesanan' => $tgl_pesanan,
					'tempat_makan' => $tempat_makan,
					'lokasi_kerja' => $lokasi_kerja,
					'kd_shift' => $kd_shift,
					'tambahan' => $tambahan,
					'pengurangan' => $pengurangan,
					'keterangan' => $in,
					'user_' => $this->session->user,
					'status' => 1,
					'keperluan' => $keperluan
				);
		$this->M_pesanan->insertapprove($array);

		$this->sendMail($object, $link, $seksi, $jenis, $jumlah);

		//redirect('CateringTambahan'); iki raguno

	}

	public function sendMail($object, $link, $seksi, $jenis, $jumlah){
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
		$this->email->from('no-reply', 'Email Catering');
			// $this->email->to($address);
		$this->email->to('rosyidatun_nur_r@quick.com');
		$this->email->subject('Permintaan Approval Catering Tambahan');
		$this->email->message("Anda mendapat pengajuan approval <b>".$jenis." Catering</b> dari <b>".$object."</b>, dengan rincian : <br><br>
			Jumlah : ".$jumlah." <br>
			Seksi : ".$seksi." <br>
			Status : <style= 'text-color: orange';>Menunggu Approval anda <br><br>
			Klik <a href=".$link.">Link</a> untuk Melihat Cuti disini <br>
			");
		$this->email->send();
	}



}
