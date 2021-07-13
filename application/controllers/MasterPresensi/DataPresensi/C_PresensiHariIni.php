<?php 
defined('BASEPATH') or exit("No Direct Script Access Allowed");

/**
 * 
 */
class C_PresensiHariIni extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/DataPresensi/M_presensihariini');
		$this->checkSession();
	}

	function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Presensi Hari ini';
		$data['Header'] = 'Presensi Hari ini';
		$data['Menu'] = 'Data Presensi';
		$data['SubMenuOne'] = 'Presensi Hari ini';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_presensihariini->getPresensiHariIni();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail($params)
	{
		$data = $this->M_presensihariini->getPresensiDetail($params);
		echo json_encode($data);
	}
}
?>