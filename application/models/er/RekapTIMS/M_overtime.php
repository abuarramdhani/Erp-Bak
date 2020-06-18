<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_overtime extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',true);
	}

	public function getData($periode1,$periode2,$hubungan,$kdsie = FALSE,$detail){
		if (isset($kdsie) and !empty($kdsie)) {
			$kd = " and tdp.kodesie like '$kdsie%'";
		}else{
			$kd = '';
		}
		if ($detail == 1 ){
		$sql = "select to_char(tdp.tanggal, 'YYYYMM') periode,
				tdp.noind,
				tp.nama,
				ts.seksi,
				count(tp.nama) hari_kerja,
				sum(extract(epoch from tdp.keluar::time - tsp.jam_msk::time))/3600 jam_kerja,
				sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time))/3600 overtime,
				(sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time))/3600)/count(tp.nama) rerata,
				(sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time)) - coalesce(sum(extract(epoch from tdt.masuk::time - tdt.keluar::time)),0))/3600 net,
				((sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time)) - coalesce(sum(extract(epoch from tdt.masuk::time - tdt.keluar::time)),0))/3600) / (count(tp.nama)) rerata_net
				from \"Presensi\".tdatapresensi  tdp
				inner join \"Presensi\".tshiftpekerja tsp
				on tsp.noind = tdp.noind
				and tsp.tanggal = tdp.tanggal
				and tsp.jam_plg < tdp.keluar
				inner join hrd_khs.tpribadi tp
				on tp.noind = tdp.noind
				inner join hrd_khs.tseksi ts
				on ts.kodesie = tp.kodesie
				left join \"Presensi\".tdatatim tdt
				on tdt.tanggal = tdp.tanggal
				and tdt.noind = tdp.noind
				and tdt.kd_ket = 'TIK'
				where tdp.tanggal between '$periode1' and '$periode2'
				$kd
				and tdp.kd_ket = 'PKJ'
				and left(tdp.noind,1) in ($hubungan)
				group by to_char(tdp.tanggal, 'YYYYMM'),tdp.noind,tp.nama,ts.seksi
				order by ts.seksi,tdp.noind,to_char(tdp.tanggal, 'YYYYMM')";
			}
			else {
				$sql = "select
						tdp.noind,
						tp.nama,
						ts.seksi,
						count(tp.nama) hari_kerja,
						sum(extract(epoch from tdp.keluar::time - tsp.jam_msk::time))/3600 jam_kerja,
						sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time))/3600 overtime,
						(sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time))/3600)/count(tp.nama) rerata,
						(sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time)) - coalesce(sum(extract(epoch from tdt.masuk::time - tdt.keluar::time)),0))/3600 net,
						((sum(extract(epoch from tdp.keluar::time - tsp.jam_plg::time)) - coalesce(sum(extract(epoch from tdt.masuk::time - tdt.keluar::time)),0))/3600) / (count(tp.nama)) rerata_net
						from \"Presensi\".tdatapresensi  tdp
						inner join \"Presensi\".tshiftpekerja tsp
						on tsp.noind = tdp.noind
						and tsp.tanggal = tdp.tanggal
						and tsp.jam_plg < tdp.keluar
						inner join hrd_khs.tpribadi tp
						on tp.noind = tdp.noind
						inner join hrd_khs.tseksi ts
						on ts.kodesie = tp.kodesie
						left join \"Presensi\".tdatatim tdt
						on tdt.tanggal = tdp.tanggal
						and tdt.noind = tdp.noind
						and tdt.kd_ket = 'TIK'
						where tdp.tanggal between '$periode1' and '$periode2'
						$kd
						and tdp.kd_ket = 'PKJ'
						and left(tdp.noind,1) in ($hubungan)
						group by tdp.noind,tp.nama,ts.seksi
						order by ts.seksi,tdp.noind";
			}
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
}
?>
