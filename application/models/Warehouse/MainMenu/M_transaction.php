<?php
class M_transaction extends CI_Model {
    public function __construct()
    {
    	$this->oracle = $this->load->database ('oracle', TRUE);
    }
	
	function insertPacking($dt)
	{
		$this->oracle->insert('KHS_PACKINGLIST_TRANSACTIONS', $dt);
	}
	
	function deletePackingList($id)
	{
		$this->oracle->where('MO_NUMBER', $id);
		$this->oracle->delete('KHS_PACKINGLIST_TRANSACTIONS');
	}
}