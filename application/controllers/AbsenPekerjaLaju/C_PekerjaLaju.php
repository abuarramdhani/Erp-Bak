<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PekerjaLaju extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AbsenPekerjaLaju/M_pekerjalaju');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Laju';
		$data['Menu'] 			= 	'Pekerja Laju';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_pekerjalaju->getPekerjaLajuAll();
		$data['transportasi'] = $this->M_pekerjalaju->getjenisTransportasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenPekerjaLaju/PekerjaLaju/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Laju';
		$data['Menu'] 			= 	'Pekerja Laju';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['transportasi'] = $this->M_pekerjalaju->getjenisTransportasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenPekerjaLaju/PekerjaLaju/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerjaByKey(){
		$key = $this->input->get('term');
		$data = $this->M_pekerjalaju->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function simpan(){
		// echo"<pre>";print_r($_POST);exit();

		$data = array(
			'noind'				=> $this->input->post('slcNoindPekerjalaju'),
			'nama'				=> $this->input->post('txtNamaPekerjalaju'),
			'alamat'			=> $this->input->post('txtAlamatPekerjalaju'),
			'desa'				=> $this->input->post('txtDesaPekerjalaju'),
			'kecamatan'			=> $this->input->post('txtKecamatanPekerjalaju'),
			'kabupaten'			=> $this->input->post('txtKabupatenPekerjalaju'),
			'provinsi'			=> $this->input->post('txtProvinsiPekerjalaju'),
			'jenis_transportasi'=> implode(',', $this->input->post('slcjenisTransportasiPekerjalaju')),
			'user_input'		=> $this->session->user,
			'mulai_laju'		=> $this->input->post('txtMulaiLajuPekerjalaju'),
			'status_active'		=> $this->input->post('radStatusPekerjaLaju'),
			'latitude'			=> $this->input->post('txtLatitudePekerjaLaju'),
			'longitude'			=> $this->input->post('txtLongitudePekerjaLaju')
		);
		$query = $this->M_pekerjalaju->insertPekerjaLaju($data);

		$data_log = array(
			'log_user' => $this->session->user,
			'log_time' => date('Y-m-d H:i:s'),
			'log_aksi' => 'PEKERJA LAJU',
			'log_detail' => $query
		);
		$this->M_pekerjalaju->insertLog($data_log);

		redirect(base_url('AbsenPekerjaLaju/PekerjaLaju'));
	}

	public function getPekerjaDetailByNoind(){
		$noind = $this->input->get('noind');
		$data = $this->M_pekerjalaju->getPekerjaDetailByNoind($noind);
		echo json_encode($data);
	}

	public function Hapus($encrypted_id){
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$id = $this->encrypt->decode($id);

		$query = $this->M_pekerjalaju->deletePekerjaLajubyID($id);

		$data_log = array(
			'log_user' => $this->session->user,
			'log_time' => date('Y-m-d H:i:s'),
			'log_aksi' => 'PEKERJA LAJU',
			'log_detail' => $query
		);
		$this->M_pekerjalaju->insertLog($data_log);

		redirect(base_url('AbsenPekerjaLaju/PekerjaLaju'));
	}

	public function Edit($encrypted_id){
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$id = $this->encrypt->decode($id);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Laju';
		$data['Menu'] 			= 	'Pekerja Laju';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['transportasi'] = $this->M_pekerjalaju->getjenisTransportasi();
		$data['data'] = $this->M_pekerjalaju->getPekerjaLajuByID($id);
		$data['encrypted_id'] = $encrypted_id;
		if (!empty($data['data'])) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('AbsenPekerjaLaju/PekerjaLaju/V_edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			redirect(base_url('AbsenPekerjaLaju/PekerjaLaju'));
		}
	}

	public function update($encrypted_id){
		// echo"<pre>";print_r($_POST);exit();
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$id = $this->encrypt->decode($id);
		$status_active = $this->input->post('radStatusPekerjaLaju');
		$data_lama = $this->M_pekerjalaju->getPekerjaLajuByID($id);
		if ($data_lama->status_active == 't' && $status_active == '0') {
			$tgl_non_active = date('Y-m-d H:i:s').'';
		}else{
			$tgl_non_active = "9999-12-31 23:59:59";
		}

		$data = array(
			'noind'				=> $this->input->post('slcNoindPekerjalaju'),
			'nama'				=> $this->input->post('txtNamaPekerjalaju'),
			'alamat'			=> $this->input->post('txtAlamatPekerjalaju'),
			'desa'				=> $this->input->post('txtDesaPekerjalaju'),
			'kecamatan'			=> $this->input->post('txtKecamatanPekerjalaju'),
			'kabupaten'			=> $this->input->post('txtKabupatenPekerjalaju'),
			'provinsi'			=> $this->input->post('txtProvinsiPekerjalaju'),
			'jenis_transportasi'=> implode(',', $this->input->post('slcjenisTransportasiPekerjalaju')),
			'user_input'		=> $this->session->user,
			'mulai_laju'		=> $this->input->post('txtMulaiLajuPekerjalaju'),
			'status_active'		=> $status_active,
			'tgl_non_active'	=> $tgl_non_active,
			'latitude'			=> $this->input->post('txtLatitudePekerjaLaju'),
			'longitude'			=> $this->input->post('txtLongitudePekerjaLaju')
		);
		$query = $this->M_pekerjalaju->updatePekerjaLaju($data,$id);

		$data_log = array(
			'log_user' => $this->session->user,
			'log_time' => date('Y-m-d H:i:s'),
			'log_aksi' => 'PEKERJA LAJU',
			'log_detail' => $query
		);
		$this->M_pekerjalaju->insertLog($data_log);

		redirect(base_url('AbsenPekerjaLaju/PekerjaLaju'));
	}

}

?>