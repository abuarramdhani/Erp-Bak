<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_Approval extends CI_Controller
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
		$this->load->library('KonversiBulan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PolaShiftSeksi/Approval/M_approval');
		$this->load->model('PolaShiftSeksi/ImportPolaShift/M_index');
		date_default_timezone_set("Asia/Jakarta");

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function ApprovalShift()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['usr'] = substr($no_induk, 0,1);
		$data['no_induk'] = $no_induk;

		$data['Title'] = 'Approval Shift';
		$data['Menu'] = 'Approval';
		$data['SubMenuOne'] = 'Approval Import Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/Approval/V_Approval_Shift', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cari_shift()
	{
		$pr = $this->input->post('pr');
		$no_induk = $this->session->user;
		$kodesie = $this->session->kodesie;
		$data['getShift'] = $this->M_approval->getShift($pr, $no_induk);
		if ($this->session->user == 'T0007') {
			$data['getShift'] = $this->M_approval->getShiftDev($pr);
		}

		$html = $this->load->view('PolaShiftSeksi/Approval/V_View_List_Shift', $data);
		echo json_encode($html);
	}

	public function detail_shift($ks, $pr, $tgl_imp)
	{

		$no_induk = $this->session->user;
		$usr = substr($no_induk, 0,1);
		if ($usr == 'B' ||$usr == 'D' ||$usr == 'J' || $no_induk == 'T0007') {
			//oke
		}else{
			echo "Access Denied";
			echo "<br>Anda akan kembali ke Halaman utama dalam 5 detik";
			header( "refresh:5;url=".base_url('PolaShiftSeksi') );
			exit();
		}
		//dari ERP
		$tgl_imp = str_replace('_', ' ', $tgl_imp);
		$data['tgl_imp'] = $tgl_imp;
		$detail = $this->M_approval->getDetail($ks, $pr,$tgl_imp);
		if (empty($detail)) {
			echo 'data kosong';exit();
		}
		$distintPekerja = $this->M_approval->getPkjDist($ks, $pr, $tgl_imp);
		$newArrPerPkj = array();
		$daftarNoind = array();
		foreach ($distintPekerja as $key) {
			$val = array();
			$daftarNoind[] = $key['noind'];
			$val['noind'] = $key['noind'];
			$val['nama'] = $key['employee_name'];
			foreach ($detail as $row) {
				if ($row['noind'] == $key['noind']) {
					$val['shift'][] = strtolower($row['inisial']);
					$val['tgl'][] = intval(substr($row['tanggal'], 8,2));
				}
			}
			$newArrPerPkj[] = $val;
		}
		$data['arrayPkj'] = $newArrPerPkj;

		// echo "<pre>";
		// print_r($newArrPerPkj);exit();

		//Dari Personalia
		$noinduk = implode("','", $daftarNoind);
		$data['arrayJav'] = "['".$noinduk."']";
		$detailP = $this->M_approval->getDetailPersonalia($ks, $pr);
		$distintPekerjaP = $this->M_approval->getPkjDistPersonalia($ks, $pr, $noinduk);
		$newArrPerPkjP = array();
		foreach ($distintPekerjaP as $k) {
			$valP = array();
			$valP['noind'] = $k['noind'];
			$valP['nama'] = $k['nama'];
			foreach ($detailP as $r) {
				if ($r['noind'] == $k['noind']) {
					$valP['shift'][] = strtolower($r['inisial']);
					$valP['tgl'][] = intval(substr($r['tanggal'], 8,2));
				}
			}
			$newArrPerPkjP[] = $valP;
		}
		$data['arrayPkjP'] = $newArrPerPkjP;

		$data['tgl_akhir'] =  date("t", strtotime($pr.'-01'));
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['seksi']	=	$this->M_index->tseksi($ks);
		$data['kode_seksi']	= $ks;
		$data['periode'] =	$pr;

		$data['Title'] = 'Approval Shift';
		$data['Menu'] = 'Approval';
		$data['SubMenuOne'] = 'Approval Import Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/Approval/V_Detail_Shift', $data);
		$this->load->view('V_Footer',$data);
	}

	public function update_shift()
	{
		$noind = $this->session->user;
		$arry = $this->input->post('arr');
		$pr = $this->input->post('periode');
		$tgl_imp = $this->input->post('tgl_imp');
		$ks = $this->input->post('kode_seksi');
		$alasan_rej = $this->input->post('alasan');
		$status = $this->input->post('stat');
		$date = date('Y-m-d H:i:s');

		if ($status == 'reject') {
			$arr = array(
					'approve_by' => $noind, 
					'tgl_approve' => $date,
					'alasan'	=>	$alasan_rej,
					);
			$updateApprove = $this->M_approval->updateApprove($tgl_imp, $ks, $arr);
			echo json_encode(true);
		}else{
			foreach ($arry as $key) {
				$ex = explode('|', $key);
				$tgl = $pr.'-'.sprintf('%02d', $ex[2]);

				if ($ex[3] == 'insert') {
					$shif = $this->M_approval->getCurrentShift($ex[0], $tgl, $noind, 'INSERT', $date, $tgl_imp);
					$ins = $this->M_approval->insetShift($shif[0]);
				}elseif ($ex[3] == 'update') {
					$shif = $this->M_approval->getCurrentShift($ex[0], $tgl, $noind, 'UPDATE', $date, $tgl_imp);
					$up = $this->M_approval->updateShift($shif[0], $ex[0], $tgl);
				}elseif ($ex[3] == 'delete') {
					$tomove = $shif = $this->M_approval->to_move($ex[0], $tgl, $noind, 'DELETE', $date);
					$ins = $this->M_approval->insetShiftHapus($tomove[0]);
					$del = $this->M_approval->delShift($ex[0], $tgl);
				}
			}
			if (!empty($arry)) {
				$arr = array(
					'approve_by' => $noind, 
					'tgl_approve' => $date, 
					);
				$updateApprove = $this->M_approval->updateApprove($tgl_imp, $ks, $arr);
			}
			echo json_encode(true);
		}
	}

	public function ApprovalTukarShift()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['usr'] = substr($no_induk, 0,1);
		$data['no_induk'] = $no_induk;

		$data['Title'] = 'Approval Shift';
		$data['Menu'] = 'Approval';
		$data['SubMenuOne'] = 'Approval Tukar Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['listApprove'] = $this->M_approval->getListApp($no_induk);
		// echo "<pre>";
		// print_r($data['listApprove']);exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/Approval/TukarShift/V_Approval_Tukar_Shift', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ApproveTS($id)
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Approval Shift';
		$data['Menu'] = 'Approval';
		$data['SubMenuOne'] = 'Approval Tukar Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
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
		$this->load->view('PolaShiftSeksi/Approval/TukarShift/V_Approval_TS', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ApproveTS_button()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$level = $this->input->post('level');
		$id = $this->input->post('id');
		$isduo = $this->input->post('duo');
		$tgl = date('Y-m-d H:i:s');
		if ($isduo == 'y') {
			$duo = ", approve2_tgl = '$tgl'";
		}else{
			$duo = '';
		}
		if ($level == '1') {
			$kolom = 'approve1_tgl';
		}elseif ($level == '2') {
			$kolom = 'approve2_tgl';
		}elseif ($level == '3') {
			$kolom = "status = '02', approve_timestamp";
		}else{
			echo "level not found";
			exit();
		}
		$up = $this->M_approval->upTS($kolom, $id, $duo, $tgl);
		//update di personalia
		if ($level == '3') {
				$getGroup = $this->M_approval->getTukarGroup($id);
			foreach ($getGroup as $gg) {
					$get = $this->M_approval->getTukar($gg['tukar_id']);
				foreach ($get as $key) {
						$up_Pers = $this->M_approval->up_pers($key['tanggal1'], $key['noind1'], $key['noind2'], $key['create_timestamp'], $tgl, '02');
					if (strlen(rtrim($key['noind2'])) < 5) {
						$getKd = $this->M_approval->getKD(rtrim($key['shift2']));
						$upPkj = $this->M_approval->upPkj($key['tanggal1'], $key['noind1'], $getKd);// update pekerja 1 saja
					}else{
						$getKd = $this->M_approval->getKD(rtrim($key['shift2']));// ini sshift 2
						$upPkj = $this->M_approval->upPkj($key['tanggal1'], $key['noind1'], $getKd);// update pekerja 1
						//tanggal1 dan 2 kan sama
						$getKd = $this->M_approval->getKD(rtrim($key['shift1']));// ini shift 1
						$upPkj = $this->M_approval->upPkj($key['tanggal2'], $key['noind2'], $getKd);// update pekerja 2 
					}
					$insertLog = $this->M_approval->insTlog($tgl, $key['vno'], $key['shift1'], $key['shift2'], $key['appr_']);// insert tlog 1 aja
				}
			}
		}
	}

	public function ApproveTS_button_reject()
	{
		$noind = $this->session->user;
		$id = $this->input->post('id');
		$alasan = $this->input->post('alasan');
		$tgl = date('Y-m-d H:i:s');

		$up_r = $this->M_approval->upTS_rej($noind, $tgl, $id, $alasan);// update di erp
		$getGroup = $this->M_approval->getTukarGroup($id);
			foreach ($getGroup as $gg) {
				$get  =	$this->M_approval->getTukar($gg['tukar_id']);// dapatkan data di erp untuk update di personalia karena disana tidak ada idnya
				$up_Pers = $this->M_approval->up_pers($get[0]['tanggal1'], $get[0]['noind1'], $get[0]['noind2'], $get[0]['create_timestamp'], $tgl, '03');
			}

	}
}