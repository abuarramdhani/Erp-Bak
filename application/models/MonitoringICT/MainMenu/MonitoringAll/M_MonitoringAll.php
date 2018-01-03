<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_MonitoringAll extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}


	function getPeriodeMonitoring()
		{
			$this->db->order_by('periode_monitoring_id'); 
			$query = $this->db->get('sc.sc_periode_monitoring');
			return $query->result_array();
		}

	function getHasil($idMon)
		{
			$sql  = "SELECT distinct(scp.perangkat_id) 
							, scpr.jenis_perangkat 
							, scpr.host 
							, schm.hasil_monitoring_id 
							, schm.tgl_monitoring 
							, scp.periode_monitoring_id
							, schm.nomor_order
					FROM sc.sc_ploting scp
					LEFT JOIN sc.sc_perangkat scpr ON scp.perangkat_id = scpr.perangkat_id
					LEFT JOIN (SELECT shm.hasil_monitoring_id 
									  , shm.perangkat_id 
									  , shm.tgl_monitoring
									  , shm.nomor_order
								FROM sc.sc_hasil_monitoring shm
								WHERE shm.periode_monitoring_id = $idMon and shm.hasil_monitoring_id 
								IN (SELECT max(hasil_monitoring_id) FROM sc.sc_hasil_monitoring WHERE periode_monitoring_id = $idMon group by perangkat_id)) 
								schm ON schm.perangkat_id = scp.perangkat_id
					WHERE scp.periode_monitoring_id = $idMon
					 ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getDetailHasil($id)
		{
			$sql = "SELECT *
					FROM sc.sc_hasil_monitoring_detail shmd
					LEFT JOIN sc.sc_aspek_monitoring sam ON shmd.aspek_id = sam.aspek_id
					WHERE shmd.hasil_monitoring_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getPIC($id)
		{
			$sql = "SELECT distinct(emall.employee_name)
				  FROM sc.sc_ploting scp
				  LEFT JOIN er.er_employee_all emall ON scp.employee_id = emall.employee_id 
				  WHERE scp.perangkat_id = $id ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}
