<?php
class M_assessment extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function ambilAspekPenilaian()
    {
    	$ambilAspekPenilaian 		= "	select		pkb.*
										from 		pk.pk_bobot as pkb
										order by 	pkb.id_bobot;";
		$queryAmbilAspekPenilaian 	=	$this->db->query($ambilAspekPenilaian);
		return $queryAmbilAspekPenilaian->result_array();
    }
	
	public function ambilDataUnitGroupBerdasarKodesie($kodesie)
	{
		$ambilDataUnitGroupBerdasarKodesie 			= "	select 		pkugl.id_unit_group
														from 		pk.pk_unit_group_list as pkugl;";
		$queryAmbilDataUnitGroupBerdasarKodesie 	=	$this->db->query($ambilDataUnitGroupBerdasarKodesie);
		$hasilAmbilDataUnitGroupBerdasarKodesie		=	$queryAmbilDataUnitGroupBerdasarKodesie->result_array();
		if(!(empty($hasilAmbilDataUnitGroupBerdasarKodesie)))
		{
			return $hasilAmbilDataUnitGroupBerdasarKodesie[0]['id_unit_group'];
		}
		else
		{
			return 0;
		}
	}

	public function ambilDataEvaluasiSeksi($periode)
	{
		$ambilDataEvaluasiSeksi 			= "	select 		pkas.*
												from 		pk.pk_assessment as pkas
												where 		pkas.periode='".$periode."'
												order by 	pkas.kodesie, 
															pkas.noind;";
		$queryAmbilDataEvaluasiSeksi 		=	$this->db->query($ambilDataEvaluasiSeksi);
		return $queryAmbilDataEvaluasiSeksi->result_array();
	}

	public function ambilDataEvaluasiSeksiIndividual($idEvaluasiSeksi)
	{
		$ambilDataEvaluasiSeksi 			= "	select 		pkas.*
												from 		pk.pk_assessment as pkas
												where 		pkas.id_assessment=".$idEvaluasiSeksi."
												order by 	pkas.kodesie, pkas.noind;";
		$queryAmbilDataEvaluasiSeksi 		=	$this->db->query($ambilDataEvaluasiSeksi);
		return $queryAmbilDataEvaluasiSeksi->result_array();
	}

	public function updateNilaiEvaluasi($data, $idEvaluasiSeksi)
	{
		$this->db->where('id_assessment', $idEvaluasiSeksi);
		$this->db->update('pk.pk_assessment', $data);
	}

	public function ambilNilaiSP()
	{
		$ambilNilaiSP 			= "	select 		pksp.*
									from 		pk.pk_sp_dtl as pksp
									where 		pksp.ttberlaku='9999-12-31'
									order by 	pksp.nilai desc;";
		$queryAmbilNilaiSP 		=	$this->db->query($ambilNilaiSP);
		return $queryAmbilNilaiSP->result_array();
	}

	public function ambilNilaiTIM()
	{
		$ambilNilaiTIM 			= "	select 		pktim.*
									from 	 	pk.pk_tim_dtl as pktim
									where 		pktim.ttberlaku='9999-12-31'
									order by	pktim.nilai desc;";
		$queryAmbilNilaiTIM		=	$this->db->query($ambilNilaiTIM);
		return $queryAmbilNilaiTIM->result_array();
	}

	public function ambilKategoriNilai()
	{
		$ambilKategoriNilai 		= "	select		pkrnil.*
										from 		pk.pk_range_nilai as pkrnil
										/*where 		pkrnil.ttberlaku='9999-12-31'*/;";
		$queryAmbilKategoriNilai	=	$this->db->query($ambilKategoriNilai);
		return $queryAmbilKategoriNilai->result_array();
	}

	public function ambilDaftarUnitGroup()
	{
		$ambilDaftarUnitGroup 		= "	select 		pkug.id_unit_group,
													pkug.unit_group
										from 		pk.pk_unit_group as pkug
										order by	pkug.id_unit_group;";
		$queryAmbilDaftarUnitGroup 	=	$this->db->query($ambilDaftarUnitGroup);
		return $queryAmbilDaftarUnitGroup->result_array();
	}

	public function ambilSKPengurangPrestasi()
	{
		$ambilSKPengurangPrestasi 			= "	select		pkskp.*
												from 		pk.pk_sk_pengurang_prestasi as pkskp
												order by 	pkskp.pengurang;";
		$queryAmbilSKPengurangPrestasi 		=	$this->db->query($ambilSKPengurangPrestasi);
		return $queryAmbilSKPengurangPrestasi->result_array();
	}

	public function ambilSKPengurangKemauan()
	{
		$ambilSKPengurangKemauan			= "	select		pkskk.*
												from 		pk.pk_sk_pengurang_kemauan as pkskk
												order by 	pkskk.pengurang;";
		$queryAmbilSKPengurangKemauan 		=	$this->db->query($ambilSKPengurangKemauan);
		return $queryAmbilSKPengurangKemauan->result_array();
	}

	public function ambilGolonganPekerjaanPekerja($id_assessment = FALSE)
	{
		$this->db->select('id_assessment, gol_kerja');
		$this->db->from('pk.pk_assessment');

		if(($id_assessment !== FALSE))
		{
			$this->db->where('id_assessment=', $id_assessment);
		}

		return $this->db->get()->result_array();
	}
}