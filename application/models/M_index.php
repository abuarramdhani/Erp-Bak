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
}