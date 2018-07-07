<?php
class M_index extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		 function login($usr, $pwd)
		{
          $sql = "select * from sys.sys_user where user_name = '" . $usr . "' and user_password = '" . $pwd . "'";
          $query = $this->db->query($sql);
          $row = $query->num_rows();
		  if($row == 1){
			  return true;
		  }else{
			  return false;
		  }
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
					where 	user_name = '" . $usr . "'";
          $query = $this->db->query($sql);
		  return $query->result();
		}
		
		public function table_columns($table_schema, $table_name)
		{
			$columns_not_included 	=	array
										(
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
			$this->db->from($schema_name.".".$table_name);
			$this->db->where($where_clause);

			return $this->db->get()->result_array();
		}

		public function table_columns_personalia($table_schema, $table_name)
		{
			$this->personalia 	=	$this->load->database('personalia', TRUE);

			$columns_not_included 	=	array
										(
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
			$this->personalia->from($schema_name.".".$table_name);
			$this->personalia->where($where_clause);

			return $this->personalia->get()->result_array();
		}

		public function table_columns_mysql($table_schema, $table_name)
		{
			$this->mysql_dev 	=	$this->load->database('mysql_dev', TRUE);
			$columns_not_included 	=	array
										(
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

			$this->mysql_dev->select('	COLUMN_NAME,
								DATA_TYPE
							');
			$this->mysql_dev->from('information_schema.columns');
			$this->mysql_dev->where('TABLE_SCHEMA =', $table_schema);
			$this->mysql_dev->where('TABLE_NAME =', $table_name);
			$this->mysql_dev->where_not_in('COLUMN_NAME', $columns_not_included);

			$this->mysql_dev->order_by('ordinal_position');

			return $this->mysql_dev->get()->result_array();
		}

		public function table_value_mysql($schema_name, $table_name, $where_clause)
		{
			$this->mysql_dev 	=	$this->load->database('mysql_dev', TRUE);

			$this->mysql_dev->select('*');
			$this->mysql_dev->from($schema_name.".".$table_name);
			$this->mysql_dev->where($where_clause);

			return $this->mysql_dev->get()->result_array();
		}
}