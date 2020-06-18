<?php
class M_sp extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL 
	public function GetSP($idSP=FALSE)
	{	
		$this->db->select('*');
		$this->db->from('pk.pk_sp_dtl');

		if(!($idSP === FALSE))
		{
			$this->db->where('id_sp_dtl=', $idSP);
		}

		$this->db->order_by('sp_num', 'asc');

		return $this->db->get()->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($inputSP)
	{
		$this->db->insert('pk.pk_sp_dtl', $inputSP);
	}

	// // DELETE
	public function DeleteSP($idSP)
	{
		$this->db->where('id_sp_dtl', $idSP);
        $this->db->delete('pk.pk_sp_dtl');
	}

	// // UPDATE 
	public function Update($updateSP, $idSP)
	{
		$this->db->where('id_sp_dtl=', $idSP);
		$this->db->update('pk.pk_sp_dtl', $updateSP);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}