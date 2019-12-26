<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Tukar extends CI_Controller
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
		$this->load->library('General');
		$this->load->library('KonversiBulan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PolaShiftSeksi/TukarShift/M_tukar');
		$this->load->model('PolaShiftSeksi/Approval/M_approval');
		$this->load->model('PermohonanCuti/M_permohonancuti');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Tukar Shift';
		$data['Menu'] = 'Tukar Shift';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['listTukar'] = $this->M_tukar->getListTukar($no_induk);
		// echo "<pre>";
		// print_r($data['listTukar']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/TukarShift/V_Index');
		$this->load->view('V_Footer',$data);

	}

	public function createTS()
	{
		$data  = $this->general->loadHeaderandSidemenu('Pola Shift Seksi', 'Tukar Shift', 'Tukar Shift', '', '');
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/TukarShift/V_CreateTS',$data);
		$this->load->view('V_Footer',$data);
	}
	public function getNoind()
	{
		$term = $this->input->post('term');
		$daftar_noind = $this->M_tukar->getDaftar(strtoupper($term));

		echo json_encode($daftar_noind);
	}

	public function getDetailNoind()
	{
		$noind = $this->input->post('noind');
		$tanggal = $this->input->post('tanggal');
		$pr_ex = explode(' - ', $tanggal);
		$a = date('Y-m-d', strtotime($pr_ex[0]));
		$b = date('Y-m-d', strtotime($pr_ex[1]. '+1 days'));
		$begin = new DateTime($a);
		$end = new DateTime($b);

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		foreach ($period as $dt) {
			$tgl = $dt->format("d-m-Y");
			$cek = $this->M_tukar->getDetail($noind, $tgl);
			if(empty($cek)){
				$noSh = 'Pekerja tersebut tidak memiliki shift pada tanggal '.$tgl.'';
				echo json_encode($noSh);
				exit();
			}
			$detail[] = $cek;
		}

		echo json_encode($detail);
	}

	public function getFormPekerja()
	{
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;
		$data['tukar'] = $this->input->post('tukar');
		$pr = $this->input->post('pr');
		$pr_ex = explode(' - ', $pr);
		$a = date('Y-m-d', strtotime($pr_ex[0]));
		$b = date('Y-m-d', strtotime($pr_ex[1]. '+1 days'));
		$begin = new DateTime($a);
		$end = new DateTime($b);

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		$arT = array();
		foreach ($period as $dt) {
			// if(date('w', strtotime($dt->format("d-m-Y"))) != 0)
			$arT[] = $dt->format("d-m-Y");
		}
		$data['arrTgl'] = $arT;

		$data['approval1'] = $this->M_permohonancuti->getApproval($noind, $kodesie);
		
		$html = $this->load->view('PolaShiftSeksi/TukarShift/V_Form_Pekerja',$data);
		
		echo json_encode($html);
	}

	public function getListShift()
	{
		$term = $this->input->post('term');
		$kd = $this->input->post('kd');
		$daftar_sh = $this->M_tukar->getDaftarShift(strtoupper($term), $kd);

		echo json_encode($daftar_sh);
	}

	public function saveTS()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$noind_user = $this->session->user;
		$tgl_tukar 	= $this->input->post('tgl_tukar');
		$tgl 		= $this->input->post('tgl');
		$isTukar	= $this->input->post('tukarpekerja');
		$inisiatif	= $this->input->post('inisiatif');
		$noind		= $this->input->post('noind');
		$kd_shift	= $this->input->post('kd_sh');
		$kd_shift_2	= $this->input->post('kd_sh_2');
		$atasan	= $this->input->post('atasan');

		if (isset($noind[1]) && $noind[0] == $noind[1]) {
			echo "Error!!<br>Noind tidak boleh Sama.........";
			exit();
		}

		if ($isTukar == 'tidak') {
			$noind[1] = '';
			$vno = $noind[0];
		}else{
			$vno = $noind[0].' & '.$noind[1];
		}
		if ($inisiatif == 'pribadi') {
			$optpekerja = '1';
			$optperusahaan = '0';
		}else{
			$optpekerja = '0';
			$optperusahaan = '1';
		}
		$group_id = $this->M_tukar->getGroupId();
		for ($i=0; $i < count($tgl); $i++) { 
			$namaHari_en = strtoupper(date('l', strtotime($tgl[$i])));
			$hari = $this->konversibulan->convert_Hari_Indonesia($namaHari_en);
			$JamShift = $this->M_tukar->getJamShift($kd_shift_2[$i], ucfirst($hari));
		//array untuk erp
			$arr[] = array(
				'tanggal1' => $tgl[$i],
				'tanggal2' => $tgl[$i],
				'noind1' => $noind[0],
				'noind2' => $noind[1],
				'kodesie' => '',
				'shift1' => $this->M_tukar->getShiftnya($kd_shift[$i]),
				'shift2' => $this->M_tukar->getShiftnya($kd_shift_2[$i]),
				'optpekerja' => $optpekerja,
				'optperusahaan' => $optperusahaan,
				'msk' => $JamShift[0]['jam_msk'],
				'akh_msk' => $JamShift[0]['jam_akhmsk'],
				'plg' => $JamShift[0]['jam_plg'],
				'b_mulai' => $JamShift[0]['break_mulai'],
				'b_selesai' => $JamShift[0]['break_selesai'],
				'i_mulai' => $JamShift[0]['ist_mulai'],
				'i_selesai' => $JamShift[0]['ist_selesai'],
				'user_' => $noind_user,
				'status' => '01',
				'create_timestamp' => date('Y-m-d H:i:s'),
				'appr_' => $atasan,
				'approve_timestamp' => '9999-12-12 00:00:00',
				'vno'	=>	$vno,
				'jml_jam_kerja'	=>	$JamShift[0]['jam_kerja'],
				'group_id'	=>	$group_id,
				);
		}

		$ins = $this->M_tukar->insertTukar($arr);

		//unset group id karena di db personalia tidak ada
		for ($i=0; $i < count($arr); $i++) { 
			unset($arr[$i]['group_id']);
		}
		// print_r($arr);exit();
		$ins = $this->M_tukar->insertTukarPersonalia($arr);

		redirect('PolaShiftSeksi/TukarShift');
	}

	public function iniSelect()
	{
		$noind = $this->input->post('noind');
		$kodesie = $this->M_tukar->getKodesie($noind);

		$approval = $this->M_permohonancuti->getApproval($noind, $kodesie[0]['kodesie']);
		$ec = "<option value=''></option>";
		foreach ($approval as $appr1) { 
			if (isset($_POST['slc_approval1']) && $_POST['slc_approval1'] == $appr1['noind'])
			{ 
				$selected = "selected";
			}else{
				$selected ="";
			} 
			$ec .= "<option ".$selected." value='".$appr1['noind']."'>".$appr1['noind']." - ".$appr1['nama'].'</option>';
		}
		echo $ec;
	}

	public function lihatView($id)
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data  = $this->general->loadHeaderandSidemenu('Pola Shift Seksi', 'Tukar Shift', 'Tukar Shift', '', '');
		
		$data['tukar']	=	$this->M_approval->getListId($id);
		$data['tukar']['min'] = date('d-m-Y', strtotime($data['tukar']['min']));
		$data['tukar']['max'] = date('d-m-Y', strtotime($data['tukar']['max']));
		if (empty(rtrim($data['tukar']['noind2']))) {
			$data['tukar']['noind2'] = $data['tukar']['noind1'];
			$data['tukar']['nama2'] = $data['tukar']['nama1'];
		}
		$data['tukar']['shift1'] = explode(';', $data['tukar']['shift1']);
		$data['tukar']['shift2'] = explode(';', $data['tukar']['shift2']);
		$data['tukar']['tgl_arr'] = explode(';', $data['tukar']['tgl_arr']);
		$data['tukar']['jumlah'] = count($data['tukar']['tgl_arr']);
		// echo "<pre>";
		// print_r($data['tukar']);exit();
		$data['user'] = $no_induk;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/TukarShift/V_Lihat_Detail',$data);
		$this->load->view('V_Footer',$data);
	}
}