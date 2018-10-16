<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cetakttbpjskes extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}
	public function ambilData()
	{
		$query = $this->erp->get('kk.kk_cetaktanterbpjskes');
		return $query->result_array();
	}
	public function getPekerja($p)
	{
		$data_pekerja = $this->personalia->query("select tp.noind, tp.nama, (select ts.seksi from hrd_khs.tseksi ts where tp.kodesie=ts.kodesie) as seksi
									from hrd_khs.v_hrd_khs_tpribadi as tp 
									where (tp.noind like '%$p%' or tp.nama like '%$p%' ) and tp.keluar='0' order by tp.noind");
		return $data_pekerja->result_array();
	}

	public function dataBPJS($noind)
	{
		$query = "select tp.noind, tp.nama, ts.seksi, (select kes.no_peserta from hrd_khs.tbpjskes kes where tp.noind=kes.noind) as no_kes, (select lk.lokasi_kerja from hrd_khs.tlokasi_kerja lk where tp.lokasi_kerja=lk.id_) as lokasi from hrd_khs.tpribadi tp inner join hrd_khs.tseksi ts on tp.kodesie=ts.kodesie where tp.noind='$noind'";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function insertData($array)
	{
		$this->erp->insert('kk.kk_cetaktanterbpjskes', $array);
		return;
	}
	public function deleteData($id)
	{
		$this->erp->where('id_cetaktanterbpjskes',$id);
		$this->erp->delete('kk.kk_cetaktanterbpjskes');
		return;
	}
	
};
