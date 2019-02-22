<?php
class M_unitgroup extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL 
	public function GetUnitGroup($idUnit=FALSE)
	{	
		if ($idUnit==FALSE) {
			$id='';
		}else{
			$id="where id_unit_group='$idUnit'";
		}
		$sql="	select	*
				from	pk.pk_unit_group
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($unit)
	{
		$sql="insert into pk.pk_unit_group
				(unit_group)
				values ('$unit')";
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// // DELETE
	public function DeleteUnitGroup($idUnit)
	{
		$this->db->where('id_unit_group', $idUnit);
        $this->db->delete('pk.pk_unit_group');
	}

	// // UPDATE 
	public function Update($idUnit,$unit)
	{
		$sql="	update	pk.pk_unit_group
				set		unit_group = '$unit'
				where 	id_unit_group='$idUnit'";
		$query= $this->db->query($sql);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}