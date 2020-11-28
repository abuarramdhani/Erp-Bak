<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*  
*/
class C_Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('M_Index');
		// $this->load->model('MonitoringKomponen/MainMenu/M_monitoring_seksi');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		// $this->load->model('PengembalianApd/M_papd');
		// $this->load->library('excel');
		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
		}
    }

	public function index()
	{
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		// $data['show'] = $this->M_outpart->getAllIn();
		// print_r($data['UserMenu']);
		// exit();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PengembanganSistem/V_Index', $data);
        $this->load->view('V_Footer', $data);
	}
}