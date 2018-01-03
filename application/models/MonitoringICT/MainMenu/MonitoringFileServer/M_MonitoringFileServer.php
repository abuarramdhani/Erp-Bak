<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_MonitoringFileServer extends CI_Model
{
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	public function getServer()
		{
			$query = $this->db->get('sc.sc_perangkat');
			return $query->result_array();
		}

	public function getAspek()
		{
			$query = $this->db->get('sc.sc_aspek_monitoring');
			return $query->result_array();
		}

	public function getPetugas()
		{
			$sql	= ' SELECT employee_id, employee_code , employee_name 
						FROM er.er_employee_all
						WHERE resign <> 1
						order by employee_code asc';
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function save($data)
		{
			$query = $this->db->insert('sc.sc_hasil_monitoring', $data);
			return $this->db->insert_id();

		}

	public function saveDetail($data2)
		{
			$query = $this->db->insert('sc.sc_hasil_monitoring_detail' ,$data2);
		}
}