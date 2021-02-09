<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_civilarea extends CI_Model
{

	function __construct()
	{
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	/**
	 * Get cost center from postgres
	 * 
	 * @param void
	 * @return Array<Object>
	 */
	public function getCostCenterArea()
	{
		$sql = "
			SELECT
				cost_center,
				branch,
				sum(luas_area) luas_area
			FROM cvl.cvl_luas_area
			GROUP BY cost_center, branch
		";

		return $this->db->query($sql)->result_object();
	}

	/**
	 * To delete area
	 * 
	 * @param Integer $id
	 * @return Object
	 */
	public function deleteAreaDetail($id)
	{
		return $this->db
			->delete('cvl.cvl_luas_area', [
				'luas_area_id' => $id
			]);
	}

	/**
	 * To insert
	 * 
	 * @param Array $data
	 * @return Mixed Int or false
	 */
	public function insertAreaDetail($data)
	{
		return ($this->db->insert('cvl.cvl_luas_area', $data)) ? $this->db->insert_id() : false;
	}

	/**
	 * Update luas area detail
	 * 
	 * @param Integer $id
	 * @param Array $data
	 * @return Object
	 */
	public function updateAreaDetail($id, $data)
	{
		return $this->db->update('cvl.cvl_luas_area', $data, [
			'luas_area_id' => $id
		]);
	}

	/**
	 * Get cost center from postgres with detail
	 * if with param will select cost center specific
	 * 
	 * @param String $cost_center
	 * @return Array<Object> or Object
	 */
	public function getCostCenterAreaDetail($cost_center = false)
	{
		$sql = $this->db
			->select("
				cla.*,
				to_char(cla.created_at, 'DD-MM-YYYY HH24:MI:SS') created_at,
				to_char(cla.updated_at, 'DD-MM-YYYY HH24:MI:SS') updated_at,
				trim(eea.employee_name) as created_by_name,
				trim(eea1.employee_name) as updated_by_name
			")
			->from('cvl.cvl_luas_area as cla')
			->join('er.er_employee_all as eea', 'cla.created_by = eea.employee_code', 'left')
			->join('er.er_employee_all as eea1', 'cla.updated_by = eea1.employee_code', 'left')
			->order_by('cla.cost_center', 'asc')
			->order_by('cla.luas_area_id', 'asc');

		if ($cost_center) {
			$sql->where('cla.cost_center', $cost_center);
		}

		return $sql->get()->result_object();
	}
}
