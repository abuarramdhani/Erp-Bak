<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_presensipekerja extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->quick = $this->load->database('quick',TRUE);
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getDepartementByKey($key){
    	$sql = "select distinct left(kodesie,1) as kodesie, 
					case when trim(dept) = '-' then 
						'semua seksi'
					else
						trim(dept)
					end as dept
				from hrd_khs.tseksi
				where trim(upper(dept)) like upper(concat('%',?,'%'))
				order by 1";
		return $this->personalia->query($sql,array($key))->result_array();
    }

    public function getBidangByKeyKode($key,$Kode){
    	$sql = "select distinct left(kodesie,3) as kodesie, 
					case when trim(bidang) = '-' then 
						concat('semua seksi dept ',trim(dept))
					else
						trim(bidang)
					end as bidang
				from hrd_khs.tseksi
				where trim(upper(bidang)) like upper(concat('%',?,'%'))
				and left(kodesie,1) = ?
				order by 1";
		return $this->personalia->query($sql,array($key,$Kode))->result_array();
    }

    public function getUnitByKeyKode($key,$Kode){
    	$sql = "select distinct left(kodesie,5) as kodesie,
					case when trim(unit) = '-' then 
						concat('semua seksi bidang ',trim(bidang))
					else
						trim(unit)
					end as unit
				from hrd_khs.tseksi
				where trim(upper(unit)) like upper(concat('%',?,'%'))
				and left(kodesie,3)  = ?
				order by 1";
		return $this->personalia->query($sql,array($key,$Kode))->result_array();
    }

    public function getSeksiByKeyKode($key,$Kode){
    	$sql = "select distinct left(kodesie,7) as kodesie, 
					case when trim(seksi) = '-' then 
						concat('semua seksi unit ',trim(unit))
					else
						trim(seksi)
					end as seksi
				from hrd_khs.tseksi
				where trim(upper(seksi)) like upper(concat('%',?,'%'))
				and left(kodesie,5)  = ?
				order by 1";
		return $this->personalia->query($sql,array($key,$Kode))->result_array();
    }

    public function getSeksiByKodesie($kodesie){
    	$sql = "select distinct
    				left(kodesie,7) as kodesie,
    				trim(dept) as dept, 
    				trim(bidang) as bidang, 
    				trim(unit) as unit, 
    				trim(seksi) as seksi
    			from hrd_khs.tseksi
    			where kodesie like concat(?,'%')
    			order by 1";
    	return $this->personalia->query($sql,array($kodesie))->result_array();
    }

    public function getTanggalBetweenTwoDate($tanggal_awal,$tanggal_akhir){
    	$sql = "select dates.dates::date as tanggal
  				from generate_series(?::date, ?::date, interval '1 day') as dates;";
  		return $this->personalia->query($sql,array($tanggal_awal,$tanggal_akhir))->result_array();
    }

    public function getEstimasi($tanggal,$shift,$kodesie){
    	$sql = "select COUNT(*) AS jumlah 
    			FROM \"Presensi\".tshiftpekerja 
				WHERE tanggal = ?
				AND kd_shift IN ($shift) 
				AND kodesie like concat(?,'%')";
		return $this->personalia->query($sql,array($tanggal,$kodesie))->row();
    }

    public function getRealitas($tanggal,$shift,$kodesie){
    	$sql = "select COUNT(*) AS jumlah 
				FROM \"Presensi\".tdatapresensi dp 
				INNER JOIN \"Presensi\".tshiftPekerja sp 
				ON sp.noind = dp.noind and sp.tanggal = dp.tanggal
				WHERE dp.kd_ket IN ('PKJ', 'PLB', 'HL') 
				AND dp.tanggal = ? 
				AND sp.kd_shift IN ($shift) 
				AND sp.kodesie like concat(?,'%')";
		return $this->personalia->query($sql,array($tanggal,$kodesie))->row();
    }

    public function getCuti($tanggal,$shift,$kodesie){
    	$sql = "select COUNT(*) AS jumlah 
				FROM \"Presensi\".tdatapresensi dp 
				INNER JOIN \"Presensi\".tshiftPekerja sp 
				ON sp.noind = dp.noind and sp.tanggal = dp.tanggal
				WHERE (dp.kd_ket like 'C%' or dp.kd_ket = 'PCZ')
				AND dp.tanggal = ? 
				AND sp.kd_shift IN ($shift) 
				AND sp.kodesie like concat(?,'%')";
		return $this->personalia->query($sql,array($tanggal,$kodesie))->row();
    }

    public function getSakit($tanggal,$shift,$kodesie){
    	$sql = "select COUNT(*) AS jumlah 
				FROM \"Presensi\".tdatapresensi dp 
				INNER JOIN \"Presensi\".tshiftPekerja sp 
				ON sp.noind = dp.noind and sp.tanggal = dp.tanggal
				WHERE dp.kd_ket = 'PSK'
				AND dp.tanggal = ? 
				AND sp.kd_shift IN ($shift) 
				AND sp.kodesie like concat(?,'%')";
		return $this->personalia->query($sql,array($tanggal,$kodesie))->row();
    }

    public function getLain($tanggal,$shift,$kodesie){
    	$sql = "select COUNT(*) AS jumlah 
				FROM \"Presensi\".tdatapresensi dp 
				INNER JOIN \"Presensi\".tshiftPekerja sp 
				ON sp.noind = dp.noind and sp.tanggal = dp.tanggal
				WHERE dp.kd_ket NOT IN ('PKJ', 'PLB', 'HL', 'PSK', 'PCZ') 
				and dp.kd_ket not like 'C%'
				AND dp.tanggal = ? 
				AND sp.kd_shift IN ($shift) 
				AND sp.kodesie like concat(?,'%')";
		return $this->personalia->query($sql,array($tanggal,$kodesie))->row();
    }

    public function getMangkir($tanggal,$shift,$kodesie){
    	$sql = "select COUNT(*) AS jumlah 
				FROM \"Presensi\".tdatatim dt 
				INNER JOIN \"Presensi\".tshiftpekerja sp 
				ON dt.noind = sp.noind 
				AND dt.tanggal = sp.tanggal 
				WHERE sp.tanggal = ?
				AND sp.kodesie like concat(?,'%')
				AND sp.kd_shift IN ($shift) 
				AND dt.kd_ket = 'TM' ";
		return $this->personalia->query($sql,array($tanggal,$kodesie))->row();
    }

} ?>