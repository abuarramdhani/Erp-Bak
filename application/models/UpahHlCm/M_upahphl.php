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
	public function updateUangMakanPuasa($lokasi_kerja,$uangmakanpuasa)
	{
		$this->erp->where('lokasi_kerja',$lokasi_kerja);
		$this->erp->update('hlcm.hlcm_datagaji',$uangmakanpuasa);
		return;
	}
	public function getDataPekerja($lokasi_kerja)
	{
		$query = "select dp.*,(select b.nama_bank from hlcm.hlcm_bank b where b.code_bank=dp.bank) as nama_bank from hlcm.hlcm_datapekerja dp where dp.lokasi_kerja='$lokasi_kerja' order by dp.last_updated,dp.noind";
		$data = $this->erp->query($query);
		return $data->result_array();
	}
	public function getPekerja($pekerja,$lokasi_kerja)
	{
		$query = "select tp.noind,tp.nama, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) from hrd_khs.tpribadi tp where (tp.noind like '%$pekerja%' or tp.nama like '%$pekerja%') and tp.lokasi_kerja='$lokasi_kerja' and tp.noind like 'R%' order by tp.noind";
		$data = $this->personalia->query($query);
		return $data->result_array();
	}
	public function pekerjaApproval($pekerja)
	{
		$query = "select tp.noind,tp.nama, (select tpk.pekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) from hrd_khs.tpribadi tp where (tp.noind like '%$pekerja%' or tp.nama like '%$pekerja%') and tp.keluar='0' order by tp.noind";
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
		$query = "select tp.noind,tp.kodesie,tp.nama,(select jabatan from hrd_khs.trefjabatan where noind='$noind') as jabatan,(select p.pekerjaan from hrd_khs.tpekerjaan p where tp.kd_pkj=p.kdpekerjaan) as pekerjaan from hrd_khs.tpribadi tp where tp.noind='$noind' and tp.keluar='0'";
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
		$query = "select ap.*, (select ket.posisi from hlcm.hlcm_posisi ket where ap.id_status=ket.id_status) as posisi, (select nama_document from hlcm.hlcm_document docu where docu.id_document = ap.document_id) as document from hlcm.hlcm_approval ap order by document_id, lokasi_kerja, id_status";
		$data = $this->erp->query($query);
		return $data->result_array();
	}

	public function ambilDataApproval($id)
	{
		$query = "select * from hlcm.hlcm_approval where id_approval='$id' ORDER BY id_approval ASC";
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
	public function ambilPekerjaHL()
	{
		$query="select tp.nama,tp.noind,tp.lokasi_kerja, (select tpk.kdpekerjaan from hrd_khs.tpekerjaan tpk where tp.kd_pkj=tpk.kdpekerjaan) as kdpekerjaan,tp.puasa from hrd_khs.tpribadi tp where left(tp.noind,1)='R' and keluar='0' order by tp.noind";
		$data=$this->personalia->query($query);
		return $data->result_array();
	}
	public function ambilDataPekerjaHL()
	{
		$query="select noind from hlcm.hlcm_datapekerja";
		$data=$this->erp->query($query);
		return $data->result_array();
	}
	public function cekdataAda($noind,$nama)
	{
		$query="select * from hlcm.hlcm_datapekerja where trim(noind)=trim('$noind') and trim(nama)=trim('$nama')";
		$data=$this->erp->query($query);
		return $data->num_rows();
	}
	public function insertDataPekerja($array)
	{
		$data = $this->erp->insert('hlcm.hlcm_datapekerja',$array);
		return;
	}
	public function updateDataPekerjaHlcm($noind,$nama,$data){
		$this->erp->where('noind',$noind);
		$this->erp->where('nama',$nama);
		$this->erp->update('hlcm.hlcm_datapekerja',$data);
		return;
	}
	public function getDatapekerjaHlcm($noind,$nama){
		$query="select * from hlcm.hlcm_datapekerja where noind='$noind' and nama='$nama'";
		$data=$this->erp->query($query);
		return $data->result_array();
	}

	public function getPekerjaSearch($noind){
		$sql = "select * 
				from hlcm.hlcm_datapekerja dp
				left join hlcm.hlcm_datagaji dg
				on dg.kode_pekerjaan = dp.kode_pekerjaan
				and dg.lokasi_kerja = dp.lokasi_kerja
				where upper(dp.noind) like upper('$noind%')";
		$data=$this->erp->query($sql);
		return $data->result_array();
	}

	public function getPekerjaanSearch(){
		$sql = "select distinct kode_pekerjaan,pekerjaan
				from hlcm.hlcm_datagaji
				order by kode_pekerjaan";
		$data=$this->erp->query($sql);
		return $data->result_array();
	}

	public function getPekerjabaruSearch($noind){
		$sql = "select kd_pkj,tp.pekerjaan
				from hrd_khs.tpribadi tpri
				left join hrd_khs.tpekerjaan tp
				on tp.kdpekerjaan = tpri.kd_pkj
				where noind ='$noind'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
};
