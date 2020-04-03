<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Poliklinik extends CI_Controller
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
		$this->load->model('MasterPekerja/Poliklinik/M_poliklinik');

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
		redirect('');
	}

	public function InputData(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Input Data Poliklinik';
		$data['Menu'] 			= 	'Poliklinik';
		$data['SubMenuOne'] 	= 	'Input Data';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Poliklinik/V_input',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$key = $this->input->get('term');

		$data = $this->M_poliklinik->getPekerjaByKey($key);

		echo json_encode($data);
	}

	public function getKeterangan(){
		$key = $this->input->get('term');

		$data = $this->M_poliklinik->getKeteranganByKey($key);

		echo json_encode($data);
	}

	public function SaveData(){
		$user = $this->session->user;
		$data = array(
			'waktu_kunjungan' 	=> $this->input->post('txtPoliklinikTanggal'),
			'noind' 			=> $this->input->post('slcPoliklinikPekerja'),
			'created_by'		=> $user
		);

		$detail = $this->input->post('slcPoliklinikKeterangan');
		
		if (!empty($detail)) {
			$id = $this->M_poliklinik->insertKunjungan($data);
			foreach ($detail as $dtl) {
				$data_detail = array(
					'id_kunjungan' 	=> $id,
					'keterangan'	=> strtoupper($dtl),
					'created_by'	=> $user
				);
				$this->M_poliklinik->insertKunjunganDetail($data_detail);
			}

			$history = $this->M_poliklinik->getDataKunjunganById($id);
			$data_history = array(
				'action'	=> 'INSERT',
				'action_user'	=> $user,
				'id_kunjungan'	=> $history->id_kunjungan,
				'noind_sesudah'	=> $history->noind,
				'waktu_kunjungan_sesudah'	=> $history->waktu_kunjungan,
				'keterangan_sesudah'	=> $history->keterangan
			);
			$this->M_poliklinik->insertKunjunganHistory($data_history);
		}

		redirect(base_url('MasterPekerja/Poliklinik/ListData'));
	}

	public function ListData(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'List Data Poliklinik';
		$data['Menu'] 			= 	'Poliklinik';
		$data['SubMenuOne'] 	= 	'List Data';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_poliklinik->getDataKunjunganAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Poliklinik/V_list',$data);
		$this->load->view('V_Footer',$data);
	}

	public function EditData($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Edit Data Poliklinik';
		$data['Menu'] 			= 	'Poliklinik';
		$data['SubMenuOne'] 	= 	'List Data';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_poliklinik->getDataKunjunganById($plaintext_string);
		$data['enkripsi'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Poliklinik/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function UpdateData($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user = $this->session->user;
		$data = array(
			'waktu_kunjungan' 	=> $this->input->post('txtPoliklinikTanggal'),
			'noind' 			=> $this->input->post('slcPoliklinikPekerja')
		);

		$detail = $this->input->post('slcPoliklinikKeterangan');
		
		if (!empty($detail)) {
			$history = $this->M_poliklinik->getDataKunjunganById($plaintext_string);
			$data_history = array(
				'action'	=> 'UPDATE',
				'action_user'	=> $user,
				'id_kunjungan'	=> $history->id_kunjungan,
				'noind_sebelum'	=> $history->noind,
				'waktu_kunjungan_sebelum'	=> $history->waktu_kunjungan,
				'keterangan_sebelum'	=> $history->keterangan
			);

			$this->M_poliklinik->updateKunjunganById($data,$plaintext_string);
			$this->M_poliklinik->deleteKunjunganDetailByIdKunjungan($plaintext_string);
			foreach ($detail as $dtl) {
				$data_detail = array(
					'id_kunjungan' 	=> $plaintext_string,
					'keterangan'	=> strtoupper($dtl),
					'created_by'	=> $user
				);
				$this->M_poliklinik->insertKunjunganDetail($data_detail);
			}

			$history = $this->M_poliklinik->getDataKunjunganById($plaintext_string);
			$data_history['noind_sesudah'] = $history->noind;
			$data_history['waktu_kunjungan_sesudah'] = $history->waktu_kunjungan;
			$data_history['keterangan_sesudah'] = $history->keterangan;
			$this->M_poliklinik->insertKunjunganHistory($data_history);
		}

		redirect(base_url('MasterPekerja/Poliklinik/ListData'));
	}

	public function HapusData($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user = $this->session->user;
		$history = $this->M_poliklinik->getDataKunjunganById($plaintext_string);
		$data_history = array(
			'action'	=> 'DELETE',
			'action_user'	=> $user,
			'id_kunjungan'	=> $history->id_kunjungan,
			'noind_sebelum'	=> $history->noind,
			'waktu_kunjungan_sebelum'	=> $history->waktu_kunjungan,
			'keterangan_sebelum'	=> $history->keterangan
		);
		$this->M_poliklinik->insertKunjunganHistory($data_history);

		$this->M_poliklinik->deleteKunjunganById($plaintext_string);
		$this->M_poliklinik->deleteKunjunganDetailByIdKunjungan($plaintext_string);

		redirect(base_url('MasterPekerja/Poliklinik/ListData'));
	}

}

?>