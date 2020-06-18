<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_notifdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->quick = $this->load->database('quick',TRUE);
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getDLThisDay(){
    	$sql = "select tpd.noind,
					tp.nama,
					tp.tempat_makan,
					tpd.spdl_id,
					case when tpd.stat = '0' then 
						'BERANGKAT'
					else 
						'PULANG'
					end as status,
					tpd.wkt_realisasi,
					tpd.tgl_realisasi::date as tanggal, 
					tp.lokasi_kerja::int::varchar as lokasi,
					(
						select count(*)
						from \"Catering\".tpenguranganpesanan tpp
						inner join \"Catering\".tpenguranganpesanan_detail tppd
						on tpp.id_pengurangan = tppd.id_pengurangan
						where tpp.fd_tanggal = tpd.tanggal
						and tppd.fs_noind = tpd.noind
					) as dikurangi,
					tlk.lokasi_kerja
				from \"Presensi\".tpresensi_dl tpd 
				left join hrd_khs.tpribadi tp 
				on tpd.noind = tp.noind
				left join hrd_khs.tlokasi_kerja tlk 
				on tlk.id_ = tp.lokasi_kerja
				where tpd.tgl_realisasi = current_date";
		return $this->personalia->query($sql)->result_array();
    }

} ?>