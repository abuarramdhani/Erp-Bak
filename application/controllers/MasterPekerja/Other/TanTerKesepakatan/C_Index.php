<?php defined('BASEPATH') or die('No direct script access allowed');

class C_Index extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('Log_Activity');
		$this->load->library('session');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Other/TanTerKesepakatan/M_TanTerKesepakatan');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession() {
		if(!$this->session->is_logged) redirect('');
	}

	/* LIST DATA */
	public function index() {
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Tanda Terima Kesepakatan';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Tanda Terima Kesepakatan Kerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_TanTerKesepakatan->getData();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/TanTerKesepakatan/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	// page
	public function record() {
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Tanda Terima Kesepakatan';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Tanda Terima Kesepakatan Kerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// if post tanggal then search by tanggal, if tanggal nulll, search all
		$tanggal = $this->input->get('tanggal');

		$data['data'] = $this->M_TanTerKesepakatan->getDataRecord($tanggal);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Other/TanTerKesepakatan/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	function delete_all() {
		$this->M_TanTerKesepakatan->deleteAll();
		redirect(base_url('MasterPekerja/TanTerKesepakatan'));
	}

	function delete($id) {
		// decode
		$parse_id = base64_decode(hex2bin($id));
		$this->M_TanTerKesepakatan->deleteById($parse_id);
		redirect(base_url('MasterPekerja/TanTerKesepakatan'));
	}

	function insert() {
		$noind = $this->input->post('tt_noind');

		if(!$noind) return redirect(base_url('MasterPekerja/TanTerKesepakatan'));

		$personal= $this->M_TanTerKesepakatan->getPersonal($noind);
		if(!$personal) return 'failed';

		$tanggal_masuk = $this->M_TanTerKesepakatan->getTanggalMasuk($noind);

		$data = array(
			'noind' => $personal->noind,
			'nama' => $personal->nama,
			'seksi' => $personal->seksi,
			'tgl_masuk' => $tanggal_masuk,
			'lokasi' => $personal->lokasi_kerja,
			'created_user' => $this->session->user,
		);

		$personal= $this->M_TanTerKesepakatan->insert($data);
		redirect(base_url('MasterPekerja/TanTerKesepakatan'));
	}

	function excel() {
		$this->load->library('Excel');

		$data['print_time'] = date('d-m-Y H:i:s');
		$data['print_by']	= $this->session->user; 
		$data['data'] = $this->M_TanTerKesepakatan->getDataExport();
		$this->load->view('MasterPekerja/Other/TanTerKesepakatan/V_Excel', $data);
	}
}