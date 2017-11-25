<?php
class M_calibration extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	public function tampilcode(){
		$query = $this->db->query("select * from kl.kl_code_component");
		return $query->result_array();
	}
	
	public function alldata(){
		$query = $this->db->query("select id,kode,nama_komponen,type_komponen,jumlah,tanggal,shift,proses,judgement,keterangan from kl.kl_document where status like 'active' order by id desc limit 1000");
		return $query->result_array();
	}
	
	public function all(){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("select * from qd.qd_document where status like 'active'");
		return $query->result();
	}
	public function allCari(){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("select * from qd.qd_document where status like 'active'");
		return $query->result();
	}
	public function tampildata($keyword){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("select * from qd.qd_document where id='$keyword' and status like 'active'");
		return $query->result();
	}
	public function get_all_name($q){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("select * from qd.qd_document where Nama_Komponen like '%G%'");
		return $query->result_array();	
	}
	public function delete($keyword){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("UPDATE qd.qd_document SET status = 'inactive' where id='$keyword'");
		return $query;
	}
	public function act_edit($id,$Kode,$Nama_Komponen,$Type_Komponen,$Jumblah,$Tanggal,$Proses,$Shift,$Judgement,$Keterangan,$doc_name,	$doc_type,$doc_path,$keyword){
		$postgres = $this->load->database("postgres",true);
		$act_edit = $postgres->query("UPDATE qd.qd_document SET Kode = '$Kode',Nama_Komponen = '$Nama_Komponen',Type_Komponen = '$Type_Komponen',Jumlah = '$Jumblah',Tanggal = '$Tanggal',Proses = '$Proses',Shift = '$Shift',Judgement = '$Judgement',Keterangan = '$Keterangan' where id='$keyword'");
		return $act_edit;
	}
	public function getKode($q){
		$query = $this->db->query("select Kode_Komponen from CodeKomponen where id like '%$q%' ");
		return $query->result_array();
	}
	public function getNama($Kode_Komponen){
		$query = $this->db->query("select Nama_Komponen from CodeKomponen where Kode_Komponen='$Kode_Komponen'");
		return $query->result();
	}
	
	public function queryCari($tanggalawal,$tanggalakhir,$KodeCari,$NamaCari,$TypeCari,$Judgement,$Tanggal=''){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("select 
												a.id,
												a.Kode,
												a.Nama_Komponen,
												a.Type_Komponen,
												a.Proses,
												a.Jumlah,
												a.Tanggal,
												a.Shift,
												a.Judgement,
												a.Keterangan
												from qd.qd_document  as a
												where a.Tanggal between '$tanggalawal' and '$tanggalakhir' and a.Kode like '$KodeCari' and a.Nama_Komponen like '$NamaCari' and a.Type_Komponen like '$TypeCari' and a.Judgement like '$Judgement' and status like 'active'");
		return $query->result();

		
	}
	
	
	public function adddata($id,$Kode,$Nama_Komponen,$Type_Komponen,$Jumblah,$Tanggal,$Shift,$Judgement,$Keterangan,$doc_name,$doc_type,$doc_path){
		$postgres = $this->load->database("postgres",true);
		$query = $postgres->query("insert into qd.qd_document values ('','$Kode','$Nama_Komponen','$Type_Komponen','$Jumlah','$Tanggal','$Shift','$Judgement','$Keterangan','$doc_name','$doc_type','$doc_path')");
		return;
	}
	function Document($id,$Kode,$Nama_Komponen,$Type_Komponen,$Jumblah,$Tanggal,$Proses,$Shift,$Judgement,$Keterangan,$docname,$docpath,$doctype){
		$postgres = $this->load->database("postgres",true);
		$data = $postgres->query("INSERT INTO qd.qd_document (kode, nama_komponen, type_komponen, jumlah, tanggal, proses, shift, judgement, keterangan, doc_name, doc_path, doc_type)values 
				('$Kode','$Nama_Komponen','$Type_Komponen','$Jumblah','$Tanggal','$Proses','$Shift','$Judgement','$Keterangan','$docname','$docpath','$doctype')");
		 return;
	}	
}