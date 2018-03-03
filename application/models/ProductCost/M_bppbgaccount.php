<?php
class M_bppbgaccount extends CI_Model {
	public function __construct()
	{
		$this->oracle = $this->load->database('oracle',true);
		$this->load->library('encrypt');
	}

	public function getAccount($id=FALSE)
	{
		if ($id===FALSE) {
			$query = $this->oracle->get('KHS_BPPBG_ACCOUNT');
		}else{
			$query = $this->oracle->get_where('KHS_BPPBG_ACCOUNT', array('ACCOUNT_ID' => $id));
		}
		return $query->result_array();
	}

	public function setAccount($data)
	{
		$this->oracle->insert('KHS_BPPBG_ACCOUNT', $data);
	}
}