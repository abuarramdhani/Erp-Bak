<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_psikotes extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
	}

	function getJadwalPS($nik, $tanggal = '')
	{
		if($tanggal == '') $tanggal = date('Y-m-d');

		$sql = "select
					*
				from
					\"Adm_Seleksi\".tjadwal_psikotest tp
				where
					tp.nik = '$nik'
					and tp.tgl_test = '$tanggal'
				order by tp.waktu_mulai";
				// echo $sql;exit;
		return $this->personalia->query($sql)->result_array();
	}

	function cekValidToken($nik, $token, $tanggal = '')
	{
		if($tanggal == '') $tanggal = date('Y-m-d');

		$sql = "select
					*
				from
					\"Adm_Seleksi\".tjadwal_psikotest tp
				where
					tp.nik = '$nik'
					and tp.kode_akses = '$token'
					and tp.tgl_test = '$tanggal'
				order by tp.waktu_mulai limit 1";
				// echo $sql;exit;
		return $this->personalia->query($sql)->row_array();
	}

	function getNextTes($nik, $token, $done, $tanggal = '')
	{
		if($tanggal == '') $tanggal = date('Y-m-d');
		$done = implode(',', $done);

		$sql = "select
					*
				from
					\"Adm_Seleksi\".tjadwal_psikotest tp
				where
					tp.nik = '$nik'
					and tp.kode_akses = '$token'
					and tp.tgl_test = '$tanggal'
					and id_test not in ($done)
				order by tp.waktu_mulai limit 1";
				// echo $sql;exit;
		return $this->personalia->query($sql)->row_array();
	}

	function getAbsPsikotes($token)
	{
		$sql = "select
					*
				from
					\"Adm_Seleksi\".tpsikotes_absen ta
				where
					kode_akses = '$token' limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	function saveImgabs($arr)
	{
		$this->personalia->insert('"Adm_Seleksi".tpsikotes_absen', $arr);
		return $this->personalia->affected_rows() > 0;
	}

	function updtAbsPsi($arr, $token)
	{
		$this->personalia->where('kode_akses', $token);
		$this->personalia->update('"Adm_Seleksi".tpsikotes_absen', $arr);
		return $this->personalia->affected_rows() > 0;
	}

	function getSetupPertanyaan($l_materi)
	{
		$sql = "select
					*
				from
					\"Adm_Seleksi\".tsetuppertanyaan t
					left join \"Adm_Seleksi\".tspertanyaan t2 on t2.id_tes = t.id_tes
					left join \"Adm_Seleksi\".tsjawaban t3 on t3.id_pertanyaan = t2.id_pertanyaan 
				where
					nama_tes in('$l_materi')
				order by t.id_tes, t2.id_pertanyaan, t3.id_jawaban;";
				// echo $sql;
		return $this->personalia->query($sql)->result_array();
	}

	function getIdtesbyNama($nama_tes)
	{
		$sql = "SELECT * FROM \"Adm_Seleksi\".tsetuppertanyaan
				WHERE nama_tes = '$nama_tes' limit 1";
		return $this->personalia->query($sql);
	}

	function getIdtesbyNama2($nama_tes)
	{
		//$nama_tes tipe array
		$nama_tes = implode("','", $nama_tes);
		$sql = "SELECT * FROM \"Adm_Seleksi\".tsetuppertanyaan
				WHERE nama_tes in ('$nama_tes')";
		return $this->personalia->query($sql)->result_array();
	}

	function getPertanyaanByIdtes($id_tes, $no)
	{
		$sql = "SELECT *,
				t.id_pertanyaan
				FROM \"Adm_Seleksi\".tspertanyaan t
				left join \"Adm_Seleksi\".tsfilequestion tq on tq.id_pertanyaan = t.id_pertanyaan
				where id_tes = '$id_tes' and t.no_soal = '$no' order by t.id_pertanyaan limit 1";
				// echo $sql;
		return $this->personalia->query($sql)->row_array();
	}

	function getListJawaban($id_pertanyaan)
	{
		//$id_pertanyaan is Int
		$sql = "SELECT * FROM \"Adm_Seleksi\".tsjawaban tj where id_pertanyaan in ($id_pertanyaan)";
		return $this->personalia->query($sql)->result_array();
	}

	function getAllPertanyaanByIdtes($id_tes)
	{
		$sql = "SELECT *, t.id_pertanyaan FROM \"Adm_Seleksi\".tspertanyaan t
				left join \"Adm_Seleksi\".tsfilequestion tq on tq.id_pertanyaan = t.id_pertanyaan
				where id_tes = '$id_tes' order by t.id_pertanyaan";
				// echo $sql;exit;
		return $this->personalia->query($sql)->result_array();
	}

	function getSesi($nik, $token, $id_tes, $now)
	{
		$sql = "select
					*
				from
					\"Adm_Seleksi\".tpsikotes_sesi
				where
					nik = '$nik'
					and kode_akses = '$token'
					and id_tes = '$id_tes'
				limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	function getSesi2($nik, $token, $done=1)
	{
		$sql = "select
					*
				from
					\"Adm_Seleksi\".tpsikotes_sesi
				where
					nik = '$nik'
					and kode_akses = '$token'
					and done = $done";
		return $this->personalia->query($sql)->result_array();
	}

	function getSetuptesbyid($id)
	{
		$sql = "SELECT * FROM \"Adm_Seleksi\".tsetuppertanyaan where id_tes = '$id' limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	function insertSesi($data)
	{
		$this->personalia->insert('"Adm_Seleksi".tpsikotes_sesi', $data);
		return $this->personalia->affected_rows();
	}

	function saveJwb($data)
	{
		$this->personalia->insert('"Adm_Seleksi".tpsikotes_jawaban', $data);
		return $this->personalia->affected_rows();
	}

	function updateJwb($data, $id)
	{
		$this->personalia->where('id', $id);
		$this->personalia->update('"Adm_Seleksi".tpsikotes_jawaban', $data);
		return $this->personalia->affected_rows();
	}

	function cekJwb($nik, $kode_akses, $id_tes)
	{
		$sql = "SELECT * FROM \"Adm_Seleksi\".tpsikotes_jawaban tj
				left join \"Adm_Seleksi\".tspertanyaan tp on tp.id_pertanyaan = tj.id_pertanyaan
				where tj.nik = '$nik' and tj.kode_akses = '$kode_akses' and tj.id_tes = '$id_tes'";
		return $this->personalia->query($sql)->result_array();
	}

	function cekJwb2($nik, $kode_akses, $id_tes, $id_pertanyaan)
	{
		$sql = "SELECT * FROM \"Adm_Seleksi\".tpsikotes_jawaban tj
				left join \"Adm_Seleksi\".tspertanyaan tp on tp.id_pertanyaan = tj.id_pertanyaan
				where tj.nik = '$nik' and tj.kode_akses = '$kode_akses' and tj.id_tes = '$id_tes' and tj.id_pertanyaan = '$id_pertanyaan' limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	function doneTes($nik, $token, $id_test, $done = 1)
	{
		$this->personalia->where('nik', $nik);
		$this->personalia->where('kode_akses', $token);
		$this->personalia->where('id_tes', $id_test);
		$this->personalia->update('"Adm_Seleksi".tpsikotes_sesi', ['done' => $done]);
		return $this->personalia->affected_rows();
	}
}