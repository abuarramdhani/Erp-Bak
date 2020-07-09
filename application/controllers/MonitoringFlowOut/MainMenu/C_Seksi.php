<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_Seksi extends CI_Controller
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
		$this->load->model('MonitoringFlowOut/M_master');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Seksi';
		$data['Menu'] = 'Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['seksi'] = $this->M_master->getSeksi(); //Menampilkan

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Master/V_Seksi', $data);
		$this->load->view('V_Footer', $data);
	}
	function setSeksi() //Tambah
	{
		$newNama = $this->input->post('createNamaSeksi');
		$this->M_master->setSeksi($newNama);
		redirect(base_url('MonitoringFlowOut/Seksi'));
	}

	function delSeksi($id) //Delete
	{
		$this->M_master->delSeksi($id);
		echo 1;
	}

	function updSeksi() //Edit
	{
		$id = $this->input->post('id');
		$newNama = $this->input->post('newNama');
		$this->M_master->updSeksi($id, $newNama);
		echo 1;
	}
	function onlySeksi()
	{
		$term = $_POST['term'];
		echo json_encode($this->M_master->onlySeksi($term));
	}
}
