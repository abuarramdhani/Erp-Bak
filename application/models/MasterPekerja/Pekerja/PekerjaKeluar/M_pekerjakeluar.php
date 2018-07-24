<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pekerjakeluar extends CI_Model {
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp', TRUE);
		$this->daerah 		=	$this->load->database('daerah', TRUE);
		
	}
	
	public function getPekerja($pekerja,$keluar)
	{
		$this->personalia->like('noind', $pekerja);
		$this->personalia->or_like('nama', $pekerja);
		$this->personalia->where('keluar', $keluar);
		$this->personalia->select('nama,noind');
		$query = $this->personalia->get('hrd_khs.tpribadi');
		return $query->result_array();
	}
	public function dataPekerja($noind,$keluar)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->where('keluar', $keluar);
		$query = $this->personalia->get('hrd_khs.tpribadi');
		return $query->result_array();
	}
	public function dataSeksi($kodesie)
	{
		$this->personalia->where('kodesie', $kodesie);
		$query = $this->personalia->get('hrd_khs.tseksi');
		return $query->result_array();
	}
	public function updateDataPekerja($data,$noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tpribadi',$data);
		return;
	}
	public function historyUpdatePekerja($history)
	{
		$this->personalia->insert('hrd_khs.tpribadi_log', $history);
		return;
	}
	public function getProvinsi($provinsi)
	{
		$this->daerah->like('nama', $provinsi);
		$query = $this->daerah->get('provinsi');
		return $query->result_array();
	}
	public function getKabupaten($kabupaten,$id_prov)
	{
		$this->daerah->where('id_prov', $id_prov);
		$this->daerah->like('nama', $kabupaten);
		$query = $this->daerah->get('kabupaten');
		return $query->result_array();
	}
	public function getKecamatan($kecamatan,$id_kab)
	{
		$this->daerah->where('id_kab', $id_kab);
		$this->daerah->like('nama', $kecamatan);
		$query = $this->daerah->get('kecamatan');
		return $query->result_array();
	}
	public function getDesa($desa,$id_kec)
	{
		$this->daerah->where('id_kec', $id_kec);
		$this->daerah->like('nama', $desa);
		$query = $this->daerah->get('kelurahan');
		return $query->result_array();
	}
};
