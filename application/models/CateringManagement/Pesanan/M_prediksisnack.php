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
					count(*) as jumlah_shift,
					/*string_agg(tdp.kd_ket,',') as ket,*/
					sum(
						case when tdp.kd_ket = 'PCZ' or left(tdp.kd_ket,1) = 'C' then 
							1
						else 
							0
						end
					) as cuti,
					sum(
						case when tdp.kd_ket = 'PRM' then 
							1
						else 
							0
						end
					) as dirumahkan,
					sum(
						case when tdp.kd_ket = 'PSK' then 
							1
						else 
							0
						end
					) as sakit,
					0 as dinas_luar,
					0 as total
				from hrd_khs.tpribadi tp 
				inner join \"Presensi\".tshiftpekerja tsp 
				on tp.noind = tsp.noind
				inner join \"Catering\".ttempat_makan ttm
				on tp.tempat_makan = ttm.fs_tempat_makan
				left join \"Presensi\".tdatapresensi tdp 
				on tp.noind = tdp.noind
				and tdp.tanggal = tsp.tanggal
				where tsp.tanggal = ?
				and ttm.fs_lokasi = ?
				and tp.keluar = '0'
				and tsp.kd_shift in ('1','4','10')
				group by tp.tempat_makan,tsp.tanggal
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
				where tsp.tanggal = ?
				and tp.tempat_makan = ?
				and tsp.kd_shift in ('1','4','10')
				order by 1 ";
    	return $this->personalia->query($sql,array($tanggal,$tempat_makan))->result_array();
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
    }

    public function getDataPrediksiSnackDetailByIdPrediksi($id_prediksi){
    	$sql = "select *
				from \"Catering\".t_prediksi_snack_detail
				where id_prediksi = ?
				order by id_prediksi_detail";
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

}
?>    