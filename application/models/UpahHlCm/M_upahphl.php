<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_upahphl extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}
	
	public function ambilDataGaji($lokasi_kerja)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$query = $this->erp->get('hlcm.hlcm_datagaji');
		// $this->erp->order_by('id_datagaji','ASC');
		return $query->result_array();
	}
	
	public function updateKepalaTukang($lokasi_kerja,$nomkepala)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$this->erp->where('pekerjaan','KEPALA TUKANG');
		$this->erp->update('hlcm.hlcm_datagaji',$nomkepala);
		return;
	}
	public function updateTukang($lokasi_kerja,$nomtukang)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$this->erp->where('pekerjaan','TUKANG');
		$this->erp->update('hlcm.hlcm_datagaji',$nomtukang);
		return;
	}
	public function updateSerabutan($lokasi_kerja,$nomserabutan)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$this->erp->where('pekerjaan','SERABUTAN');
		$this->erp->update('hlcm.hlcm_datagaji',$nomserabutan);
		return;
	}
	public function updateTenaga($lokasi_kerja,$nomtenaga)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$this->erp->where('pekerjaan','TENAGA');
		$this->erp->update('hlcm.hlcm_datagaji',$nomtenaga);
		return;
	}
	public function updateUangMakan($lokasi_kerja,$uangmakan)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$this->erp->update('hlcm.hlcm_datagaji',$uangmakan);
		return;
	}
	public function getDataPekerja($lokasi_kerja)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$query = $this->erp->get('hlcm.hlcm_datapekerja');
		return $query->result_array();
	}
	public function getPekerja($pekerja,$lokasi_kerja)
	{
		$query = "select tp.noind,tp.nama, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) from hrd_khs.tpribadi tp where (tp.noind like '%$pekerja%' or tp.nama like '%$pekerja%') and tp.lokasi_kerja='$lokasi_kerja' and tp.noind like 'R%' order by tp.noind";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function pekerjaApproval($pekerja,$lokasi_kerja)
	{
		$query = "select tp.noind,tp.nama, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) from hrd_khs.tpribadi tp where (tp.noind like '%$pekerja%' or tp.nama like '%$pekerja%') and tp.lokasi_kerja='$lokasi_kerja' order by tp.noind";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function getBank($bank)
	{
		$query = "select code_bank, nama_bank from hlcm.hlcm_bank where nama_bank like '%$bank%'";
		$data = $this->erp->query($query);
		return $data->result_array();
	}
	public function changeNama($noind)
	{
		$query = "select tp.nama, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) as pekerjaan from hrd_khs.tpribadi tp where tp.noind='$noind'";
		// $this->personalia->where('noind',$noind);
		// $data = $this->personalia->get('hrd_khs.tpribadi');
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function namaPekerja($noind)
	{
		$query = "select tp.nama from hrd_khs.tpribadi tp where tp.noind='$noind'";
		// $this->personalia->where('noind',$noind);
		// $data = $this->personalia->get('hrd_khs.tpribadi');
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function simpanDataPekerja($array)
	{
		$this->erp->insert('hlcm.hlcm_datapekerja',$array);
		return;
	}
	public function pekerjaan($pekerjaan)
	{
		$this->personalia->where('pekerjaan',$pekerjaan);
		$data = $this->personalia->get('hrd_khs.tpekerjaan');
		return $data->result_array();
	}
	public function dataApproval()
	{
		$query = "select ap.*, (select ket.posisi from hlcm.hlcm_posisi ket where ap.id_status=ket.id_status) as posisi from hlcm.hlcm_approval ap";
		$data = $this->erp->query($query);
		return $data->result_array();
	}

	public function ambilDataApproval($id)
	{
		$query = "select * from hlcm.hlcm_approval ORDER BY id_approval ASC";
		// $this->erp->where('id_approval',$id);
		// $this->erp->order_by('id_approval','ASC');
		$data = $this->erp->query($query);
		return $data->result_array();
	}
	public function simpanApproval($id,$array)
	{
		$this->erp->where('id_approval',$id);
		$this->erp->update('hlcm.hlcm_approval',$array);
		return;
	}
	public function ambilDataPek($id)
	{
		$this->erp->where('id_pekerja', $id);
		$data = $this->erp->get('hlcm.hlcm_datapekerja');
		return $data->result_array();
	}
	public function pekerjaankode($kdpkj)
	{
		$query = "select pekerjaan from hrd_khs.tpekerjaan where kdpekerjaan='$kdpkj'";
		$data= $this->personalia->query($query);
		return $data->result_array();
	}
	public function ambilnamaBank($kdbank)
	{
		$query = "select nama_bank from hlcm.hlcm_bank where code_bank='$kdbank'";
		$data = $this->erp->query($query);
		return $data->result_array();
	}
	public function ambilkodeBank($bank)
	{
		$query = "select code_bank from hlcm.hlcm_bank where nama_bank='$bank'";
		$data = $this->erp->query($query);
		return $data->result_array();
	}
	public function updateDataPekerja($array,$id)
	{
		$this->erp->where('id_pekerja',$id);
		$this->erp->update('hlcm.hlcm_datapekerja',$array);
		return;
	}
	public function deleteDataPekerja($id)
	{
		$this->erp->where('id_pekerja',$id);
		$this->erp->delete('hlcm.hlcm_datapekerja');
		return;
	}
};
