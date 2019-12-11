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
		$detail = $this->M_tukar->getDetail($noind, $tanggal);

		echo json_encode($detail);
	}

	public function getFormPekerja()
	{
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;
		$data['tukar'] = $this->input->post('tukar');

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
		$noind_user = $this->session->user;
		$tgl_tukar 	= $this->input->post('tgl_tukar');
		$isTukar	= $this->input->post('tukarpekerja');
		$inisiatif	= $this->input->post('inisiatif');
		$noind		= $this->input->post('noind');
		$kd_shift	= $this->input->post('kd_sh');
		$atasan	= $this->input->post('atasan');

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
		$namaHari_en = strtoupper(date('l', strtotime($tgl_tukar)));
		$hari = $this->konversibulan->convert_Hari_Indonesia($namaHari_en);
		$JamShift = $this->M_tukar->getJamShift($kd_shift[1], ucfirst($hari));
		//array untuk erp
		$arr = array(
			'tanggal1' => $tgl_tukar,
			'tanggal2' => $tgl_tukar,
			'noind1' => $noind[0],
			'noind2' => $noind[1],
			'kodesie' => '',
			'shift1' => $this->M_tukar->getShiftnya($kd_shift[0]),
			'shift2' => $this->M_tukar->getShiftnya($kd_shift[1]),
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
			);
		// print_r($arr);exit();
		$ins = $this->M_tukar->insertTukar($arr);
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
		$data['user'] = $no_induk;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/TukarShift/V_Lihat_Detail',$data);
		$this->load->view('V_Footer',$data);
	}
}