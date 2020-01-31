<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);

class C_PekerjaKhusus extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_pekerjakhusus');
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

		$data['Title']			=	'Komponen Gaji Pekerja Khusus';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Penggajian';
		$data['SubMenuTwo'] 	= 	'Komponen Pekerja Khusus';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['data'] = $this->M_pekerjakhusus->getPekerjaKhususAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaKhusus/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function insert(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Komponen Gaji Pekerja Khusus';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Penggajian';
		$data['SubMenuTwo'] 	= 	'Komponen Pekerja Khusus';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['formula'] = $this->M_pekerjakhusus->getFormulaAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaKhusus/V_insert',$data);
		$this->load->view('V_Footer',$data);
	}

	public function searchActiveEmployees(){
		$key = $this->input->get('term');
		$data = $this->M_pekerjakhusus->getEmployeeByParams($key);
		echo json_encode($data);
	}

	public function save(){
		$noind = $this->input->post('slcKhususNoind');
		$noind_baru = $this->M_pekerjakhusus->getNoindBaru($noind);
		$data = array(
			'noind' 		=> $this->input->post('slcKhususNoind'),
			'noind_baru' 	=> $noind_baru,
			'xgp' 			=> $this->input->post('txtKhususGP'),
			'xip' 			=> $this->input->post('txtKhususIP'),
			'xif' 			=> $this->input->post('txtKhususIF'),
			'ubt' 			=> $this->input->post('txtKhususUBT'),
			'xik' 			=> $this->input->post('txtKhususIK'),
			'upamk' 		=> $this->input->post('txtKhususUPAMK'),
			'xum' 			=> $this->input->post('txtKhususUM'),
			'ims' 			=> $this->input->post('txtKhususIMS'),
			'imm' 			=> $this->input->post('txtKhususIMM'),
			'ipt' 			=> $this->input->post('txtKhususIPT'),
			'lembur' 		=> $this->input->post('txtKhususLembur'),
			'cuti' 			=> $this->input->post('txtKhususCUTI'),
			'formula_id' 	=> $this->input->post('slckhususFormula'),
			'info' 			=> $this->input->post('txtKhususInfo'),
			'khusus' 		=> $this->input->post('txtKhususKhusus'),
			'umc'			=> $this->input->post('txtKhususUMC')
		);
		
		$this->M_pekerjakhusus->savePekerjaKhusus($data);
		redirect(site_url('MasterPresensi/ReffGaji/PekerjaKhusus'));
	}

	public function delete($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
 		$decrypted_String = $this->encrypt->decode($decrypted_String);
 		$txt = explode("-", $decrypted_String);
 		$noind_baru = $txt['0'];
 		$noind = $txt['1'];
 		$this->M_pekerjakhusus->deletePekerjaKhusus($noind,$noind_baru);
 		redirect(site_url('MasterPresensi/ReffGaji/PekerjaKhusus'));
	}

	public function edit($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
 		$decrypted_String = $this->encrypt->decode($decrypted_String);
 		$txt = explode("-", $decrypted_String);
 		$noind_baru = $txt['0'];
 		$noind = $txt['1'];

 		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Komponen Gaji Pekerja Khusus';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Penggajian';
		$data['SubMenuTwo'] 	= 	'Komponen Pekerja Khusus';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['encrypted_string'] = $id;
		$data['user'] = $this->session->user;
		$data['formula'] = $this->M_pekerjakhusus->getFormulaAll();
		$data['data'] = $this->M_pekerjakhusus->getPekerjaKhususByNoind($noind,$noind_baru);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaKhusus/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
 		$decrypted_String = $this->encrypt->decode($decrypted_String);
 		$txt = explode("-", $decrypted_String);
 		$noind_baru = $txt['0'];
 		$noind = $txt['1'];

 		$data = array(
			'xgp' 			=> $this->input->post('txtKhususGP'),
			'xip' 			=> $this->input->post('txtKhususIP'),
			'xif' 			=> $this->input->post('txtKhususIF'),
			'ubt' 			=> $this->input->post('txtKhususUBT'),
			'xik' 			=> $this->input->post('txtKhususIK'),
			'upamk' 		=> $this->input->post('txtKhususUPAMK'),
			'xum' 			=> $this->input->post('txtKhususUM'),
			'ims' 			=> $this->input->post('txtKhususIMS'),
			'imm' 			=> $this->input->post('txtKhususIMM'),
			'ipt' 			=> $this->input->post('txtKhususIPT'),
			'lembur' 		=> $this->input->post('txtKhususLembur'),
			'cuti' 			=> $this->input->post('txtKhususCUTI'),
			'formula_id' 	=> $this->input->post('slckhususFormula'),
			'info' 			=> $this->input->post('txtKhususInfo'),
			'khusus' 		=> $this->input->post('txtKhususKhusus'),
			'umc'			=> $this->input->post('txtKhususUMC')
		);

		// echo $noind.'-'.$noind_baru."<pre>";print_r($data);exit();

		$this->M_pekerjakhusus->updatePekerjaKhusus($noind,$noind_baru,$data);

		redirect(site_url('MasterPresensi/ReffGaji/PekerjaKhusus'));
	}

}
?>