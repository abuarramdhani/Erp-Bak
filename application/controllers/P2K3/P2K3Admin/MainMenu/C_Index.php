<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('ciqrcode');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3/P2K3Admin/M_dtmasuk');
		$this->load->model('P2K3/MainMenu/M_order');
		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){
		} else {
			redirect('index');
		}
	}

	public function standar()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$noind = $this->session->user;
		$ks = $this->input->post('k3_adm_ks');
		if (empty($ks)) {
			$ks = $kodesie;
		}
		$baru = '1999-01-01 01:10:10';
		$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
		if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
			$baru = $cek_terbaru[0]['tgl_approve_tim'];
		}
		$data['list'] = $this->M_dtmasuk->getListAprove($ks, $baru);
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['seksi'] = '';
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/P2K3Admin/APD/V_Admin_Standar', $data);
		$this->load->view('V_Footer',$data);
	}

	public function order()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['Title'] = 'Kebutuhan APD';
		$data['Menu'] = 'Kebutuhan APD';
		$data['SubMenuOne'] = 'Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$ks = $this->input->post('k3_adm_ks');
		$m = substr($pr, 0,2);
		$y = substr($pr, 5,5);
		$periode = $pr;
		$pr = $y.'-'.$m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		$data['pr'] = $periode;


		$data['listtobon'] = $this->M_dtmasuk->listtobon($ks, $pr);
		$jml = '';
		// echo "<pre>";
		// print_r($data['listtobon']);exit();
		foreach ($data['listtobon'] as $key) {
			$a = $key['jml_item'];
			$b = $key['jml_pekerja'];
			$a = explode(',', $a);
			$b = explode(',', $b);
			$hit = count($a);
			for ($i=0; $i < $hit; $i++) {
				$jml += ($a[$i]*$b[$i]);
			}
			$push = array("total"=> $jml);
			array_splice($key,4,1,$push);
			$new[] = $key;
			$data['listtobon'] = $new;
			$jml = 0;
		}
		// echo "<pre>";
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		if (empty($data['seksi'])) {
			$data['seksi'] = array('section_name' 	=>	'');
		}
		// print_r($data['seksi']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/P2K3Admin/APD/V_Admin_Order', $data);
		$this->load->view('V_Footer',$data);
	}

	public function perhitungan()
	{
		// print_r($_POST);exit();
		// echo "<pre>";
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$val = $this->input->post('validasi');
		$m = substr($pr, 0,2);
		$y = substr($pr, 5,5);
		$periode = $pr;
		$pr = $y.'-'.$m;
		if (strlen($pr) < 3) {
			$pr = date('Y-m');
			$periode = date('m - Y',  strtotime(" +1 months"));
		}
		$data['toHitung']= '';
		$data['run'] = '0';
		$data['pr'] = $periode;
		if ($val == 'hitung') {
			$data['toHitung'] = $this->M_dtmasuk->toHitung($pr);
			foreach ($data['toHitung'] as $key) {
				$a = $key['ttl_kebutuhan'];
				$b = $key['ttl_bon'];
				$out = ($a-$b);
				$push = array("total"=> $out);
				array_splice($key,5,1,$push);
				$new[] = $key;
				$data['toHitung'] = $new;
			}
			$data['run'] = '1';
		}
		// print_r($data['toHitung']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/P2K3Admin/APD/V_Admin_Perhitungan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function monitoring()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$m = substr($pr, 0,2);
		$y = substr($pr, 5,5);
		$periode = $pr;
		$pr = $y.'-'.$m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		$data['pr'] = $periode;

		$noind = $this->session->user;
		$data['listOrder'] = $this->M_dtmasuk->getOrder($pr);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/P2K3Admin/APD/V_Admin_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function inputBon()
	{
		// print_r($_POST);exit();
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$ks = $this->input->post('k3_adm_ks');
		$m = substr($pr, 0,2);
		$y = substr($pr, 5,5);
		$periode = $pr;
		$pr = $y.'-'.$m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		$data['pr'] = $periode;
		$data['ks'] = $ks;
		$data['pri'] = $pr;
		$data['listtobon'] = $this->M_dtmasuk->listtobon($ks, $pr);
		$jml = '';
		// echo "<pre>";
		// print_r($data['listtobon']);exit();
		foreach ($data['listtobon'] as $key) {
			$a = $key['jml_item'];
			$b = $key['jml_pekerja'];
			$a = explode(',', $a);
			$b = explode(',', $b);
			$hit = count($a);
			for ($i=0; $i < $hit; $i++) {
				$jml += ($a[$i]*$b[$i]);
			}
			$push = array("total"=> $jml);
			array_splice($key,4,1,$push);
			$new[] = $key;
			$data['listtobon'] = $new;
			$jml = 0;
		}
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		if (empty($data['seksi'])) {
			$data['seksi'] = array('section_name' 	=>	'');
		}
		// print_r($new);
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/P2K3Admin/APD/V_Admin_Bon', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getSeksiAprove()
	{
		$item = $_GET['s'];
		$item = strtoupper($item);
		$data = $this->M_dtmasuk->getSeksiApprove($item);
		echo json_encode($data);
	}

	public function submitBon()
	{
		// print_r($_POST);exit();
		$tgl = date('Y-m-d H:i:s');
		$noind = $this->session->user;
		$apd = $this->input->post('p2k3_apd');
		$bon = $this->input->post('p2k3_jmlBon');
		$pr = $this->input->post('p2k3_pr');
		$ks = $this->input->post('p2k3_ks');
		$jml_k = $this->input->post('p2k3_jmlKebutuhan');
		$sisa_saldo = $this->input->post('p2k3_sisaSaldo');

		for ($i=0; $i < count($apd); $i++) {
			$data = array(
				'periode'	=>	$pr,
				'kodesie'	=>	$ks,
				'tgl_bon'	=>	$tgl,
				'item_code'	=>	$apd[$i],
				'jml_bon'	=>	$bon[$i],
				'input_by'	=>	$noind,
				'jml_kebutuhan'	=>	$jml_k[$i],
				'sisa_saldo'	=>	$sisa_saldo[$i],
				);
			$input = $this->M_dtmasuk->insertBon($data);
			//insert to sys.t_log_activity
			$aksi = 'P2K3';
			$detail = "Submit Bon Periode=$pr item=".$apd[$i];
			$this->log_activity->activity_log($aksi, $detail);
			//
		}
		redirect('p2k3adm/Admin/inputBon');
	}

	public function hitung()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$m = substr($pr, 0,2);
		$y = substr($pr, 5,5);
		$periode = $pr;
		$pr = $y.'-'.$m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		$data['pr'] = $periode;
		$run = '0';
		$jml = '';
		$validasi = $this->input->post('validasi');
		if ($validasi == 'hitung') {
			$delPeriode = $this->M_dtmasuk->delPeriode($pr);
			$list = array();
			$data['allKs'] = $this->M_dtmasuk->allKs($pr);
			foreach ($data['allKs'] as $key) {
				$record = $this->M_dtmasuk->getlistHitung($pr, $key['kodesie']);
				$new = array();
				foreach ($record as $row) {
					$a = $row['jml_item'];
					$b = $row['jml_pekerja'];
					$a = explode(',', $a);
					$b = explode(',', $b);
					$hit = count($a);
					for ($i=0; $i < $hit; $i++) {
						$jml += ($a[$i]*$b[$i]);
					}
					$push = array("total"=> $jml);
					array_splice($row,3,1,$push);
					$new[] = $row;

					$item = array(
						'periode'	=>	$pr,
						'item_kode'	=>	$row['kode_item'],
						'kodesie'	=>	$row['kodesie'],
						'jml_kebutuhan'	=>	$jml,
						);
					$inpHitung = $this->M_dtmasuk->inpHitung($item);
					$jml = 0;
				}
				$list[] = $new;
			}
			$data['listHitung'] = $list;
			// echo "<pre>";
			// print_r($data['listHitung']);
			// exit();
			$run = '1';
		}
		$data['run'] = $run;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3/P2K3Admin/APD/V_Admin_Hitung', $data);
		$this->load->view('V_Footer',$data);
	}
}
