<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_uploadpph extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	function getBatch()
	{
		$sql = "SELECT max(batch_num) batch_num 
				FROM ap.ap_tax_data order by batch_num desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function saveData($data)
	{
		$this->db->insert('ap.ap_tax_data',$data);
	}

	function getDataUpload($batch = FALSE)
	{
		$qbatch = ($batch === FALSE) ? '' : ' WHERE batch_num = '.$batch;
		$sql = "SELECT atd.batch_num
						,atd.tgl_upload
						,atd.arsip
						, (SELECT count(*) jumlah FROM ap.ap_tax_data atd2 WHERE atd2.batch_num = atd.batch_num ) jumlah
				FROM ap.ap_tax_data atd $qbatch 
				GROUP BY atd.batch_num, atd.tgl_upload, atd.arsip ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function checkBatch($no)
	{
		$sql = "SELECT * FROM ap.ap_tax_data WHERE batch_num = '$no'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function getDataBatch($batch)
	{
		$sql = "SELECT * 
				FROM ap.ap_tax_data 
				WHERE batch_num = '$batch'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getMaxNumb($param,$lokasi)
	{
		$sql = "SELECT MAX(no_urut) nomor
				FROM ap.ap_tax_data 
				WHERE no_urut like '%$param'
				AND lokasi = '$lokasi'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function updateNoUrut($jenis,$tgltransaksi,$vendor,$batch_num, $newNoUrut)
	{
		$sql = "UPDATE ap.ap_tax_data SET 
					no_urut = '$newNoUrut'
				WHERE batch_num = '$batch_num'
					AND nama_vendor = '$vendor'
					AND jenis_pph = '$jenis'
				";
		$query = $this->db->query($sql);

	}

	function delete_pph($batch_num)
	{
		$sql = "DELETE 
				FROM ap.ap_tax_data 
				WHERE batch_num = '$batch_num'";
		$query = $this->db->query($sql);
	}

	function archive_pph($batch_num)
	{
		$sql = "UPDATE ap.ap_tax_data SET arsip = '1' WHERE batch_num = '$batch_num' ";
		$query = $this->db->query($sql);
	}


	function checkVendorInvoice($vendor,$invoice)
	{
		$sql = "SELECT * FROM ap.ap_tax_data WHERE nama_vendor ='$vendor'  and no_invoice = '$invoice' and arsip = '1'";
		$query =$this->db->query($sql);
		return $query->num_rows();
	}
}