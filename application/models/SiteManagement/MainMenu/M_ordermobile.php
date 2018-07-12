<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_ordermobile extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function check($no_order)
		{
			$sql ="SELECT * FROM sm.sm_order where no_order = '$no_order'";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

	function Update($tgl_terima, $no_order)
		{
			$sql = "update sm.sm_order set status=1, tgl_terima='$tgl_terima' where no_order='$no_order'";
			$query = $this->db->query($sql);
		}
}