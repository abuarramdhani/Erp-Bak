<?php
clASs M_creditlimit extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->postgre = $this->load->database ( 'erp', TRUE );
    }
	
	public function showDataSemua()
	{
		$sql = "SELECT id,tanggal,seksi,nama,order_,jenis_order,keterangan
 				FROM pe.pe_table_order";
		
		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function seksi()
	{
		$sql = "SELECT id,seksi,deskripsi
				FROM pe.pe_seksi";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getSeksi($id)
	{
		$sql = "SELECT id,seksi,deskripsi
				FROM pe.pe_seksi WHERE id=$id";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getAllSeksi()
	{
		$sql = "SELECT seksi
				FROM pe.pe_seksi";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function order()
	{
		$sql = "SELECT id,order_,deskripsi
				FROM pe.pe_order";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getOrder($id)
	{
		$sql = "SELECT id,order_,deskripsi
				FROM pe.pe_order WHERE id=$id";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getAllOrder()
	{
		$sql = "SELECT order_
				FROM pe.pe_order";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function jenisOrder()
	{
		$sql = "SELECT id,jenis_order,deskripsi
				FROM pe.pe_jenis_order";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getJenisOrder($id)
	{
		$sql = "SELECT id,jenis_order,deskripsi
				FROM pe.pe_jenis_order WHERE id=$id";
		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getAllJenisOrder()
	{
		$sql = "SELECT jenis_order
				FROM pe.pe_jenis_order";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function getLaporan($id)
	{
		$sql = "SELECT id,tanggal,seksi,nama,order_,jenis_order,keterangan
 				FROM pe.pe_table_order WHERE id = $id";

		$query = $this->postgre->query($sql);
		return $query->result_array();
	}

	public function insertSeksi($seksi,$deskripsi)
	{
		$sql = "INSERT INTO pe.pe_seksi(seksi,deskripsi) values('$seksi','$deskripsi')";

		$query = $this->postgre->query($sql);
		
	}

	public function UpdateSeksi($seksi,$deskripsi,$id)
	{
		$sql = "UPDATE pe.pe_seksi set seksi ='$seksi', deskripsi='$deskripsi' where id = '$id'";

		$query = $this->postgre->query($sql);
		
	}

	public function insertOrder($order_,$deskripsi)
	{
		$sql = "INSERT INTO pe.pe_order(order_,deskripsi) values('$order_','$deskripsi')";

		$query = $this->postgre->query($sql);
		
	}

	public function UpdateOrder($order_,$deskripsi,$id)
	{
		$sql = "UPDATE pe.pe_order set order_ ='$order_', deskripsi='$deskripsi' where id = '$id'";

		$query = $this->postgre->query($sql);
		
	}

	public function insertJenisOrder($jenisorder,$deskripsi)
	{
		$sql = "INSERT INTO pe.pe_jenis_order(jenis_order,deskripsi) values('$jenisorder','$deskripsi')";

		$query = $this->postgre->query($sql);
		
	}

	public function UpdateJenisOrder($jenisorder,$deskripsi,$id)
	{
		$sql = "UPDATE pe.pe_jenis_order set jenis_order ='$jenisorder', deskripsi='$deskripsi' where id = '$id'";

		$query = $this->postgre->query($sql);
		
	}

		public function deleteSeksi($id)
	{
		$sql = "DELETE FROM pe.pe_seksi WHERE id = $id";

		$query = $this->postgre->query($sql);
		
	}

		public function deleteOrder($id)
	{
		$sql = "DELETE FROM pe.pe_order WHERE id = $id";

		$query = $this->postgre->query($sql);
		
	}

		public function deleteJenisOrder($id)
	{
		$sql = "DELETE FROM pe.pe_jenis_order WHERE id = $id";

		$query = $this->postgre->query($sql);
		
	}
	public function insertSemua($tanggal,$seksi,$nama,$order_,$jenis_order,$keterangan)
	{
		$sql = "INSERT INTO pe.pe_table_order(tanggal,seksi,nama,order_,jenis_order,keterangan) values('$tanggal','$seksi','$nama','$order_','$jenis_order','$keterangan')";

		$query = $this->postgre->query($sql);
		
	}

	public function UpdateLaporan($tanggal,$seksi,$nama,$order_,$jenis_order,$keterangan,$id)
	{
		$sql = "UPDATE pe.pe_table_order set tanggal ='$tanggal', seksi='$seksi', nama='$nama', order_='$order_', jenis_order='$jenis_order', keterangan='$keterangan' where id = '$id'";

		$query = $this->postgre->query($sql);
		
	}

	public function deleteLaporan($id)
	{
		$sql = "DELETE FROM pe.pe_table_order WHERE id = $id";

		$query = $this->postgre->query($sql);
		
	}
}
?>