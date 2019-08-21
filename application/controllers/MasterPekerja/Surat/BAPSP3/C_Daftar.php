<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_Daftar extends CI_Controller {

	function __construct() {
        parent::__construct();
		if(!$this->session->is_logged) { redirect('index'); }
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/BAPSP3/M_Daftar');
    }

    function index() {
		$data['UserMenu'] = $this->M_user->getUserMenu($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->session->userid, $this->session->responsibility_id);
        $data['Menu'] = $data['UserMenu'][1]['menu_title'];
		$data['Title'] = $data['UserSubMenuOne'][33]['menu_title'];
        $data['SubMenuOne'] = $data['UserSubMenuOne'][33]['menu_title'];
        $data['SubMenuTwo'] = '';
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/BAPSP3/V_Daftar', $data);
		$this->load->view('V_Footer', $data);
    }
}