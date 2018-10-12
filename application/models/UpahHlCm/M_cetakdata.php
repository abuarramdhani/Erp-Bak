<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cetakdata extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	public function ambilPekerja($p)
	{
		$query = "select noind,nama from hrd_khs.tpribadi where (noind like '%$p%' or nama like '%$p%') and keluar='0' and noind like 'R%' order by noind";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function ambilKepalaTukang()
	{
		$query = "select tp.noind,tp.nama,(select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) as pekerjaan from hrd_khs.tpribadi tp where tp.nama in ('WALUYO','MUGIYANA','KLIMIN','PARTIMIN','MUHAMMAD SADALI','SURAJI','NUR SIHONO','SUKRI','PARLAN','SUJONO','HERU WIDODO') and noind like 'R%' group by tp.noind,tp,nama,pekerjaan order by pekerjaan";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function ambildataRekap($tanggalawal,$tanggalakhir)
	{
		$query = "select pk.no_rekening, pk.noind, pk.atas_nama, (select b.nama_bank from hlcm.hlcm_bank b where pk.bank=b.code_bank) as bank from hlcm.hlcm_datapekerja pk";
		$data = $this->erp->query($query);
		return $data->result_array();
	}

	
	
};
