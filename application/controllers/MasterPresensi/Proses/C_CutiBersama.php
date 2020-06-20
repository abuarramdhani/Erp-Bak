<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_CutiBersama extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/Proses/M_cutibersama');
		date_default_timezone_set('Asia/Jakarta');

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

		$data['Title']			=	'Cuti Bersama';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Cuti Bersama';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $user;
		$data['data'] = $this->M_cutibersama->getRekapCutiBersama();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/Proses/CutiBersama/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Proses(){
		$user = $this->session->user;
		$tanggal 	= $this->input->post('txtTanggalCutiBersama');
		$ket  		= $this->input->post('txtKeteranganCutiBersama');

		$data = $this->M_cutibersama->getDataCutiByTanggal($tanggal);
		
		$progress = array(
			'user_' 	=> $user,
			'progress' 	=> 0,
			'total' 	=> count($data),
			'menu' 		=> 'CutiBersama'
		);

		$this->M_cutibersama->deleteProgress($user);
		$progress_id = $this->M_cutibersama->insertProgress($progress);
		session_write_close();
		flush();

		$cek_tlibur = $this->M_cutibersama->getTliburByTanggal($tanggal);
		
		if (count($cek_tlibur) == 0) {
			$this->M_cutibersama->insertTlibur($tanggal);
		}

		$data_cb = $this->M_cutibersama->getTdatapresensiByTanggal($tanggal);

		if (!empty($data_cb)) {
			foreach ($data_cb as $dc) {
				$this->M_cutibersama->deleteTdataPresensiByTanggalNoind($tanggal,$dc['noind']);
				$this->M_cutibersama->updateTdatacutibyTanggalNoindAction($dc['noind'],$tanggal,'del');
			}
			$this->M_cutibersama->deleteTdataTim($tanggal);
		}

		$datajadi = array();
		$index = 0;
		
		foreach ($data as $dt) {
			$datajadi[$index] = $dt;
			if (strtotime($dt['tgl_boleh_ambil']) == strtotime($dt['awal_tahun'])) {
				if (strtotime($dt['akhkontrak']) <= strtotime($tanggal)) {
					if ($dt['sisa_cuti'] > 0) {
						$datajadi[$index]['set'] = "cuti_bersama";
					}else{
						if ($dt['jml_cuti'] > 0) {
							$datajadi[$index]['set'] = "mangkir_berpoint";	
						}else{
							$datajadi[$index]['set'] = "mangkir_tidak_berpoint";	
						}
					}
				}else{
					$datajadi[$index]['set'] = "melebihi_akhir_kontrak";	
				}
			}else{
				$datajadi[$index]['set'] = "mangkir_tidak_berpoint";
			}

			if ($datajadi[$index]['set'] == "mangkir_tidak_berpoint") {
				$cek_tdatatim = $this->M_cutibersama->getTdatatimByTanggalNoind($tanggal,$dt['noind']);
				if (count($cek_tdatatim) == 0) {
					$data_insert = array(
						'tanggal' 	=> $tanggal,
						'noind' 	=> $dt['noind'],
						'kodesie' 	=> $dt['kodesie'],
						'masuk' 	=> '0',
						'keluar' 	=> '0',
						'kd_ket' 	=> 'TM',
						'point'		=> 0,
						'user_' 	=> $user,
						'noind_baru' => $dt['noind_baru']
					);
					$this->M_cutibersama->insertTdatatim($data_insert);
				}
			}

			if ($datajadi[$index]['set'] == "mangkir_berpoint") {
				$cek_tdatatim = $this->M_cutibersama->getTdatatimByTanggalNoind($tanggal,$dt['noind']);	
				if (count($cek_tdatatim) == 0) {
					$data_insert = array(
						'tanggal' 	=> $tanggal,
						'noind' 	=> $dt['noind'],
						'kodesie' 	=> $dt['kodesie'],
						'masuk' 	=> '0',
						'keluar' 	=> '0',
						'kd_ket' 	=> 'TM',
						'point'		=> 1,
						'user_' 	=> $user,
						'noind_baru' => $dt['noind_baru']
					);
					$this->M_cutibersama->insertTdatatim($data_insert);
				}
			}

			if ($datajadi[$index]['set'] == "cuti_bersama") {
				$cek_tdatapresensi = $this->M_cutibersama->getTdatapresensiByTanggalNoind($tanggal,$dt['noind']);
				if (count($cek_tdatapresensi) == 0) {
					$data_insert = array(
						'tanggal' 	=> $tanggal,
						'noind' 	=> $dt['noind'],
						'kodesie' 	=> $dt['kodesie'],
						'masuk' 	=> '0',
						'keluar' 	=> '0',
						'kd_ket' 	=> 'CB',
						'total_lembur' => '0',
						'ket' 		=> 'biasa',
						'user_' 	=> $user,
						'noind_baru' => $dt['noind_baru'],
						'alasan'	=> 'Cuti Bersama'
					);
					$this->M_cutibersama->insertTdatapresensi($data_insert);
					$this->M_cutibersama->updateTdatacutibyTanggalNoindAction($dt['noind'],$tanggal,'add');
				}
			}

			$index++;

			$this->M_cutibersama->updateProgress($user,$index);
			session_write_close();
			flush();
		}
		
		// echo "<pre>";print_r($datajadi);exit();
		$data_log = array(
			'wkt' 		=> date('Y-m-d H:i:s'),
			'menu' 		=> 'MASTER PRESENSI => PROSES => CUTI BERSAMA',
			'ket'		=> 'SET CUTI BERSAMA TGL. '.$tanggal,
			'noind' 	=> $user,
			'program' 	=> 'ERP'
		);
		$this->M_cutibersama->insertLog($data_log);

		// redirect(base_url('MasterPresensi/Proses/CutiBersama'));
	}

	public function cekProgress(){
		$user = $this->input->get('user');
		$data = $this->M_cutibersama->getProgress($user);
		if (!empty($data)) {
			if ($data->progress >= $data->total) {
				$this->M_cutibersama->deleteProgress($user);
			}
			echo round(($data->progress/$data->total)*100);
		}else{
			echo "kosong";
		}
	}

	public function Detail(){
		$tanggal = $this->input->get('tanggal');
		$keterangan = $this->input->get('keterangan');
		if ($keterangan == 'cb') {
			$data = $this->M_cutibersama->getPekerjaCutiByTanggal($tanggal);
		}elseif ($keterangan == 'mtp') {
			$data = $this->M_cutibersama->getPekerjaMangkirTanpaPointByTanggal($tanggal);
		}elseif ($keterangan == 'mp') {
			$data = $this->M_cutibersama->getPekerjaMangkirPointByTanggal($tanggal);
		}elseif ($keterangan == 'l') {
			$data = $this->M_cutibersama->getPekerjaLainByTanggal($tanggal);
		}elseif ($keterangan == 'j') {
			$data = $this->M_cutibersama->getPekerjaJumlahByTanggal($tanggal);
		}else{
			$data = array();
		}

		$isiEmail = "	<table class='table table-striped table-bordered table-hover tbl-MPR-CutiBersama-modal-table'>
							<thead>
								<th>No.</th>
								<th>Tanggal</th>
								<th>No. Induk</th>
								<th>Nama</th>
								<th>Masuk</th>
								<th>keluar</th>
								<th>Keterangan</th>
								<th>Action</th>
							</thead>
							<tbody>";
		if (isset($data) && !empty($data)) {
			$nomor = 1;
			foreach ($data as $dt) {
				if (strtotime($dt['tanggal']) <= strtotime(date('Y-m-d'))) {
					$action = "Sudah Melewati Tanggal";
				}else{
					if (in_array(trim($dt['kd_ket']), array('CB','TM'))) {
						$action = "<a href='".base_url('MasterPresensi/Proses/CutiBersama/Hapus?tanggal='.$dt['tanggal'].'&noind='.$dt['noind'])."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data No. Induk ".$dt['noind']." Tanggal ".date('d M Y', strtotime($dt['tanggal']))." ?\")'>
												<span class='fa fa-trash'></span>
												Hapus
											</a>";
					}else{
						$action = "Bukan Cuti Bersama / Mangkir";
					}
				}
					
				$isiEmail .= "	<tr>
									<td>".$nomor."</td>
									<td>".date('d M Y', strtotime($dt['tanggal']))."</td>
									<td>".$dt['noind']."</td>
									<td>".$dt['nama']."</td>
									<td>".$dt['masuk']."</td>
									<td>".$dt['keluar']."</td>
									<td>".$dt['kd_ket']."</td>
									<td>".$action."</td>
								</tr>";
				$nomor++;
			}
		}
		$isiEmail .= "		</tbody>
						</table>";
		// echo "<pre>";print_r($data);echo "</pre>";
		echo $isiEmail;
	}

	public function Hapus(){
		$user = $this->session->user;
		$noind = $this->input->get('noind');
		$tanggal = $this->input->get('tanggal');

		if (!empty($noind) && !empty($tanggal)) {
			$data = $this->M_cutibersama->getDataPresensiByTanggalNoind($tanggal,$noind);
			$data_log = array(
				'wkt' 		=> date('Y-m-d H:i:s'),
				'menu' 		=> 'MASTER PRESENSI => PROSES => CUTI BERSAMA',
				'ket'		=> 'HAPUS CUTI BERSAMA PEKERJA TGL. '.$tanggal,
				'noind' 	=> $user,
				'program' 	=> 'ERP'
			);
			$this->M_cutibersama->insertLog($data_log);
		}elseif (!empty($tanggal)) {
			$data = $this->M_cutibersama->getDataPresensiByTanggal($tanggal);
			$data_log = array(
				'wkt' 		=> date('Y-m-d H:i:s'),
				'menu' 		=> 'MASTER PRESENSI => PROSES => CUTI BERSAMA',
				'ket'		=> 'HAPUS CUTI BERSAMA ALL TGL. '.$tanggal.' No. INDUK '.$noind,
				'noind' 	=> $user,
				'program' 	=> 'ERP'
			);
			$this->M_cutibersama->insertLog($data_log);
			$this->M_cutibersama->deleteTliburCutiBersamaByTanggal($tanggal);
		}else{
			$data = array();
		}

		if (!empty($data)) {
			foreach ($data as $dt) {
				if (in_array(trim($dt['kd_ket']), array('CB','TM'))) {
					if (trim($dt['kd_ket']) == 'TM') {
						$this->M_cutibersama->deleteTdatatimTMByTanggalNoind($tanggal,$dt['noind']);
					}elseif (trim($dt['kd_ket']) == 'CB') {
						$this->M_cutibersama->deleteTdataPresensiByTanggalNoind($tanggal,$dt['noind']);
						$this->M_cutibersama->updateTdatacutibyTanggalNoindAction($dt['noind'],$tanggal,'del');
					}
				}
			}
		}

		redirect(base_url('MasterPresensi/Proses/CutiBersama'));
	}
}

?>