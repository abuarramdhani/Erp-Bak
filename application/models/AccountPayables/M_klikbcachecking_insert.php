<?php
class M_klikbcachecking_insert extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//CEK RECAP
	public function SearchRecap($no_rek_penerima,$berita){
		$sql = "select * from ap.ap_klikbca_checking where no_rek_penerima='$no_rek_penerima' and berita='$berita'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//INSERT RECAP
	public function InsertRecap($no_referensi,$no_rek_pengirim,$no_rek_penerima,$nama_pengirim,$nama_penerima,$jumlah,$berita,$jenis_transfer,$user_id){
		$sql = "
			insert into ap.ap_klikbca_checking
			(no_referensi,no_rek_pengirim,no_rek_penerima,nama_pengirim,nama_penerima,jumlah,berita,jenis_transfer,upload_date,uploaded_by)values
			('$no_referensi','$no_rek_pengirim','$no_rek_penerima','$nama_pengirim','$nama_penerima','$jumlah','$berita','$jenis_transfer','now()','$user_id')";
		$query = $this->db->query($sql);
		return;
	}

	//DELETE RECAP
		public function DeleteRecap($no_rek_penerima,$berita){
			$sql = "delete from ap.ap_klikbca_checking where no_rek_penerima='$no_rek_penerima' and berita='$berita'";
			$query = $this->db->query($sql);
			return;
		}

}
?>