<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_lantai extends CI_Model
{

	function __construct()
	{
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	/**
	 * Get floor level
	 * 
	 * @param String $floor
	 * @return Array<Object>|Object
	 */
	public function getFloor($floor = false)
	{
		$query = $this->db
			->order_by('nama_lantai', 'ASC');

		if ($floor) {
			return $query
				->where('nama_lantai', $floor)
				->get('cvl.cvl_lantai')
				->row();
		}

		return $query
			->get('cvl.cvl_lantai')
			->result_object();
	}

	/**
	 * Add Floor
	 * 
	 * @param String $value
	 * @return Object
	 */
	public function addFloor($value)
	{
		return $this->db->insert('cvl.cvl_lantai', [
			'nama_lantai' => $value
		]);
	}
}
