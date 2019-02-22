<?php
class M_ajax extends CI_Model {
	public function __construct()
	{
		$this->oracle = $this->load->database('oracle',true);
		$this->load->library('encrypt');
				$this->load->helper('url');
	}

	public function checkBppbgAccount($field1, $val1, $field2, $val2, $field3, $val3)
	{
		$this->oracle->select('*');
		$this->oracle->from('KHS_BPPBG_ACCOUNT');
		$this->oracle->where($field1, $val1);
		$this->oracle->where($field2, $val2);
		$this->oracle->where($field3, $val3);
		$query = $this->oracle->get();

		return $query->num_rows();
	}
}