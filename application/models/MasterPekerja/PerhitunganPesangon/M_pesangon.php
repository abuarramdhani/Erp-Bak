<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pesangon extends CI_Model {
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}
	public function detailPekerja($noind,$cuti)
	 	{

	 		if('0'==$cuti)
	 			{
			 		$getDetailPekerja 		= "	select 		trim(pri.noind) as noind,
		            										rtrim(pri.nama) as nama,
		            										rtrim(tseksi.seksi) as seksi,
		            										rtrim(tseksi.unit) as unit,
		            										rtrim(tseksi.dept) as departemen,
		            rtrim(lokker.lokasi_kerja) as lokasi_kerja,rtrim(pri.npwp)as npwp,rtrim(pri.nik)as nik,
		            (
						case 	when 	pri.kd_pkj is not null and pri.kd_pkj <> ''
						then 	 rtrim(tpekerjaan.pekerjaan)
						else     tref.jabatan
						end
					) as pekerjaan,
					to_char(pri.diangkat,'DD/MM/YYYY') as diangkat,
					date_part('year', age(tglkeluar::date,  diangkat::date )) || ' tahun ' ||
		             date_part('month', age(tglkeluar::date,  diangkat::date )) || ' bulan ' ||
		           date_part('day', age(tglkeluar::date,  diangkat::date )) || ' hari 'as
					 masakerja,
					 date_part('year', age(tglkeluar::date,  diangkat::date ))  as
					 masakerja_tahun,
					 date_part('month', age(tglkeluar::date,  diangkat::date ))  as
					 masakerja_bulan,
					 date_part('day', age(tglkeluar::date,  diangkat::date ))  as
					 masakerja_hari,
					pri.templahir  || '  ' ||  to_char(pri.tgllahir,'DD/MM/YYYY') as tempat,
					rtrim(pri.alamat)|| ',' ||  pri.kec || ',' ||  pri.kab || ',' ||  pri.prop as alamat,
					case when extract(month from pri.tglkeluar) = 1 then
						concat(extract(day from pri.tglkeluar),' January ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 2 then
						concat(extract(day from pri.tglkeluar),' February ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 3 then
						concat(extract(day from pri.tglkeluar),' March ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 4 then
						concat(extract(day from pri.tglkeluar),' April ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 5 then
						concat(extract(day from pri.tglkeluar),' May ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 6 then
						concat(extract(day from pri.tglkeluar),' June ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 7 then
						concat(extract(day from pri.tglkeluar),' July ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 8 then
						concat(extract(day from pri.tglkeluar),' August ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 9 then
						concat(extract(day from pri.tglkeluar),' September ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 10 then
						concat(extract(day from pri.tglkeluar),' October ',extract(year from pri.tglkeluar))
					when extract(month from pri.tglkeluar) = 11 then
						concat(extract(day from pri.tglkeluar),' November ',extract(year from pri.tglkeluar))
					else
						concat(extract(day from pri.tglkeluar),' December ',extract(year from pri.tglkeluar))
					end metu,alasan.alasan_tampil as alasan,
					case when extract(month from pri.akhkontrak) = 1 then
						concat(extract(day from pri.akhkontrak),' January ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 2 then
						concat(extract(day from pri.akhkontrak),' February ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 3 then
						concat(extract(day from pri.akhkontrak),' March ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 4 then
						concat(extract(day from pri.akhkontrak),' April ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 5 then
						concat(extract(day from pri.akhkontrak),' May ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 6 then
						concat(extract(day from pri.akhkontrak),' June ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 7 then
						concat(extract(day from pri.akhkontrak),' July ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 8 then
						concat(extract(day from pri.akhkontrak),' August ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 9 then
						concat(extract(day from pri.akhkontrak),' September ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 10 then
						concat(extract(day from pri.akhkontrak),' October ',extract(year from pri.akhkontrak))
					when extract(month from pri.akhkontrak) = 11 then
						concat(extract(day from pri.akhkontrak),' November ',extract(year from pri.akhkontrak))
					else
						concat(extract(day from pri.akhkontrak),' December ',extract(year from pri.akhkontrak))
					end akhir,
					pesangon.pasal_pengali_pesangon as pasal,
					pesangon.uang_pesangon as pesangon,
					pesangon.upmk as up,
					coalesce(tpson.jml_cuti,0) as cuti,
					pesangon.uang_ganti_rugi as rugi,
					concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
					concat(pesangon.upmk,' X GP') as upmk,
					concat (pesangon.uang_ganti_rugi,'% UANG PESANGON + UANG PMK') as gantirugi,
					concat(coalesce(tpson.jml_cuti,0),' hari ')as sisacuti,
					concat(coalesce(tpson.jml_cuti,0),' GP/30 ')as sisacutihari
									from 		hrd_khs.tpribadi as pri
									join 	hrd_khs.tseksi as tseksi on tseksi.kodesie=pri.kodesie
									left join hrd_khs.trefjabatan tref on tref.noind = pri.noind
									left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr
									left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
									left join hrd_khs.t_pesangon as tpson on tpson.noinduk = pri.noind
									left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
									join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr
									and date_part('year', age(tglkeluar::date,  diangkat::date ))>= pesangon.batas_tahun_kerja_awal
									and date_part('year', age(tglkeluar::date,  diangkat::date ))< pesangon.batas_tahun_kerja_akhir
									join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
									where 		pri.noind='$noind' and cuti.periode=extract(year from current_date)::varchar";
					}
					else
					{

					$getDetailPekerja 		= "	select 		trim(pri.noind) as noind,
		            										rtrim(pri.nama) as nama,
		            										rtrim(tseksi.seksi) as seksi,
		            										rtrim(tseksi.unit) as unit,
		            										rtrim(tseksi.dept) as departemen,
		            rtrim(lokker.lokasi_kerja) as lokasi_kerja,rtrim(pri.npwp)as npwp,rtrim(pri.nik)as nik,
		            (
						case 	when 	pri.kd_pkj is not null and pri.kd_pkj <> ''
						then 	 rtrim(tpekerjaan.pekerjaan)
						else     tref.jabatan
						end
					) as pekerjaan,
					to_char(pri.diangkat,'DD/MM/YYYY') as diangkat,
					date_part('year', age(tglkeluar::date,  diangkat::date )) || ' tahun ' ||
		             date_part('month', age(tglkeluar::date,  diangkat::date )) || ' bulan ' ||
		           date_part('day', age(tglkeluar::date,  diangkat::date )) || ' hari 'as
					 masakerja,
					 date_part('year', age(tglkeluar::date,  diangkat::date ))  as
					 masakerja_tahun,
					 date_part('month', age(tglkeluar::date,  diangkat::date ))  as
					 masakerja_bulan,
					 date_part('day', age(tglkeluar::date,  diangkat::date ))  as
					 masakerja_hari,
					pri.templahir  || '  ' ||  to_char(pri.tgllahir,'DD/MM/YYYY') as tempat,
					rtrim(pri.alamat)|| ',' ||  pri.kec || ',' ||  pri.kab || ',' ||  pri.prop as alamat,
					case when extract(month from pri.tglkeluar) = 1 then
						concat(extract(day from pri.tglkeluar),' January ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 2 then
						concat(extract(day from pri.tglkeluar),' February ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 3 then
						concat(extract(day from pri.tglkeluar),' March ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 4 then
						concat(extract(day from pri.tglkeluar),' April ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 5 then
						concat(extract(day from pri.tglkeluar),' May ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 6 then
						concat(extract(day from pri.tglkeluar),' June ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 7 then
						concat(extract(day from pri.tglkeluar),' July ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 8 then
						concat(extract(day from pri.tglkeluar),' August ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 9 then
						concat(extract(day from pri.tglkeluar),' September ',extract(year from pri.tglkeluar))
					 when extract(month from pri.tglkeluar) = 10 then
						concat(extract(day from pri.tglkeluar),' October ',extract(year from pri.tglkeluar))
					when extract(month from pri.tglkeluar) = 11 then
						concat(extract(day from pri.tglkeluar),' November ',extract(year from pri.tglkeluar))
					else
						concat(extract(day from pri.tglkeluar),' December ',extract(year from pri.tglkeluar))
					end metu,alasan.alasan_tampil as alasan,
					case when extract(month from pri.akhkontrak) = 1 then
						concat(extract(day from pri.akhkontrak),' January ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 2 then
						concat(extract(day from pri.akhkontrak),' February ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 3 then
						concat(extract(day from pri.akhkontrak),' March ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 4 then
						concat(extract(day from pri.akhkontrak),' April ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 5 then
						concat(extract(day from pri.akhkontrak),' May ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 6 then
						concat(extract(day from pri.akhkontrak),' June ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 7 then
						concat(extract(day from pri.akhkontrak),' July ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 8 then
						concat(extract(day from pri.akhkontrak),' August ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 9 then
						concat(extract(day from pri.akhkontrak),' September ',extract(year from pri.akhkontrak))
					 when extract(month from pri.akhkontrak) = 10 then
						concat(extract(day from pri.akhkontrak),' October ',extract(year from pri.akhkontrak))
					when extract(month from pri.akhkontrak) = 11 then
						concat(extract(day from pri.akhkontrak),' November ',extract(year from pri.akhkontrak))
					else
						concat(extract(day from pri.akhkontrak),' December ',extract(year from pri.akhkontrak))
					end akhir,
					pesangon.pasal_pengali_pesangon as pasal,
					pesangon.uang_pesangon as pesangon,
					pesangon.upmk as up,
 					coalesce(cuti.sisa_cuti,0) as cuti,
					pesangon.uang_ganti_rugi as rugi,
					concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
					concat(pesangon.upmk,' X GP') as upmk,
					concat (pesangon.uang_ganti_rugi,'% UANG PESANGON + UANG PMK') as gantirugi,
		 			concat(coalesce(cuti.sisa_cuti,0),' hari ')as sisacuti,
		 			concat(coalesce(cuti.sisa_cuti,0),' GP/30 ')as sisacutihari
									from 		hrd_khs.tpribadi as pri
									join 	hrd_khs.tseksi as tseksi on tseksi.kodesie=pri.kodesie
									left join hrd_khs.trefjabatan tref on tref.noind = pri.noind
									left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr
									left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
									left join hrd_khs.t_pesangon as tpson on tpson.noinduk = pri.noind
									left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
									join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr
									and date_part('year', age(tglkeluar::date,  diangkat::date ))>= pesangon.batas_tahun_kerja_awal
									and date_part('year', age(tglkeluar::date,  diangkat::date ))< pesangon.batas_tahun_kerja_akhir
									join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
									where 		pri.noind='$noind' and cuti.periode=extract(year from current_date)::varchar";
					}

			$query 	=	$this->personalia->query($getDetailPekerja);
			return $query->result_array();
			//return $getDetailPekerja;

	 	}

		public function getPekerjaPHK($id)
	 	{
	 		$sql	= "	SELECT ts.*, tp.*, cast(tp.tglkeluar as date) tanggal_keluar, ti.seksi, ti.unit, ti.dept from hrd_khs.t_pesangon ts
								INNER JOIN hrd_khs.tpribadi tp on tp.noind = ts.noinduk
								INNER JOIN hrd_khs.tseksi ti on ti.kodesie = tp.kodesie
								where id_pesangon = '$id'";
			return $this->personalia->query($sql)->result_array();
	 	}

		public function getTertandaKasbon()
	  {
	    $sql = "SELECT noind, trim(nama) as nama FROM hrd_khs.tpribadi WHERE keluar = '0' ORDER BY noind";
	    return $this->personalia->query($sql)->result_array();
	  }

		public function getdataNama($noind)
		{
			$sql = "SELECT tp.noind, trim(tp.nama) as nama, tr.jabatan FROM hrd_khs.tpribadi tp
			 		LEFT JOIN hrd_khs.trefjabatan tr ON tr.kodesie = tp.kodesie AND tr.noind = tp.noind AND tr.kd_jabatan = tp.kd_jabatan
					WHERE tp.noind = '$noind' ORDER BY tp.noind";
			return $this->personalia->query($sql)->result_array();
		}

		public function UpdateDate($id, $tgl)
		{
			$sql = "UPDATE hrd_khs.t_pesangon SET tgl_cetak_prev = '$tgl' WHERE id_pesangon = '$id'";
			return $this->personalia->query($sql);
		}

		public function getAlasanKeluar($noind)
		{
			$sql = "SELECT trim(a.alasan_tampil) as alasan_tampil from hrd_khs.t_alasan_pesangon a
							LEFT JOIN hrd_khs.tpribadi b ON a.alasan_master_pekerja = b.sebabklr
							where b.noind = '$noind'";
			return $this->personalia->query($sql)->row()->alasan_tampil;
		}

	 public function getPekerjaAktif($noind)
	 	{
	 		$getPekerjaAktif="select trim(noind) as noind, concat_ws(' - ', noind, nama) as pekerja from hrd_khs.tpribadi where   noind like '%$noind%' or nama like '%$noind%' and keluar = '0'
			order by noind ";
	 		$query 	=	$this->personalia->query($getPekerjaAktif);
			return $query->result_array();
	 	}

	 public function inputHitungPesangon($inputHitungPesangon)
	 	{
	 		$this->personalia->insert('hrd_khs.t_pesangon',$inputHitungPesangon);
	 	}

	  public function lihat()
		{
		 	$lihat = "select * from hrd_khs.t_pesangon as hit
		 			join 		hrd_khs.tpribadi as pri on hit.noinduk=pri.noind
					ORDER BY id_pesangon desc";
		 	$query = $this->personalia->query($lihat);
		 	return $query->result_array();
		 }

	public function penerima($id)
		{
		 	$lihat = "select pri.nama as penerima from hrd_khs.t_pesangon as hit
		 			join 		hrd_khs.tpribadi as pri on hit.penerima=pri.noind where hit.id_pesangon='$id'";
		 	$query = $this->personalia->query($lihat);
		 	return $query->result_array();
		 }

	public function pengirim($id)
		{
		 	$lihat = "select pri.nama as pengirim, tref.jabatan as jabatan from hrd_khs.t_pesangon as hit
		 			join 		hrd_khs.tpribadi as pri on hit.pengirim=pri.noind left join hrd_khs.trefjabatan tref on pri.noind = tref.noind where hit.id_pesangon='$id'";
		 	$query = $this->personalia->query($lihat);
		 	return $query->result_array();
		 }

	    public function delete($id)
	    {
	    	$this->personalia->where('id_pesangon', $id);
	    	$this->personalia->delete('hrd_khs.t_pesangon');
	    }


     public function editHitungPesangon($id)
	    {
	    	$editHitungPesangon="select 		trim(pri.noind) as noind,
            										rtrim(pri.nama) as nama,
            										rtrim(tseksi.seksi) as seksi,
            										rtrim(tseksi.unit) as unit,
            										rtrim(tseksi.dept) as departemen,
													pri.tglkeluar,
            rtrim(lokker.lokasi_kerja) as lokasi_kerja,rtrim(pri.npwp)as npwp,rtrim(pri.nik)as nik,
            (
				case 	when 	pri.kd_pkj is not null and pri.kd_pkj <> ''
				then 	 rtrim(tpekerjaan.pekerjaan)
				else     tref.jabatan
				end
			) as pekerjaan,
			tpes.id_pesangon as id,
			tpes.no_rekening as no_rek,
			tpes.nama_rekening as nama_rek,
			tpes.bank as bank,
			tpes.potongan as potongan,
			tpes.hutang_koperasi as hutang_koperasi,
			tpes.hutang_perusahaan as hutang_perusahaan,
			tpes.lain_lain as lain_lain,
			to_char(pri.diangkat,'DD/MM/YYYY') as diangkat,
			date_part('year', age(tglkeluar::date,  diangkat::date )) || ' tahun ' ||
             date_part('month', age(tglkeluar::date,  diangkat::date )) || ' bulan ' ||
           date_part('day', age(tglkeluar::date,  diangkat::date )) || ' hari 'as
			 masakerja,
			 date_part('year', age(tglkeluar::date,  diangkat::date ))  as
			 masakerja_tahun,
			 date_part('month', age(tglkeluar::date,  diangkat::date ))  as
			 masakerja_bulan,
			 date_part('day', age(tglkeluar::date,  diangkat::date ))  as
			 masakerja_hari,
			pri.templahir  || '  ' ||  to_char(pri.tgllahir,'DD/MM/YYYY') as tempat,
			rtrim(pri.alamat)|| ',' ||  pri.kec || ',' ||  pri.kab || ',' ||  pri.prop as alamat,
			case when extract(month from pri.tglkeluar) = 1 then
				concat(extract(day from pri.tglkeluar),' January ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 2 then
				concat(extract(day from pri.tglkeluar),' February ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 3 then
				concat(extract(day from pri.tglkeluar),' March ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 4 then
				concat(extract(day from pri.tglkeluar),' April ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 5 then
				concat(extract(day from pri.tglkeluar),' May ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 6 then
				concat(extract(day from pri.tglkeluar),' Juny ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 7 then
				concat(extract(day from pri.tglkeluar),' July ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 8 then
				concat(extract(day from pri.tglkeluar),' August ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 9 then
				concat(extract(day from pri.tglkeluar),' September ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 10 then
				concat(extract(day from pri.tglkeluar),' October ',extract(year from pri.tglkeluar))
			when extract(month from pri.tglkeluar) = 11 then
				concat(extract(day from pri.tglkeluar),' November ',extract(year from pri.tglkeluar))
			else
				concat(extract(day from pri.tglkeluar),' December ',extract(year from pri.tglkeluar))
			end metu,alasan.alasan_tampil as alasan,
			case when extract(month from tpes.tgl_proses_phk) = 1 then
				concat(extract(day from tpes.tgl_proses_phk),' January ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 2 then
				concat(extract(day from tpes.tgl_proses_phk),' February ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 3 then
				concat(extract(day from tpes.tgl_proses_phk),' March ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 4 then
				concat(extract(day from tpes.tgl_proses_phk),' April ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 5 then
				concat(extract(day from tpes.tgl_proses_phk),' May ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 6 then
				concat(extract(day from tpes.tgl_proses_phk),' June ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 7 then
				concat(extract(day from tpes.tgl_proses_phk),' July ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 8 then
				concat(extract(day from tpes.tgl_proses_phk),' August ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 9 then
				concat(extract(day from tpes.tgl_proses_phk),' September ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 10 then
				concat(extract(day from tpes.tgl_proses_phk),' October ',extract(year from tpes.tgl_proses_phk))
			when extract(month from tpes.tgl_proses_phk) = 11 then
				concat(extract(day from tpes.tgl_proses_phk),' November ',extract(year from tpes.tgl_proses_phk))
			when extract(month from tpes.tgl_proses_phk) = 12 then
				concat(extract(day from tpes.tgl_proses_phk),' December ',extract(year from tpes.tgl_proses_phk))
			else
			null
			end tgl_phk,
			tpes.tgl_proses_phk as proses_phk,
			pesangon.pasal_pengali_pesangon as pasal,
			pesangon.uang_pesangon as pesangon,
			pesangon.upmk as up,
			tpson.jml_cuti as cuti,
			pesangon.uang_ganti_rugi as rugi,
			concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
			concat(pesangon.upmk,' X GP') as upmk,
			concat (pesangon.uang_ganti_rugi,'% (UANG PESANGON + UANG PMK)') as gantirugi,
			concat(tpson.jml_cuti,' hari ')as sisacuti,
			concat(tpson.jml_cuti,' GP/30 ')as sisacutihari
							from 		hrd_khs.tpribadi as pri
							join    hrd_khs.t_pesangon as tpes on pri.noind=tpes.noinduk
							join 	hrd_khs.tseksi as tseksi on tseksi.kodesie=pri.kodesie
							left join hrd_khs.trefjabatan tref on tref.noind = pri.noind
							left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr
							left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
							left join hrd_khs.t_pesangon as tpson on tpson.noinduk = pri.noind
							left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
							join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr
							and date_part('year', age(tglkeluar::date,  diangkat::date )) >= pesangon.batas_tahun_kerja_awal
							and date_part('year', age(tglkeluar::date,  diangkat::date )) < pesangon.batas_tahun_kerja_akhir
							join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
							where 		tpes.id_pesangon='$id' and cuti.periode=extract(year from pri.tglkeluar)::varchar";
	 		$query 	=	$this->personalia->query($editHitungPesangon);
			return $query->result_array();
        }

	    public function update($id,$data)
	    {
			$this->personalia->where('id_pesangon', $id);
	    	$this->personalia->update('hrd_khs.t_pesangon',$data);

	    }

	     public function cetak($id)
	    {
	    	$cetak="select 		
	    	trim(pri.noind) as noind,
			rtrim(pri.nama) as nama,
			(select string_agg(distinct rtrim(tseksi.seksi),'<br>') from hrd_khs.tseksi tseksi where tseksi.kodesie in (select kodesie from hrd_khs.trefjabatan tref where tref.noind=pri.noind)) as seksi,
			(select string_agg(distinct rtrim(tseksi.unit),'<br>') from hrd_khs.tseksi tseksi where tseksi.kodesie in (select kodesie from hrd_khs.trefjabatan tref where tref.noind=pri.noind)) as unit,
			(select string_agg(distinct rtrim(tseksi.dept),'<br>') from hrd_khs.tseksi tseksi where tseksi.kodesie in (select kodesie from hrd_khs.trefjabatan tref where tref.noind=pri.noind)) as dept,
            rtrim(lokker.lokasi_kerja) as lokasi_kerja,rtrim(pri.npwp)as npwp,rtrim(pri.nik)as nik,
            (	case
					when pri.kd_pkj is not null
					and pri.kd_pkj <> '' then rtrim( tpekerjaan.pekerjaan )
					else 
						(
						(
						select string_agg(distinct upper(jabatan),'<br>') from hrd_khs.torganisasi tto where tto.kd_jabatan in 
						(select tref.kd_jabatan from hrd_khs.trefjabatan tref where tref.noind=pri.noind))
						)
				end
			) as pekerjaan,
			tpes.id_pesangon as id,
			tpes.pengirim as pengirim,
			tpes.tgl_cetak_prev as tgl_cetak_prev,
			tpes.no_rekening as no_rek,
			tpes.nama_rekening as nama_rek,
			tpes.bank as bank,
			tpes.potongan as potongan,
			tpes.hutang_koperasi as hutang_koperasi,
			tpes.hutang_perusahaan as hutang_perusahaan,
			tpes.lain_lain as lain_lain,
			to_char(pri.diangkat,'DD/MM/YYYY') as diangkat,
			date_part('year', age(tglkeluar::date,  diangkat::date )) || ' tahun ' ||
             date_part('month', age(tglkeluar::date,  diangkat::date )) || ' bulan ' ||
           date_part('day', age(tglkeluar::date,  diangkat::date )) || ' hari 'as
			 masakerja,
			 date_part('year', age(tglkeluar::date,  diangkat::date ))  as
			 masakerja_tahun,
			 date_part('month', age(tglkeluar::date,  diangkat::date ))  as
			 masakerja_bulan,
			 date_part('day', age(tglkeluar::date,  diangkat::date ))  as
			 masakerja_hari,
			pri.templahir  || '  ' ||  to_char(pri.tgllahir,'DD/MM/YYYY') as tempat,
			rtrim(pri.alamat)|| ',' ||  pri.kec || ',' ||  pri.kab || ',' ||  pri.prop as alamat,
			case when extract(month from pri.tglkeluar) = 1 then
				concat(extract(day from pri.tglkeluar),' Januari ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 2 then
				concat(extract(day from pri.tglkeluar),' Februari ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 3 then
				concat(extract(day from pri.tglkeluar),' Maret ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 4 then
				concat(extract(day from pri.tglkeluar),' April ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 5 then
				concat(extract(day from pri.tglkeluar),' Mei ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 6 then
				concat(extract(day from pri.tglkeluar),' Juni ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 7 then
				concat(extract(day from pri.tglkeluar),' Juli ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 8 then
				concat(extract(day from pri.tglkeluar),' Agustus ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 9 then
				concat(extract(day from pri.tglkeluar),' September ',extract(year from pri.tglkeluar))
			 when extract(month from pri.tglkeluar) = 10 then
				concat(extract(day from pri.tglkeluar),' Oktober ',extract(year from pri.tglkeluar))
			when extract(month from pri.tglkeluar) = 11 then
				concat(extract(day from pri.tglkeluar),' November ',extract(year from pri.tglkeluar))
			else
				concat(extract(day from pri.tglkeluar),' Desember ',extract(year from pri.tglkeluar))
			end metu,alasan.alasan_tampil as alasan,
			case when extract(month from tpes.tgl_proses_phk) = 1 then
				concat(extract(day from tpes.tgl_proses_phk),' Januari ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 2 then
				concat(extract(day from tpes.tgl_proses_phk),' Februari ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 3 then
				concat(extract(day from tpes.tgl_proses_phk),' Maret ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 4 then
				concat(extract(day from tpes.tgl_proses_phk),' April ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 5 then
				concat(extract(day from tpes.tgl_proses_phk),' Mei ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 6 then
				concat(extract(day from tpes.tgl_proses_phk),' Juni ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 7 then
				concat(extract(day from tpes.tgl_proses_phk),' Juli ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 8 then
				concat(extract(day from tpes.tgl_proses_phk),' Agustus ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 9 then
				concat(extract(day from tpes.tgl_proses_phk),' September ',extract(year from tpes.tgl_proses_phk))
			 when extract(month from tpes.tgl_proses_phk) = 10 then
				concat(extract(day from tpes.tgl_proses_phk),' Oktober ',extract(year from tpes.tgl_proses_phk))
			when extract(month from tpes.tgl_proses_phk) = 11 then
				concat(extract(day from tpes.tgl_proses_phk),' November ',extract(year from tpes.tgl_proses_phk))
			when extract(month from tpes.tgl_proses_phk) = 12 then
				concat(extract(day from tpes.tgl_proses_phk),' Desember ',extract(year from tpes.tgl_proses_phk))
			else
			null
			end tgl_phk,
			tpes.tgl_proses_phk as proses_phk,
			pesangon.pasal_pengali_pesangon as pasal,
			pesangon.uang_pesangon as pesangon,
			pesangon.upmk as up,
			tpson.jml_cuti as cuti,
			pesangon.uang_ganti_rugi as rugi,
			concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
			concat(pesangon.upmk,' X GP') as upmk,
			concat (pesangon.uang_ganti_rugi,'% (UANG PESANGON + UANG PMK)') as gantirugi,
			concat(tpson.jml_cuti,' hari ')as sisacuti,
			concat(tpson.jml_cuti,' GP/30 ')as sisacutihari
			from 		hrd_khs.tpribadi as pri
			join    hrd_khs.t_pesangon as tpes on pri.noind=tpes.noinduk
			left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr
			left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
			left join hrd_khs.t_pesangon as tpson on tpson.noinduk = pri.noind
			left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
			join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr
			and date_part('year', age(tglkeluar::date,  diangkat::date )) >= pesangon.batas_tahun_kerja_awal
			and date_part('year', age(tglkeluar::date,  diangkat::date )) < pesangon.batas_tahun_kerja_akhir
			join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
			where 		tpes.id_pesangon='$id' and cuti.periode=extract(year from pri.tglkeluar)::varchar";
	 		
	 		$query 	=	$this->personalia->query($cetak);
			return $query->result_array();
        }
};
