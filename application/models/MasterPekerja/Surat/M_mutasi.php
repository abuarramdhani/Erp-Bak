<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_mutasi extends CI_Model
	{
    	public function __construct()
	    {
	       parent::__construct();
	       $this->personalia 	= 	$this->load->database('personalia', TRUE);
	    }

	    public function create($create)
	    {
	    	$this->personalia->insert('"Surat".tsurat_mutasi', $create);
	    }

	    public function view($tanggal_cetak = FALSE, $kode_surat = FALSE, $nomor_surat = FALSE)
	    {
	    	$this->personalia->select('	tsurat_mutasi.*,
	    		 						tpribadi.nama,
	    		 						tsurat_mutasi.lokasi_kerja_lama kode_lokasi_kerja_lama,
	    		 						tsurat_mutasi.lokasi_kerja_baru kode_lokasi_kerja_baru,
	    		 						lokasi_lama.lokasi_kerja lokasi_kerja_lama,
	    		 						lokasi_baru.lokasi_kerja lokasi_kerja_baru,
	    								tseksi_lama.dept dept_lama,
	    								tseksi_lama.bidang bidang_lama,
	    								tseksi_lama.unit unit_lama,
	    								tseksi_lama.seksi seksi_lama,
	    								tseksi_lama.pekerjaan pekerjaan_lama,
	    								tseksi_baru.dept dept_baru,
	    								tseksi_baru.bidang bidang_baru,
	    								tseksi_baru.unit unit_baru,
	    								tseksi_baru.seksi seksi_baru,
	    								tseksi_baru.pekerjaan pekerjaan_baru');
	    	$this->personalia->from('"Surat".tsurat_mutasi');
	    	$this->personalia->join('hrd_khs.v_hrd_khs_tseksi tseksi_lama', 'tseksi_lama.kodesie = tsurat_mutasi.kodesie_lama');
	    	$this->personalia->join('hrd_khs.v_hrd_khs_tseksi tseksi_baru', 'tseksi_baru.kodesie = tsurat_mutasi.kodesie_baru');
	    	$this->personalia->join('hrd_khs.v_hrd_khs_tpribadi tpribadi', 'tpribadi.noind=tsurat_mutasi.noind');
	    	$this->personalia->join('hrd_khs.tlokasi_kerja lokasi_lama', 'lokasi_lama.id_ = tsurat_mutasi.lokasi_kerja_lama');
	    	$this->personalia->join('hrd_khs.tlokasi_kerja lokasi_baru', 'lokasi_baru.id_ = tsurat_mutasi.lokasi_kerja_baru');
	    	
	    	if($tanggal_cetak !== FALSE && $kode_surat !== FALSE && $nomor_surat !== FALSE)
	    	{
	    		$this->personalia->where('tanggal_cetak=', $tanggal_cetak);
	    		$this->personalia->where('kode_surat=', $kode_surat);
	    		$this->personalia->where('nomor_surat=', $nomor_surat);
	    	}
				$this->personalia->where('deleted_date is null');

	    	$this->personalia->order_by('tanggal_cetak', 'desc');
	    	return $this->personalia->get()->result_array();
	    }

	    public function update($tanggal_cetak, $kode_surat, $nomor_surat, $update)
	    {
	    	$this->personalia->where('tanggal_cetak=', $tanggal_cetak);
	    	$this->personalia->where('kode_surat=', $kode_surat);
	    	$this->personalia->where('nomor_surat=', $nomor_surat);

	    	$this->personalia->update('"Surat".tsurat_mutasi', $update);
	    }

	    public function delete($tanggal_cetak, $kode_surat, $nomor_surat)
	    {
	    	$this->personalia->where('tanggal_cetak=', $tanggal_cetak);
	    	$this->personalia->where('kode_surat=', $kode_surat);
	    	$this->personalia->where('nomor_surat=', $nomor_surat);

	    	$this->personalia->delete('"Surat".tsurat_mutasi');
	    }
 	}