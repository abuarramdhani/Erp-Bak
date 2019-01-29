<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_daftarasset extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getDataAsset(){
		$sql = "select *, 
				case when status_retired = '0' then 
					'Aktif'
				when status_retired = '1' then
					'Non-Aktif Sementara'
				else
					'Non-Aktif Permanent'
				end status_aktif,
				(
				select case when count(*) > 0 then
					(
						select seksi_awal 
						from sm.sm_transfer_asset 
						where tag_number = pa.tag_number 
						order by id_transfer desc 
						limit 1
					)
				else
				'-'
				end
				from sm.sm_transfer_asset ta 
				where ta.tag_number = pa.tag_number
				) transfer,
				(
				select case when count(*) > 0 then
					(
					select ea.employee_name 
					from er.er_employee_all ea 
					where ea.employee_code = 	(
													select requester_baru 
													from sm.sm_transfer_asset 
													where tag_number = pa.tag_number 
													order by id_transfer desc 
													limit 1
												)
					)
				else
					(
					select ea.employee_name
					from er.er_employee_all ea 
					where ea.employee_code = 	(
													select distinct ia.requester
													from sm.sm_input_asset ia
													where ia.no_pp = pa.no_pp
												)
					)
				end
				from sm.sm_transfer_asset ta 
				where ta.tag_number = pa.tag_number
				) requester
				from sm.sm_pembelian_asset pa";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>