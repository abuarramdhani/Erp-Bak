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

	public function getPresensiOriginalHariIni()
	{
		$query = "select (
		        case when tp.lokasi_kerja in('01','03','04') then 'Pusat'
		        when tp.lokasi_kerja = '02' then 'Tuksono'
		        else 'Cabang'
		        end
		    ) as lokasi,
		    (
		        case when tp.lokasi_kerja ='02' or left(tp.kodesie,1) ='3' then 'Fabrikasi'
		        else 'Non Fabrikasi'
		        end
		    ) as jenis,
		    sum(
		        case when (
		            select count(*)
		            from \"Presensi\".tpresensi_riil tps
		            where tp.noind = tps.noind
		            and tps.user_ != 'ABSON'
		            and trim(tps.waktu) !='0'
		            and tps.tanggal = current_date
		        ) = 0 then 0
		        else 1
		        end
		    ) as jumlah_wfo,
		    sum(
		        case when (
		            select count(*)
		            from \"Presensi\".tpresensi_riil tps
		            where tp.noind = tps.noind
		            and tps.user_ = 'ABSON'
		            and trim(tps.waktu) !='0'
		            and tps.tanggal = current_date
		        ) = 0 then 0
		        else 1
		        end
		    ) as jumlah_wfh,
		    sum(
		         case when (
		            select count(*)
		            from \"Presensi\".tpresensi_riil tps
		            where tp.noind = tps.noind
		            and trim(tps.waktu) !='0'
		            and tps.tanggal = current_date
		        ) = 0 then 1
		        else 0
		        end
		    ) as jumlah_off
		from hrd_khs.tpribadi tp
		where tp.keluar ='0'
		and left(tp.noind,1) not in ('M','L','Z')
		and tp.lokasi_kerja in ('01','02','03','04')
		group by (
		        case when tp.lokasi_kerja in('01','03','04') then 'Pusat'
		        when tp.lokasi_kerja = '02' then 'Tuksono'
		        else 'Cabang'
		        end
		) ,
		(
		    case when tp.lokasi_kerja ='02' or left(tp.kodesie,1) ='3' then 'Fabrikasi'
		    else 'Non Fabrikasi'
		    end
		)";
		return $this->personalia->query($query)->result_array();
	}

	public function getPresensiPenyesuaianHariIni()
	{
		$query = "select (
		        case when tp.lokasi_kerja in('01','03','04') then 'Pusat'
		        when tp.lokasi_kerja = '02' then 'Tuksono'
		        else 'Cabang'
		        end
		    ) as lokasi,
		    (
		        case when
		            tp.lokasi_kerja ='02' /*tuksono*/
		            or left(tp.kodesie,1) ='3' /*dep prod*/
		            or left(tp.kodesie, 7) in ('4050101','4060101') /*personalia civil maintenance dan waste management*/
		            or tp.kd_pkj in (
		                '401010204', /*OP. DAPUR UMUM*/
		                '401010102', /*SATUAN PENGAMAN*/
		                '401010201', /*OP. PEKERJAAN UMUM*/
		                '401010202', /*KERNET*/
		                '401010203' /*SOPIR*/
		            )
		        then 'Fabrikasi'
		        else 'Non Fabrikasi'
		        end
		    ) as jenis,
		    sum(
		        case when (
		            select count(*)
		            from \"Presensi\".tpresensi_riil tps
		            where tp.noind = tps.noind
		            and tps.user_ != 'ABSON'
		            and trim(tps.waktu) !='0'
		            and tps.tanggal = current_date
		        ) = 0 then 0
		        else 1
		        end
		    ) as jumlah_wfo,
		    sum(
		        case when (
		            select count(*)
		            from \"Presensi\".tpresensi_riil tps
		            where tp.noind = tps.noind
		            and tps.user_ = 'ABSON'
		            and trim(tps.waktu) !='0'
		            and tps.tanggal = current_date
		        ) = 0 then 0
		        else 1
		        end
		    ) as jumlah_wfh,
		    sum(
		         case when (
		            select count(*)
		            from \"Presensi\".tpresensi_riil tps
		            where tp.noind = tps.noind
		            and trim(tps.waktu) !='0'
		            and tps.tanggal = current_date
		        ) = 0 then 1
		        else 0
		        end
		    ) as jumlah_off
		from hrd_khs.tpribadi tp
		where tp.keluar ='0'
		and left(tp.noind,1) not in ('M','L','Z')
		and tp.lokasi_kerja in ('01','02','03','04')
		group by (
		        case when tp.lokasi_kerja in('01','03','04') then 'Pusat'
		        when tp.lokasi_kerja = '02' then 'Tuksono'
		        else 'Cabang'
		        end
		    ) ,
		    (
		        case when
		            tp.lokasi_kerja ='02' /*tuksono*/
		                or left(tp.kodesie,1) ='3' /*dep prod*/
		                or left(tp.kodesie, 7) in ('4050101','4060101') /*personalia civil maintenance dan waste management*/
		                or tp.kd_pkj in (
		                    '401010204', /*OP. DAPUR UMUM*/
		                    '401010102', /*SATUAN PENGAMAN*/
		                    '401010201', /*OP. PEKERJAAN UMUM*/
		                    '401010202', /*KERNET*/
		                    '401010203' /*SOPIR*/
		                )
		        then 'Fabrikasi'
		        else 'Non Fabrikasi'
		        end
		    )";
		return $this->personalia->query($query)->result_array();
	}

	public function getPresensiDetail($params)
	{
		$param = explode("_",$params);

		switch ($param[0]) {
			case 'p':
				$lokasi = "and tp.lokasi_kerja in('01','03','04')";
				switch ($param[1]) {
					case 'o':
						switch ($param[2]) {
							case 'f':
								$seksi = "and left(tp.kodesie,1) ='3'";
								break;
							case 'n':
								$seksi = "and left(tp.kodesie,1) !='3'";
								break;
							default:
								$seksi = "";
								break;
						}
						break;
					case 'p':
						switch ($param[2]) {
							case 'f':
								$seksi = "and (
					                left(tp.kodesie,1) ='3' /*dep prod*/
					                or left(tp.kodesie, 7) in ('4050101','4060101') /*personalia civil maintenance dan waste management*/
					                or tp.kd_pkj in (
					                    '401010204', /*OP. DAPUR UMUM*/
					                    '401010102', /*SATUAN PENGAMAN*/
					                    '401010201', /*OP. PEKERJAAN UMUM*/
					                    '401010202', /*KERNET*/
					                    '401010203' /*SOPIR*/
					                )
					            )";
					            break;
							case 'n':
								$seksi = "and (
					                case when left(tp.kodesie,1) ='3' /*dep prod*/ then true
					                when left(tp.kodesie, 7) in ('4050101','4060101') /*personalia civil maintenance dan waste management*/ then true
					                when tp.kd_pkj in (
					                    '401010204', /*OP. DAPUR UMUM*/
					                    '401010102', /*SATUAN PENGAMAN*/
					                    '401010201', /*OP. PEKERJAAN UMUM*/
					                    '401010202', /*KERNET*/
					                    '401010203' /*SOPIR*/
					                ) then true
					                else false 
					                end
					            ) = false";
								break;
							default:
								$seksi = "";
								break;
						}
						break;
					default:
						$seksi = "";
						break;
				}
				break;
			case 't':
				$lokasi = "and tp.lokasi_kerja = '02'";
				$seksi = "";
				break;
			default:
				$lokasi = "and tp.lokasi_kerja in ('01','02','03','04')";
				$seksi = "";
				break;
		}
		switch ($param[3]) {
			case 'wfo':
				$user = "and user_ != 'ABSON'";
				$jumlah_absen = "and (
                        select count(*)
                        from \"Presensi\".tpresensi_riil tpr
                        where tpr.tanggal = current_date
                        and tpr.noind = tp.noind
                        $user
                    ) > 0";
				break;
			case 'wfh':
				$user = "and user_ = 'ABSON'";
				$jumlah_absen = "and (
                        select count(*)
                        from \"Presensi\".tpresensi_riil tpr
                        where tpr.tanggal = current_date
                        and tpr.noind = tp.noind
                        $user
                    ) > 0";
				break;
			case 'off': 
			$user = "";
				$jumlah_absen = "and (
                        select count(*)
                        from \"Presensi\".tpresensi_riil tpr
                        where tpr.tanggal = current_date
                        and tpr.noind = tp.noind
                    ) = 0";
                break;
			default:
				$user = "";
				break;
		}
		$query = "select ts.dept,ts.bidang,ts.unit,ts.seksi,tp.noind,tp.nama,
				coalesce(
                    (
                        select string_agg(waktu,'|' order by waktu)
                        from \"Presensi\".tpresensi_riil tpr
                        where tpr.tanggal = current_date
                        and tpr.noind = tp.noind
                        $user
                    ),
				    '-'
                ) as waktu,
				coalesce(
                    (
                        select string_agg(
                        	case user_ 
                        	when 'ABSON' then 'Absen Online'
                        	when 'BRCD1' then 'Depan Mushola'
                        	when 'BRCD2' then 'Dep Prod'
                        	when 'BRCD3' then 'Anjungan'
                        	when 'BRCD4' then 'Finishgood'
                        	when 'BRCD5' then 'Sheet Metal'
                        	when 'BRCD6' then 'Foundry'
                        	when 'BRCD7' then 'Machining'
                        	when 'BRCD0' then 'Civil Mtn'
                        	when 'BRCDa' then 'Finishgood2'
                        	when 'BRCDb' then 'Foundry2'
                        	when 'BRCDc' then 'Machining2'
                        	when 'BRCDf' then 'Painting'
                        	else user_
                        	end,
                        	'|' order by waktu
                        )
                        from \"Presensi\".tpresensi_riil tpr
                        where tpr.tanggal = current_date
                        and tpr.noind = tp.noind
                        $user
                    ),
				    '-'
                ) as lokasi, 
				coalesce(
			        (
			            select string_agg(ts1.shift, ',')
			            from \"Presensi\".tshiftpekerja tsp
	                    inner join \"Presensi\".tshift ts1
			            on tsp.kd_shift = ts1.kd_shift
			            where tsp.noind = tp.noind
			            and tsp.tanggal = current_date
			        ),
			        '-'
			    ) as shift
			from hrd_khs.tpribadi tp
			inner join hrd_khs.tseksi ts
			on tp.kodesie = ts.kodesie
			left join hrd_khs.tpekerjaan tpk
			on tp.kd_pkj = tpk.kdpekerjaan
			where tp.keluar = '0'
			and left(tp.noind,1) not in ('M','L','Z')
			$lokasi 
			$seksi
			$jumlah_absen
			order by tp.noind";
		return $this->personalia->query($query)->result_array();
	}
}
?>