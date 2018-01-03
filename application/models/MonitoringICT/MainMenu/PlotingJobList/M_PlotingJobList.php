<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_PlotingJobList extends CI_Model
{	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function getJobList($id=null)
		{
			$qwhere = $id != null ? ' WHERE scp.perangkat_id = '.$id : '';
			$sql = "SELECT distinct(scp.perangkat_id) 
						   , scp.jenis_perangkat 
						   , scp.host  
						   , table1.periode_monitoring_id
						   , table1.periode_monitoring
					FROM sc.sc_perangkat scp 
					LEFT JOIN (SELECT scpl.periode_monitoring_id
							  , scpm.periode_monitoring 
							  , scpl.perangkat_id 
					   FROM sc.sc_ploting scpl 
					   LEFT JOIN sc.sc_periode_monitoring scpm 
					   ON scpm.periode_monitoring_id = scpl.periode_monitoring_id) table1 ON table1.perangkat_id = scp.perangkat_id
					 $qwhere ORDER BY scp.jenis_perangkat";
			$query = $this->db->query($sql);
			return $query->result_array();

		}

	function getPIC($id)
		{
			$sql = "SELECT ea.employee_id
						   , ea.employee_code
						   , ea.employee_name
					FROM sc.sc_ploting scpl
					LEFT JOIN er.er_employee_all ea ON ea.employee_id = scpl.employee_id
					WHERE scpl.perangkat_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getPICAll()
		{
			$sql = "SELECT su.* 
							, ea.employee_name
							, ea.employee_code
					FROM sys.sys_user su 
					LEFT JOIN er.er_employee_all ea ON su.employee_id = ea.employee_id
					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getPeriod()
		{
			$query = $this->db->get('sc.sc_periode_monitoring');
			return $query->result_array();
		}

	function getPlotExits($data)
		{
			$query = $this->db->get_where('sc.sc_ploting', $data);
			return $query->num_rows();
		}

	function getExist($id,$perangkat_id)
		{
			$sql = "SELECT *
					FROM sc.sc_ploting
					WHERE perangkat_id = $perangkat_id 
						AND employee_id = $id";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

	function InsertNew($data)
		{
			$query = $this->db->insert('sc.sc_ploting', $data);
			return $this->db->insert_id();
		}

	function UpdateJob($id,$perangkat_id,$data)
		{
			$this->db->update('sc.sc_ploting',$data,  array('employee_id' => $id , 'perangkat_id' => $perangkat_id ) );
			$query = $this->db->get_where('sc.sc_ploting' , $data);
			return $query->result_array();
		}

	function getIdPlot($data)
		{
			$query = $this->db->get_where('sc.sc_ploting', $data);
			return $query->result_array();
		}

	function delPlot($data , $perangkat_id)
		{
			$sql = "DELETE FROM sc.sc_ploting WHERE ploting_id not in ($data) AND perangkat_id = $perangkat_id";
			$query = $this->db->query($sql);

		}

	function delPlot2($perangkat_id)
		{
			$sql = "DELETE FROM sc.sc_ploting WHERE perangkat_id = $perangkat_id";
			$query = $this->db->query($sql);

		}
}