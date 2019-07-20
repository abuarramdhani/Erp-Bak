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
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('ciqrcode');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3V2/P2K3Admin/M_dtmasuk');
		$this->load->model('P2K3V2/MainMenu/M_order');
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

		$data['Title'] = 'Kebutuhan APD';
		$data['Menu'] = 'Kebutuhan APD';
		$data['SubMenuOne'] = 'Standar';
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
		// echo "<pre>";
		// print_r($data['list']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Standar', $data);
		$this->load->view('V_Footer',$data);
	}

	public function order()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;

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
			$ks = $kodesie;
		}
		$data['pr'] = $periode;
		if ($ks == 'semua') {
			$ks = '';
		}

		
			$data['listtobon'] = $this->M_dtmasuk->listtobon2($ks, $pr);
		$jml = '';
		// echo "<pre>";
		// print_r($data['listtobon']);exit();
		// foreach ($data['listtobon'] as $key) {
		// 	$a = $key['jml_item'];
		// 	$b = $key['jml_pekerja'];
		// 	$c = $key['jml_kebutuhan_umum'];
		// 	$d = $key['jml_kebutuhan_staff'];
		// 	$e = $key['jml_pekerja_staff'];
		// 	$a = explode(',', $a);
		// 	print_r($a);
		// 	$b = explode(',', $b);
		// 	$hit = count($a);
		// 	for ($i=0; $i < $hit; $i++) { 
		// 		$jml += ($a[$i]*$b[$i]); 
		// 	}
		// 	$jml = $jml+$c+($d*$e);
		// 	$push = array("total"=> $jml);
		// 	array_splice($key,4,1,$push);
		// 	$new[] = $key;
		// 	$data['listtobon'] = $new;
		// 	$jml = 0;
		// }
		// echo "<pre>";
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		if (empty($data['seksi'])) {
			$data['seksi'] = array('section_name' 	=>	'');
			$data['seksi'] = array('0' 	=>	$data['seksi']);
		}
		if ($ks == '') {
			$data['seksi'] = array('section_name' 	=>	'SEMUA SEKSI');
			$data['seksi'] = array('0' 	=>	$data['seksi']);
		}
		// print_r($data['listtobon']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Order', $data);
		$this->load->view('V_Footer',$data);
	}

	public function perhitungan()
	{
		// print_r($_POST);exit();
		// echo "<pre>";
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Perhitungan APD';
		$data['Menu'] = 'Perhitungan APD';
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
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Perhitungan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function monitoring()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring APD';
		$data['Menu'] = 'Monitoring APD';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$sub = $this->input->post('p2k3_admin_monitor');

		$m = substr($pr, 0,2);
		$y = substr($pr, 5,5);
		$periode = $pr;
		$pr = $y.'-'.$m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		if (empty($sub)) {
			$sub = '0';
		}
		$data['pr'] = $periode;

		$noind = $this->session->user;
		$data['listOrder'] = $this->M_dtmasuk->getOrder($pr);
		// print_r($data['listOrder']);exit();
		$data['jumlah'] = $this->M_dtmasuk->getjmlSeksi();
		$data['jumlahDepan'] = $this->M_dtmasuk->getjmlSeksiDepan($pr);
		$data['sub'] = $sub;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Monitoring', $data);
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

		$ks = $this->input->post('k3_adm_ks');
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
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Bon', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getSeksiAprove()
	{
		$item = $_GET['s'];
		$item = strtoupper($item);
		$data = $this->M_dtmasuk->getSeksiApprove($item);
		echo json_encode($data);
	}
	public function getSeksiAprove2()
	{
		$item = '';
		$item = strtoupper($item);
		$data = $this->M_dtmasuk->getSeksiApprove2($item);
		// echo json_encode($data);
		// echo '<option></option>';
		echo '<option selected value="semua">SEMUA SEKSI</option>';
		foreach ($data as $key) {
			echo '<option value="'.$key['substring'].'">'.$key['substring'].' - '.$key['section_name'].'</option>';
		}
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
		}
		redirect('p2k3adm_V2/Admin/inputBon');
	}

	public function hitung()
	{
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
			// echo "<pre>";
			// print_r($data['allKs']);exit();
			foreach ($data['allKs'] as $key) {
				$record = $this->M_dtmasuk->getlistHitung($pr, $key['kodesie']);
				// echo "<br>";print_r($key['kodesie']);echo "<br>";
				$new = array();
				foreach ($record as $row) {
					$a = $row['jml_item'];
					// echo $a;
					// echo "<br>";
					// echo $row['kode_item'];
					$b = $row['jml_pekerja'];
					$c = $row['jml_kebutuhan_umum'];
					$d = $row['jml_kebutuhan_staff'];
					$e = $row['jml_pekerja_staff'];
					$a = explode(',', $a);
					$b = explode(',', $b);
					$hit = count($a);
					for ($i=0; $i < $hit; $i++) { 
						$jml += ($a[$i]*$b[$i]); 
					}
					// echo "<br>";
					// echo $row['kode_item'].'=';
					// echo $jml.'-'.$c.'-'.$d.'-'.$e;
					$jml = ceil($jml+$c+($d*$e));
					// echo "___".$jml;
					$push = array("total"=> $jml);
					array_splice($row,4,1,$push);
					$new[] = $row;
					// print_r($new);exit();

					$item = array(
						'periode'	=>	$pr,
						'item_kode'	=>	$row['kode_item'],
						'kodesie'	=>	$row['kodesie'],
						'jml_kebutuhan'	=>	$jml,
						);
				// echo "<pre>";print_r($record);exit();
					$inpHitung = $this->M_dtmasuk->inpHitung($item);
					$jml = 0;
					// print_r($record);exit();
				}
				$list[] = $new;
			}
			// exit();
			$data['listHitung'] = $list;
			// echo "<pre>";
			// print_r($data['listHitung']);
			// exit();
			$run = '1';
		}
		$data['run'] = $run;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Hitung', $data);
		$this->load->view('V_Footer',$data);
	}

	public function inputStandarTIM()
	{
		// print_r($_POST);exit();
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;

		$data['Title'] = 'Input Standar Kebutuhan Seksi';
		$data['Menu'] = 'Input Standar Kebutuhan Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$act = '0';
		$ks = $this->input->post('k3_adm_ks');
		if (!empty($ks)) {
			$act = '1';
		}
		if (empty($ks)) {
			$ks = $kodesie;
		}
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['act'] = $act;
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		$data['kodesie'] = $ks;
		// print_r($data['seksi']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Input_Standar_TIM', $data);
		$this->load->view('V_Footer',$data);
	}

	public function inputOrderTIM()
	{
		// print_r($_POST);exit();
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;

		$data['Title'] = 'Input Order Seksi';
		$data['Menu'] = 'Input Order Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$act = '0';
		$ks = $this->input->post('k3_adm_ks');
		if (!empty($ks)) {
			$act = '1';
			$pr = date("Y-m", strtotime(" +1 months"));
			$cek = $this->M_order->cekOrder($ks, $pr);
			if ($cek > 0) {
				$act = '2';
			}
		}
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['act'] = $act;
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		$data['kodesie'] = $ks;
		$data['max_pekerja']	= 	count($this->M_order->maxPekerja($ks));
		// print_r($data['max_pekerja']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Input_Order_TIM', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveInputStandar()
	{
		$noind = $this->session->user;
		// $kodesie = $this->session->kodesie;
		$kodesie = $this->input->post('p2k3_adm_kodesie');
		$daftar_pekerjaan	= $this->M_order->daftar_pekerjaan($kodesie);
		$item = $this->input->post('txtKodeItem');
		$umum = $this->input->post('txtkebUmum');
		$staff = $this->input->post('txtkebStaff');
		$jumlah = $this->input->post('p2k3_isk_standar');
		$tgl_input = date('Y-m-d H:i:s');

		// implode kdpekerjaan
		foreach ($daftar_pekerjaan as $key) {
			$kd[] = $key['kdpekerjaan'];
		}
		$kd_pkj = implode(',', $kd);

		//implode jumlah
		$a = 0;
		for ($i=0; $i < count($item); $i++) {
			$getbulan = $this->M_dtmasuk->getBulan($item[$i]);
			for ($x=$a; $x < (count($daftar_pekerjaan)*($i+1)); $x++) { 
				$jml[$i][] = (round($jumlah[$x]/$getbulan,2));
			}

			$itemUmum = (round($umum[$i]/$getbulan,2));
			$itemStaf = (round($staff[$i]/$getbulan,2));
			$data = array(
				'kode_item'	=>	$item[$i],
				'kd_pekerjaan'	=> $kd_pkj,
				'jml_item'	=>	implode(',', $jml[$i]),
				'kodesie'	=>	$kodesie,
				'tgl_input'	=>	$tgl_input,
				'status'	=>	'3',
				'tgl_approve'	=>	$tgl_input,
				'tgl_approve_tim'	=>	$tgl_input,
				'approve_by'	=>	$noind,
				'approve_tim_by'	=>	$noind,
				'jml_kebutuhan_umum'	=>	$itemUmum,
				'jml_kebutuhan_staff'	=>	$itemStaf,
				);
			$a += count($daftar_pekerjaan);
			// echo "<pre>";
			// print_r($data);
			// echo "<br>";exit();
			$input = $this->M_order->save_standar($data);
		}
		// exit();
		redirect('p2k3adm_V2/Admin/inputStandarTIM');
	}

	public function saveInputOrder()
	{
		$noind = $this->session->user;
		$kodesie  = $this->input->post('p2k3_adm_kodesie');
		$daftar_pekerjaan	= $this->M_order->daftar_pekerjaan($kodesie);
      	$jml = $this->input->post('pkjJumlah');
      	$staff = $this->input->post('staffJumlah');
      	$periode = $this->input->post('k3_periode');
		// print_r($_POST); print_r($daftar_pekerjaan);exit();

      	foreach ($daftar_pekerjaan as $key) {
      		$kd[] = $key['kdpekerjaan'];
      	}
      	$kd_pkj = implode(',', $kd);
      	$jml_pkj = implode(',', $jml);
      	$tgl_input = date('Y-m-d H:i:s');
      	$ks = substr($kodesie, 0,7);
      	// echo $ks;exit();
      	$data = array(
      		'kd_pekerjaan'	=> $kd_pkj,
      		'jml_pekerja'	=>	$jml_pkj,
      		'jml_pekerja_staff'	=>	$staff,
      		'kodesie'	=>	$ks,
      		'tgl_input'	=>	$tgl_input,
      		'status'	=>	'1',
      		'periode'	=>	$periode,
      		'tgl_approve'	=>	date('Y-m-d H:i:s'),
      		'approve_by'	=>	$noind,
      		);
      	$inputPkj = $this->M_order->inputPkj($data);
      	redirect('p2k3adm_V2/Admin/inputOrderTIM');
	}

	public function detail_seksi()
	{
		$id_kebutuhan = $this->input->post('phoneData');
		// echo $id_kebutuhan;exit();
		if(isset($id_kebutuhan) and !empty($id_kebutuhan)){
			$records = $this->M_dtmasuk->detail_seksi($id_kebutuhan);
			if (empty($records)) {
				echo '<center><ul class="list-group"><li class="list-group-item">'.'Semua Seksi Telah Order'.'</li></ul></center>';
			}else{
				echo '<table class="table table-bordered table-hover table-striped text-center">
				<tr>
					<th>NO</th>
					<th>NAMA SEKSI</th>
				</tr>';
				$i = 1;
				$search = array('0','1','2');
				$change = array('Pending', 'Approved', 'Rejected');
				foreach($records as $key){
					echo '<tr>
					<td>'.$i.'</td>
					<td>'.$key["seksi"].'</td>
				</tr>';
				$i++;
			}
			echo '</table>';
		}
	}
	else {
		echo '<center><ul class="list-group"><li class="list-group-item">'.'Data Kosong'.'</li></ul></center>';
	}	
}

public function MonitoringBon()
{
	$user1 = $this->session->user;
	$user_id = $this->session->userid;
	$kodesie = $this->session->kodesie;

	$data['Title'] = 'Monitoring Bon';
	$data['Menu'] = 'Monitoring Bon';
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
		$ks = $kodesie;
	}
	$seksi = $this->M_dtmasuk->cekseksi($ks);
	$data['kodesie'] = $ks;
	if (empty($data['seksi'])) {
		$seksi = array(array('section_name' => ''));
	}
	if ($ks == 'semua') {
		$seksi = array(array('section_name' => 'SEMUA SEKSI'));
	}
	$data['seksi'] = $seksi;
	// print_r($data['seksi']);exit();
	if ($ks == 'semua') {
		$ks = '';
	}
	$data['pr'] = $periode;
	$data['period'] = $pr;
	$data['monitorbon'] = $this->M_dtmasuk->monitorbon($ks, $pr);
	// foreach ($data['monitorbon'] as $key) {
	// 	$kode = explode(',', $key['kode_barang']);
	// 	$apd = explode(',', $key['nama_apd']);
	// 	$kode = explode(',', $key['jml_bon']);
	// 	$kode = explode(',', $key['satuan']);
	// }

	// echo "<pre>"; print_r($kode);exit();



	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Monitoring_bon', $data);
	$this->load->view('V_Footer',$data);
}

public function ajaxRow($ks, $pr)
{
	$datha = $this->M_dtmasuk->monitorbon($ks, $pr);
		// $tes[] = array_values($datha);
	// echo "<pre>"; print_r($tes);exit();
	echo json_encode(array('data'=>$datha));
}

public function RiwayatKebutuhan($ks = false)
{
	$user1 = $this->session->user;
	$user_id = $this->session->userid;
	$kodesie = $this->session->kodesie;

	$data['Title'] = 'Riwayat';
	$data['Menu'] = 'Riwayat';
	$data['SubMenuOne'] = 'Standar Kebutuhan';
	$data['SubMenuTwo'] = '';

	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	if (empty($ks)) {
		$ks = $this->input->post('k3_adm_ks');
	}
	if (empty($ks)) {
		$ks = $kodesie;
	}
	$baru = '1999-01-01 01:10:10';
	$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
	if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
		$baru = $cek_terbaru[0]['tgl_approve_tim'];
	}
	// $data['list'] = $this->M_dtmasuk->getListAprove($ks, $baru);
	$data['inputStandar'] = $this->M_order->getInputstd($ks);
	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
	$data['seksi'] = '';
	$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);


	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Riwayat_Kebutuhan', $data);
	$this->load->view('V_Footer',$data);
}

public function editRiwayatKebutuhan($id, $ks)
{
	$user1 = $this->session->user;
	$user_id = $this->session->userid;
	$kodesie = $this->session->kodesie;

	$data['Title'] = 'Riwayat';
	$data['Menu'] = 'Riwayat';
	$data['SubMenuOne'] = 'Standar Kebutuhan';
	$data['SubMenuTwo'] = '';

	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
	$data['ks'] = $ks;
	$data['inputStandar'] = $this->M_order->getInputstd3($id);
	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
	$data['id'] = $id;

	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Edit_Riwayat', $data);
	$this->load->view('V_Footer',$data);
}

public function SaveEditRiwayatKebutuhan()
{
	// print_r($_POST);exit();
	$id = $this->input->post('id');
	$ks = $this->input->post('ks');
	$jmlUmum = $this->input->post('jmlUmum');
	$staffJumlah = $this->input->post('staffJumlah');
	$pkjJumlah = $this->input->post('pkjJumlah');
	$pkj = implode(',', $pkjJumlah);

	$update = $this->M_dtmasuk->updateRiwayat($id, $jmlUmum, $staffJumlah,$pkj);
	if ($update) {
		redirect('p2k3adm_V2/Admin/RiwayatKebutuhan/'.$ks);
	}
}

public function RiwayatOrder()
{
	$user1 = $this->session->user;
	$user_id = $this->session->userid;
	$kodesie = $this->session->kodesie;

	$data['Title'] = 'Riwayat';
	$data['Menu'] = 'Riwayat';
	$data['SubMenuOne'] = 'Order';
	$data['SubMenuTwo'] = '';

	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	$ks = $this->input->post('k3_adm_ks');
	if (empty($ks)) {
		$ks = $kodesie;
	}
	$baru = '1999-01-01 01:10:10';
	$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
	if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
		$baru = $cek_terbaru[0]['tgl_approve_tim'];
	}
	$data['tampil_data'] 		= $this->M_order->tampil_data($ks);
	$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
	$data['seksi'] = '';
	$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);

	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Riwayat_Order', $data);
	$this->load->view('V_Footer',$data);
}

public function Email()
{
	$user1 = $this->session->user;
	$user_id = $this->session->userid;
	$kodesie = $this->session->kodesie;

	$data['Title'] = 'Setup';
	$data['Menu'] = 'Setup';
	$data['SubMenuOne'] = 'Email';
	$data['SubMenuTwo'] = '';

	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	$data['email'] = $this->M_dtmasuk->getEmail();

	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Setup_Email', $data);
	$this->load->view('V_Footer',$data);
}

public function addEmail()
{
	$email = $this->input->post('email');
	$addEmail = $this->M_dtmasuk->addEmail($email);
}
public function editEmail()
{
	$email = $this->input->post('email');
	$id = $this->input->post('id');
	$addEmail = $this->M_dtmasuk->editEmail($id,$email);
}

public function hapusEmail()
{
	$id = $this->input->post('id');
	$addEmail = $this->M_dtmasuk->hapusEmail($id);
}
}