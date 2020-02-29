<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Pekerja extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManagementAdmin/M_pekerja');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Management Admin';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['table'] = $this->M_pekerja->getPekerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Master/V_pekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CariPekerja(){
		$noind = $this->input->get('term');
		$data = $this->M_pekerja->getEmployee($noind);
		echo json_encode($data);
	}

	public function CariNamaPekerja(){
		$id = $this->input->post('id');
		$data = $this->M_pekerja->getEmployeeName($id);
		echo $data['0']['employee_name'];
	}

	public function AddPekerja(){
		$arrData = array(
			'employee_id' => $this->input->post('id'),
			'noind' => $this->input->post('noind'),
			'nama_pekerja' => $this->input->post('nama'),
			'created_by' => $this->session->user
		);
		$this->M_pekerja->insertPekerja($arrData);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Menambah Data Pekerja ID='.$this->input->post('id');
		$this->log_activity->activity_log($aksi, $detail);
		//
		echo "sukses";
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_pekerja->deletePekerja($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Menghapus Data Pekerja ID='.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('ManagementAdmin/Pekerja'));
	}
}
?>
