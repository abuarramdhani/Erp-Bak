<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cetakttbpjs extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}
	public function ambilData()
	{	
		$query = $this->erp->where('stat_cetak','0');
		$query = $this->erp->get('kk.kk_cetaktanterbpjs');
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
		$query = "select tp.noind, tp.nama, ts.seksi, (select tk.no_peserta from hrd_khs.tbpjstk tk where tp.noind=tk.noind) as no_kpj, (select tk.kartu_jaminan_pensiun from hrd_khs.tbpjstk tk where tp.noind=tk.noind) as jp, (select lk.lokasi_kerja from hrd_khs.tlokasi_kerja lk where tp.lokasi_kerja=lk.id_) as lokasi from hrd_khs.tpribadi tp inner join hrd_khs.tseksi ts on tp.kodesie=ts.kodesie where tp.noind='$noind'";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function insertData($array)
	{
		$this->erp->insert('kk.kk_cetaktanterbpjs', $array);
		return;
	}
	public function deleteData($id)
	{
		$query = "update kk.kk_cetaktanterbpjs set stat_cetak='1' where stat_cetak = '0' and id_cetaktanterbpjs = '$id';";
		$this->erp->query($query);
		// $this->erp->where('id_cetaktanterbpjs',$id);
		// $this->erp->delete('kk.kk_cetaktanterbpjs');
		// return;
	}
	
	public function deleteDataAll(){
		$query = "update kk.kk_cetaktanterbpjs set stat_cetak='1' where stat_cetak = '0';";
		$this->erp->query($query);
	}
};
