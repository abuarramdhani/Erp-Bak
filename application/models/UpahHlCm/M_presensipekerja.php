<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_presensipekerja extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	public function getAbsenDefault(){
		$sql = "(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, b.nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatatim a
				INNER JOIN hrd_khs.TPribadi b
				ON b.noind=a.noind 
				WHERE b.keluar = '0' and date_part('month',tanggal) = date_part('month',now() - interval '1 month') 
				AND date_part('year',tanggal) = date_part('year',now() - interval '1 month') AND left(a.noind,1) = 'R' )
				UNION 
				(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, b.nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatapresensi a
				INNER JOIN hrd_khs.TPribadi b 
				ON b.noind=a.noind 
				WHERE b.keluar = '0' and date_part('month',tanggal) =  date_part('month',now() - interval '1 month')  
				AND date_part('year',tanggal) = date_part('year',now() - interval '1 month') AND left(a.noind,1) = 'R' )
				ORDER BY  kodesie,noind,tanggal, kd_ket";
		return $this->personalia->query($sql)->result_array();
	}

	public function getAbsenByParams($awal,$akhir,$pkjoff = FALSE,$pkjoff_awal = FALSE,$pkjoff_akhir = FALSE){
		if ($pkjoff == "On") {
			$off = " b.tglkeluar between '$pkjoff_awal' and '$pkjoff_akhir' ";
		} else {
			$off = " b.keluar = '0' ";
		}
		$sql = "(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, trim(b.nama) as nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatatim a
				INNER JOIN hrd_khs.TPribadi b
				ON b.noind=a.noind 
				WHERE $off and tanggal between '$awal' and '$akhir' AND left(a.noind,1) = 'R' )
				UNION 
				(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, b.nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatapresensi a
				INNER JOIN hrd_khs.TPribadi b 
				ON b.noind=a.noind 
				WHERE $off and tanggal between '$awal' and '$akhir' AND left(a.noind,1) = 'R' )
				ORDER BY  kodesie,noind,tanggal, kd_ket";
		return $this->personalia->query($sql)->result_array();
	}

	public function getLemburByParams($awal,$akhir,$pkjoff = FALSE,$pkjoff_awal = FALSE,$pkjoff_akhir = FALSE){
		if ($pkjoff == "On") {
			$off = " b.tglkeluar between '$pkjoff_awal' and '$pkjoff_akhir' ";
		} else {
			$off = " b.keluar = '0' ";
		}
		$sql = "(SELECT a.tanggal, a.noind, a.kodesie, trim(b.nama) as nama, sum(c.total_lembur ) total_lembur ,to_char(a.tanggal,'yyyymmdd') as index_tanggal 
				 FROM \"Presensi\".TLembur a
				   INNER JOIN hrd_khs.TPribadi b ON b.Noind = a.noind 
				   INNER JOIN \"Presensi\".TDataPresensi c ON a.noind = c.noind 
				     AND a.tanggal = c.tanggal 
				WHERE $off and a.tanggal between '$awal' and '$akhir' 
				  AND left(a.noind, 1) = 'R'
				 GROUP BY a.tanggal, a.noind, a.kodesie, b.nama ) 
				ORDER BY a.kodesie, a.noind, a.tanggal";
		return $this->personalia->query($sql)->result_array();
	}

	public function getSusulan($kd_ket,$noind,$tanggal){
		$sql = "select * from \"Presensi\".tsusulan 
                where noind = '$noind' and tanggal = '$tanggal'
                and ket like '%$kd_ket%'";
        return $this->personalia->query($sql)->result_array();
	}

	public function getTanggalDefault(){
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series(now() - interval '2 month', now(), '1 day') as dates
				where date_part('month',dates.dates) = date_part('month',now() - interval '1 month') ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getTanggalByParams($awal,$akhir){
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series('$awal'::date, '$akhir'::date, '1 day') as dates ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getWaktuAbsen($noind,$awal,$akhir){
		$sql = "select tanggal::date as tanggal,waktu, b.nama
				from \"Presensi\".tprs_shift a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				where a.noind = '$noind'
				and tanggal between '$awal' and '$akhir'
				order by tanggal, waktu";
		return $this->personalia->query($sql)->result_array();
	}

	public function getInisial($noind,$tanggal){
		$sql = "select trim(b.inisial) as inisial 
				from \"Presensi\".tshiftpekerja a 
				inner join \"Presensi\".tshift b 
				on a.kd_shift = b.kd_shift
				where noind = '$noind'
				and tanggal = '$tanggal'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->inisial;
		}else{
			return "<span style='color: red'>S?</span>";
		}
		
	}

	public function getRekapPresensi($awal,$akhir){
		$sql = "select 	a.noind, a.jml_gp as gp_gaji, a.jml_um as um_gaji, a.jml_lbr as lembur_gaji,  a.ump as ump_gaji,
						coalesce(b.gp,0) as gp_tambahan, coalesce(b.um,0) as um_tambahan, coalesce(b.lembur,0) as lembur_tambahan, 
						coalesce(c.gp,0) as gp_potongan, coalesce(c.um,0) as um_potongan, coalesce(c.lembur,0) as lembur_potongan,
						d.pekerjaan,
						e.nama
				from hlcm.hlcm_proses a
				left join (
						select noind, tgl_awal_periode, tgl_akhir_periode, sum(gp) as gp,sum(um) as um,sum(lembur) as lembur
						from hlcm.hlcm_tambahan
						group by noind,tgl_awal_periode,tgl_akhir_periode
					) b 
					on a.noind = b.noind 
					and a.tgl_awal_periode = b.tgl_awal_periode
					and a.tgl_akhir_periode = b.tgl_akhir_periode
				left join (
						select noind, tgl_awal_periode, tgl_akhir_periode, sum(gp) as gp,sum(um) as um,sum(lembur) as lembur
						from hlcm.hlcm_potongan
						group by noind,tgl_awal_periode,tgl_akhir_periode
					) c 
					on a.noind = c.noind 
					and a.tgl_awal_periode = c.tgl_awal_periode 
					and a.tgl_akhir_periode = c.tgl_akhir_periode
				left join hlcm.hlcm_datagaji d 
					on a.kode_pekerjaan = d.kode_pekerjaan 
					and a.lokasi_kerja = d.lokasi_kerja
				left join hlcm.hlcm_datapekerja e 
					on a.noind = e.noind
				where a.tgl_awal_periode = '$awal'
					and a.tgl_akhir_periode = '$akhir'
				order by a.noind";
		return $this->erp->query($sql)->result_array();
	}

	public function insertArsip($data){
		$this->erp->insert('hlcm.hlcm_presensi',$data);
		return;
	}

	public function getArsipPresensi(){
		$sql = "select 	a.tgl_awal_periode,
						a.tgl_akhir_periode,
						a.asal,
						a.keterangan,
						concat(a.created_by,' - ', b.employee_name) as created_by,
						to_char(a.created_date,'yyyy-mm-dd HH24:MI:ss') as created_date,
						a.id_presensi 
				from hlcm.hlcm_presensi a 
				left join er.er_employee_all b 
				on a.created_by = b.employee_code
				order by a.created_date desc";
		return $this->erp->query($sql)->result_array();
	}

	public function getArsipPresensiDetail($id){
		$sql = "select * from hlcm.hlcm_presensi where id_presensi = $id";
		return $this->erp->query($sql)->row();
	}
} 

?>