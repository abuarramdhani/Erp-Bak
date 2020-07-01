<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Index extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PersonaliaApprovalAsska/M_personaliaapproveasska');

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

		$data['Title']			=	'Approval Atasan (Asska)';
		$data['Menu'] 			= 	'Lain-lain';
		$data['SubMenuOne'] 	= 	'Sebaran';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dashboard'] = array(); 

		// Laporan Lembur 
		$data['dashboard'][] = array(
			'ket' 		=> 'Laporan Lembur',
			'link'		=> 'Responsibility/2593',
			'jumlah' 	=> $this->M_personaliaapproveasska->getSPLOpenCountByNoind($user)
		); 

		// Rencana Lembur 
		$data['dashboard'][] = array(
			'ket' 		=> 'Rencana Lembur',
			'link'		=> 'RencanaLembur/ListRencanaLembur',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getRencanaLemburByNoindAtasan($user)
		); 

		// Perizinan Dinas 
		$data['dashboard'][] = array(
			'ket' 		=> 'Perizinan Dinas Pusat Tuksono Mlati',
			'link'		=> 'PerizinanDinas/AtasanApproval',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getPerizinanDInasByNoindAtasan($user)
		); 

		// Kaizen
		$data['dashboard'][] = array(
			'ket' 		=> 'Kaizen',
			'link'		=> 'SystemIntegration/KaizenGenerator/ApprovalKaizen/index',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getKaizenByNoindAtasan($user)
		); 

		// Absen Online
		$data['dashboard'][] = array(
			'ket' 		=> 'Absen Online',
			'link'		=> 'AbsenAtasan/List',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getAbsenOnlineByApprover($user)
		); 

		// Perizinan Pribadi
		$data['dashboard'][] = array(
			'ket' 		=> 'Perizinan Pribadi',
			'link'		=> 'IKP/ApprovalAtasan',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getPerizinanPribadi($user)
		); 

		// Tukar Shift
		$data['dashboard'][] = array(
			'ket' 		=> 'Tukar Shift',
			'link'		=> 'PolaShiftSeksi/Approval/ApprovalTukarShift',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getTukarShiftByApprover($user)
		); 

		// Import Shift
		$data['dashboard'][] = array(
			'ket' 		=> 'Import Shift',
			'link'		=> 'PolaShiftSeksi/Approval/ApprovalShift',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getImportShiftByAtasan($user)
		); 

		// Pengajuan Cuti
		$data['dashboard'][] = array(
			'ket' 		=> 'Pengajuan Cuti',
			'link'		=> 'PermohonanCuti',
			'jumlah' 	=> $this->M_personaliaapprovekasie->getCutiByApprover($user)
		); 

		usort($data['dashboard'], function($a, $b){
			return $a['jumlah'] < $b['jumlah'] ? 1 : -1;
		});

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PersonaliaApprovalAsska/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

}

?>