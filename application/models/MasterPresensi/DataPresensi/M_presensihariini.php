<?php 
defined('BASEPATH') or exit("No DIrect Script Access Allowed");
/**
 * 
 */
class M_presensihariini extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getPresensiHariIni()
	{
		$query = "select (
			        case when tp.lokasi_kerja in('01','03','04') then 'PusatMlati'
			        when tp.lokasi_kerja = '02' then 'Tuksono'
			        else 'Cabang'
			        end
			    ) as lokasi,
			    sum(
			        case when (
			            select count(*)
			            from \"Presensi\".tprs_shift tps
			            where tp.noind = tps.noind
			            and tps.user_ != 'ABSON'
			            and trim(tps.waktu) !='0'
			            and tps.tanggal = current_date
			        ) = 0 then 0
			        else 1
			        end
			    ) as jumlah_masuk,
			    sum(
			         case when (
			            select count(*)
			            from \"Presensi\".tprs_shift tps
			            where tp.noind = tps.noind
			            and tps.user_ != 'ABSON'
			            and trim(tps.waktu) !='0'
			            and tps.tanggal = current_date
			        ) = 0 then 1
			        else 0
			        end
			    ) as jumlah_tdk_masuk
			from hrd_khs.tpribadi tp
			where tp.keluar ='0'
			and left(tp.noind,1) not in ('M','L','Z')
			group by (
			        case when tp.lokasi_kerja in('01','03','04') then 'PusatMlati'
			        when tp.lokasi_kerja = '02' then 'Tuksono'
			        else 'Cabang'
			        end
			)";
		return $this->personalia->query($query)->result_array();
	}

	public function getPresensiDetail($params)
	{
		switch (substr($params, 0, 3) ) {
			case 'pst':
				$lokasi = "and tp.lokasi_kerja in ('01','04','03')";
				break;
			case 'tks':
				$lokasi = "and tp.lokasi_kerja in ('02')";
				break;
			case 'cbg':
				$lokasi = "and tp.lokasi_kerja not in ('01','02','03','04')";
				break;
			default:
				$lokasi = "";
				break;
		}
		switch (substr($params, 4)) {
			case 'masuk':
				$absen = "and (
					select count(*)
					from \"Presensi\".tprs_shift tps
					where tps.noind = tp.noind
					and tps.tanggal = current_date
					and tps.user_ != 'ABSON'
					and trim(tps.waktu) !='0'
				) > 0 ";
				break;
			case 'tidak':
				$absen = "and (
					select count(*)
					from \"Presensi\".tprs_shift tps
					where tps.noind = tp.noind
					and tps.tanggal = current_date
					and tps.user_ != 'ABSON'
					and trim(tps.waktu) !='0'
				) = 0 ";
				break;
			default:
				$absen = "";
				break;
		}
		$query = "select current_date tanggal,tp.noind,tp.nama,tp.kodesie,tp.noind_baru,coalesce(ts.shift,'-') shift,
				(
					select string_agg(tps.waktu,';')
					from \"Presensi\".tprs_shift tps
					where tps.noind = tp.noind
					and tps.tanggal = current_date
					and tps.user_ != 'ABSON'
					and trim(tps.waktu) !='0'
				) waktu
			from hrd_khs.tpribadi tp 
			left join \"Presensi\".tshiftpekerja tsp
			on tsp.noind = tp.noind
			and tsp.tanggal = current_date
			left join \"Presensi\".tshift ts
			on tsp.kd_shift = ts.kd_shift
			where tp.keluar = '0'
			and left(tp.noind,1) not in ('M','L','Z')
			$lokasi 
			$absen
			order by tp.noind";
		return $this->personalia->query($query)->result_array();
	}
}
?>