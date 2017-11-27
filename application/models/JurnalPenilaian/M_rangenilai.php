<?php
class M_rangenilai extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL BOBOT
	public function GetRange($idRange=FALSE)
	{	
		if ($idRange==FALSE) {
			$id='';
		}else{
			$id="where id_range_nilai='$idRange' ";
		}
		$sql="	select	*
				from	pk.pk_range_nilai
				where ttberlaku='9999-12-31'
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// // ADD MASTER DATA GOLONGAN
	public function AddMaster($date, $ba, $bb, $kat)
	{
		$sql="insert into pk.pk_range_nilai
				(bts_ats,bts_bwh,kategori,tberlaku,ttberlaku)
				values ('$ba','$bb','$kat', TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// // DELETE
	public function DeleteRange($idRange)
	{
		$this->db->where('id_range_nilai', $idRange);
        $this->db->delete('pk.pk_range_nilai');
	}

	// // UPDATE GOLONGAN
	public function Update($date, $ba, $bb, $kat, $idRange)
	{
		$sql1="	update	pk.pk_range_nilai
				set		ttberlaku = '$date'
				where 	id_range_nilai='$idRange'";
		$sql2=" insert into pk.pk_range_nilai
				(bts_ats,bts_bwh,kategori,tberlaku,ttberlaku)
				values ('$ba','$bb','$kat', TO_DATE('$date', 'YYYY/MM/DD'), '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}