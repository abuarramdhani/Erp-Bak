<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_rekapjp extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);    
    }

    public function getRJP($tglRekap, $kode, $kodesie, $lokasi)
    {
    	$sql = "select
					a.noind,
					a.nama,
					ts.dept,
					ts.bidang,
					ts.unit,
					ts.seksi,
					tlk.lokasi_kerja,
					a.jabatan,
					a.tgl_masuk,
					a.tgl_akhir_kontrak,
					tn.fs_ket status,
					case
						when tpk.pekerjaan is null then '-'
						else tpk.pekerjaan
					end pekerjaan,
					case
						when tpk.jenispekerjaan = '0' then 'DIRECT'
						else 'INDIRECT'
					end jenis_pekerjaan
				from
					(
					select
						distinct tp.noind,
						tp.nama,
						tp.masukkerja::date tgl_masuk,
						tp.akhkontrak::date tgl_akhir_kontrak,
						tm.tanggal_berlaku,
						tpos.tgl_berlaku,
						tp.kodesie tpkod,
						tm.kodesie_lama,
						tm.kodesie_baru,
						coalesce
						(case
							when '$tglRekap' < tm.tanggal_berlaku::date then tm.kodesie_lama
							else tm.kodesie_baru
						end, tp.kodesie) kodesie,
						coalesce
						(case
							when '$tglRekap' < tm.tanggal_berlaku then tm.lokasi_kerja_lama
							else tm.lokasi_kerja_baru
						end, tp.lokasi_kerja) lokasi_kerja,
						coalesce
						(case
							when '$tglRekap' < tm.tanggal_berlaku then tm.jabatan_lama
							else tm.jabatan_baru
						end, tp.jabatan) jabatan,
						coalesce
						(case
							when '$tglRekap' < tpos.tgl_berlaku then tpos.kdpekerjaan_lama
							when '$tglRekap' < tm.tanggal_berlaku then tm.kd_pkj_lama
							when '$tglRekap' >= tpos.tgl_berlaku then tpos.kdpekerjaan_baru
							when '$tglRekap' >= tm.tanggal_berlaku then tm.kd_pkj_baru
							else tp.kd_pkj
						end, tp.kd_pkj) kode_pkj,
						tp.kode_status_kerja
					from
						hrd_khs.tpribadi tp
					left join \"Surat\".tsurat_mutasi tm on
						tp.noind = tm.noind
						and tm.tanggal_berlaku >= '$tglRekap'
					left join hrd_khs.ttransposisi_pekerja tpos on
						tp.noind = tpos.noind
						and  tpos.tgl_berlaku >= '$tglRekap'
					where
						tp.tglkeluar > '$tglRekap'
						and $kode
						and tp.masukkerja <= '$tglRekap'
					order by
						tp.noind) a
				left join hrd_khs.tpekerjaan tpk on
					a.kode_pkj = tpk.kdpekerjaan,
					hrd_khs.tseksi ts,
					hrd_khs.tlokasi_kerja tlk,
					hrd_khs.tnoind tn
				where
					a.kodesie = ts.kodesie
					and a.lokasi_kerja = tlk.id_
					and a.kode_status_kerja = tn.fs_noind
					and a.kodesie like '$kodesie%'
					and a.lokasi_kerja like '%$lokasi%'
				order by a.noind";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }
}