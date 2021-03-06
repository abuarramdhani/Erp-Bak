<?php
Defined('BASEPATH') or exit('No Direct Sekrip Access Allowed');
/**
 * 
 */
class M_undangan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPekerjaKHS($noind = FALSE){
		if ($noind == FALSE) {
			$sql = "select employee_code noind,
						case when length(concat(split_part(employee_name,' ',1),' ',split_part(employee_name,' ',2),' ',left(split_part(employee_name,' ',3),1))) > 17 then 
									concat(split_part(employee_name,' ',1),' ',left(split_part(employee_name,' ',2),1),' ',left(split_part(employee_name,' ',3),1))
							else 
								concat(split_part(employee_name,' ',1),' ',split_part(employee_name,' ',2),' ',left(split_part(employee_name,' ',3),1))
							end nama 
				from er.er_employee_all 
				where resign = '0' 
				order by employee_code;";
		}else{
			$sql = "select employee_code noind,
						case when length(concat(split_part(employee_name,' ',1),' ',split_part(employee_name,' ',2),' ',left(split_part(employee_name,' ',3),1))) > 17 then 
									concat(split_part(employee_name,' ',1),' ',left(split_part(employee_name,' ',2),1),' ',left(split_part(employee_name,' ',3),1))
							else 
								concat(split_part(employee_name,' ',1),' ',split_part(employee_name,' ',2),' ',left(split_part(employee_name,' ',3),1))
							end nama 
				from er.er_employee_all 
				where employee_code = '$noind';";
		}
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertUndangan($data){
		$this->db->insert('pl.pl_undangan',$data);
	}

	public function getUndangan(){
		$sql = "select 	to_char(cast(create_date as date),'dd')tanggal,
						to_char(cast(create_date as date),'mm')bulan,
						to_char(cast(create_date as date),'yyyy')tahun,
						acara,
						tempat,
						peserta,
						keterangan,
						id_undangan 
				from pl.pl_undangan 
				order by id_undangan desc;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getUndanganByID($id){
		$sql = "select *,
				to_char(tanggal,'dd month yyyy') tgl,
				cast(tanggal as time) wkt,
				to_char(cast(tanggal as date),'dd')tg1,
				to_char(cast(tanggal as date),'d')hr1,
				to_char(cast(tanggal as date),'mm')b1,
				to_char(cast(tanggal as date),'yyyy')th1,
				to_char(cast(create_date as date),'dd')tg2,
				to_char(cast(create_date as date),'mm')b2,
				to_char(cast(create_date as date),'yyyy')th2,
				concat(split_part(employee_name,' ',1),' ',split_part(employee_name,' ',2),' ',left(split_part(employee_name,' ',3),1)) app_name
				from pl.pl_undangan pu
				inner join er.er_employee_all
					on approval = employee_code
				where id_undangan = '$id';";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateUndangan($id,$data){
		$this->db->where('id_undangan',$id);
		$this->db->update('pl.pl_undangan',$data);
	}

	public function deleteUndangan($id){
		$this->db->where('id_undangan',$id);
		$this->db->delete('pl.pl_undangan');
	}

	public function getTrainingParticipant($id){
		$sql = "select *
				from pl.pl_participant 
				where scheduling_id = $id";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getTraining($id){
		$sql = "select * ,
				concat(to_char(cast(\"date\" as date),'dd '),initcap(split_part(to_char(cast(\"date\" as date),'month'),' ',1)),to_char(cast(\"date\" as date),' yyyy')) tgl,
				start_time wkt,
				to_char(cast(\"date\" as date),'dd')tg1,
				to_char(cast(\"date\" as date),'d')hr1,
				to_char(cast(\"date\" as date),'mm')b1,
				to_char(cast(\"date\" as date),'yyyy')th1,
				to_char(current_date,'dd')tg2,
				to_char(current_date,'mm')b2,
				to_char(current_date,'yyyy')th2, 
				scheduling_name acara,
				room tempat,
				(select case when count(*)<= 3 then
					3
				else
					15
				end keterangan
				from pl.pl_participant where scheduling_id = pst.scheduling_id),
				(select case when  trainer_name not like '%(%)%' then 
				concat(split_part(trainer_name,' ',1),' ',split_part(trainer_name,' ',2),' ',left(split_part(trainer_name,' ',3),1)) 
				else
				trainer_name
				end app_name
				from pl.pl_master_trainer
				where trainer_id = pst.trainer::int),
				(select noind
				from pl.pl_master_trainer
				where trainer_id = pst.trainer::int)
				from pl.pl_scheduling_training pst 
				where scheduling_id = $id";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getUndanganByTanggal($tanggal){
		$sql = "select * from pl.pl_scheduling_training pst
				left join pl.pl_master_trainer pmt 
				on pmt.trainer_id = pst.trainer::int 
				where \"date\" = '$tanggal'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
 ?>