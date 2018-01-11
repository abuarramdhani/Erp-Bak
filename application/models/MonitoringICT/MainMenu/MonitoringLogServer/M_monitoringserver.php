<?php 
class M_MonitoringServer extends CI_Model
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	public function getData($id_log=null)
		{
			if ($id_log == null) { 
				$where_log = "";
			}else{
				$where_log = "WHERE sc_lrs.log_id = $id_log ";
			}
			$sql = "SELECT sc_rs.ruang_server_name ruang_server,
						   sc_lrs.tanggal tanggal,
						   sc_lrs.log_id log_id,
						   sc_lrs.jam_masuk jam_masuk,
						   sc_lrs.jam_keluar jam_keluar,
						   sc_lrs.keperluan keperluan,
						   su_ser.employee pemberi_izin
					FROM 
						sc.sc_log_ruang_server sc_lrs
						LEFT JOIN sc.sc_ruang_server sc_rs ON sc_lrs.ruang_server = sc_rs.sc_ruang_server_id
						LEFT JOIN er.er_employee_all er_ea ON sc_lrs.pemberi_izin = er_ea.employee_id
						LEFT JOIN (SELECT su.user_id , concat(er_eall.employee_code, '-' , er_eall.employee_name) employee
									FROM sys.sys_user su , er.er_employee_all er_eall
									WHERE su.employee_id = er_eall.employee_id ) su_ser ON su_ser.user_id = sc_lrs.pemberi_izin
						 "
					.$where_log;
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function getPekerja($pk)
		{
			$sql = "SELECT scp.log_id , concat(erea.employee_code, '-' , erea.employee_name) petugas
					FROM sc.sc_petugas scp , er.er_employee_all erea
					WHERE scp.employee_code = erea.employee_id
						AND scp.log_id = '$pk'";
			$query = $this->db->query($sql);
			return $query->result_array();

		}

	public function getPekerjaLS()
		{
			$sql	= ' SELECT employee_id, employee_code , employee_name 
						FROM er.er_employee_all
						WHERE resign <> 1
						order by employee_code asc';
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function getRuangServer()
		{
			$query = $this->db->get('sc.sc_ruang_server');
			return $query->result_array();
		}

	public function save_log($tg,$jm,$jk,$kp,$pi,$rs)
		{
			$sql 	= "INSERT INTO sc.sc_log_ruang_server(tanggal,jam_masuk,jam_keluar,keperluan,pemberi_izin,ruang_server)
						values('$tg','$jm','$jk','$kp','$pi','$rs')";
			$query  = $this->db->query($sql);
			$sql2 	= "SELECT log_id FROM sc.sc_log_ruang_server 
						WHERE tanggal  = '$tg'
						AND jam_masuk = '$jm'
						AND jam_keluar = '$jk'
						AND keperluan  = '$kp'
						AND ruang_server  = '$rs'
						AND pemberi_izin  = '$pi' ";
			$query2 = $this->db->query($sql2);
			return $query2->result_array(); 
		}

	public function save_petugas($pk,$li)
		{
			$sql 	= "INSERT INTO sc.sc_petugas(log_id,employee_code)
						VALUES ('$li','$pk')";
			$query  = $this->db->query($sql);
		}
}
