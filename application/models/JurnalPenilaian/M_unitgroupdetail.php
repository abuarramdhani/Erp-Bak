<?php
class M_unitgroupdetail extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL USER GROUP DETAIL
	public function GetUnitGroupDetail($idUnit=FALSE)
	{	
		if ($idUnit==FALSE) {
			$id='';
		}else{
			$id="where id_unit_group_list='$idUnit'";
		}
		$sql="	select	*
				from	pk.pk_unit_group_list
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// AMBIL USER GROUP
	public function GetUnitGroupCreate($idUnitGroup)
	{	
		$sql="	select	*
				from	pk.pk_unit_group
				where unit_group='$idUnitGroup'";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($dataInsert)
	{
		$this->db->insert('pk.pk_unit_group_list', $dataInsert);
		// $sql="insert into pk.pk_unit_group_list
		// 		(id_unit_group, unit, tberlaku, ttberlaku)
		// 		values ('$IDUnit','$unit',TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		// $query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// // DELETE
	public function DeleteUnitGroupDetail($idUnitDetail)
	{
		$this->db->where('id_unit_group_list', $idUnitDetail);
        $this->db->delete('pk.pk_unit_group_list');
	}

	// // UPDATE 
	public function Update($idUnitDetail,$date,$IDUnit,$unit)
	{
		$sql1="	update	pk.pk_unit_group_list
				set		ttberlaku = '$date'
				where 	id_unit_group_list='$idUnitDetail'";
		$sql2=" insert into pk.pk_unit_group_list
				(id_unit_group, unit, tberlaku, ttberlaku)
				values ('$IDUnit','$unit',TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	

	// AMBIL SEKSI
	public function GetSectionGroup()
	{	
		$sql = "
				select section_name 
				from er.er_section 
				group by section_name
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


}