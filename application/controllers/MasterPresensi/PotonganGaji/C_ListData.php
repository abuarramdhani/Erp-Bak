<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_ListData extends CI_Controller {

	function __construct() {
		parent::__construct();
        if(!$this->session->is_logged){ redirect(''); }
		$this->load->library('Log_Activity');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/PotonganGaji/M_listdata');
    }

	public function index() {
		$data['UserMenu'] = $this->M_user->getUserMenu($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->session->userid, $this->session->responsibility_id);
        $data['Title'] = 'List Data Potongan';
		$data['Menu'] = $data['SubMenuOne'] = $data['SubMenuTwo'] = null;
		$data['list'] = $this->M_listdata->getList();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPresensi/PotonganGaji/V_ListData', $data);
		$this->load->view('V_Footer', $data);
	}

	public function deleteData() {
		//insert to t_log
		$aksi = 'MASTER PRESENSI';
		$detail = 'Delete Potongan Gaji ID='.$this->input->post('id');
		$this->log_activity->activity_log($aksi, $detail);
		//
		echo json_encode($this->M_listdata->deleteData($this->input->post('id')));
	}
}
