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


 	function InsertRecap($htmldata){
        $this->db->insert('ap.ap_klikbca_checking', $htmldata);
    }

	//DELETE RECAP
		public function DeleteRecap($no_rek_penerima,$berita){
			$sql = "delete from ap.ap_klikbca_checking where no_rek_penerima='$no_rek_penerima' and berita='$berita'";
			$query = $this->db->query($sql);
			return;
		}

}
?>