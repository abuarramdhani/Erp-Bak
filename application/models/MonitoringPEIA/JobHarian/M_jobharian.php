<?php
clASs M_jobharian extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function showDataSemua()
	{
		$sql = "SELECT id,tanggal,nama,keterangan
 				FROM pe.pe_table_job ORDER BY tanggal DESC";
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getLaporan($id)
	{
		$sql = "SELECT id,tanggal,nama,keterangan
 				FROM pe.pe_table_job WHERE id = $id";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	
	public function insertSemua($tanggal,$nama,$keterangan)
	{
		$sql = "INSERT INTO pe.pe_table_job(tanggal,nama,keterangan) values ('$tanggal','$nama','$keterangan')";

		$query = $this->db->query($sql);
		
	}

	public function UpdateLaporan($tanggal,$nama,$keterangan,$id)
	{
		$sql = "UPDATE pe.pe_table_job set tanggal ='$tanggal', nama='$nama', keterangan='$keterangan' where id = '$id'";

		$query = $this->db->query($sql);
		
	}

	public function deleteLaporan($id)
	{
		$sql = "DELETE FROM pe.pe_table_job WHERE id = $id";

		$query = $this->db->query($sql);
		
	}

	public function searchTanggal($tanggalan1,$tanggalan2)
	{
		$sql = "SELECT id,tanggal,nama,keterangan FROM pe.pe_table_job WHERE tanggal between '$tanggalan1' AND '$tanggalan2'";

		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
}
?>