<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pengalamankerja extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getPekerjaByKey($key)
	{
		$sql = "select noind,trim(nama) as nama
					from hrd_khs.tpribadi
					where 
					 (
						noind like upper(concat('%',?,'%'))
						or nama like upper(concat('%',?,'%'))
						)";
		return $this->personalia->query($sql, array($key, $key))->result_array();
	}



	public function detailPekerja($noind)
	{
		$getDetailPekerja 		= "select a.noind, nama, a.kd_jabatan, masukkerja::date,akhkontrak::date, alamat,desa,kec,kab,nik,
	 		                           dept, bidang, unit, seksi, c.jabatan, tor.jabatan as jabatan_organisasi, a.kodesie,
	 		                           (case when d.status=1 then concat('Sudah Diapprove Hubker') else concat('Belum Diapprove Hubker') end) as apd
					                    from hrd_khs.tpribadi a
																inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
																inner join hrd_khs.trefjabatan c on a.noind=c.noind
																left join \"Surat\".tpengembalian_apd d on a.noind=d.noind
																left join hrd_khs.torganisasi tor on tor.kd_jabatan = a.kd_jabatan
					                   where a.noind = '$noind'";

		$query 	=	$this->personalia->query($getDetailPekerja);
		return $query->result_array();
	}

	public function isiSuratPengalaman()
	{
		$getIsiSuratPengalaman 		= "select *
					                    from \"Surat\".tisi_pengalaman"; // ini nggak dikasih where ....


		$query 	=	$this->personalia->query($getIsiSuratPengalaman);
		return $query->result_array();
	}

	public function nomorSuratPengalaman()
	{
		$getnomorSuratPengalaman 		= " select 
                                             lpad(
	                                         (
		                                     coalesce(
			                                 (
				                             SELECT MAX(no_surat) AS kodemax 
				                              FROM \"Surat\".tsurat_pengalaman 
				                              where kd_surat=to_char(current_date,'yyyy/mm')
			                                 ),
			                                 '000'
		                                     )::numeric+1
	                                         )::varchar,
	                                         3,
	                                         '0'
                                             ) as no_selanjutnya,
                                             to_char(current_date,'yyyy/mm') as tahun_bulan,
                                             to_char(current_date,'yyyy/mm/dd')as tanggal_surat ";


		$query 	=	$this->personalia->query($getnomorSuratPengalaman);
		return $query->result_array();
	}
	public function DetailisiSuratPengalaman($kd)
	{
		$DetailisiSuratPengalaman 		= "select *
					                    from \"Surat\".tisi_pengalaman where kd_isi='$kd'"; //ini


		$query 	=	$this->personalia->query($DetailisiSuratPengalaman);
		return $query->result_array();
	}

	public function getSuratPengalamanKerjaAll()
	{

		$sql = "SELECT 
				    	ts.kd_surat,
				    	no_surat,
				    	ts.noind,
				    	concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
				    	ts.isi_surat,
				    	ts.tgl_kena::date,
				        ts.kodesie,
				    	ts.tgl_cetak::date,
				    	ts.tgl_surat::date,
				    	ts.cetak,
						ts.alamat,
						tp.noind,
						(case when ts.noind in (select noind from hrd_khs.tlog tl where tl.noind = ts.noind and tl.jenis = 'CETAK -> SURAT PENGALAMAN KERJA')
							then 'blue' else 'black' end) as warna
					from \"Surat\".tsurat_pengalaman ts
					left join hrd_khs.tpribadi tp 
					on ts.noind = tp.noind
					order by ts.kd_surat desc, no_surat desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function insertSuratPengalamanKerja($data)
	{
		$this->personalia->insert("\"Surat\".tsurat_pengalaman", $data);
	}

	public function deleteSuratPengalamanKerja($kode, $nomor)
	{
		$sql = "delete from \"Surat\".tsurat_pengalaman where trim(kd_surat)='$kode' and trim(no_surat)='$nomor' ";
		$query 	=	$this->personalia->query($sql);
	}

	public function updateSuratPengalamanKerjaBy($kode, $nomor, $pengalaman_tglCetak)
	{
		$sql = "update \"Surat\".tsurat_pengalaman set cetak='true',tgl_cetak='$pengalaman_tglCetak' where trim(kd_surat)='$kode' and trim(no_surat)='$nomor' ";
		$query 	=	$this->personalia->query($sql);
	}


	public function getSuratPengalamanKerja($kode, $nomor)
	{
		$sql = "select 
				    	ts.kd_surat,
				    	trim (no_surat) as nomor,
				    	no_surat,
				    	trim(tp.templahir) templahir,
				    	tp.tgllahir,
				    	tp.noind,
				    	tp.nama,
				    	te.seksi,
				    	te.bidang,
				    	tp.nik,
				    	tp.kec,
				    	tp.kab,
				    	tp.prop,
				    	tp.kodepos,
				    	to_char(current_date,'yyyy/mm/dd') as pengalaman_tglCetak,
				    	left(kd_surat,4) as tahun,
				    	right(kd_surat,2) as bulan,
				    	(case when extract(month from tp.tgllahir) = 1 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Januari ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 2 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Februari ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 3 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Maret ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 4 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' April ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 5 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Mei ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 6 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Juni ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 7 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Juli ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 8 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Agustus ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 9 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' September ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 10 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Oktober ',extract(year from tp.tgllahir))
							when extract(month from tp.tgllahir) = 11 then
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' November ',extract(year from tp.tgllahir))
							else
								concat(lpad(extract(day from tp.tgllahir)::text, 2, '0'),' Desember ',extract(year from tp.tgllahir))
							end) lahir,
							(case when extract(month from tp.masukkerja) = 1 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Januari ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 2 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Februari ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 3 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Maret ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 4 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' April ',extract(year from tp.masukkerja))
							when extract(month from tp.tgllahir) = 5 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Mei ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 6 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Juni ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 7 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Juli ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 8 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Agustus ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 9 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' September ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 10 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Oktober ',extract(year from tp.masukkerja))
							when extract(month from tp.masukkerja) = 11 then
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' November ',extract(year from tp.masukkerja))
							else
								concat(lpad(extract(day from tp.masukkerja)::text, 2,'0'),' Desember ',extract(year from tp.masukkerja))
							end) masuk,
				    	te.unit,
							te.dept,
							masukkerja::date,
							akhkontrak::date, 
							ts.alamat,
							desa,
							kec,
							kab,
							nik,
				    	concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
				    	ts.isi_surat,
				    	ts.tgl_kena::date,
				    	ts.tgl_masuk::date,
				      ts.kodesie,
				    	ts.tgl_cetak::date,
				    	ts.tgl_surat::date,
				    	(case when d.status=1 then concat('Sudah Diapprove Hubker') else concat('Belum Diapprove Hubker') end) as apd,
				    	ts.cetak,
				    	tp.jabatan,
				    	ts.alamat
						from \"Surat\".tsurat_pengalaman ts
							left join hrd_khs.tpribadi tp on ts.noind = tp.noind
							left join hrd_khs.tseksi te on ts.kodesie = te.kodesie
							left join \"Surat\".tpengembalian_apd d on ts.noind=d.noind
						where trim(kd_surat)='$kode' and trim(no_surat)='$nomor'
						order by ts.tgl_surat desc
						limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	public function updateSuratPengalamanKerja($data, $kode, $nomor)
	{
		$this->personalia->where('no_surat', $nomor);
		$this->personalia->where('kd_surat', $kode);
		$this->personalia->update("\"Surat\".tsurat_pengalaman", $data);
	}

	public function add_template($data)
	{
		$this->personalia->insert("\"Surat\".tisi_pengalaman", $data);
	}

	public function edit_template($key, $newvalue)
	{
		// print_r([
		// 	$key, $newvalue]);die;
		$this->personalia
			->where('kd_isi', $key)
			->set('isi_surat', $newvalue)
			->update("\"Surat\".tisi_pengalaman");
	}

	public function delete_template($key)
	{
		$this->personalia
			->where('kd_isi', $key)
			->delete("\"Surat\".tisi_pengalaman");
	}

	public function insertLogCetak($data)
	{
		$this->personalia->insert("hrd_khs.tlog", $data);
	}
}
