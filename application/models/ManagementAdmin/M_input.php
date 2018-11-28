<?php
Defined('BASEPATH') or exit('No DIrect Script Access Allowed');
/**
 * 
 */
class M_input extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertData($data){
		$this->db->insert('ma.ma_pelaksanaan',$data);

		$id = $this->db->insert_id();
		$sql = "update ma.ma_pelaksanaan 
				set status_selesai = '1',
				total_waktu = extract(epoch from end_time-start_time)
				where id_pelaksanaan = $id";
		$this->db->query($sql);
		
		$sql = "insert into ma.ma_pending
			(id_pekerja,pekerjaan,total_target,start_time,end_time,total_waktu,jml_dokument)
			select id_pekerja,pekerjaan,total_target,start_time,end_time,total_waktu,jml_dokument
			from ma.ma_pelaksanaan pk where pk.total_waktu > total_target and pk.id_pelaksanaan = $id";
		$this->db->query($sql);
	}
}
?>