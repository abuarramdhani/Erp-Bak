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
				total_waktu = extract(epoch from end_time-start_time),
				status_tercapai = 	case when cast(total_target as int) >= cast((extract(epoch from end_time-start_time)) as int) then
					cast('1' as bool)
				else
					cast('0' as bool)
				end
				where id_pelaksanaan = $id";
		$this->db->query($sql);
		
		$sql = "insert into ma.ma_pending
			(id_pekerja,pekerjaan,total_target,start_time,end_time,total_waktu,jml_dokument,id_pelaksanaan)
			select id_pekerja,pekerjaan,total_target,start_time,end_time,total_waktu,jml_dokument,id_pelaksanaan
			from ma.ma_pelaksanaan pk where pk.status_tercapai = '0' and pk.id_pelaksanaan = $id";
		$this->db->query($sql);
	}
}
?>