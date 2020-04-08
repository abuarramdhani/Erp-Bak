<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_setuppuasa extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	function getPekerjaAll(){
		$sql = "select 
					t1.noind,
					trim(upper(t1.nama)) as nama,
					trim(upper(t1.agama)) as agama,
					trim(upper(t2.dept)) as dept,
					trim(upper(t2.bidang)) as bidang,
					trim(upper(t2.unit)) as unit,
					trim(upper(t2.seksi)) as seksi,
					case when t1.puasa = '1' then 'PUASA' else 'TIDAK PUASA' end as puasa
				from hrd_khs.tpribadi t1
				inner join hrd_khs.tseksi t2 
				on t1.kodesie = t2.kodesie
				and t1.keluar = '0'
				and lokasi_kerja in ('01','02','03','04')
				and left(noind,1) not in ('M','Z','L')
				order by t1.kodesie,t1.noind";
		return $this->personalia->query($sql)->result_array();
	}

	function updatePuasaByNoind($noind,$status){
		$sql = "update hrd_khs.tpribadi
				set puasa = concat(?,'')::bool
				where noind = ? ";
		$this->personalia->query($sql,array($status,$noind));
	}

	function getMuslimTidakPuasa(){
		$sql = "select t1.noind,
					trim(upper(t1.nama)) as nama,
					trim(upper(t1.agama)) as agama,
					trim(upper(t2.dept)) as dept,
					trim(upper(t2.bidang)) as bidang,
					trim(upper(t2.unit)) as unit,
					trim(upper(t2.seksi)) as seksi,
					case when t1.puasa = '1' then 'PUASA' else 'TIDAK PUASA' end as puasa
				from hrd_khs.tpribadi t1
				inner join hrd_khs.tseksi t2 
				on t1.kodesie = t2.kodesie
				and t1.keluar = '0'
				and upper(trim(agama)) in ('ISLAM')
				and puasa = '0'
				and lokasi_kerja in ('01','02','03','04')
				and left(noind,1) not in ('M','Z','L')";
		return $this->personalia->query($sql)->result_array();
	}

	function getNonMuslimPuasa(){
		$sql = "select t1.noind,
					trim(upper(t1.nama)) as nama,
					trim(upper(t1.agama)) as agama,
					trim(upper(t2.dept)) as dept,
					trim(upper(t2.bidang)) as bidang,
					trim(upper(t2.unit)) as unit,
					trim(upper(t2.seksi)) as seksi,
					case when t1.puasa = '1' then 'PUASA' else 'TIDAK PUASA' end as puasa
				from hrd_khs.tpribadi t1
				inner join hrd_khs.tseksi t2 
				on t1.kodesie = t2.kodesie
				and t1.keluar = '0'
				and upper(trim(agama)) not in ('ISLAM')
				and puasa = '1'
				and lokasi_kerja in ('01','02','03','04')
				and left(noind,1) not in ('M','Z','L')";
		return $this->personalia->query($sql)->result_array();
	}
}

?>