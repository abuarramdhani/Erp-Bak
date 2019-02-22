<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_detailurutanjdwl extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getDetailUrutanJdwl(){
		$sql = "select * from \"Catering\".tdetailjadwal order by fs_hari,fn_urutan_jadwal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCountKatering(){
		$sql = "select count(*) as jml from \"Catering\".tkatering where fb_status = '1' group by fb_status";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getDetailurutanJdwlByHariUrutan($hr,$ur){
		$sql = "select * from \"Catering\".tdetailjadwal where fs_hari='$hr' and fn_urutan_jadwal='$ur'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertDetailUrutanJdwl($data){
		$this->personalia->insert("\"Catering\".tdetailjadwal",$data);
	}

	public function updateDetailUrutanJdwl($data,$where){
		$this->personalia->where("fs_hari",$where['fs_hari']);
		$this->personalia->where("fn_urutan_jadwal",$where['fn_urutan_jadwal']);
		$this->personalia->update("\"Catering\".tdetailjadwal",$data);
	}

	public function deleteDetailUrutanJdwl($where){
		$this->personalia->where("fs_hari",$where['fs_hari']);
		$this->personalia->where("fn_urutan_jadwal",$where['fn_urutan_jadwal']);
		$this->personalia->delete("\"Catering\".tdetailjadwal");
	}
}

?>