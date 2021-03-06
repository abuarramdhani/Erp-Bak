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
					distinct a.noind,
					a.nama,
					ts.dept,
					ts.bidang,
					ts.unit,
					ts.seksi,
					case
						when tlk.lokasi_kerja is null then '-'
						else tlk.lokasi_kerja
					end lokasi_kerja,
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
						tm2.tglberlaku::date,
						tpos.tgl_berlaku::date,
						tp.kodesie tpkod,
						tm2.kodesielm,
						tm2.kodesiebr,
						coalesce
						(case
							when '$tglRekap' < tm2.tglberlaku::date then tm2.kodesielm
							else tm2.kodesiebr
						end,
						tp.kodesie) kodesie,
						coalesce
						(case
							when '$tglRekap' < tm2.tglberlaku then tm2.lokasilm
							else tm2.lokasibr
						end,
						tp.lokasi_kerja) lokasi_kerja,
						coalesce
						(case
							when '$tglRekap' < tm2.tglberlaku then tm2.jabatanlm
							else tm2.jabatanbr
						end,
						tp.jabatan) jabatan,
						coalesce
						(case
							when '$tglRekap' < tpos.tgl_berlaku then tpos.kdpekerjaan_lama
							when '$tglRekap' < tm2.tglberlaku then tm2.kd_pkj_lama
							when '$tglRekap' >= tpos.tgl_berlaku then tpos.kdpekerjaan_baru
							when '$tglRekap' >= tm2.tglberlaku then tm2.kd_pkj_baru
							else tp.kd_pkj
						end,
						tp.kd_pkj) kode_pkj,
						tp.kode_status_kerja,
						row_number() over (partition by tp.noind
					order by
						tp.noind,
						tm2.tglberlaku) r,
						row_number() over (partition by tp.nik,
						tp.nama
					order by
						tp.tglkeluar) y
					from
						hrd_khs.tpribadi tp
					left join (
						select
							distinct tm.noind,
							tm.tglberlaku,
							tm.kodesielm,
							tm.kodesiebr,
							tm.lokasilm,
							tm.lokasibr,
							tm.jabatanlm,
							tm.jabatanbr,
							tsm.kd_pkj_lama,
							tsm.kd_pkj_baru
						from
							hrd_khs.tmutasi tm
						left join (
							select
								t2.*
							from
								\"Surat\".tsurat_mutasi t2
							where
								t2.tanggal_cetak = (
								select
									max(t.tanggal_cetak)
								from
									\"Surat\".tsurat_mutasi t
								where
									t2.noind = t.noind )) tsm on
							tm.noind = tsm.noind
							and tm.tglberlaku::date = tsm.tanggal_berlaku::date
						order by
							tm.noind) tm2 on
						tp.noind = tm2.noind
						and tm2.tglberlaku >= '$tglRekap'
					left join hrd_khs.ttransposisi_pekerja tpos on
						tp.noind = tpos.noind
						and tpos.tgl_berlaku >= '$tglRekap'
					where
						(tp.tglkeluar > '$tglRekap' or (tp.tglkeluar < '$tglRekap' and tp.keluar = '0'))
						and $kode
						and tp.masukkerja <= '$tglRekap'
					order by
						tp.noind) a
				left join hrd_khs.tpekerjaan tpk on
					a.kode_pkj = tpk.kdpekerjaan
				left join hrd_khs.tseksi ts on
					a.kodesie = ts.kodesie
				left join hrd_khs.tlokasi_kerja tlk on
					a.lokasi_kerja = tlk.id_
				left join hrd_khs.tnoind tn on
					a.kode_status_kerja = tn.fs_noind
				where
					a.kodesie like '$kodesie%'
					and (a.lokasi_kerja like '%$lokasi%'
					or a.lokasi_kerja is null)
					and a.r < 2
					and a.y < 2
				order by
					a.noind";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }
}