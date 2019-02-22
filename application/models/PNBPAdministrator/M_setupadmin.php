<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_setupadmin extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getUser(){
		$sql = "select * from pd.pnbp_user_administrator pua 
				left join er.er_employee_all eea
				on pua.noind = eea.employee_code";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getWorker($noind){
		$sql = "select * from sys.sys_user su 
				inner join er.er_employee_all eea
				on su.employee_id = eea.employee_id
				where eea.resign = '0'
				and (
					upper(eea.employee_code) like upper('%$noind%') 
					or upper(eea.employee_name) like upper('%$noind%')
					)";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertUser($user,$aktif){
		$sql = "insert into pd.pnbp_user_administrator
				(noind,status_active)
				values('$user','$aktif')";
		$this->db->query($sql);
		return;
	}

	public function deleteUser($id){
		$sql = "delete from pd.pnbp_user_administrator
				where id_user = $id";
		$this->db->query($sql);
		return ;
	}

	public function updateUser($id_user){
		$sql = "update pd.pnbp_user_administrator
				set status_active = case when status_active = true then false else true end
				where id_user = $id_user";
		$this->db->query($sql);
		return ;
	}
}
?>