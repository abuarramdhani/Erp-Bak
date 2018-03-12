<?php
class M_ajax extends CI_Model {
	public function __construct()
	{
		$this->oracle = $this->load->database('oracle',true);
		$this->load->library('encrypt');
				$this->load->helper('url');
	}

	public function checkBppbgAccount($field,$value)
	{
		$this->oracle->select('*');
		$this->oracle->from('KHS_BPPBG_ACCOUNT');
		$this->oracle->where($field, $value);
		$query = $this->oracle->get();

		return $query->num_rows();
	}
}