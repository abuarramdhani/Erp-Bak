<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 *
 */
class C_RekapAbsen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Extra/M_rekapabsen');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Absen';
		$data['Menu'] = 'Extra';
		$data['SubMenuOne'] = 'Rekap Absen';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/LihatAbsen/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cari(){
		$tanggal = $this->input->post('tanggal');
		$shift = $this->input->post('shift_pesanan');
		$tempat = $this->input->post('tempat_makan');
		$user_id = $this->session->userid;

		$data['data'] = $this->M_rekapabsen->cari($tanggal,$shift,$tempat);

		$tgl1 = date('d/M/Y',strtotime($tanggal));
		$data['tanggalm'] = $tgl1;

		$data['Title'] = 'Rekap Absen';
		$data['Menu'] = 'Extra';
		$data['SubMenuOne'] = 'Rekap Absen';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/LihatAbsen/V_index.php',$data);
		$this->load->view('V_Footer',$data);

	}

}
?>
