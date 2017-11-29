<?php
class M_sp extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL 
	public function GetSP($idSP=FALSE)
	{	
		if ($idSP==FALSE) {
			$id='';
		}else{
			$id="where id_sp_dtl='$idSP' ";
		}
		$sql="	select	*
				from	pk.pk_sp_dtl
				where ttberlaku='9999-12-31'
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($date, $noSP, $nilai)
	{
		$sql="insert into pk.pk_sp_dtl
				(sp_num,nilai,tberlaku,ttberlaku)
				values ('$noSP','$nilai',TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// // DELETE
	public function DeleteSP($idSP)
	{
		$this->db->where('id_sp_dtl', $idSP);
        $this->db->delete('pk.pk_sp_dtl');
	}

	// // UPDATE 
	public function Update($date, $noSP, $nilai, $idSP)
	{
		$sql1="	update	pk.pk_sp_dtl
				set		ttberlaku = '$date'
				where 	id_sp_dtl='$idSP'";
		$sql2=" insert into pk.pk_sp_dtl
				(sp_num,nilai,tberlaku,ttberlaku)
				values ('$noSP','$nilai',TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}