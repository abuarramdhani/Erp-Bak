<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_cutibersama extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getDataCutiByTanggal($tanggal){
		$sql = "select tp.noind,
					tp.nama,
					tp.noind_baru,
					tp.kodesie,
					tp.akhkontrak::date as akhkontrak,
					tp.tglkeluar::date as tglkeluar,
					coalesce(tdc.jml_cuti,0) as jml_cuti,
					coalesce(tdc.tgl_boleh_ambil,now())::date as tgl_boleh_ambil,
					coalesce(tdc.sisa_cuti,0) as sisa_cuti,
					coalesce(tdc.cuti_bersama,0) as cuti_bersama,
					coalesce(tdc.sisa_cuti_tot,0) as sisa_cuti_tot,
					concat(extract(year from ?::date)::varchar,'-01-01')::date as awal_tahun
				from hrd_khs.tpribadi tp 
				left join \"Presensi\".tdatacuti tdc 
					on tp.noind = tdc.noind 
					and tdc.periode = extract(year from ?::date)::varchar
				where tp.keluar = '0'";
		return $this->personalia->query($sql, array($tanggal,$tanggal))->result_array();
	}

	public function insertLog($data){
		$this->personalia->insert('hrd_khs.tlog',$data);
	}

	public function insertTdatapresensi($data){
		$this->personalia->insert('"Presensi".tdatapresensi',$data);
	}

	public function insertTdatatim($data){
		$this->personalia->insert('"Presensi".tdatatim',$data);
	}

	public function getTliburByTanggal($tanggal){
		$sql = "select * 
				from \"Dinas_Luar\".tlibur 
				where keterangan = 'Cuti Bersama'
				and tanggal = ?";
		return $this->personalia->query($sql, array($tanggal))->result_array();
	}

	public function insertTlibur($tanggal){
		$sql = "insert into \"Dinas_Luar\".tlibur 
				(tanggal, hari, keterangan)select ?,
				(case extract(isodow from ?::date) 
					when 1 then 'Senin' 
					when 2 then 'Selasa' 
					when 3 then 'Rabu'
					when 4 then 'Kamis'
					when 5 then 'Jumat'
					when 6 then 'Sabtu'
					else 'Minggu'
				end),
				'Cuti Bersama'";
		$this->personalia->query($sql, array($tanggal,$tanggal));
	}

	public function getTdatapresensiByTanggal($tanggal){
		$sql = "select * 
				from \"Presensi\".tdatapresensi 
				where tanggal = ?
				and trim(kd_ket) = 'CB'";
		$this->personalia->query($sql, array($tanggal));
	}

	public function deleteTdataPresensiByTanggalNoind($tanggal,$noind){
		$sql = "delete from \"Presensi\".tdatapresensi 
				where tanggal = ?
				and trim(kd_ket) = 'CB'
				and noind = ?";
		$this->personalia->query($sql, array($tanggal,$noind));
	}

	public function deleteTdataTim($tanggal){
		$sql = "delete from \"Presensi\".tdatatim 
				where tanggal = ?
				and trim(kd_ket) = 'TM'";
		$this->personalia->query($sql, array($tanggal));
	}

	public function getTdatatimByTanggalNoind($tanggal,$noind){
		$sql = "select * 
				from \"Presensi\".tdatatim 
				where noind = ?
				and tanggal = ?
				and trim(kd_ket) = 'TM'";
		return $this->personalia->query($sql, array($noind,$tanggal))->result_array();
	}

	public function getTdatapresensiByTanggalNoind($tanggal,$noind){
		$sql = "select * 
				from \"Presensi\".tdatapresensi
				where noind = ?
				and tanggal = ?
				and trim(kd_ket) = 'CB'";
		return $this->personalia->query($sql, array($noind,$tanggal))->result_array();
	}

	public function updateTdatacutibyTanggalNoindAction($noind,$tanggal,$action){
		if ($action == "add") {
			$sql = "update \"Presensi\".tdatacuti
					set cuti_bersama = cuti_bersama + 1,
						sisa_cuti = sisa_cuti - 1
					where noind = ?
						and periode = extract(year from ?::date)::varchar";
		} else if ($action == "del") {
			$sql = "update \"Presensi\".tdatacuti
					set cuti_bersama = cuti_bersama - 1,
						sisa_cuti = sisa_cuti + 1
					where noind = ?
						and periode = extract(year from ?::date)::varchar";
		}
		$this->personalia->query($sql, array($noind,$tanggal));
	}

	public function insertProgress($data){
		$this->personalia->insert("\"Presensi\".progress_transfer_reffgaji",$data);
		return $this->personalia->insert_id();
	}

	public function getProgress($user){
		$sql = "select *
				from \"Presensi\".progress_transfer_reffgaji
				where user_ = ? and menu = 'CutiBersama'";
		return $this->personalia->query($sql,array($user))->row();
	}

	public function deleteProgress($user){
		$sql = "delete from \"Presensi\".progress_transfer_reffgaji
				where user_ = ? and menu = 'CutiBersama'";
		$this->personalia->query($sql,array($user));
	}

	public function updateProgress($user,$index){
		$sql = "update \"Presensi\".progress_transfer_reffgaji
				set progress = ?
				where user_ = ? and menu = 'CutiBersama'";
		$this->personalia->query($sql,array($index,$user));
	}

	public function getRekapCutiBersama(){
		$sql = "select tanggal::date as tanggal,
					(
						select count(*)
						from \"Presensi\".tdatapresensi tdp
						where tdp.tanggal = tl.tanggal
						and trim(kd_ket) = 'CB'
					) as cuti_bersama,
					(
						select count(*)
						from \"Presensi\".tdatatim tdt
						where tdt.tanggal = tl.tanggal
						and trim(kd_ket) = 'TM'
						and point = 0
					) as mangkir_tanpa_point,
					(
						select count(*)
						from \"Presensi\".tdatatim tdt
						where tdt.tanggal = tl.tanggal
						and trim(kd_ket) = 'TM'
						and point = 1
					) as mangkir_berpoint,
					(
						(
							select count(*)
							from \"Presensi\".tdatatim tdt
							where tdt.tanggal = tl.tanggal
							and trim(kd_ket) != 'TM'
						) +
						(
							select count(*)
							from \"Presensi\".tdatapresensi tdp
							where tdp.tanggal = tl.tanggal
							and trim(kd_ket) != 'CB'
						)
					) as lain,
					(
						(
							select count(*)
							from \"Presensi\".tdatatim tdt
							where tdt.tanggal = tl.tanggal
						) + 
						(
							select count(*)
							from \"Presensi\".tdatapresensi tdp
							where tdp.tanggal = tl.tanggal
						)
					) as jumlah
				from \"Dinas_Luar\".tlibur tl 
				where upper(trim(keterangan)) = upper('Cuti Bersama')
				order by tanggal desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerjaCutiByTanggal($tanggal){
		$sql = "select tdp.tanggal::date as tanggal,tdp.noind,trim(tp.nama) as nama,tdp.kd_ket,tdp.masuk,tdp.keluar
				from \"Presensi\".tdatapresensi tdp
				left join hrd_khs.tpribadi tp 
				on tdp.noind = tp.noind
				where tdp.tanggal = ?
				and trim(tdp.kd_ket) = 'CB'
				order by tp.noind";
		return $this->personalia->query($sql,array($tanggal))->result_array();
	}

	public function getPekerjaMangkirTanpaPointByTanggal($tanggal){
		$sql = "select tdt.tanggal::date as tanggal,tdt.noind,trim(tp.nama) as nama,tdt.kd_ket,tdt.masuk,tdt.keluar
				from \"Presensi\".tdatatim tdt
				left join hrd_khs.tpribadi tp 
				on tdt.noind = tp.noind
				where tdt.tanggal = ?
				and trim(tdt.kd_ket) = 'TM'
				and tdt.point = 0
				order by tp.noind";
		return $this->personalia->query($sql,array($tanggal))->result_array();
	}

	public function getPekerjaMangkirPointByTanggal($tanggal){
		$sql = "select tdt.tanggal::date as tanggal,tdt.noind,trim(tp.nama) as nama,tdt.kd_ket,tdt.masuk,tdt.keluar
				from \"Presensi\".tdatatim tdt
				left join hrd_khs.tpribadi tp 
				on tdt.noind = tp.noind
				where tdt.tanggal = ?
				and trim(tdt.kd_ket) = 'TM'
				and tdt.point = 1
				order by tp.noind";
		return $this->personalia->query($sql,array($tanggal))->result_array();
	}

	public function getPekerjaLainByTanggal($tanggal){
		$sql = "select tdt.tanggal::date as tanggal,tdt.noind,trim(tp.nama) as nama,tdt.kd_ket,tdt.masuk,tdt.keluar
				from \"Presensi\".tdatatim tdt
				left join hrd_khs.tpribadi tp 
				on tdt.noind = tp.noind
				where tdt.tanggal = ?
				and trim(tdt.kd_ket) != 'TM'
				union all 
				select tdp.tanggal::date as tanggal,tdp.noind,trim(tp.nama) as nama,tdp.kd_ket,tdp.masuk,tdp.keluar
				from \"Presensi\".tdatapresensi tdp
				left join hrd_khs.tpribadi tp 
				on tdp.noind = tp.noind
				where tdp.tanggal = ?
				and trim(tdp.kd_ket) != 'CB'
				order by noind";
		return $this->personalia->query($sql,array($tanggal,$tanggal))->result_array();
	}

	public function getPekerjaJumlahByTanggal($tanggal){
		$sql = "select tdt.tanggal::date as tanggal,tdt.noind,trim(tp.nama) as nama,tdt.kd_ket,tdt.masuk,tdt.keluar
				from \"Presensi\".tdatatim tdt
				left join hrd_khs.tpribadi tp 
				on tdt.noind = tp.noind
				where tdt.tanggal = ?
				union all 
				select tdp.tanggal::date as tanggal,tdp.noind,trim(tp.nama) as nama,tdp.kd_ket,tdp.masuk,tdp.keluar
				from \"Presensi\".tdatapresensi tdp
				left join hrd_khs.tpribadi tp 
				on tdp.noind = tp.noind
				where tdp.tanggal = ?
				order by noind";
		return $this->personalia->query($sql,array($tanggal,$tanggal))->result_array();
	}

	public function getDataPresensiByTanggal($tanggal){
		$sql = "select tdt.tanggal::date as tanggal,tdt.noind,trim(tp.nama) as nama,tdt.kd_ket,tdt.masuk,tdt.keluar
				from \"Presensi\".tdatatim tdt
				left join hrd_khs.tpribadi tp 
				on tdt.noind = tp.noind
				where tdt.tanggal = ?
				union all 
				select tdp.tanggal::date as tanggal,tdp.noind,trim(tp.nama) as nama,tdp.kd_ket,tdp.masuk,tdp.keluar
				from \"Presensi\".tdatapresensi tdp
				left join hrd_khs.tpribadi tp 
				on tdp.noind = tp.noind
				where tdp.tanggal = ?
				order by noind";
		return $this->personalia->query($sql,array($tanggal,$tanggal))->result_array();
	}

	public function getDataPresensiByTanggalNoind($tanggal,$noind){
		$sql = "select tdt.tanggal::date as tanggal,tdt.noind,trim(tp.nama) as nama,tdt.kd_ket,tdt.masuk,tdt.keluar
				from \"Presensi\".tdatatim tdt
				left join hrd_khs.tpribadi tp 
				on tdt.noind = tp.noind
				where tdt.tanggal = ?
				and tdt.noind = ?
				union all 
				select tdp.tanggal::date as tanggal,tdp.noind,trim(tp.nama) as nama,tdp.kd_ket,tdp.masuk,tdp.keluar
				from \"Presensi\".tdatapresensi tdp
				left join hrd_khs.tpribadi tp 
				on tdp.noind = tp.noind
				where tdp.tanggal = ?
				and tdp.noind = ?
				order by noind";
		return $this->personalia->query($sql,array($tanggal,$noind,$tanggal,$noind))->result_array();
	}

	public function deleteTdatatimTMByTanggalNoind($tanggal,$noind){
		$sql = "delete from \"Presensi\".tdatatim 
				where noind = ?
				and tanggal = ?";
		$this->personalia->query($sql,array($noind,$tanggal));
	}

	public function deleteTliburCutiBersamaByTanggal($tanggal){
		$sql = "delete from \"Dinas_Luar\".tlibur
				where tanggal = ?
				and keterangan = 'Cuti Bersama'";
		$this->personalia->query($sql,array($tanggal));		
	}

} ?>