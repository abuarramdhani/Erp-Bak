<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_absenperlokasiabsen extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->quick = $this->load->database('quick',TRUE);
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getDeviceAbsen(){
    	$sql = "select * 
    			from db_datapresensi.tb_device  
    			where office in ('01','02','03')
    			order by office,device_name";
    	return $this->quick->query($sql)->result_array();
    }

    public function getCountPresensiTpresensirill($tanggal,$inisial_lokasi){
    	$sql = "select coalesce(
					(
						select count(*) as jumlah 
						from \"Presensi\".tpresensi_riil 
						where user_ = '$inisial_lokasi' 
						and tanggal = '$tanggal' 
					),
					0
				) as jumlah";
		return $this->personalia->query($sql)->row()->jumlah;
    }

    public function getCountCateringTpresensi($tanggal,$inisial_lokasi){
    	$sql = "select coalesce(
					(
						select count(*) as jumlah 
						from \"Catering\".tpresensi 
						where user_ = '$inisial_lokasi' 
						and tanggal = '$tanggal' 
					),
					0
				) as jumlah";
		return $this->personalia->query($sql)->row()->jumlah;
    }

    public function getLastUpdatePresensiTpresensiriil($inisial_lokasi){
    	$sql = "select coalesce(
					(
						select max(tanggal_input) as last_update 
 						from \"Presensi\".tpresensi_riil 
						where user_ = '$inisial_lokasi' 
					),
					'1900-01-01 00:00:00'::timestamp
				) as last_update";
		return $this->personalia->query($sql)->row()->last_update;
    }

    public function getDetailKateringByTanggalUser($tanggal,$user){
    	$sql = "select a.noind,
				coalesce(b.nama,'nn') as nama, 
				a.waktu, 
				coalesce(d.shift, 'TIDAK ADA SHIFT') as shift, 
				coalesce(a.tempat_makan,b.tempat_makan) as tempat_makan 
				from \"Catering\".tpresensi a 
				left join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				left join \"Presensi\".tshiftpekerja c 
				on a.noind = c.noind 
				and a.tanggal = c.tanggal 
				left join \"Presensi\".tshift d 
				on trim(c.kd_shift) = trim(d.kd_shift) 
				where a.user_ = '$user' 
				and a.tanggal = '$tanggal' 
				order by noind";
		return $this->personalia->query($sql)->result_array();
    }

    public function getDetailKateringByTanggalUserWaktuNoind($tanggal,$user,$waktu,$noind){
    	$sql = "select a.noind,
				coalesce(b.nama,'nn') as nama, 
				a.waktu, 
				coalesce(d.shift, 'TIDAK ADA SHIFT') as shift, 
				coalesce(a.tempat_makan,b.tempat_makan) as tempat_makan 
				from \"Catering\".tpresensi a 
				left join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				left join \"Presensi\".tshiftpekerja c 
				on a.noind = c.noind 
				and a.tanggal = c.tanggal 
				left join \"Presensi\".tshift d 
				on trim(c.kd_shift) = trim(d.kd_shift) 
				where a.user_ = '$user' 
				and a.tanggal = '$tanggal' 
				and a.waktu = '$waktu'
				and a.noind = '$noind'
				order by noind";
		return $this->personalia->query($sql)->result_array();
    }

    public function getDetailAbsenByTanggalUser($tanggal,$user){
    	$sql = "select a.noind,
				coalesce(b.nama,'nn') as nama, 
				a.waktu, 
				coalesce(d.shift, 'TIDAK ADA SHIFT') as shift, 
				b.tempat_makan as tempat_makan 
				from \"Presensi\".tpresensi_riil a 
				left join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				left join \"Presensi\".tshiftpekerja c 
				on a.noind = c.noind 
				and a.tanggal = c.tanggal 
				left join \"Presensi\".tshift d 
				on trim(c.kd_shift) = trim(d.kd_shift) 
				where a.user_ = '$user' 
				and a.tanggal = '$tanggal' 
				order by noind";
		return $this->personalia->query($sql)->result_array();
    }

    public function getDetailAbsenByTanggalUserWaktuNoind($tanggal,$user,$waktu,$noind){
    	$sql = "select a.noind,
				coalesce(b.nama,'nn') as nama, 
				a.waktu, 
				coalesce(d.shift, 'TIDAK ADA SHIFT') as shift, 
				b.tempat_makan as tempat_makan 
				from \"Presensi\".tpresensi_riil a 
				left join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				left join \"Presensi\".tshiftpekerja c 
				on a.noind = c.noind 
				and a.tanggal = c.tanggal 
				left join \"Presensi\".tshift d 
				on trim(c.kd_shift) = trim(d.kd_shift) 
				where a.user_ = '$user' 
				and a.tanggal = '$tanggal' 
				and a.waktu = '$waktu'
				and a.noind = '$noind'
				order by noind";
		return $this->personalia->query($sql)->result_array();
    }
}

?>