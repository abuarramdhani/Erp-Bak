<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_JobListMonitoring extends CI_model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	public function getData($user_id) 
		{
			$sql ="SELECT sp.perangkat_id, sp.jenis_perangkat , sp.host , spl.periode_monitoring, spl.periode_monitoring_id , shm.tgl_monitoring
					FROM sc.sc_perangkat sp
					LEFT JOIN (SELECT max(tgl_monitoring) tgl_monitoring , perangkat_id FROM sc.sc_hasil_monitoring group by perangkat_id) shm ON shm.perangkat_id = sp.perangkat_id 
					INNER JOIN (SELECT distinct(scp.perangkat_id), scpm.periode_monitoring_id , scpm.periode_monitoring
							   FROM sc.sc_ploting scp, sc.sc_periode_monitoring scpm
							   WHERE scp.periode_monitoring_id = scpm.periode_monitoring_id
							   AND scp.employee_id = (SELECT employee_id FROM sys.sys_user WHERE user_id = $user_id)) spl 
							   ON sp.perangkat_id = spl.perangkat_id

					";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function getDetPerangkat($id=null,$periode=null)
		{
			$where = $periode == null ? '' : 'AND spm.periode_monitoring_id = '.$periode;
			$sql = "SELECT sp.perangkat_id , sp.host , sp.jenis_perangkat , spm.periode_monitoring , spm.periode_monitoring_id
					FROM sc.sc_perangkat sp
					LEFT JOIN sc.sc_ploting scp ON scp.perangkat_id = sp.perangkat_id
					LEFT JOIN (SELECT scpm.*, scscp.ploting_id,scscp.employee_id,scscp.perangkat_id FROM sc.sc_periode_monitoring scpm 
							   LEFT JOIN sc.sc_ploting scscp ON scpm.periode_monitoring_id = scscp.periode_monitoring_id) spm ON spm.perangkat_id = sp.perangkat_id
					WHERE sp.perangkat_id = $id ".$where;
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function getHasil($id,$limit =false)
		{
			$qLimit = "LIMIT 10";
			if ($limit == true) {
				$qLimit = "LIMIT ".$limit;
			}
			if ($limit == 'No') {
				$qLimit = "";
			}
			$sql ="SELECT * 
					FROM sc.sc_hasil_monitoring
					WHERE perangkat_id = $id  
					ORDER BY tgl_monitoring DESC $qLimit";
			$query = $this->db->query($sql);
			return $query->result_array();
		} 

	public function getDetailHasil($id)
		{
			$sql = "SELECT *
					FROM sc.sc_hasil_monitoring_detail shmd
					LEFT JOIN sc.sc_aspek_monitoring sam ON shmd.aspek_id = sam.aspek_id
					WHERE shmd.hasil_monitoring_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function getAspek($id=null,$periode=null)
		{
			$where = $periode == null ? '' : 'AND periode_monitoring_id = '.$periode;
			$sql   ="SELECT *
					 FROM SC.sc_aspek_monitoring
					 WHERE perangkat_id = $id 
					 ".$where." ORDER BY aspek_id ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function getEmployeeId($id)
		{
			$sql = "SELECT su.employee_id ,ea.employee_name
					FROM sys.sys_user su
					LEFT JOIN er.er_employee_all ea ON ea.employee_id = su.employee_id
					WHERE user_id = $id";
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

	public function insTicketNumb($id,$ticketId)
		{
			$data = array(
			        'nomor_order' => $ticketId,
			);
			$this->db->where('hasil_monitoring_id', $id);
			$this->db->update('sc.sc_hasil_monitoring', $data);
		}

	public function getHasilEdit($id)
		{
			$sql ="SELECT sp.perangkat_id , sp.host , sp.jenis_perangkat , shm.tgl_monitoring ,shm.periode_monitoring_id,shm.nomor_order , shm.info , shmd.*
					FROM sc.sc_hasil_monitoring shm
					LEFT JOIN sc.sc_perangkat sp ON sp.perangkat_id = shm.perangkat_id
					LEFT JOIN sc.sc_hasil_monitoring_detail shmd ON shmd.hasil_monitoring_id = shm.hasil_monitoring_id
					WHERE shm.hasil_monitoring_id = $id ORDER BY aspek_id ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function saveEdit($data,$id)
		{
			$this->db->where('hasil_monitoring_id', $id);
			$this->db->update('sc.sc_hasil_monitoring', $data);
		}

	public function saveEditDetail($data,$id)
		{
			$this->db->where('hasil_monitoring_detail_id', $id);
			$this->db->update('sc.sc_hasil_monitoring_detail', $data);
		}

	public function delete($id)
		{
			$this->db->where('hasil_monitoring_id', $id);
			$this->db->delete('sc.sc_hasil_monitoring');
			$this->db->where('hasil_monitoring_id', $id);
			$this->db->delete('sc.sc_hasil_monitoring_detail');
		}

	public function getStatusOrder($idTicket)
		{
			$this->db2 = $this->load->database('ticket',true);
			$sql   = "SELECT kts.state, kt.ticket_id
					FROM khs_ticket kt
					LEFT JOIN khs_ticket_status kts ON kt.status_id = kts.id
					WHERE kt.number = $idTicket ";
			$query = $this->db2->query($sql);
			return $query->result_array();
		}
}

