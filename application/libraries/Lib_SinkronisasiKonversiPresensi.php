<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
class lib_sinkronisasikonversipresensi
{

	function __construct()
	{
		$this->CI = &get_instance();

		$this->CI->load->library('General');

		date_default_timezone_set('Asia/Jakarta');

		$this->CI->load->model('SystemAdministration/MainMenu/M_user');

		$this->CI->load->model('er/M_sinkronisasikonversipresensi');
		
		$execution_timestamp 	=	date('Y-m-d H:i:s');
		$session_user 			=	$this->CI->session->user;
	}

	public function history($schema_name, $table_name, $where_clause, $type)
	{
		$column 		=	$this->CI->general->load_all_column_personalia($schema_name, $table_name);
		$data_type 		=	$this->CI->general->load_all_data_type_personalia($schema_name, $table_name);
		$value 			=	$this->CI->general->load_all_value_table_personalia($schema_name, $table_name, $where_clause);

		$history 		=	array();

		$col_index 		=	0;
		
		foreach ($value as $val)
		{
			foreach ($column as $col)
			{
				$history[$col] 	=	$val[$col];

				if ( $data_type[$col_index] == 'boolean' )
				{
					if ( $history[$col] == 't' )
					{
						$history[$col] = TRUE;
					}
					else
					{
						$history[$col] = FALSE;
					}
				}

				$col_index++;
			}

			if ( strtoupper($type) == 'CREATE' )
			{
				$history['create_timestamp'] 	=	$val['create_timestamp'];
				$history['create_user']			=	$val['create_user'];
				$history['history_type']		=	'CREATE';
			}
			elseif ( strtoupper($type) == 'UPDATE' )
			{
				$history['update_timestamp'] 	=	$val['last_update_timestamp'];
				$history['update_user']			=	$val['last_update_user'];
				$history['history_type']		=	'UPDATE';
			}
			elseif ( strtoupper($type) == 'DELETE' )
			{
				$history['delete_timestamp'] 	=	date('Y-m-d H:i:s');
				$history['delete_user']			=	$this->CI->session->user;
				$history['history_type']		=	'DELETE';
			}
			else
			{
				$history['update_timestamp'] 	=	$val['last_update_timestamp'];
				$history['update_user']			=	$val['last_update_user'];
				$history['history_type']		=	strtoupper($type);
			}

			$this->CI->M_sinkronisasikonversipresensi->history($schema_name, $table_name, $history);
		}
	}
}