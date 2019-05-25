<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class C_Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('EvaluasiTIMS/M_index');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = '';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputJenisPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jenis Penilaian';
		$data['SubMenuTwo'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Jenis_penilaian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function JenisPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jenis Penilaian';
		$data['SubMenuTwo'] = '';

		$data['listJp'] = $this->M_index->listJp();
      	// print_r($data['listJp']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Jenis_penilaian_list',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SubmitJenisPenilaian()
	{
		// print_r($_POST);exit();
		$this->checkSession();
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$jp = strtoupper($this->input->post('et_jenis_penilaian'));
		$data = array(
			'jenis_penilaian'	=>	$jp,
			'created_by'		=>	$noind,
			'created_date'		=>	date('Y-m-d H:i:s'),
			);
		$inputjp = $this->M_index->inputjp($data);
		if ($inputjp) {
			redirect('EvaluasiTIMS/Setup/JenisPenilaian');
		}
	}

	public function StandarPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Standar Penilaian';
		$data['SubMenuTwo'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Standar_penilaian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPenilaian()
	{
		$term = strtoupper($this->input->get('s'));
		// echo $term;exit();
		$listJp = $this->M_index->listJp2($term);

		echo json_encode($listJp);
	}
	public function getPenilaian2()
	{
		// print_r($_POST);exit();
		$term = $this->input->post('s');
		// echo $term;exit();
		$listJp = $this->M_index->listJp3($term);

		echo json_encode($listJp);
		// header('Content-Type: application/json');
	}

	public function SubmitStandarPenilaian()
	{
		$noind = $this->session->user;
		// print_r($_POST);exit();
		$id = $this->input->post('et_select_jp');
		$t = $this->input->post('et_input_t');
		$tim = $this->input->post('et_input_tim');
		$tims = $this->input->post('et_input_tims');
		$data = array(
			'std_t'		=>	$t,
			'std_tim'	=>	$tim,
			'std_tims'	=>	$tims,
			'last_update_date'	=>	date('Y-m-d H:i:s'),
			'last_update_by'	=>	$noind,
			);

		$updateJp = $this->M_index->updateJp($id, $data);
		if ($updateJp) {
			redirect('EvaluasiTIMS/Setup/JenisPenilaian');
		}
	}

	public function Harian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Harian';
		$data['Menu'] = 'TIMS Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$val = '0';
		$jb = array('jenis_penilaian'	=>	'');
		$a = '';
		$jp = '';
		$lh = $this->input->post('et_s_harian');
		if (!empty($lh)) {
			$jp = $this->M_index->listJp3($lh);
			$t = $jp[0]['std_t'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];
			// print_r($jp);exit();
			$val = '1';
			$a = array();
			$vali = $this->M_index->getVal();
			$listHarian = $this->M_index->listHarian($t, $tim, $tims, $vali);
			$listDept = array('KEUANGAN', 'PEMASARAN', 'PERSONALIA', 'PRODUKSI');
			$last_col = array_column($listHarian, 'count', 'dept');
			foreach ($listDept as $key) {
				if (array_key_exists($key, $last_col)) {
					$a[] = $last_col[$key];
				}else{
					$a[] = '0';
				}
			}
			
			// print_r($last_col);
			// print_r($a);exit();
		}
		$data['val'] = $val;
		// print_r($last_col);exit();
		$data['jumlah'] = $a;
		$data['jp'] = $jp;
		$data['idi'] = $lh;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_harian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function LihatHarian($a, $b)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Harian';
		$data['Menu'] = 'TIMS Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$vali = $this->M_index->getVal();
		if ($b == '1') {
			$b = 'KEUANGAN';
		}elseif ($b == '2') {
			$b = 'PEMASARAN';
		}elseif ($b == '3') {
			$b = 'PERSONALIA';
		}else{
			$b = 'PRODUKSI';
		}
		$jp = $this->M_index->listJp3($a);
			$t = $jp[0]['std_t'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];

		// print_r($jp);exit();
		$data['listLt'] = $this->M_index->listLt($b, $t, $tim, $tims, $vali);
		$data['jp'] = $jp[0]['jenis_penilaian'];
		$data['dept'] = $b;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_harian_lihat',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Bulanan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Bulanan';
		$data['Menu'] = 'TIMS Bulanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$pr = $this->input->post('et_periode');
		$jenisPenilaian = $this->input->post('et_jenis_jp');
		$val = '0';
		$data['jp'] = '';
		if (!empty($pr) || !empty($jenisPenilaian)) {
			$val = '1';
			$jp = $this->M_index->listJp3($jenisPenilaian);
			$t = $jp[0]['std_t'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];
			$data['jp'] = $jp[0]['jenis_penilaian'];
			$vali = $this->M_index->getVal();

			$tanggal = explode(' - ', $pr);
			$tgl1 = $tanggal[0];
			$tgl2 = $tanggal[1];
			$getlist = $this->M_index->listBl($tgl1, $tgl2, $t, $tim, $tims, $vali);
			// echo "<pre>"; print_r($getlist);exit();
			$data['listLt'] = $getlist;
		}
		$data['val'] = $val;
		$data['pr'] = $pr;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_bulanan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function LamaEvaluasi()
	{
		// print_r($_POST);exit();
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Lama Evaluasi';
		$data['SubMenuTwo'] = '';

		$val = $this->M_index->getVal();
		// echo $val;exit();
		$data['sesi'] =$val;
      	// print_r($data['sesi']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Lama_evaluasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputLamaEvaluasi()
	{
		// print_r($_POST);
		$val = $this->input->post('et_rd_le');
		$send = $this->M_index->saveLama($val);

		if ($send) {
			redirect('EvaluasiTIMS/Setup/LamaEvaluasi');
		}
		echo "error occurred";
	}
}