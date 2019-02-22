<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
class lib_monitoringpresensi
{

	function __construct()
	{
		$this->CI = &get_instance();

		$this->CI->load->library('General');

		date_default_timezone_set('Asia/Jakarta');

		$this->CI->load->model('SystemAdministration/MainMenu/M_user');


		$this->CI->load->model('PresenceManagement/M_monitoringpresensi');
		
		$execution_timestamp 	=	date('Y-m-d H:i:s');
		$session_user 			=	$this->CI->session->user;
	}

	public function send_to_sdk_server($port, $url, $parameter)
	{
		$curl = curl_init();
				set_time_limit(0);
				curl_setopt_array
				(
					$curl,
					array
					(
						CURLOPT_PORT => $port,
						CURLOPT_URL => "http://".$url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $parameter,
						CURLOPT_HTTPHEADER =>
						array
						(
							"cache-control: no-cache",
							"content-type: application/x-www-form-urlencoded"
						),
					)
				);
		$response 	= 	curl_exec($curl);
		$err 		= 	curl_error($curl);
		curl_close($curl);

		if ($err)
		{
			$response = ("Error #:" . $err);
		}
		else
		{
			$response;
		}

		return $response;
	}

	public function get_finger_template_json($noind_baru, $kode_finger = FALSE)
	{
		$header 	=	"[";
		$content 	=	"";
		$footer 	=	"]";

		$get_finger_template	=	$this->CI->M_monitoringpresensi->user_finger_template($noind_baru, $kode_finger);
		foreach ($get_finger_template as $finger_template)
		{
			if ( $content != "" )
			{
				$content 	.=	", ";
			}

			$content 	.=	'{';
			$content 	.=	'"pin":"'.$finger_template['noind_baru'].'", ';
			$content 	.=	'"idx":"'.$finger_template['kode_finger'].'", ';
			$content 	.=	'"alg_ver":"'.$finger_template['alg_ver'].'", ';
			$content 	.=	'"template":"'.$finger_template['jari'].'"';
			$content 	.=	'}';
		}
		return ($header.$content.$footer);
	}

	public function history($schema_name, $table_name, $where_clause, $type)
	{
		$column 		=	$this->CI->general->load_all_column_mysql($schema_name, $table_name);
		$data_type 		=	$this->CI->general->load_all_data_type_mysql($schema_name, $table_name);
		$value 			=	$this->CI->general->load_all_value_table_mysql($schema_name, $table_name, $where_clause);

		$history 		=	array();

		$col_index 		=	0;

		foreach ($value as $val)
		{
			foreach ($column as $col)
			{
				$history[$col] 	=	$val[$col];

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

			$this->CI->M_monitoringpresensi->history($schema_name, $table_name, $history);
		}
	}
}