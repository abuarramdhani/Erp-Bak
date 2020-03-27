<?php
class M_bobot extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL BOBOT
	public function GetBobot($idBobot=FALSE)
	{
		$this->db->select('*');
		$this->db->from('pk.pk_bobot');

		if(!($idBobot === FALSE))
		{
			$this->db->where('id_bobot', $idBobot);
		}

		$this->db->order_by('bobot', 'desc');

		return $this->db->get()->result_array();
	}

	// ADD MASTER DATA GOLONGAN
	public function AddMaster($inputBobot)
	{
		$this->db->insert('pk.pk_bobot', $inputBobot);
	}

	// DELETE
	public function DeleteBobot($idBobot)
	{
		$this->db->where('id_bobot=', $idBobot);
        $this->db->delete('pk.pk_bobot');
	}

	// UPDATE GOLONGAN
	public function Update($updateBobot, $idBobot)
	{
		// $sql1="	update	pk.pk_bobot
		// 		set		bobot
		// 		where 	id_bobot='$idBobot'";
		// $query1= $this->db->query($sql1);
		$this->db->where('id_bobot=', $idBobot);
		$this->db->update('pk.pk_bobot', $updateBobot);
	}

	public function createColum($real,$konversi)
	{
		$sql = "	ALTER TABLE 	pk.pk_assessment ADD column $real float4,ADD column $konversi float4;
					ALTER TABLE 	pk.pk_assessment_history ADD column $real float4,ADD column $konversi float4;";
		$query = $this->db->query($sql);
	}

	public function dropColum($real,$konversi){
		$sql = "	ALTER TABLE pk.pk_assessment DROP column $real,DROP column $konversi; 
					ALTER TABLE pk.pk_assessment_history DROP column $real,DROP column $konversi;";
		$query = $this->db->query($sql);
	}

	public function get_bobot_by_id($idBobot){
		$this->db->where('id_bobot=',$idBobot);
		return $this->db->get('pk.pk_bobot')->row();
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}