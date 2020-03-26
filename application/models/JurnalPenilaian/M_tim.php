<?php
class M_tim extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL 
	public function GetTIM($idTIM=FALSE)
	{
		$this->db->select('*');
		$this->db->from('pk.pk_tim_dtl');

		if(!($idTIM === FALSE))
		{
			$this->db->where('id_tim_dtl', $idTIM);
		}

		$this->db->order_by('nilai', 'desc');

		return $this->db->get()->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($inputTIM)
	{
		$this->db->insert('pk.pk_tim_dtl', $inputTIM);
	}

	// // DELETE
	public function DeleteTIM($idTIM)
	{
		$this->db->where('id_tim_dtl', $idTIM);
        $this->db->delete('pk.pk_tim_dtl');
	}

	// // UPDATE 
	public function Update($updateTIM, $idTIM)
	{
		$this->db->where('id_tim_dtl=', $idTIM);
		$this->db->update('pk.pk_tim_dtl', $updateTIM);
	}
}