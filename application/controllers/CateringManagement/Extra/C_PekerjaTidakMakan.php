<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PekerjaTidakMakan extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_pekerjatidakmakan');
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

		$data['Title']			=	'List Pekerja Tidak Makan';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Menu';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_pekerjatidakmakan->getPekerjaTidakMakanAll();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PekerjaTidakMakan/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Tidak Makan';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Menu';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PekerjaTidakMakan/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$key = $this->input->get('term');
		$data = $this->M_pekerjatidakmakan->getpekerjaByKey($key);
		echo json_encode($data);
	}

	public function simpan(){
		$pekerja = $this->input->post('pekerja');
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		$keterangan = $this->input->post('keterangan');
		$permintaan_id = $this->input->post('permintaan_id');

		if ($permintaan_id !== "0") {
			$data_update = array(
				'dari' => $tanggal_awal,
				'sampai' => $tanggal_akhir,
				'keterangan' => $keterangan,
				'updated_by' => $this->session->user,
				'updated_date' => date('Y-m-d H:i:s')
			);
			$this->M_pekerjatidakmakan->updatePekerjaTidakMakanById($data_update,$permintaan_id);
		}else{
			$data_insert = array(
				'pekerja' => $pekerja,
				'dari' => $tanggal_awal,
				'sampai' => $tanggal_akhir,
				'keterangan' => $keterangan,
				'created_by' => $this->session->user,
				'created_date' => date('Y-m-d H:i:s')
			);
			$this->M_pekerjatidakmakan->insertPekerjaTidakMakan($data_insert);
		}

	}

	public function edit(){
		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Tidak Makan';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Menu';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_pekerjatidakmakan->getPekerjaTidakMakanById($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PekerjaTidakMakan/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function hapus(){
		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_pekerjatidakmakan->deletePekerjaTidakMakanById($plaintext_string);

		$data_awal = $this->M_pekerjatidakmakan->getPekerjaTidakMakanAll();
		$data_akhir = array();
		foreach ($data_awal as $key => $value) {
			$encrypted_string = $this->encrypt->encode($value['permintaan_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$data_akhir[$key]['action'] = "<a href=\"".base_url('CateringManagement/Extra/PekerjaTidakMakan/edit?id='.$encrypted_string)."\" class=\"btn btn-info\"><span class=\"fa fa-pencil-square-o\"></span> Edit</a>
					<button type=\"button\" class=\"btn btn-danger btn-CM-PekerjaTidakMakan-Delete\" data-id=\"".$encrypted_string."\"><span class=\"fa fa-trash\"></span> Hapus</button>";
			$data_akhir[$key]['pekerja'] = $value['pekerja'].' - '.$value['nama'];
			$data_akhir[$key]['dari'] = date('d M Y',strtotime($value['dari']));
			$data_akhir[$key]['sampai'] = date('d M Y',strtotime($value['sampai']));
			$data_akhir[$key]['keterangan'] = $value['keterangan'];
			
		}
		echo json_encode($data_akhir);
	}

} ?>