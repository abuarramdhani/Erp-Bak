<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_SetupPenjadwalan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
	    $this->load->model('Api/Psikotes/M_setuppsikotes');
	    $this->load->model('ADMSeleksi/M_setting');
	    $this->load->library('KonversiBulan');
		$this->load->model('ADMSeleksi/M_penjadwalan');
		$this->load->model('ADMSeleksi/M_hasiltes');
	    date_default_timezone_set('Asia/Jakarta');
	    $this->load->model('ADMSeleksi/M_hasiltes');
	    $this->load->library('Upload');
	}


	public function get_nama_psikotest(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_penjadwalan->get_namates($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function search(){
		$tipe = $this->input->post('tipe');
		$tanggal = $this->input->post('tanggal');
		$getdata = $this->M_penjadwalan->data_peserta($tipe, $tanggal);
		foreach ($getdata as $key => $value) {
			$getdata[$key]['kode_akses'] = $this->randomKodeAkses(6, false, 'lud');
		}

		$data['data'] = $getdata;
		$html = $this->load->view('ADMSeleksi/Penjadwalan/V_Daftar_Peserta', $data, true);
		echo $html;
	}

	function randomKodeAkses($length = 6, $add_dashes = false, $available_sets = 'luds')
	{
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$kode_akses = '';
		foreach($sets as $set)
		{
			$kode_akses .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$kode_akses .= $all[array_rand($all)];
		$kode_akses = str_shuffle($kode_akses);
		if(!$add_dashes)
			return $kode_akses;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($kode_akses) > $dash_len)
		{
			$dash_str .= substr($kode_akses, 0, $dash_len) . '-';
			$kode_akses = substr($kode_akses, $dash_len);
		}
		$dash_str .= $kode_akses;
		return $dash_str;
	}

	public function save(){
		// echo "<pre>";
		// print_r($_POST);exit;
		$tipe           = $this->input->post('kode_akses_psikotest');
		$tanggal        = $this->input->post('tanggal_surat_psikotest');
		$kode           = $tipe.'_'.DateTime::createFromFormat('d/m/Y', $tanggal)->format('dmy');
		$tgl_tes        = $this->input->post('tanggal_psikotest');
		$waktu_mulai    = $this->input->post('waktu_mulai_psikotest');
		$waktu_selesai  = $this->input->post('waktu_selesai_psikotest');
		$zona           = $this->input->post('zona_psikotest');
		$nama_tes       = $this->input->post('nama_test_psikotest');

		$nama_peserta   = $this->input->post('nama_peserta');
		$nohp           = $this->input->post('no_hp');
		$kode_akses     = $this->input->post('kode_akses');
		$nik   = $this->input->post('nik');
		$pendidikan     = $this->input->post('pendidikan');

		$datanya = array();
		for ($i=0; $i < count($nama_peserta); $i++) { 
			for ($t=0; $t < count($nama_tes) ; $t++) { 
				$datanya = array( 'kode_test' => $kode,
					'tgl_surat' => DateTime::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d'),
					'tgl_test' => DateTime::createFromFormat('d/m/Y', $tgl_tes)->format('Y-m-d'),
					'waktu_mulai' => $waktu_mulai,
					'waktu_selesai' => $waktu_selesai,
					'zona' => $zona,
					'id_test' => $nama_tes[$t],
					'nik' => $nik[$i],
					'nama_peserta' => $nama_peserta[$i],
					'pendidikan' => $pendidikan[$i],
					'no_hp' => $nohp[$i],
					'kode_akses' => $kode_akses[$i],
					'created_by' => $this->session->user,
					'creation_date' => date('Y-m-d H:m:i')

				);
				$this->M_penjadwalan->savePesertaPsikotest($datanya);
			}
		}
		$this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'SET UP PENJADWALAN PSIKOTEST', "INPUT DATA $kode", $this->session->user, "INPUT DATA PESERTA", "PENJADWALAN PSIKOTEST");

		echo 'success';
	}

	public function search_monitoring(){
		$ket        = $this->input->post('ket');
		$data['id'] = $this->input->post('id');
		$getdata    = $this->M_penjadwalan->data_psikotest($ket);
		$kode = $datanya = array();
		foreach ($getdata as $key => $value) {
			$kodetgl = $value['kode_test'].'_'.DateTime::createFromFormat('Y-m-d', $value['tgl_test'])->format('dmy');
			if (!in_array($kodetgl, $kode)) {
				$nama = array();
				array_push($kode, $kodetgl);
				array_push($nama, $value['nama_peserta']);
				$datanya[$kodetgl] = $value;
				$datanya[$kodetgl]['peserta'][] = $value['nama_peserta'];
			}else {
				if (!in_array($value['nama_peserta'], $nama)) {
					$datanya[$kodetgl]['peserta'][] = $value['nama_peserta'];
					array_push($nama, $value['nama_peserta']);
				}
			}
		}
		$data['data'] = $datanya;
		echo $this->load->view('ADMSeleksi/Penjadwalan/V_Monitoring_Table', $data , true);
	}

	public function search_hasilTes(){
		$ket        = $this->input->post('ket');
		$data['id'] = $this->input->post('id');
		$data['data']    = $this->M_hasiltes->data_psikotest($ket);
		echo $this->load->view('ADMSeleksi/HasilTes/V_Mon_Table', $data, true);
	}

	public function hapus_jadwal(){
		$this->M_penjadwalan->hapus_jadwal($this->input->post('kode'), $this->input->post('tgl'));
		$this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "HAPUS JADWAL ".$this->input->post('kode').", TANGGAL ".$this->input->post('tgl')."", "ADMIN", "HAPUS DATA JADWAL PSIKOTEST", "PENJADWALAN PSIKOTEST");

		echo "success";
	}

	function getDataPsikotes()
	{
		// print_r($_POST);exit;
		$kode = $this->input->post('kode');
		$tgltes = $this->input->post('tgltes');
		$kode = str_replace('-','/',$kode);
		$tgltes = DateTime::createFromFormat('dmy', $tgltes)->format('Y-m-d');

		$data['data'] = $this->M_penjadwalan->data_psikotest2($kode, $tgltes);
		$data['tes'] = $this->M_penjadwalan->data_tes($kode, $tgltes);
		$arrTes = array();
		foreach ($data['tes'] as $key) {
			$arrTes[] = $this->M_penjadwalan->get_namates2($key['id_test']);
		}
		$data['namaTes'] = $arrTes;

		echo json_encode($data);
	}

	public function save_edit(){
		$tipe           = $this->input->post('kode_akses_psikotest');
		$tanggal        = $this->input->post('tanggal_surat_psikotest');
		$kode           = $tipe.'_'.DateTime::createFromFormat('d/m/Y', $tanggal)->format('dmy');
		$tgl_tes        = $this->input->post('tanggal_psikotest');
		$waktu_mulai    = $this->input->post('waktu_mulai_psikotest');
		$waktu_selesai  = $this->input->post('waktu_selesai_psikotest');
		$zona           = $this->input->post('zona_psikotest');
		$nama_peserta   = $this->input->post('nama_peserta');
		$nama_tes       = $this->input->post('nama_test_psikotest');
		$nik            = $this->input->post('nik');
		$pendidikan     = $this->input->post('pendidikan');
		$no_hp          = $this->input->post('no_hp');
		$kode_akses     = $this->input->post('kode_akses');

		$datanya = array();
		for ($i=0; $i < count($nama_peserta); $i++) { 
			for ($t=0; $t < count($nama_tes) ; $t++) { 
				$cek = $this->M_penjadwalan->cek_jadwal($nama_tes[$t], $kode_akses[$i]);
				if (!empty($cek)) {
					$datanya = array( 'kode_test' => $kode,
						'tgl_test' => DateTime::createFromFormat('d/m/Y', $tgl_tes)->format('Y-m-d'),
						'waktu_mulai' => $waktu_mulai,
						'waktu_selesai' => $waktu_selesai,
						'zona' => $zona,
						'id_test' => $nama_tes[$t],
						'kode_akses' => $kode_akses[$i],
					);
					$this->M_penjadwalan->updatePesertaPsikotest($datanya);
				}else {
					$datanya = array( 'kode_test' => $kode,
						'tgl_surat' => DateTime::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d'),
						'tgl_test' => DateTime::createFromFormat('d/m/Y', $tgl_tes)->format('Y-m-d'),
						'waktu_mulai' => $waktu_mulai,
						'waktu_selesai' => $waktu_selesai,
						'zona' => $zona,
						'id_test' => $nama_tes[$t],
						'nik' => $nik[$i],
						'nama_peserta' => $nama_peserta[$i],
						'pendidikan' => $pendidikan[$i],
						'no_hp' => $no_hp[$i],
						'kode_akses' => $kode_akses[$i],
						'created_by' => $this->session->user,
						'creation_date' => date('Y-m-d H:m:i')

					);
					$this->M_penjadwalan->savePesertaPsikotest($datanya);
				}
			}
		}
		$this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "EDIT DATA $kode", 'ADMIN', "EDIT DATA PESERTA", "PENJADWALAN PSIKOTEST");

		$peserta_hapus = $this->input->post('peserta_terhapus');
		$hapus = explode('+', $peserta_hapus);
		for ($i=0; $i < count($hapus) ; $i++) { 
			$namanya = explode('_',$hapus[$i]);
        // $this->M_penjadwalan->hapus_peserta($namanya[1]);
			if(!isset($namanya[1])) continue;
			$this->M_penjadwalan->hapus_peserta2($namanya[1]);
			$this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING PENJADWALAN PSIKOTEST', "HAPUS PESERTA ".$namanya[0]."", 'ADMIN', "HAPUS DATA PESERTA", "PENJADWALAN PSIKOTEST");
		}
		echo 'success';
	}

	public function get_nama_peserta(){
		$tipe = $this->input->get('tipe',TRUE);
		$tanggal = DateTime::createFromFormat('d/m/Y', $this->input->get('tanggal',TRUE))->format('Y-m-d');
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_hasiltes->get_nama_peserta($term, $tipe, $tanggal);
		echo json_encode($data);
	}

	function apiSearchHasilTes()
	{
        $tipe       = $this->input->post('tipe');
        $tanggal    = $this->input->post('tanggal');
        $tes        = $this->input->post('tes');
        $peserta    = $this->input->post('peserta');

        $tanggal = !empty($tanggal) ? "and a.tgl_test = '". DateTime::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d')."'" : '';
        $nama_peserta = !empty($peserta) ? "and a.nama_peserta = '$peserta'" : '';
        $nama_tes = !empty($tes) ? "and a.id_test = $tes" : '';
            
        $getdata = $this->M_hasiltes->data_hasil_tes($tipe, $tanggal, $nama_peserta, $nama_tes);
        $data['data'] = $getdata;
        echo $this->load->view("ADMSeleksi/HasilTes/V_Collect_Table", $data, true);
	}

	function apiDetailTes()
	{
		$kode = $this->input->get('kode');
		$kode = explode("_", $kode);
		$kode_akses = $kode[0];
		$id_tes = $kode[1];
		$getdata = $this->M_hasiltes->detail_tes($kode_akses, $id_tes);
		$data['data'] = $this->olah_hasil($getdata);

		echo json_encode($data);
	}

	function olah_hasil($getdata){
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$datanya[$value['nik']][$value['nama_tes']][] = $value;
		}
		return $datanya;
	}

	function hapus_hasil_tes(){
		$kode = $this->input->post('kode');
		$id_tes = $this->input->post('id_tes');
		$this->M_hasiltes->delete_jawaban($kode, $id_tes);
		$this->M_hasiltes->delete_sesi($kode, $id_tes);
		$this->M_hasiltes->delete_peserta($kode, $id_tes);
		$this->M_penjadwalan->insert_log(date('Y-m-d H:i:s'), 'MONITORING HASIL TES', "HAPUS HASIL TES, kode akses ".$kode.", id tes ".$id_tes, "ADMIN", "HAPUS DATA HASIL TES", "MONITORING HASIL TES");

		echo 'success';
	}

	function Lihat_detail()
	{
		$kode = $this->input->post('collect_peserta');
		if (empty($kode)) {
			echo "<script>
			alert('Check Nama Peserta terlebih dahulu!');
			</script>" ;
			exit();
		}
		$pisah = explode("+", $kode);
		$kode = '';
		for ($i=0; $i < count($pisah) ; $i++) { 
			if ($pisah[$i] != '') {
				$kode = $i == 0 ? "'".$pisah[$i]."'" : $kode.", '".$pisah[$i]."'";
			}
		}
		$getdata = $this->M_hasiltes->getdata_hasil($kode);
		$data = $this->olah_hasil($getdata);

		echo json_encode($data);
	}

	function Export_detail()
	{
		$kode = $this->input->post('collect_peserta');
		if (empty($kode)) {
			echo "<script>
			alert('Check Nama Peserta terlebih dahulu!');
			</script>" ;
			exit();
		}
		$pisah = explode("+", $kode);
		$kode = '';
		for ($i=0; $i < count($pisah) ; $i++) { 
			if ($pisah[$i] != '') {
				$kode = $i == 0 ? "'".$pisah[$i]."'" : $kode.", '".$pisah[$i]."'";
			}
		}
		$getdata = $this->M_hasiltes->getdata_hasil($kode);
		$data = $this->olah_hasil($getdata);
		echo json_encode($data);
	}
}