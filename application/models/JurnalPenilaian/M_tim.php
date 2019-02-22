<?php
class M_tim extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL 
	public function GetTIM($idTIM=FALSE)
	{	
		if ($idTIM==FALSE) {
			$id='';
		}else{
			$id="where id_tim_dtl='$idTIM'";
		}
		$sql="	select	*
				from	pk.pk_tim_dtl
				where ttberlaku='9999-12-31'
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($date, $btsA, $btsB, $nilai)
	{
		$sql="insert into pk.pk_tim_dtl
				(bts_ats,bts_bwh,nilai,tberlaku,ttberlaku)
				values ('$btsA','$btsB', '$nilai' ,TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// // DELETE
	public function DeleteTIM($idTIM)
	{
		$this->db->where('id_tim_dtl', $idTIM);
        $this->db->delete('pk.pk_tim_dtl');
	}

	// // UPDATE 
	public function Update($date, $btsA, $btsB, $nilai, $idTIM)
	{
		$sql1="	update	pk.pk_tim_dtl
				set		ttberlaku = '$date'
				where 	id_tim_dtl='$idTIM'";
		$sql2=" insert into pk.pk_tim_dtl
				(bts_ats,bts_bwh,nilai,tberlaku,ttberlaku)
				values ('$btsA','$btsA', '$nilai' ,TO_DATE('$date', 'YYYY/MM/DD'), '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}