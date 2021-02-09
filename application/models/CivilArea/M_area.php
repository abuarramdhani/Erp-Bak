<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_area extends CI_Model
{

	function __construct()
	{
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	/**
	 * Get Area Name
	 * 
	 * @param String $name
	 * @return Array<Object>|Object
	 */
	public function getArea($name = false)
	{
		$query =  $this->db
			->order_by('nama_area', 'ASC')
			->from('cvl.cvl_nama_area');

		if ($name) {
			$query->where('nama_area', $name);
			return $query->get()->row();
		}

		return $query->get()->result_object();
	}

	/**
	 * Add Area
	 * 
	 * @param String $value
	 * @return Object
	 */
	public function addArea($value)
	{
		return $this->db->insert('cvl.cvl_nama_area', [
			'nama_area' => $value
		]);
	}
}
