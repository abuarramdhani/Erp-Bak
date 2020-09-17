<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_disnaker extends CI_Model
{
	
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
	}

	public function getPkjDisAktif($tgl)
	{
		$sql = "SELECT
					tp.noind,
					tp.nama,
					tp.nik,
					tp.alamat,
					tp.almt_kost,
					tp.nohp,
					tb.no_peserta bpjs_kesehatan,
					tb2.no_peserta bpjs_ketenagakerjaan,
					tp.pendidikan,
					-- tor.jabatan,
					'V' upah,
					'Bulanan' upah_berlaku,
					case
						when (
						select
							count(*)
						from
							\"Surat\".tsurat_pengangkatan tpeng
						where
							tpeng.noind = tp.noind
							and tpeng.tanggal_berlaku > '$tgl'
						limit 1) > 0 then 
						(select fs_ket from hrd_khs.tnoind t where t.fs_noind = (
						select
							left(noind,1)
						from
							\"Surat\".tsurat_pengangkatan tpeng
						where
							tpeng.tanggal_berlaku > '$tgl'
						order by
							tanggal_berlaku asc
						limit 1))
						else (select fs_ket from hrd_khs.tnoind t where t.fs_noind = left(tp.noind,1))
					end as status_pegawai,
					'WNI' kewarganegaraan,
					tp.email,
					case
						when (
						select
							count(*)
						from
							\"Surat\".tsurat_pengangkatan tpeng
						where
							tpeng.noind = tp.noind
							and tpeng.tanggal_berlaku > '$tgl'
						limit 1) > 0 then (
						select jabatan from hrd_khs.torganisasi where kd_jabatan = (
						select
							kd_jabatan_lama
						from
							\"Surat\".tsurat_pengangkatan tpeng
						where
							tpeng.tanggal_berlaku > '$tgl'
						order by
							tanggal_berlaku asc
						limit 1))
						else (select jabatan from hrd_khs.torganisasi where kd_jabatan = tp.kd_jabatan)
					end as jabatan
				from
					hrd_khs.tpribadi tp
					left join hrd_khs.tbpjskes tb on tb.noind = tp.noind
					left join hrd_khs.tbpjstk tb2 on tb2.noind = tp.noind
					left join hrd_khs.torganisasi tor on tor.kd_jabatan = tp.kd_jabatan
					where
					tglkeluar > '$tgl'";
		return $this->personalia->query($sql)->result_array();
	}
	public function getPkjDisResign($tgl)
	{
		$tgl_awal = date('Y-m-', strtotime($tgl)).'01';
		$sql = "select
					tp.noind,
					tp.nama,
					tp.nik,
					tp.alamat,
					tp.almt_kost,
					tp.nohp,
					tb.no_peserta bpjs_kesehatan,
					tb2.no_peserta bpjs_ketenagakerjaan,
					tp.pendidikan,
					tor.jabatan,
					'V' upah,
					'Bulanan' upah_berlaku,
					(select fs_ket from hrd_khs.tnoind t where t.fs_noind = left(tp.noind,1)) status_pegawai,
					'WNI' kewarganegaraan,
					tp.email,
					tp.sebabklr,
					tp.tglkeluar
				from
					hrd_khs.tpribadi tp
					left join hrd_khs.tbpjskes tb on tb.noind = tp.noind
					left join hrd_khs.tbpjstk tb2 on tb2.noind = tp.noind
					left join hrd_khs.torganisasi tor on tor.kd_jabatan = tp.kd_jabatan
					where
					tglkeluar between '$tgl_awal' and '$tgl'";
					// echo $sql;exit();
		return $this->personalia->query($sql)->result_array();
	}
}