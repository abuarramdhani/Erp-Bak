<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_MP_Setting extends CI_Controller
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
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Setting/M_settingmpk');

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

	public function Seksi()
	{
		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Setting Seksi', 'Setting', 'Seksi', '');
		$data['seksi'] = $this->M_settingmpk->getSeksi();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Setting/V_Setting_Seksi',$data);
		$this->load->view('V_Footer',$data);
		$this->session->unset_userdata('sukses_mpk');
	}

	public function saveSeksi()
	{
		$user = $this->session->userdata('user');
		$noind_baru = $this->M_settingmpk->getNoindNew($user);
		$noind_baru = $noind_baru[0]['noind_baru'];

		$kodesie = $this->input->post('kodesie');
		$status = $this->input->post('status');
		$alasan = $this->input->post('alasan');

		if ($status == 1) {
			$st = "Aktif";
		}else{
			$st = "Tidak Aktif";
		}

		$arr = array(
			'flag' => $status,
			'alasan' => $alasan,
			'last_update_by' => $user,
			'last_action' => 'UPDATE',
			'last_action_date' => date('Y-m-d H:i:s'),
			);
		$up = $this->M_settingmpk->updateSeksi($arr, $kodesie);

		$log = $this->M_settingmpk->insertLog($kodesie, $user, $st, $noind_baru);
		$this->session->set_userdata('sukses_mpk', '1');
		redirect('MasterPekerja/Setting/Seksi');
	}
}