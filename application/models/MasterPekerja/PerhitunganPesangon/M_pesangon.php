<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pesangon extends CI_Model {

	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
	}

	function getDetailPekerja($noind)
	{
		$sql = "select a.noind,a.nama,a.nik,a.npwp,
				a.diangkat::date,a.tglkeluar::date,
				trim(a.alamat) as alamat,trim(a.kec) as kec,trim(a.kab) as kab,trim(a.prop) as prop,
				trim(a.templahir) as tempat_lahir,a.tgllahir::date as tanggal_lahir,
				b.dept,b.unit,b.seksi,d.lokasi_kerja,e.pekerjaan,
				(
					select string_agg(c.jabatan,'; ')
					from hrd_khs.trefjabatan c 
					where c.noind = a.noind
				) as jabatan,
				f.dasar_hukum,f.sebab_keluar,f.pengali_u_pesangon,f.pengali_u_pmk,
				case extract(isodow from tglkeluar)
				when 1 then 'Senin' 
				when 2 then 'Selasa' 
				when 3 then 'Rabu' 
				when 4 then 'Kamis' 
				when 5 then 'Jumat' 
				when 6 then 'Sabtu' 
				when 7 then 'Minggu'
				else 'undefined' 
				end as hari
			from hrd_khs.tpribadi a 
			inner join hrd_khs.tseksi b 
			on a.kodesie = b.kodesie
			inner join hrd_khs.tlokasi_kerja d 
			on a.lokasi_kerja = d.id_
			inner join hrd_khs.t_sebab_keluar f 
			on trim(a.sebabklr) = f.kode
			left join hrd_khs.tpekerjaan e 
			on a.kd_pkj = e.kdpekerjaan
			where a.noind = ?
			and a.keluar = '0'";
		return $this->personalia->query($sql,array($noind))->row();
	}

	function getPesangonById($id){
		$sql = "select a.noind,a.nama,a.nik,a.npwp,
				a.diangkat::date,a.tglkeluar::date,
				trim(a.alamat) as alamat,trim(a.desa) as kel, trim(a.kec) as kec,trim(a.kab) as kab,trim(a.prop) as prop,
				trim(a.templahir) as tempat_lahir,a.tgllahir::date as tanggal_lahir,
				b.dept,b.unit,b.seksi,d.lokasi_kerja,
				g.dasar_hukum,g.sebab_keluar,
				case extract(isodow from tglkeluar)
				when 1 then 'Senin' 
				when 2 then 'Selasa' 
				when 3 then 'Rabu' 
				when 4 then 'Kamis' 
				when 5 then 'Jumat' 
				when 6 then 'Sabtu' 
				when 7 then 'Minggu'
				else 'undefined' 
				end as hari_keluar,
				g.*,
				case extract(isodow from g.tgl_proses_phk)
				when 1 then 'Senin' 
				when 2 then 'Selasa' 
				when 3 then 'Rabu' 
				when 4 then 'Kamis' 
				when 5 then 'Jumat' 
				when 6 then 'Sabtu' 
				when 7 then 'Minggu'
				else 'undefined' 
				end as hari_phk,
				a.jenkel
			from hrd_khs.tpribadi a 
			inner join hrd_khs.tseksi b 
			on a.kodesie = b.kodesie
			inner join hrd_khs.tlokasi_kerja d 
			on a.lokasi_kerja = d.id_
			inner join hrd_khs.t_sebab_keluar f 
			on trim(a.sebabklr) = f.kode
			inner join hrd_khs.t_pesangon g 
			on a.noind = g.noinduk
			where g.id_pesangon = ?";
		return $this->personalia->query($sql,array($id))->row();
	}

	function getSisaCuti($noind)
	{
		$sql = "select coalesce(
					b.sisa_cuti-
					(
						select count(*) 
						from \"Presensi\".tdatapresensi c
						where c.tanggal>=a.tglkeluar::date 
						and c.noind=a.noind
						and (
							trim(c.kd_ket) like 'C%'
							or trim(c.kd_ket) = 'PCZ'
						)
					),
					0
				) as sisa_cuti
			from hrd_khs.tpribadi a
			left join \"Presensi\".tdatacuti b 
			on a.noind = b.noind
			and b.periode =extract(year from current_date)::varchar
			where a.noind = ?";
		return $this->personalia->query($sql,array($noind))->row()->sisa_cuti;
	}

	function getSetupPesangon($tahun)
	{
		$sql = "select u_pesangon, u_pmk
			from hrd_khs.t_setup_pesangon
			where batas_tahun_kerja_awal <= ?
			and batas_tahun_kerja_akhir > ?";
		return $this->personalia->query($sql,array($tahun,$tahun))->row();
	}

	public function detailPekerja($noind,$cuti)
 	{

 		if('0'==$cuti){
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
		
		}else{

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
				coalesce(cuti.sisa_cuti,0)+(select count(*) from \"Presensi\".tdatapresensi where tanggal>=pri.tglkeluar::date and noind=pri.noind) as cuti,
			pesangon.uang_ganti_rugi as rugi,
			concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
			concat(pesangon.upmk,' X GP') as upmk,
			concat (pesangon.uang_ganti_rugi,'% UANG PESANGON + UANG PMK') as gantirugi,
 			concat((coalesce(cuti.sisa_cuti,0)+(select count(*) from \"Presensi\".tdatapresensi where tanggal>=pri.tglkeluar::date and noind=pri.noind)),' hari ')as sisacuti,
 			concat((coalesce(cuti.sisa_cuti,0)+(select count(*) from \"Presensi\".tdatapresensi where tanggal>=pri.tglkeluar::date and noind=pri.noind)),' GP/30 ')as sisacutihari
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
						LEFT JOIN hrd_khs.tpribadi b ON trim(a.alasan_master_pekerja) = trim(b.sebabklr)
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

    public function update($id,$data)
    {
		$this->personalia->where('id_pesangon', $id);
    	$this->personalia->update('hrd_khs.t_pesangon',$data);

    }

    function getTemplateSurat($jenis){
    	$sql = "select *
    		from \"Surat\".tisi_surat
    		where jenis_surat = ?";
    	return $this->personalia->query($sql,array($jenis))->row()->isi_surat;
    }
};
