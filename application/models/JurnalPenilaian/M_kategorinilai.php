<?php
class M_kategorinilai extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL 
	public function GetKatNil($idKatNil=FALSE)
	{	
		if ($idKatNil==FALSE) {
			$id='';
		}else{
			$id="where id_kategori='$idKatNil'";
		}
		$sql="	select	*
				from	pk.pk_kategori
				where ttberlaku='9999-12-31'
				$id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	// ADD MASTER DATA 
	public function AddMaster($date, $kat, $std_nilai)
	{
		$sql="insert into pk.pk_kategori
				(kategori,std_nilai,tberlaku,ttberlaku)
				values ('$kat','$std_nilai', TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		$query= $this->db->query($sql);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	// // DELETE
	public function DeleteKatNil($idKatNil)
	{
		$this->db->where('id_kategori', $idKatNil);
        $this->db->delete('pk.pk_kategori');
	}

	// // UPDATE 
	public function Update($date, $kat, $std_nilai, $idKatNil)
	{
		$sql1="	update	pk.pk_kategori
				set		ttberlaku = '$date'
				where 	id_kategori='$idKatNil'";
		$sql2=" insert into pk.pk_kategori
				(kategori,std_nilai,tberlaku,ttberlaku)
				values ('$kat','$std_nilai' ,TO_DATE('$date', 'YYYY/MM/DD'), '9999-12-31')";
		$query1= $this->db->query($sql1);
		$query2= $this->db->query($sql2);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}