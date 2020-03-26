<?php
class M_pengurangnilai extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public 	$SKPengurangPrestasi 	=	'pk.pk_sk_pengurang_prestasi';
    public 	$SKPengurangKemauan 	=	'pk.pk_sk_pengurang_kemauan';

    public function inputSKPengurangPrestasi($input)
    {
   		$this->db->insert($this->SKPengurangPrestasi, $input);
   	}

   	public function updateSKPengurangPrestasi($update, $idSKPrestasi)
   	{
   		$this->db->where('sk_pres_id', $idSKPrestasi);
   		$this->db->update($this->SKPengurangPrestasi, $update);
   	}

   	public function ambilSKPengurangPrestasi()
   	{
   		$ambilSKPengurangPrestasi 			= "	select 		pkskp.*
												from 		pk.pk_sk_pengurang_prestasi as pkskp
												order by 	pkskp.pengurang;";
		$queryAmbilSKPengurangPrestasi 		=	$this->db->query($ambilSKPengurangPrestasi);
		return $queryAmbilSKPengurangPrestasi->result_array();
   	}

   	public function deleteSKPrestasi($idSKPrestasi)
   	{
   		$this->db->where('sk_pres_id=', $idSKPrestasi);
   		$this->db->delete($this->SKPengurangPrestasi);
   	}

    public function inputSKPengurangKemauan($input)
    {
   		$this->db->insert($this->SKPengurangKemauan, $input);
   	}

   	public function updateSKPengurangKemauan($update, $idSKPrestasi)
   	{
   		$this->db->where('sk_kemauan_id', $idSKPrestasi);
   		$this->db->update($this->SKPengurangKemauan, $update);
   	}

   	public function ambilSKPengurangKemauan()
   	{
   		$ambilSKPengurangKemauan 			= "	select 		pkskk.*
												from 		pk.pk_sk_pengurang_kemauan as pkskk
												order by 	pkskk.pengurang;";
		$queryAmbilSKPengurangKemauan 		=	$this->db->query($ambilSKPengurangKemauan);
		return $queryAmbilSKPengurangKemauan->result_array();
   	}

   	public function deleteSKKemauan($idSKPrestasi)
   	{
   		$this->db->where('sk_kemauan_id=', $idSKPrestasi);
   		$this->db->delete($this->SKPengurangKemauan);
   	}

}