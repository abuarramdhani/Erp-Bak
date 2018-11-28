<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_proses extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPekerja($nama){
		$sql = "select * from ma.ma_pekerja where (nama_pekerja like '%$nama%' or noind like '%$nama%') and status_delete = '0'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPekerjaan($nama){
		$sql = "select * from ma.ma_target where lower(pekerjaan) like '%$nama%'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDataProses($noind = FALSE){
		if ($noind == FALSE) {
			$sql = "select *,	(select concat(noind,' - ',nama_pekerja) 
								from ma.ma_pekerja pkj 
								where pkj.id_pekerja = cast(pls.id_pekerja as int)
								) pekerja 
					from ma.ma_pelaksanaan pls 
					where status_selesai = '0'";
		}else{
			$sql = "select *,	(select concat(noind,' - ',nama_pekerja) 
								from ma.ma_pekerja pkj 
								where pkj.id_pekerja = cast(pls.id_pekerja as int)
								) pekerja 
					from ma.ma_pelaksanaan pls
					inner join  ma.ma_pekerja pkj 
						on pkj.id_pekerja = cast(pls.id_pekerja as int)
					where status_selesai = '0'
					and pkj.noind = '$noind'";
		}
		
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDataSelesai($noind = FALSE){
		if ($noind == FALSE) {
			$sql = "select *,	(select concat(noind,' - ',nama_pekerja) 
								from ma.ma_pekerja pkj 
								where pkj.id_pekerja = cast(pls.id_pekerja as int)
								) pekerja 
					from ma.ma_pelaksanaan pls
					where status_selesai = '1'";
		}else{
			$sql = "select *,	(select concat(noind,' - ',nama_pekerja) 
								from ma.ma_pekerja pkj 
								where pkj.id_pekerja = cast(pls.id_pekerja as int)
								) pekerja 
					from ma.ma_pelaksanaan pls
					inner join  ma.ma_pekerja pkj 
						on pkj.id_pekerja = cast(pls.id_pekerja as int)
					where status_selesai = '1'
					and pkj.noind = '$noind'";
		}
		
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertPelaksanaan($data){
		$sql = "insert into ma.ma_pelaksanaan
				(id_pekerja,pekerjaan,jml_dokument,total_target,created_by,start_time)
				values
				('".$data['id_pekerja']."','".$data['pekerjaan']."','".$data['jml_dokument']."','".$data['total_target']."','".$data['created_by']."',date_trunc('second',current_timestamp))";
		$this->db->query($sql);
	}

	public function updateDataSelesai($id){
		$sql = "update ma.ma_pelaksanaan 
				set end_time = date_trunc('second',current_timestamp),
				status_selesai = '1',
				total_waktu = extract(epoch from date_trunc('second',current_timestamp)-start_time)
				where id_pelaksanaan = $id";
		$this->db->query($sql);

		$sql = "update ma.ma_pelaksanaan 
				set status_tercapai = 	case when total_target >= total_waktu then
											cast('1' as boolean)
										else
											cast('0' as boolean)
										end
				where status_selesai = '1'
				and id_pelaksanaan = $id";
		$this->db->query($sql);
	}

	public function insertPending($id){
		$sql = "insert into ma.ma_pending
				(id_pekerja,pekerjaan,total_target,start_time,end_time,total_waktu,jml_dokument,id_pelaksanaan)
				select id_pekerja,pekerjaan,total_target,start_time,end_time,total_waktu,jml_dokument,id_pelaksanaan
				from ma.ma_pelaksanaan pk where pk.total_waktu > total_target and pk.id_pelaksanaan = $id";
		$this->db->query($sql);
	}
}
?>