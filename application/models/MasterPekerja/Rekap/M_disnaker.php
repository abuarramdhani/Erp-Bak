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

	function getLokasiKerja($keyword){
		$this->personalia->like('lokasi_kerja',$keyword, 'both');
		return $this->personalia->get('hrd_khs.tlokasi_kerja')->result();
	}

	public function getLokasiKerjabyID($id){
		$this->personalia->where('id_',$id);
		return $this->personalia->get('hrd_khs.tlokasi_kerja')->row_array();
	}


	public function getPkjDisAktif($tgl,$lokasi)
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
				case
 					when (
 					select
 						count(noind)
 					from
 						hrd_khs.tmutasi t2
 					where
 						t2.tglberlaku > '$tgl'
 						and t2.noind = tp.noind ) > 0 then (
 					select
 						lokasilm
 					from
 						hrd_khs.tmutasi
 					where
 						tglberlaku > '$tgl'
 						and noind = tp.noind
 					order by
 						tglberlaku
 					limit 1)
 					else tp.lokasi_kerja end lokasi_kerja,
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
					tglkeluar > '$tgl' and lokasi_kerja like'$lokasi%' and left(tp.noind,1) in ('A','B','J','H')
					order by tp.noind";
		return $this->personalia->query($sql)->result_array();
	}
	public function getPkjDisResign($tgl,$lokasi)
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
					(tglkeluar between '$tgl_awal' and '$tgl') and lokasi_kerja like '$lokasi%' and left(tp.noind,1) in ('A','B','J','H')
					order by tglkeluar asc";
					// echo $sql;exit();
		return $this->personalia->query($sql)->result_array();
	}
}