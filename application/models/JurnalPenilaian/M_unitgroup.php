<?php
class M_unitgroup extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	public function ambilNamaUnitGroup($idUnitGroup = FALSE)
	{
		$queryAmbilNamaUnitGroup	=	'';
		if ($idUnitGroup === FALSE) 
		{
			$ambilNamaUnitGroup 		= "	select 		pkug.id_unit_group,
														pkug.unit_group as nama_unit_group
											from 		pk.pk_unit_group as pkug
											order by 	pkug.id_unit_group";
			$queryAmbilNamaUnitGroup 	= 	$this->db->query($ambilNamaUnitGroup);
		}
		else
		{
			$ambilNamaUnitGroup 		= "	select 		pkug.id_unit_group,
														pkug.unit_group as nama_unit_group
											from 		pk.pk_unit_group as pkug
											where 		pkug.id_unit_group=".$idUnitGroup."
											order by 	pkug.id_unit_group";
			$queryAmbilNamaUnitGroup 	= 	$this->db->query($ambilNamaUnitGroup);			
		}
		return $queryAmbilNamaUnitGroup->result_array();
	}

	public function ambilSeksiUnitGroup()
	{
		$ambilSeksiUnitGroup 		= "	select 		pkugl.id_unit_group,
													concat_ws(' = ', pkugl.kodesie, pkugl.seksi) as value_seksi_unit_group,
													concat_ws(' - ', pkugl.kodesie, pkugl.seksi) as nama_seksi_unit_group
										from 		pk.pk_unit_group_list as pkugl
										order by 	pkugl.id_unit_group,
													pkugl.kodesie;";
		$queryAmbilSeksiUnitGroup	=	$this->db->query($ambilSeksiUnitGroup);
		return $queryAmbilSeksiUnitGroup->result_array();
	}

	public function tambahNamaUnitGroup($dataNamaUnitGroup)
	{
		$this->db->insert('pk.pk_unit_group', $dataNamaUnitGroup);
		$insert_id 	= 	$this->db->insert_id();

		return $insert_id;
	}

	public function tambahSeksiUnitGroup($dataSeksiUnitGroup)
	{
		$this->db->insert('pk.pk_unit_group_list', $dataSeksiUnitGroup);
		$insert_id 	= 	$this->db->insert_id();

		return $insert_id;
	}

	public function deleteUnitGroup($idUnitGroup)
	{
		$this->db->where('id_unit_group', $idUnitGroup);
        $this->db->delete('pk.pk_unit_group');

        $this->db->where('id_unit_group', $idUnitGroup);
        $this->db->delete('pk.pk_unit_group_list');
	}

	public function updateNamaUnitGroup($dataNamaUnitGroup, $idUnitGroup)
	{
		$this->db->where('id_unit_group', $idUnitGroup);
		$this->db->update('pk.pk_unit_group', $dataNamaUnitGroup);
	}

	public function hapusSeksiUnitGroup($idDBUnitGroup, $kodesie)
	{
		$hapusSeksiUnitGroup 	= "	delete from 	pk.pk_unit_group_list
									where 			id_unit_group=".$idDBUnitGroup."
													and 	kodesie not in(".$kodesie.");";
		$queryHapusSeksiUnitGroup	=	$this->db->query($hapusSeksiUnitGroup);
	}

	public function checkExistDataUnitGroup($kodesie, $idDBUnitGroup)
	{
		$checkExistDataUnitGroup	= "	select 		count(pkugl.kodesie) as status_kodesie
										from 		pk.pk_unit_group_list as pkugl
										where 		pkugl.kodesie='".$kodesie."'
													and 	pkugl.id_unit_group=".$idDBUnitGroup.";";
		$queryCheckExistDataUnitGroup	=	$this->db->query($checkExistDataUnitGroup);
		$hasilCheckExistDataUnitGroup	=	$queryCheckExistDataUnitGroup->result_array();
		return $hasilCheckExistDataUnitGroup[0]['status_kodesie'];
	}

	public function ambilDataUnitGroupDeleted($idUnitGroup)
	{
		$ambilDataUnitGroupDeleted			= "	select 		pkug.*
												from 		pk.pk_unit_group as pkug
												where 		pkug.id_unit_group=".$idUnitGroup.";";
		$queryAmbilDataUnitGroupDeleted 	=	$this->db->query($ambilDataUnitGroupDeleted);
		return $queryAmbilDataUnitGroupDeleted->result_array();
	}

	public function inputDataUnitGroupDeletedkeHistory($dataHistory)
	{
		$this->db->insert('pk.pk_unit_group_history', $dataHistory);
	}

	public function ambilDataUnitGroupListDeleted($idUnitGroup)
	{
		$ambilDataUnitGroupListDeleted			= "	select 		pkugl.*
													from 		pk.pk_unit_group_list as pkugl
													where 		pkugl.id_unit_group=".$idUnitGroup.";";
		$queryAmbilDataUnitGroupListDeleted 	=	$this->db->query($ambilDataUnitGroupListDeleted);
		return $queryAmbilDataUnitGroupListDeleted->result_array();	
	}

	public function inputDataUnitGroupListDeletedkeHistory($dataHistory)
	{
		$this->db->insert('pk.pk_unit_group_list_history', $dataHistory);
	}

	// 	Master Distribution
	//	{

		public function ambilJumlahGolongan()
		{
			$ambilJumlahGolongan 			= "	select 		pkgl.id as id_jumlah_golongan,
															pkgl.num as jumlah_golongan
												from 		pk.pk_gol_num as pkgl;";
			$queryAmbilJumlahGolongan 		= 	$this->db->query($ambilJumlahGolongan);
			$hasilAmbilJumlahGolongan 		= 	$queryAmbilJumlahGolongan->result_array();
			return $hasilAmbilJumlahGolongan;
		}

		public function setJumlahGolongan($jumlahGolongan, $idJumlahGolongan)
		{
			$this->db->where('id', $idJumlahGolongan);
			$this->db->update('pk.pk_gol_num', $jumlahGolongan);
		}

		public function cekDataDistribusi($golKerja)
		{
			$cekDataDistribusi 			= "	select 		count(pkudis.id_unit_distribution) as jumlah_data_distribusi_pekerja
											from 		pk.pk_unit_distribution as pkudis
											where 		pkudis.gol_kerja='".$golKerja."';";
			$queryCekDataDistribusi		=	$this->db->query($cekDataDistribusi);
			$hasilCekDataDistribusi		=	$queryCekDataDistribusi->result_array();
			return $hasilCekDataDistribusi[0]['jumlah_data_distribusi_pekerja'];
		}

		public function tambahDataDistribusiPekerja($dataDistribusiPekerja)
		{
			$this->db->insert('pk.pk_unit_distribution', $dataDistribusiPekerja);
		}

		public function ambilDistribusiPekerja($golKerja = FALSE)
		{
			if($golKerja === FALSE)
			{
				$ambilDistribusiPekerja 		= "	select 		pkudis.gol_kerja,
																pkudis.gol_num,
																pkudis.worker_count
													from 		pk.pk_unit_distribution as pkudis";
				$queryAmbilDistribusiPekerja 	=	$this->db->query($ambilDistribusiPekerja);				
			}
			else
			{
				$ambilDistribusiPekerja 		= "	select 		pkudis.gol_kerja,
																pkudis.gol_num,
																pkudis.worker_count
													from 		pk.pk_unit_distribution as pkudis
													where 		pkudis.gol_kerja='".$golKerja."';";
				$queryAmbilDistribusiPekerja 	=	$this->db->query($ambilDistribusiPekerja);				
			}
			return $queryAmbilDistribusiPekerja->result_array();
		}

		public function updateDataDistribusiPekerja($dataDistribusiPekerja, $idUnitGroup, $golongan)
		{
			$this->db->where('gol_kerja', $idUnitGroup);
			$this->db->where('gol_num', $golongan);
			$this->db->update('pk.pk_unit_distribution', $dataDistribusiPekerja);
		}

		public function ambilDataJumlahGolonganDeleted($idJumlahGolongan)
		{
			$ambilDataJumlahGolonganDeleted			= "	select 		pkgl.*
														from 		pk.pk_gol_num as pkgl
														where 		pkgl.id=".$idJumlahGolongan.";";
			$queryAmbilDataJumlahGolonganDeleted 	=	$this->db->query($ambilDataJumlahGolonganDeleted);
			return $queryAmbilDataJumlahGolonganDeleted->result_array();
		}

		public function inputDataJumlahGolonganDeletedkeHistory($dataHistory)
		{
			$this->db->insert('pk.pk_gol_num_history', $dataHistory);
		}

		public function hapusJumlahGolongan($idJumlahGolongan)
		{
			$this->db->where('id', $idJumlahGolongan);
	        $this->db->delete('pk.pk_gol_num');
		}

		public function buatJumlahGolonganBaru($dataBaru)
		{
			$this->db->insert('pk.pk_gol_num', $dataBaru);
		}

	//	}

}