<?php
class M_rangenilai extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	

	// AMBIL BOBOT
	// public function GetRange($idRange=FALSE)
	// {	
	// 	if ($idRange==FALSE) {
	// 		$id='';
	// 	}else{
	// 		$id="and id_range_nilai='$idRange' ";
	// 	}
	// 	$sql="	select	*
	// 			from	pk.pk_range_nilai
	// 			where ttberlaku='9999-12-31'
	// 			$id
	// 			order by 	gol_nilai;";
	// 	$query= $this->db->query($sql);
	// 	return $query->result_array();
	// }

	public function GetRange($idRange=FALSE)
	{
		$this->db->select('*');
		$this->db->from('pk.pk_range_nilai');
		if(!($idRange===FALSE))
		{
			$this->db->where('id_range_nilai=', $idRange);
		}

		return $this->db->get()->result_array();
	}

	// // ADD MASTER DATA GOLONGAN
	public function AddMaster($input)
	{
		// $sql="insert into pk.pk_range_nilai
		// 		(bts_ats,bts_bwh,kategori,tberlaku,ttberlaku)
		// 		values ('$ba','$bb','$kat', TO_DATE('$date', 'YYYY/MM/DD') , '9999-12-31')";
		// $query= $this->db->query($sql);
		// $insert_id = $this->db->insert_id();
		// return  $insert_id;

		$this->db->insert('pk.pk_range_nilai', $input);
	}

	// // DELETE
	public function DeleteRange($idRange)
	{
		$this->db->where('id_range_nilai', $idRange);
        $this->db->delete('pk.pk_range_nilai');
	}

	// // UPDATE GOLONGAN
	public function Update($update, $idRange)
	{
		// $sql1="	update	pk.pk_range_nilai
		// 		set		ttberlaku = '$date'
		// 		where 	id_range_nilai='$idRange'";
		// $sql2=" insert into pk.pk_range_nilai
		// 		(bts_ats,bts_bwh,kategori,tberlaku,ttberlaku)
		// 		values ('$ba','$bb','$kat', TO_DATE('$date', 'YYYY/MM/DD'), '9999-12-31')";
		// $query1= $this->db->query($sql1);
		// $query2= $this->db->query($sql2);

		$this->db->where('id_range_nilai', $idRange);
		$this->db->update('pk.pk_range_nilai', $update);
	}

	public function ambilDataGolonganNilaiDeleted($jumlahGolongan = FALSE)
	{
		$this->db->select('*');
		$this->db->from('pk.pk_range_nilai');

		if(!($jumlahGolongan===FALSE))
		{
			$this->db->where('gol_nilai>', $jumlahGolongan);
		}

		return $this->db->get()->result_array();
	}

	public function createRangeNilai($inputRangeNilai)
	{
		$this->db->insert('pk.pk_range_nilai', $inputRangeNilai);
	}

	public function deleteRangeNilaiUnused($jumlahGolonganBaru = FALSE)
	{
		if(!($jumlahGolonganBaru===FALSE))
		{
			$this->db->where('gol_nilai>', $jumlahGolonganBaru);
			$this->db->delete('pk.pk_range_nilai');
		}
		else
		{
			$this->db->empty_table('pk.pk_range_nilai');
		}
		
	}

	public function inputDataRangeNilaiDeletedkeHistory($dataHistory)
	{
		$this->db->insert('pk.pk_range_nilai_history', $dataHistory);
	}

	public function updateRangeNilai($dataUpdate, $idRangeNilai)
	{
		$this->db->where('id_range_nilai', $idRangeNilai);
		$this->db->update('pk.pk_range_nilai', $dataUpdate);
	}

//--------------------------------JAVASCRIPT RELATED--------------------------//	


}