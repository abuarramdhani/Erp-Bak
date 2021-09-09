<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_Psikotes extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
	    $this->load->model('Api/Psikotes/M_psikotes');
	    date_default_timezone_set('Asia/Jakarta');
	}

	function getJadwalPsikotes()
	{
		$arr = array(
			'error' => 1,
			'jadwal' => 0,
			'desc' => 'Invalid nik'
		);

		$nik = $this->input->get('nik');
		$requester = $this->input->get('requester');
		if(empty($requester)) $requester = 'erec';
		if (empty($nik) || !is_numeric($nik)) {
			echo json_encode($arr);
			return true; exit();
		}

		$jadwal = $this->M_psikotes->getJadwalPS($nik);
		if (!empty($jadwal) && $requester == 'erec') {
			$arr = array(
				'error' => 0,
				'jadwal' => 1,
				'desc' => 'Ada Jadwal Psikotes hari ini'
			);

			echo json_encode($arr);
			return true; exit();
		}else{
			$arr = array(
				'error' => 0,
				'jadwal' => 0,
				'desc' => 'Tidak ada Jadwal'
			);
			echo json_encode($arr);
			return true; exit();
		}
	}

	function cekTokenPsikotes()
	{
		$nik = $this->input->get('nik');
		$token = $this->input->get('token');
		$requester = $this->input->get('requester');
		if(empty($requester)) $requester = 'erec';

		$arr = array(
			'error' => 1,
			'desc' => 'Invalid nik or token'
		);

		if (empty($nik) || empty($token)) {
			echo json_encode($arr);
			return true; exit();
		}

		$valid = $this->M_psikotes->cekValidToken($nik, $token);
		if (!empty($valid) && $requester == 'erec') {
			$arr = array(
				'error' => 0,
				'desc' => 'Token Valid',
				'data' => $valid
			);
			echo json_encode($arr);
			return true; exit();
		}

		echo json_encode($arr);
	}

	function cekAbsenPsikotes($token)
	{
		$token = $this->input->get('token');
		$requester = $this->input->get('requester');
		if(empty($requester)) $requester = 'erec';

		$arr = array(
			'error' => 1,
			'absensi' => 0,
			'desc' => 'Invalid token'
		);

		if (empty($token)) {
			echo json_encode($arr);
			return true; exit();
		}

		$absensi = $this->M_psikotes->getAbsPsikotes($token);
		if (!empty($absensi)) {
			$arr = array(
				'error' => 0,
				'absensi' => 1,
				'desc' => 'Sudah Absensi'
			);
		}else{
			$arr = array(
				'error' => 0,
				'absensi' => 0,
				'desc' => 'Belum Absensi'
			);
		}

		echo json_encode($arr);
		return true; exit();
	}

	function saveImgAbsnsi()
	{
		$token = $this->input->post('token');
		$client_time = $this->input->post('client_time');
		$client_timezone = $this->input->post('client_timezone');
		$filename = $this->input->post('filename');

		$arr = array(
			'kode_akses' => $token,
			'client_time' => $client_time,
			'client_timezone' => $client_timezone,
			'server_time' => date('Y-m-d H:i:s'),
			'filename' => $filename,
		);
		$absensi = $this->M_psikotes->getAbsPsikotes($token);
		if(empty($absensi))
			$ins = $this->M_psikotes->saveImgabs($arr);
		else
			$ins = $this->M_psikotes->updtAbsPsi($arr, $token);

		$data['error'] = '0';
		echo json_encode($data);
	}

	function pertanyaanNo()
	{
		$token = $this->input->get('token');
		$nik = $this->input->get('nik');
		$id_tes = $this->input->get('idtest');
		$no_soal = $this->input->get('number');
		$current = $no_soal-1;

		//cek session apakah belum ada atau masih di dalam, atau sesion sudah habis
		$in_session = $this->cekSessionTes($nik, $token, $id_tes);
		$data['start_sesi'] = isset($in_session['start_sesi']) ? $in_session['start_sesi']:0;
		$data['timeout'] = 0;
		if ($in_session['error']) {
			$data['error'] = 1;
			$data['desc'] = $in_session['desc'];
			$data['timeout'] = 1;
			$data['timeout_desc'] = $in_session['desc'];
			// echo json_encode($data);
			// return;exit; 
		}

		//get pertanyaan berdasarkan nomor
		$pertanyaan = $this->M_psikotes->getAllPertanyaanByIdtes($id_tes);
		$lid_pertanyaan = array_column($pertanyaan, 'id_pertanyaan');
		// echo json_encode($pertanyaan);exit;
		if(empty($pertanyaan)){
			$data['error'] = 1;
			$data['desc'] = 'Pertanyaan not found';
			echo json_encode($data);
			return;exit; 
		}
		$prev = !isset($pertanyaan[$current-1]) ? 'null':$no_soal-1;
		$next = !isset($pertanyaan[$current+1]) ? 'null':$no_soal+1;
		$pertanyaan = $pertanyaan[$current];
		
		$total_pertanyaan = count($this->M_psikotes->getAllPertanyaanByIdtes($id_tes));

		$jawaban = $this->M_psikotes->getListJawaban($pertanyaan['id_pertanyaan']);
		for ($i=0; $i <count($jawaban) ; $i++) { 
			if(!file_exists($jawaban[$i]['doc_path']))
				$jawaban[$i]['doc_path'] = '';
			else
				$jawaban[$i]['doc_path'] = base_url().$jawaban[$i]['doc_path'];
		}

		//cek jawaban yg sudah ada
		$cek_jwb = $this->M_psikotes->cekJwb($nik, $token, $id_tes);
		$ljawaban = array_column($cek_jwb, 'id_pertanyaan');
		$cjwb = $this->M_psikotes->cekJwb2($nik, $token, $id_tes, $pertanyaan['id_pertanyaan']);
		$jwb = !empty($cjwb) ? $cjwb['jawaban']:'null';
		$pertanyaan_file = file_exists($pertanyaan['doc_path']) ? base_url().$pertanyaan['doc_path'] : '';

		$data['error'] = 0;
		$data['desc'] = 'Okey';
		$data['pertanyaan'] = $pertanyaan['pertanyaan'];
		$data['jawaban'] = $jawaban;//list jawaban
		$data['prev'] = $prev;
		$data['next'] = $next;
		$data['jwb'] = $jwb;//jawaban yg sudah tersimpan
		$data['no_soal'] = $no_soal;
		$data['id_pertanyaan'] = $pertanyaan['id_pertanyaan'];
		$data['total_pertanyaan'] = $total_pertanyaan;
		$data['done'] = $ljawaban;
		$data['list_id_pertanyaan'] = $lid_pertanyaan;
		$data['pertanyaan_file'] = $pertanyaan_file;
		$data['base_url'] = base_url();
		echo json_encode($data);
	}

	function aaa()
	{
		echo file_exists('./assets/upload/ADMSeleksi/question_1_1628133989_100_kimetsu_5_smasll.png');
	}

	function idAwalTes()
	{
		$token = $this->input->get('token');
		$nik = $this->input->get('nik');
		$list = $this->M_psikotes->cekValidToken($nik, $token);

		if(empty($list)){
			$data['error'] = 1;
			$data['id_tes'] = 0;
			$data['nama_tes'] = '';
			$data['instruksi'] = '';
		}else{
			$tes = $this->M_psikotes->getSetuptesbyid($list['id_test']);
			$data['error'] = 0;
			$data['id_tes'] = $tes['id_tes'];
			$data['nama_tes'] = $tes['nama_tes'];
			$data['instruksi'] = $tes['instruksi_tes'];
		}

		echo json_encode($data);
	}

	function cekSessionTes($nik = false, $token = false, $id_tes = false)
	{
		if (!$nik) $nik = $this->input->get('nik'); 
		if (!$token) $token = $this->input->get('token'); 
		if (!$id_tes) $id_tes = $this->input->get('idtes');
		$return = $this->input->get('type');

		$now = date('Y-m-d H:i:s');
		$sesi = $this->M_psikotes->getSesi($nik, $token, $id_tes, $now);
		$setup_tes = $this->M_psikotes->getSetuptesbyid($id_tes);
		if (empty($sesi) && !empty($setup_tes)) {
			// jika sesi kosong tapi di temukan setup pertanyaannya maka -> set session
			$arr = [
				'nik'		=>	$nik,
				'token'		=>	$token,
				'id_tes'	=>	$id_tes,
			];
			$data = $this->setSessionTes($setup_tes, $arr);
		}elseif (!empty($sesi)) {
			$data = $this->getSessionTes($sesi, $now);
		}else{
			$data['error'] = 1;
			$data['desc'] = 'Invalid Session';
			$data['start_sesi'] = 0;
		}

		if($return == 'json'){
			echo json_encode($data);
		}else{
			return $data;
		}
	}

	function getSessionTes($sesi, $now = false)
	{
		if(!$now) $now = date('Y-m-d H:i:s');

		$x = strtotime($now) <= strtotime($sesi['time_end']) && strtotime($now) >= strtotime($sesi['time_start']);
		if ($x) {
			$data['error'] = 0;
			$data['desc'] = 'di dalam session';
			$data['start_sesi'] = 0;
			$data['durasi'] = strtotime($sesi['time_end']) - strtotime($now);
		}else{
			$data['error'] = 1;
			$data['desc'] = 'di luar session';
			$data['start_sesi'] = 0;
		}
		return $data;
	}

	function setSessionTes($setup_tes, $info)
	{
		//$setup_tes adalah data dari table tsetuppertanyaan berdasarkan id

		$durasi = $setup_tes['menit']*60+$setup_tes['detik'];
		$d =  date('Y-m-d H:i:s');
		$d_end = date('Y-m-d H:i:s', time() + $durasi);
		$arr['nik'] = $info['nik'];
		$arr['kode_akses'] = $info['token'];
		$arr['id_tes'] = $info['id_tes'];
		$arr['time_start'] =$d;
		$arr['time_end'] = $d_end;
		$ins = $this->M_psikotes->insertSesi($arr);

		$data['error'] = 0;
		$data['desc'] = 'sesion baru';
		$data['start_sesi'] = 1;
		$data['durasi'] = $durasi;

		return $data;
	}

	function saveJawaban()
	{
		$token = $this->input->post('token');
		$nik = $this->input->post('nik');
		$id_test = $this->input->post('id_test');
		$id_pertanyaan = $this->input->post('id_pertanyaan');
		$id_test = $this->input->post('id_test');
		$jawaban = $this->input->post('jawaban');

		$cek = $this->cekSessionTes($nik, $token, $id_test);
		$data['start_sesi'] = isset($cek['start_sesi']) ? $cek['start_sesi']:0;
		$data = $cek;
		if (!$cek['error']) {
			$cek_jwb = $this->M_psikotes->cekJwb2($nik, $token, $id_test, $id_pertanyaan);
			$arr['nik'] = $nik;
			$arr['kode_akses'] = $token;
			$arr['id_tes'] = $id_test;
			$arr['id_pertanyaan'] = $id_pertanyaan;
			$arr['jawaban'] = $jawaban;

			if(empty($cek_jwb)){
				$ins = $this->M_psikotes->saveJwb($arr);
				$data['desc'] = 'Berhasil Simpan Jawaban';
			}else{
				$ins = $this->M_psikotes->updateJwb($arr, $cek_jwb['id']);
				$data['desc'] = 'Berhasil Update Jawaban';
			}
		}

		echo json_encode($data);
	}

	function SelesaiTes()
	{
		$token = $this->input->post('token');
		$nik = $this->input->post('nik');
		$id_test = $this->input->post('id_test');

		$upd = $this->M_psikotes->doneTes($nik, $token, $id_test);
		$data = $this->cekNextTes($nik, $token);

		$data['error'] = 0;

		echo json_encode($data);
	}

	function cekNextTes($nik = false, $token = false)
	{
		$token = $this->input->post('token');
		$nik = $this->input->post('nik');

		// $token = $this->input->get('token');
		// $nik = $this->input->get('nik');

		$sesi = $this->M_psikotes->getSesi2($nik, $token);
		$done = array_column($sesi, 'id_tes');
		$cek = $this->M_psikotes->getNextTes($nik, $token, $done);
		if (empty($cek)) {
			$data['next_tes'] = 'null';
			$data['nama_tes'] = 'null';
			$data['instruksi'] = 'null';
		}else{
			$tes = $this->M_psikotes->getSetuptesbyid($cek['id_test']);
			$data['next_tes'] = $tes['id_tes'];
			$data['nama_tes'] = $tes['nama_tes'];
			$data['instruksi'] = $tes['instruksi_tes'];
		}
		// echo '<pre>';
		// print_r($data);
		// exit;
		return $data;
	}
}