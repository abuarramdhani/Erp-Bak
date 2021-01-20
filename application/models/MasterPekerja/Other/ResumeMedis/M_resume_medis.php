<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_resume_medis extends CI_Model
{
	private $_tablePerusahaan = 'kk.kk_perusahaan';

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
		$this->erp =	$this->load->database('erp_db', TRUE);
	}

	public function rulesPerusahaan()
	{
		return [
			[
				'field' => 'txt_namaPerusahaan',
				'label' => 'Nama Perusahaan',
				'rules' => 'required'
			],

			[
				'field' => 'txt_kodeMitraPerusahaan',
				'label' => 'Kode Mitra',
				'rules' => 'required'
			],

			[
				'field' => 'txt_alamatPerusahaan',
				'label' => 'Alamat',
				'rules' => 'required'
			],

			[
				'field' => 'txt_desaPerusahaan',
				'label' => 'Desa',
				'rules' => 'required'
			],

			[
				'field' => 'txt_kecamatanPerusahaan',
				'label' => 'Kecamatan',
				'rules' => 'required'
			],

			[
				'field' => 'txt_kotaPerusahaan',
				'label' => 'Kota',
				'rules' => 'required'
			],

			[
				'field' => 'txt_noTelpPerusahaan',
				'label' => 'No Telepon',
				'rules' => 'required'
			],

			[
				'field' => 'txt_namaKontakPersonilPerusahaan',
				'label' => 'Kontak Personal',
				'rules' => 'required'
			]

		];
	}

	public function getDataPerusahaan()
	{
		return $this->erp->get($this->_tablePerusahaan)->result();
	}

	public function getDataPerusahaanById($id_perusahaan)
	{
		return $this->erp->get_where($this->_tablePerusahaan, ['id_perusahaan' => $id_perusahaan])->row();
	}

	public function savePerusahaan($insert_perusahaan)
	{
		$this->erp->insert('kk.kk_perusahaan', $insert_perusahaan);
		return $this->erp->insert_id();
	}

	public function kk_perusahaan_history($history)
	{
		$this->erp->insert('kk.kk_perusahaan_history', $history);
	}

	public function updatePerusahaan($update_perusahaan, $id_dekrip_perusahaan)
	{
		$this->erp->where('id_perusahaan', $id_dekrip_perusahaan);
		$this->erp->update('kk.kk_perusahaan', $update_perusahaan);
	}

	public function deletePerusahaan($id_perusahaan)
	{
		return $this->erp->delete($this->_tablePerusahaan, array('id_perusahaan' => $id_perusahaan));
	}

	public function getDataPekerjaByid($pekerja)
	{
		return $this->personalia->query(
			"	SELECT tp.noind, tp.nama
				FROM hrd_khs.v_hrd_khs_tpribadi tp
				where (tp.noind like '%$pekerja%' or tp.nama like '%$pekerja%' )
			"
		)
			->result_array();
	}

	public function getPerusahaan($perusahaan)
	{
		return $this->erp->query(
			"	SELECT * FROM kk.kk_perusahaan
				WHERE ( kode_mitra LIKE '%$perusahaan%' OR kota LIKE '%$perusahaan%')
			"
		)
			->result_array();
	}

	public function getDataPekerjaRow($noind)
	{
		return $this->personalia->query(
			"SELECT tp.noind, tp.nama, tp.jenkel, tp.templahir, tp.tgllahir, tp.alamat, tp.desa, tp.kec, tp.kab, tp.prop, tp.kodepos, tp.nohp, tp.kodesie, tp.kd_jabatan, tp.jabatan, ts.seksi
			FROM hrd_khs.v_hrd_khs_tpribadi tp
			INNER JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
			WHERE tp.noind = '$noind'
			"
		)->result_array();
	}

	public function getNoPeserta($noind)
	{
		$no_peserta =  $this->personalia->query(
			"SELECT tbp.noind, tbp.no_peserta
			FROM hrd_khs.tbpjstk tbp
			WHERE tbp.noind = '$noind'
			"
		)->result_array();
		return $no_peserta;
	}

	public function saveDataResumeMedis($dataResumeMedis)
	{
		$this->erp->insert('kk.kk_resume_medis', $dataResumeMedis);
		return $this->erp->insert_id();
	}

	public function getDataResumeMedis()
	{
		return $this->erp->query(
			"SELECT rm.id_rm, rm.kd_mitra, rm.noind, rm.nama, rm.tgl_laka, rm.tgl_periksa
			 FROM kk.kk_resume_medis rm
			 ORDER BY rm.id_rm DESC
			"
		)->result_array();
	}

	public function getDataResumeMedisById($id)
	{
		return $this->erp->query(
			"SELECT rm.id_rm, rm.kd_mitra, rm.noind, rm.nama, rm.tgl_laka, rm.tgl_periksa
			 FROM kk.kk_resume_medis rm
			 WHERE rm.id_rm = '$id'
			"
		)->result_array();
	}

	public function deleteResumeMedis($id_rm)
	{
		return $this->erp->delete('kk.kk_resume_medis', array('id_rm' => $id_rm));
	}

	public function getPerusaanByid($kd_mitra)
	{
		return $this->erp->query(
			"SELECT kp.kode_mitra, kp.kota, kp.keterangan
			FROM kk.kk_perusahaan kp
			WHERE kp.kode_mitra = '$kd_mitra'"
		)->result_array();
	}

	public function cetakResumeMedis($id)
	{
		return $this->erp->query(
			"	SELECT rm.id_rm, rm.noind, rm.nama, rm.jenkel, rm.templahir, rm.tgllahir, rm.alamat, rm.desa, rm.kec, rm.kab, rm.prop, rm.kodepos, rm.nohp, rm.seksi, rm.jabatan, rm.no_peserta, rm.tgl_laka, rm.tgl_periksa, rm.kd_mitra, kp.nama_perusahaan, kp.alamat as alper, kp.no_telp 
			From kk.kk_resume_medis rm
			INNER JOIN  kk.kk_perusahaan kp ON rm.kd_mitra= kp.kode_mitra
			WHERE rm.id_rm = '$id'
			"
		)->result_array();
	}

	public function getNoindResMedisById($id)
	{
		return $this->erp->query(
			"SELECT rm.id_rm, rm.noind  
			FROM kk.kk_resume_medis rm 
			WHERE rm.id_rm = '$id'"
		)->result_array();
	}

	public function updateDataResumeMedis($id_rm, $updateResumeMedis)
	{
		$this->erp->where('id_rm', $id_rm);
		$this->erp->update('kk.kk_resume_medis', $updateResumeMedis);
	}


	public function insertTlog($dataLog)
	{
		$this->personalia->insert('hrd_khs.tlog', $dataLog);
	}

	function tgl_indo1($lahir)
	{

		$bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$exp =  explode("-", $lahir);

		return  $exp[2] . ' ' . $bulan[(int)$exp[1]] . ' ' . $exp[0];;
	}
}
