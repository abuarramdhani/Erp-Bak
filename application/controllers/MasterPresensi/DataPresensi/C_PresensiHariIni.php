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
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/DataPresensi/M_presensihariini');
		
	}

	function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Presensi Hari ini';
		$data['Header'] = 'Presensi Hari ini';
		$data['Menu'] = 'Data Presensi';
		$data['SubMenuOne'] = 'Presensi Hari ini';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_barcode'] = $this->M_presensihariini->getPresensiBarcodeHariIni();
		$data['data_wfh'] = $this->M_presensihariini->getPresensiWFHHariIni();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detailBarcode($params)
	{
		$data = $this->M_presensihariini->getPresensiBarcodeDetail($params);
		echo json_encode($data);
	}

	public function detailWfh($params)
	{
		$data = $this->M_presensihariini->getPresensiWfhDetail($params);
		echo json_encode($data);
	}

	public function Pusat()
	{
		$data['data_wfh'] = $this->M_presensihariini->getPresensiWFHHariIni();
		echo "page under maintenance";
		// $this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Pusat',$data);
	}

	public function Tuksono()
	{
		$data['data_wfh'] = $this->M_presensihariini->getPresensiWFHHariIni();
		echo "page under maintenance";
		// $this->load->view('MasterPresensi/DataPresensi/PresensiHariIni/V_Tuksono',$data);
	}

	public function updateData()
	{
		$data = $this->M_presensihariini->getPresensiWFHHariIni();
		$p_wfo 		= 0;
		$p_wfh		= 0;
		$p_off		= 0;
		$p_total	= 0;
		$p_fb_wfo	= 0;
		$p_fb_wfh	= 0;
		$p_fb_off	= 0;
		$p_nfb_wfo	= 0;
		$p_nfb_wfh	= 0;
		$p_nfb_off	= 0;
		$p_total	= 0;
		$t_wfo		= 0;
		$t_wfh		= 0;
		$t_off		= 0;
		$t_total	= 0;
		$t_fb_wfo	= 0;
		$t_fb_wfh	= 0;
		$t_fb_off	= 0;
		$t_nfb_wfo	= 0;
		$t_nfb_wfh	= 0;
		$t_nfb_off	= 0;
		$t_total	= 0;
		$waktu 		= date('Y-m-d H:i:s');
		
		if (isset($data) && !empty($data)) {
			foreach ($data as $key => $value) {
				if ($value['lokasi'] == "Pusat") {
					if ($value['jenis'] == "Fabrikasi") {
						$p_fb_wfo	= $value['jumlah_wfo'];
						$p_fb_wfh	= $value['jumlah_wfh'];
						$p_fb_off	= $value['jumlah_off'];
					}elseif($value['jenis'] = "Non Fabrikasi"){
						$p_nfb_wfo	= $value['jumlah_wfo'];
						$p_nfb_wfh	= $value['jumlah_wfh'];
						$p_nfb_off	= $value['jumlah_off'];
					}
				}elseif ($value['lokasi'] == "Tuksono") {
					if ($value['jenis'] == "Fabrikasi") {
						$t_fb_wfo	= $value['jumlah_wfo'];
						$t_fb_wfh	= $value['jumlah_wfh'];
						$t_fb_off	= $value['jumlah_off'];
					}elseif($value['jenis'] = "Non Fabrikasi"){
						$t_nfb_wfo	= $value['jumlah_wfo'];
						$t_nfb_wfh	= $value['jumlah_wfh'];
						$t_nfb_off	= $value['jumlah_off'];
					}
				}
			}
			$p_wfo		= $p_fb_wfo + $p_nfb_wfo;
			$p_wfh		= $p_fb_wfh + $p_nfb_wfh;
			$p_off		= $p_fb_off + $p_nfb_off;
			$p_total	= $p_wfo + $p_wfh + $p_off;

			$t_wfo		= $t_fb_wfo + $t_nfb_wfo;
			$t_wfh		= $t_fb_wfh + $t_nfb_wfh;
			$t_off		= $t_fb_off + $t_nfb_off;
			$t_total	= $t_wfo + $t_wfh + $t_off;
		}

		$result = array(
			'p_wfo'		=> $p_wfo,
			'p_wfh'		=> $p_wfh,
			'p_off'		=> $p_off,
			'p_ttl'		=> $p_total,
			'p_fb_wfo'	=> $p_fb_wfo,
			'p_fb_wfh'	=> $p_fb_wfh,
			'p_fb_off'	=> $p_fb_off,
			'p_nfb_wfo'	=> $p_nfb_wfo,
			'p_nfb_wfh'	=> $p_nfb_wfh,
			'p_nfb_off'	=> $p_nfb_off,
			'p_ttl'		=> $p_total,
			't_wfo'		=> $t_wfo,
			't_wfh'		=> $t_wfh,
			't_off'		=> $t_off,
			't_total'	=> $t_total,
			't_fb_wfo'	=> $t_fb_wfo,
			't_fb_wfh'	=> $t_fb_wfh,
			't_fb_off'	=> $t_fb_off,
			't_nfb_wfo'	=> $t_nfb_wfo,
			't_nfb_wfh'	=> $t_nfb_wfh,
			't_nfb_off'	=> $t_nfb_off,
			't_ttl'		=> $t_total,
			'waktu'		=> $waktu
		);
		echo json_encode($result);
	}
}
?>