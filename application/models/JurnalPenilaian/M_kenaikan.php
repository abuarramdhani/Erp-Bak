<?php
class M_kenaikan extends CI_Model 
{

    public function __construct()
    {
        parent::__construct();
        $this->personalia 	=	$this->load->database("personalia",true);
    }

    public function ambilGolonganKerja()
    {
    	$ambilGolonganKerja 			= "	select distinct pri.golkerja
											from			hrd_khs.v_hrd_khs_tpribadi as pri
											where 			pri.kode_status_kerja='A'
															and 	keluar=false
											order by 		pri.golkerja";
		$queryAmbilGolonganKerja 		=	$this->personalia->query($ambilGolonganKerja);
		return $queryAmbilGolonganKerja->result_array();
    }

    public function inputKenaikan($inputKenaikan)
    {
    	$this->db->insert('pk.pk_kenaikan', $inputKenaikan);
    }

    public function ambilKenaikan($jumlahGolongan = FALSE)
    {
        $this->db->select('*');
        $this->db->from('pk.pk_kenaikan');

        if(!($jumlahGolongan===FALSE))
        {
            $this->db->where('gol_nilai', $jumlahGolongan);
        }

        $this->db->order_by('id_kenaikan');

        $ambilKenaikan   =   $this->db->get();

        return $ambilKenaikan->result_array();
    }

    public function ambilKenaikanDeleted($jumlahGolongan = FALSE)
    {
    	$this->db->select('*');
    	$this->db->from('pk.pk_kenaikan');

    	if(!($jumlahGolongan===FALSE))
    	{
    		$this->db->where('gol_nilai', $jumlahGolongan);
    	}

    	$ambilKenaikanDeleted 	=	$this->db->get();

    	return $ambilKenaikanDeleted->result_array();
    }

    public function inputKenaikanDeletedkeHistory($dataHistory)
    {
    	$this->db->insert('pk.pk_kenaikan_history', $dataHistory);
    }

    public function hapusKenaikan($gol_nilai)
    {
    	$this->db->where('gol_nilai', $gol_nilai);
    	$this->db->delete('pk.pk_kenaikan');
    }

    public function hapusSemuaKenaikan()
    {
    	$this->db->empty_table('pk.pk_kenaikan');
    }

    public function updateKenaikan($updateKenaikan, $golonganPenilaian, $golonganPekerjaan)
    {
    	$this->db->where('gol_nilai=', $golonganPenilaian);
    	$this->db->where('gol_kerja=', $golonganPekerjaan);
    	$this->db->update('pk.pk_kenaikan', $updateKenaikan);
    }
}