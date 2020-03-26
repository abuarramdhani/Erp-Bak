<?php
class M_golongan extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
		
	// AMBIL GOLONGAN
	public function GetGolongan($idGol=FALSE)
	{	
		if ($idGol==FALSE) {
			$id='';
		}else{
			$id="and id= $idGol";
		}
		$sql="	select	*
				from	pk.pk_gol_num
				where ttberlaku='9999-12-31'
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA GOLONGAN
	public function AddMaster($date, $noGol)
	{
		$sql="	insert into pk.pk_gol_num
				(num,tberlaku,ttberlaku)
				values ('$noGol', TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// DELETE GOLONGAN
	public function DeleteGol($idGol)
	{
		$this->db->where('id', $idGol);
        $this->db->delete('pk.pk_gol_num');
	}

	// UPDATE GOLONGAN
	public function Update($date, $noGol, $idGol)
	{
		$sql1="	update	pk.pk_gol_num
				set		ttberlaku = '$date'
				where 	id='$idGol'";
		$sql2=" insert into pk.pk_gol_num
				(num,tberlaku,ttberlaku)
				values ('$noGol', TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}
	
//--------------------------------JAVASCRIPT RELATED--------------------------//	


}