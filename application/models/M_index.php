<?php
class M_index extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

	function login($usr, $pwd)
	{
		$sql = "
			select * from sys.sys_user as sys
			left join er.er_employee_all as er on upper(trim(sys.user_name)) = upper(trim(er.employee_code))
			where sys.user_name = upper(trim('$usr'))
			and (sys.user_password = '$pwd' or sys.token = '$pwd')
			and er.resign = 0
		  ";
		$query = $this->db->query($sql);
		$row = $query->num_rows();
		if ($row == 1) {
			return true;
		} else {
			return false;
		}
	}

	function getPassword($user)
	{
		$user = strtoupper($user);
		$sql = "SELECT * FROM sys.sys_user WHERE user_name='$user' and user_password=md5('123456')";
		return $this->db->query($sql)->num_rows() > 0 ? true : false;
	}

	function getDetail($usr)
	{
		$sql = "	select 	su.*,
          					er.section_code,
          					er.employee_name,
          					er.location_code
          	 		from 	sys.sys_user as su
							join 	er.er_employee_all as er
									on 	er.employee_id=su.employee_id
					where 	user_name = UPPER('" . $usr . "')";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getTheme()
	{
		$sql = "	select 	theme
          	 		from 	sys.sys_theme ";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function table_columns($table_schema, $table_name)
	{
		$columns_not_included 	=	array(
			'create_timestamp',
			'create_user',
			'update_timestamp',
			'update_user',
			'delete_timestamp',
			'delete_user',
			'last_update_timestamp',
			'last_update_user',
			'history_type'
		);

		$this->db->select('	column_name,
								data_type
							');
		$this->db->from('information_schema.columns');
		$this->db->where('table_schema =', $table_schema);
		$this->db->where('table_name =', $table_name);
		$this->db->where_not_in('column_name', $columns_not_included);

		$this->db->order_by('ordinal_position');

		return $this->db->get()->result_array();
	}

	public function table_value($schema_name, $table_name, $where_clause)
	{
		$this->db->select('*');
		$this->db->from($schema_name . "." . $table_name);
		$this->db->where($where_clause);

		return $this->db->get()->result_array();
	}

	public function table_columns_personalia($table_schema, $table_name)
	{
		$this->personalia 	=	$this->load->database('personalia', TRUE);

		$columns_not_included 	=	array(
			'create_timestamp',
			'create_user',
			'update_timestamp',
			'update_user',
			'delete_timestamp',
			'delete_user',
			'last_update_timestamp',
			'last_update_user',
			'history_type'
		);

		$this->personalia->select('	column_name,
										data_type
									');
		$this->personalia->from('information_schema.columns');
		$this->personalia->where('table_schema =', str_replace('"', '', $table_schema));
		$this->personalia->where('table_name =', str_replace('"', '', $table_name));
		$this->personalia->where_not_in('column_name', $columns_not_included);

		$this->personalia->order_by('ordinal_position');

		return $this->personalia->get()->result_array();
	}

	public function table_value_personalia($schema_name, $table_name, $where_clause)
	{
		$this->personalia 	=	$this->load->database('personalia', TRUE);

		$this->personalia->select('*');
		$this->personalia->from($schema_name . "." . $table_name);
		$this->personalia->where($where_clause);

		return $this->personalia->get()->result_array();
	}

	public function table_columns_mysql($table_schema, $table_name)
	{
		$this->quick 	=	$this->load->database('quick', TRUE);
		$columns_not_included 	=	array(
			'create_timestamp',
			'create_user',
			'update_timestamp',
			'update_user',
			'delete_timestamp',
			'delete_user',
			'last_update_timestamp',
			'last_update_user',
			'history_type'
		);

		$this->quick->select('	COLUMN_NAME,
								DATA_TYPE
							');
		$this->quick->from('information_schema.columns');
		$this->quick->where('TABLE_SCHEMA =', $table_schema);
		$this->quick->where('TABLE_NAME =', $table_name);
		$this->quick->where_not_in('COLUMN_NAME', $columns_not_included);

		$this->quick->order_by('ordinal_position');

		return $this->quick->get()->result_array();
	}

	public function table_value_mysql($schema_name, $table_name, $where_clause)
	{
		$this->quick 	=	$this->load->database('quick', TRUE);

		$this->quick->select('*');
		$this->quick->from($schema_name . "." . $table_name);
		$this->quick->where($where_clause);

		return $this->quick->get()->result_array();
	}

	public function path_photo($noind)
	{
		$personalia = $this->load->database('personalia', true);
		$sql = "SELECT path_photo from hrd_khs.tpribadi where noind = '$noind'";
		return $personalia->query($sql)->row()->path_photo;
	}
	public function getAksesKDJabatan($noind)
	{
		$personalia = $this->load->database('personalia', true);
		$sql = "SELECT kd_jabatan from hrd_khs.tpribadi where noind = '$noind'";
		return $personalia->query($sql)->result_array();
	}
	public function getIpAddress($noind)
	{
		$erp = $this->load->database('default', true);
		$sql = "SELECT ip_address from sys.sys_log_activity where log_user = '$noind' and log_aksi = 'Login' order by log_time desc";
		return $erp->query($sql)->result_array();
	}
	public function getEmail($noind)
	{
		$personalia = $this->load->database('personalia', true);
		$sql = "SELECT email_internal, trim(telkomsel_mygroup) nomor from hrd_khs.tpribadi where noind = '$noind'";
		return $personalia->query($sql)->result_array();
	}
}
