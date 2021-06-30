<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_prediksisnack extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
        $this->dinas_luar = $this->load->database('dinas_luar',TRUE);
    }

    public function getPrediksiSnackByTanggalShiftLokasi($tanggal,$shift,$lokasi){
    	$sql = "select 
					tp.tempat_makan,
					tsp.tanggal,
					ts.shift,
					count(*) as jumlah_shift,
					/*string_agg(tdp.kd_ket,',') as ket,*/
					sum(
						case when (tdp.kd_ket = 'PCZ' or left(tdp.kd_ket, 1) = 'C') and t.fs_noind is null then 
							1
						else 
							0
						end
					) as cuti,
					sum(
						case when tdp.kd_ket = 'PRM' and t.fs_noind is null then 
							1
						else 
							0
						end
					) as dirumahkan,
					sum(
						case when tdp.kd_ket = 'PSK' and t.fs_noind is null then 
							1
						else 
							0
						end
					) as sakit,
					0 as dinas_luar,
					0 as total,
					(
						select count(*)
                        from
                        \"Catering\".tpuasa t2
                        inner join \"Presensi\".tshiftpekerja tsp2 
                        on t2.fs_noind = tsp2.noind
                        and t2.fd_tanggal = tsp2.tanggal
                        left join \"Presensi\".tshift ts2 
						on tsp2.kd_shift = ts2.kd_shift
                        left join hrd_khs.tpribadi t3 
                        on t3.noind = t2.fs_noind 
                        where trim(t3.tempat_makan) = trim(tp.tempat_makan)
                        and t2.fd_tanggal = tsp.tanggal
                        and ts2.shift = ts.shift
                    ) puasa
				from hrd_khs.tpribadi tp 
				inner join \"Presensi\".tshiftpekerja tsp 
				on tp.noind = tsp.noind
				inner join \"Presensi\".tshift ts 
				on tsp.kd_shift = ts.kd_shift
				inner join \"Catering\".ttempat_makan ttm
				on tp.tempat_makan = ttm.fs_tempat_makan
				left join \"Presensi\".tdatapresensi tdp 
				on tp.noind = tdp.noind
				and tdp.tanggal = tsp.tanggal
                left join \"Catering\".tpuasa t on
                    t.fs_noind = tsp.noind
                    and t.fd_tanggal = tsp.tanggal
                    and tsp.kd_shift in ('1','4','7','9','10')
				where tsp.tanggal = ?
				and ttm.fs_lokasi = ?
				and tp.keluar = '0'
				and tsp.kd_shift in ('1','4','7','9','10')
				group by tp.tempat_makan,tsp.tanggal,ts.shift
				order by 1 ";
		return $this->personalia->query($sql,array($tanggal,$lokasi))->result_array();
    }

    public function getDinasLuarByNoind($noind){
    	$sql = "select t1.spdl_id,t1.noind,max(t2.sampai) as tgl_pulang
				from t_surat_perintah_dl t1 
				inner join t_surat_perintah_dl_detail t2 
				on t1.spdl_id = t2.spdl_id
				where t1.request_approve_draft=1 
				and t1.draft_approved=1
				and t1.request_approve_realisasi=0
				and t1.realisasi_approved=0
				and t1.laporan_approved=0
				and t1.cetak_realisasi=0
				and t2.sampai >= '2020-01-01'
				and t1.noind = ?
				group by t1.spdl_id,t1.noind
				order by t1.spdl_id desc ";
		return $this->dinas_luar->query($sql,array($noind))->result_array();
    }

    public function getNoindByTempatMakanShiftTanggal($tempat_makan,$shift,$tanggal){
    	$sql = "select tp.noind
				from hrd_khs.tpribadi tp 
				inner join \"Presensi\".tshiftpekerja tsp 
				on tp.noind = tsp.noind
				inner join \"Presensi\".tshift ts 
				on tsp.kd_shift = ts.kd_shift
				where tsp.tanggal = ?
				and tp.tempat_makan = ?
				and ts.shift = ?
				and tp.noind not in (
					select t.fs_noind from \"Catering\".tpuasa t
                	left join \"Presensi\".tshiftpekerja t2 
                	on t2.noind = t.fs_noind 
                	and t2.tanggal = t.fd_tanggal 
                	where t.fs_noind = tp.noind 
                	and tsp.tanggal = t.fd_tanggal 
                )
				order by 1 ";
    	return $this->personalia->query($sql,array($tanggal,$tempat_makan,$shift))->result_array();
    }

    public function getAbsenSetelahPulangByTimestampNoind($tgl_pulang,$noind){
    	$sql = "select *
				from \"Presensi\".tpresensi_riil
				where concat(tanggal::date,' ',waktu::time)::timestamp >= ?
				and noind = ?";
    	return $this->personalia->query($sql,array($tgl_pulang,$noind))->result_array();
    }

    public function insertPrediksi($data){
    	$this->personalia->insert("\"Catering\".t_prediksi_snack", $data);
    	return $this->personalia->insert_id();
    }

    public function insertPrediksiDetail($data){
    	$this->personalia->insert("\"Catering\".t_prediksi_snack_detail", $data);
    	return $this->personalia->insert_id();
    }

    public function getDataPrediksiSnackDetailByIdPrediksi($id_prediksi){
    	$sql = "select string_agg(id_prediksi_detail::varchar,',') as id,tempat_makan,
				sum(
					case when trim(shift) = 'SHIFT UMUM' then 
						jumlah_shift
					else 
						0
					end
				) as shift_umum,
				sum(
					case when trim(shift) = 'SHIFT 1' then 
						jumlah_shift
					else 
						0
					end
				) as shift_1,
				sum(
					case when trim(shift) = 'SHIFT 1 SATPAM' then 
						jumlah_shift
					else 
						0
					end
				) as shift_1_satpam,
				sum(
					case when trim(shift) = 'SHIFT 1 PU' then 
						jumlah_shift
					else 
						0
					end
				) as shift_1_pu,
				sum(
					case when trim(shift) = 'SHIFT DAPUR  UMUM' then 
						jumlah_shift
					else 
						0
					end
				) as shift_dapur_umum,
				sum(dirumahkan) as dirumahkan, 
				sum(cuti) as cuti,
				sum(sakit) as sakit,
				sum(dinas_luar) as dinas_luar,
				sum(puasa) as puasa,
				sum(total) as total
			from \"Catering\".t_prediksi_snack_detail
			where id_prediksi = ?
			group by tempat_makan
			order by tempat_makan";
    	return $this->personalia->query($sql,array($id_prediksi))->result_array();
    }

    public function getDataPrediksiSnackByTanggalShiftLokasi($tanggal,$shift,$lokasi){
    	$sql = "select *, (select trim(nama) from hrd_khs.tpribadi t2 where t1.created_by = t2.noind) as nama
				from \"Catering\".t_prediksi_snack t1 
				where tanggal = ?
				and shift = ?
				and lokasi = ?
				order by created_timestamp desc ";
    	return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
    }

    public function getDataPrediksiSnackAll(){
    	$sql = "select tanggal,shift,lokasi,
						count(*) as jumlah,
						min(created_timestamp) as pertama, 
						max(created_timestamp) as terakhir,
						string_agg(distinct created_by,',' order by created_by) as pekerja
				from \"Catering\".t_prediksi_snack
				group by tanggal,shift,lokasi";
    	return $this->personalia->query($sql)->result_array();
    }

    public function insertPrediksiPekerja($id_prediksi_detail,$tanggal,$shift,$lokasi,$tempat_makan){
    	$sql = "insert into \"Catering\".t_prediksi_snack_pekerja
    		(id_prediksi_snack_detail, noind, nama,keterangan)
			select ?, tp.noind, tp.nama,
				case when t.fs_noind is null then 
					case when tdp.kd_ket = 'PCZ' or left(tdp.kd_ket, 1) = 'C' then 
						'Cuti'
					when tdp.kd_ket = 'PRM' then 
						'Dirumahkan'
					when tdp.kd_ket = 'PSK' then 
						'Sakit'
					when (
						select count(*)
						from \"Catering\".t_prediksi_snack_dl tpsdl
						where tpsdl.noind = tp.noind
						and tpsdl.id_prediksi_snack_detail = ?
						and tpsdl.tgl_pulang >= tsp.tanggal
					) > 0 then 
						'Dinas Luar'
					else 
						null 
					end
				else 
					'Puasa'
				end as ket
			from hrd_khs.tpribadi tp 
			inner join \"Presensi\".tshiftpekerja tsp 
			on tp.noind = tsp.noind
			inner join \"Presensi\".tshift ts 
			on tsp.kd_shift = ts.kd_shift
			inner join \"Catering\".ttempat_makan ttm
			on tp.tempat_makan = ttm.fs_tempat_makan
			left join \"Presensi\".tdatapresensi tdp 
			on tp.noind = tdp.noind
			and tdp.tanggal = tsp.tanggal
			left join \"Catering\".tpuasa t 
			on t.fs_noind = tsp.noind
			and t.fd_tanggal = tsp.tanggal
			where tsp.tanggal = ?
			and ttm.fs_lokasi = ?
			and tp.tempat_makan = ?
			and ts.shift = ?
			and tp.keluar = '0'
			";
		$this->personalia->query($sql,array($id_prediksi_detail,$id_prediksi_detail,$tanggal,$lokasi,$tempat_makan,$shift));
    }

    public function getPrediksiSnackPekerjaByIdDetail($id){
    	$sql = "select a.*,b.shift 
    		from \"Catering\".t_prediksi_snack_pekerja a
    		inner join \"Catering\".t_prediksi_snack_detail b 
    		on a.id_prediksi_snack_detail = b.id_prediksi_detail
    		where b.id_prediksi_detail = ?
    		order by b.shift,a.noind";
    	return $this->personalia->query($sql,array($id))->result_array();
    }

    public function getPrediksiSnackDetailByIdDetail($id){
    	$sql = "select b.lokasi,b.tanggal,a.tempat_makan,
				sum(
					case when trim(a.shift) = 'SHIFT UMUM' then 
						jumlah_shift
					else 
						0
					end
				) as shift_umum,
				sum(
					case when trim(a.shift) = 'SHIFT 1' then 
						jumlah_shift
					else 
						0
					end
				) as shift_1,
				sum(
					case when trim(a.shift) = 'SHIFT 1 SATPAM' then 
						jumlah_shift
					else 
						0
					end
				) as shift_1_satpam,
				sum(
					case when trim(a.shift) = 'SHIFT 1 PU' then 
						jumlah_shift
					else 
						0
					end
				) as shift_1_pu,
				sum(
					case when trim(a.shift) = 'SHIFT DAPUR  UMUM' then 
						jumlah_shift
					else 
						0
					end
				) as shift_dapur_umum,
				sum(a.dirumahkan) as dirumahkan, 
				sum(a.cuti) as cuti,
				sum(a.sakit) as sakit,
				sum(a.dinas_luar) as dinas_luar,
				sum(a.puasa) as puasa,
				sum(a.total) as total
    		from \"Catering\".t_prediksi_snack_detail a 
    		inner join \"Catering\".t_prediksi_snack b 
    		on a.id_prediksi = b.id_prediksi
    		where a.id_prediksi_detail in ?
    		group by b.lokasi,b.tanggal,a.tempat_makan";
    	return $this->personalia->query($sql,array($id))->row();
    }

    public function insertPrediksiDL($data){
    	$this->personalia->insert("\"Catering\".t_prediksi_snack_dl",$data);
    }

}
?>    