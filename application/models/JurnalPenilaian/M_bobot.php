<?php
class M_bobot extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL BOBOT
	public function GetBobot($idBobot=FALSE)
	{	
		if ($idBobot==FALSE) {
			$id='';
		}else{
			$id="and id_bobot='$idBobot'";
		}
		$sql="	select	*
				from	pk.pk_bobot
				where ttberlaku='9999-12-31'
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA GOLONGAN
	public function AddMaster($date, $aspek, $bobot, $desc)
	{
		$sql="insert into pk.pk_bobot
				(aspek,bobot,description,tberlaku,ttberlaku)
				values ('$aspek','$bobot','$desc', TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		// return $sql;
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// DELETE
	public function DeleteBobot($idBobot)
	{
		$this->db->where('id_bobot', $idBobot);
        $this->db->delete('pk.pk_bobot');
	}

	// UPDATE GOLONGAN
	public function Update($date, $aspek, $bobot, $desc, $idBobot)
	{
		$sql1="	update	pk.pk_bobot
				set		ttberlaku = '$date'
				where 	id_bobot='$idBobot'";
		$sql2=" insert into pk.pk_bobot
				(aspek,bobot,description,tberlaku,ttberlaku)
				values ('$aspek','$bobot','$desc', TO_DATE('$date', 'YYYY/MM/DD'), '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}