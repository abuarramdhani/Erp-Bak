<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pesangon extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}
	public function detailPekerja($noind)
	 	{
	 		$getDetailPekerja 		= "	select 		trim(pri.noind) as noind,
            										rtrim(pri.nama) as nama,
            										rtrim(tseksi.seksi) as seksi,
            										rtrim(tseksi.unit) as unit,
            										rtrim(tseksi.dept) as departemen,
            rtrim(lokker.lokasi_kerja) as lokasi_kerja,
            (
				case 	when 	pri.kd_pkj is not null
				then 	 rtrim(tpekerjaan.pekerjaan)
				else     pri.jabatan
				end
			) as pekerjaan,
			to_char(pri.diangkat,'DD/MM/YYYY') as diangkat,
			date_part('year', age(akhkontrak::date,  diangkat::date )) || ' tahun ' ||
             date_part('month', age(akhkontrak::date,  diangkat::date )) || ' bulan ' ||
           date_part('day', age(akhkontrak::date,  diangkat::date )) || ' hari 'as 
			 masakerja,
			 date_part('year', age(akhkontrak::date,  diangkat::date ))  as
			 masakerja_tahun,
			 date_part('month', age(akhkontrak::date,  diangkat::date ))  as
			 masakerja_bulan,
			 date_part('day', age(akhkontrak::date,  diangkat::date ))  as
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
			pesangon.pasal_pengali_pesangon as pasal,
			pesangon.uang_pesangon as pesangon,
			pesangon.upmk as up,
			cuti.sisa_cuti as cuti,
			pesangon.uang_ganti_rugi as rugi,
			concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
			concat(pesangon.upmk,' X GP') as upmk,
			concat (pesangon.uang_ganti_rugi,'% UANG PESANGON + UANG PMK') as gantirugi,
			concat(cuti.sisa_cuti,' hari ')as sisacuti,
			concat(cuti.sisa_cuti,' GP/30 ')as sisacutihari
							from 		hrd_khs.tpribadi as pri
							join 	hrd_khs.tseksi as tseksi on tseksi.kodesie=pri.kodesie
							left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr 
							left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
							left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
							join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr 
							and (extract(year from pri.tglkeluar) - extract(year from pri.diangkat)) >= pesangon.batas_tahun_kerja_awal 
							and (extract(year from pri.tglkeluar) - extract(year from pri.diangkat)) < pesangon.batas_tahun_kerja_akhir
							join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
							where 		pri.noind='$noind' and cuti.periode=extract(year from current_date)::varchar";
										
			$query 	=	$this->personalia->query($getDetailPekerja);
			return $query->result_array();
			//return $getDetailPekerja;

	 	}

	 	

	 public function getPekerjaAktif($noind)
	 	{
	 		$getPekerjaAktif="select trim(noind) as noind, concat_ws(' - ', noind, nama) as pekerja from hrd_khs.tpribadi where   noind like '$noind%' or nama like'$noind%'
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
		 			join 		hrd_khs.tpribadi as pri on hit.noinduk=pri.noind";
		 	$query = $this->personalia->query($lihat);
		 	return $query->result_array();
		 }

	public function penerima()
		{
		 	$lihat = "select pri.nama as penerima from hrd_khs.t_pesangon as hit
		 			join 		hrd_khs.tpribadi as pri on hit.penerima=pri.noind";
		 	$query = $this->personalia->query($lihat);
		 	return $query->result_array();
		 }

	public function pengirim()
		{
		 	$lihat = "select pri.nama as pengirim from hrd_khs.t_pesangon as hit
		 			join 		hrd_khs.tpribadi as pri on hit.pengirim=pri.noind";
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
            rtrim(lokker.lokasi_kerja) as lokasi_kerja,
            (
				case 	when 	pri.kd_pkj is not null
				then 	 rtrim(tpekerjaan.pekerjaan)
				else     pri.jabatan
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
			date_part('year', age(akhkontrak::date,  diangkat::date )) || ' tahun ' ||
             date_part('month', age(akhkontrak::date,  diangkat::date )) || ' bulan ' ||
           date_part('day', age(akhkontrak::date,  diangkat::date )) || ' hari 'as 
			 masakerja,
			 date_part('year', age(akhkontrak::date,  diangkat::date ))  as
			 masakerja_tahun,
			 date_part('month', age(akhkontrak::date,  diangkat::date ))  as
			 masakerja_bulan,
			 date_part('day', age(akhkontrak::date,  diangkat::date ))  as
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
			pesangon.pasal_pengali_pesangon as pasal,
			pesangon.uang_pesangon as pesangon,
			pesangon.upmk as up,
			cuti.sisa_cuti as cuti,
			pesangon.uang_ganti_rugi as rugi,
			concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
			concat(pesangon.upmk,' X GP') as upmk,
			concat (pesangon.uang_ganti_rugi,'% (UANG PESANGON + UANG PMK)') as gantirugi,
			concat(cuti.sisa_cuti,' hari ')as sisacuti,
			concat(cuti.sisa_cuti,' GP/30 ')as sisacutihari
							from 		hrd_khs.tpribadi as pri
							join    hrd_khs.t_pesangon as tpes on pri.noind=tpes.noinduk
							join 	hrd_khs.tseksi as tseksi on tseksi.kodesie=pri.kodesie
							left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr 
							left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
							left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
							join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr 
							and (extract(year from pri.tglkeluar) - extract(year from pri.diangkat)) >= pesangon.batas_tahun_kerja_awal 
							and (extract(year from pri.tglkeluar) - extract(year from pri.diangkat)) < pesangon.batas_tahun_kerja_akhir
							join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
							where 		tpes.id_pesangon='$id' and cuti.periode=extract(year from current_date)::varchar";
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
	    	$cetak="select 		trim(pri.noind) as noind,
            										rtrim(pri.nama) as nama,
            										rtrim(tseksi.seksi) as seksi,
            										rtrim(tseksi.unit) as unit,
            										rtrim(tseksi.dept) as departemen,
            rtrim(lokker.lokasi_kerja) as lokasi_kerja,
            (
				case 	when 	pri.kd_pkj is not null
				then 	 rtrim(tpekerjaan.pekerjaan)
				else     pri.jabatan
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
			date_part('year', age(akhkontrak::date,  diangkat::date )) || ' tahun ' ||
             date_part('month', age(akhkontrak::date,  diangkat::date )) || ' bulan ' ||
           date_part('day', age(akhkontrak::date,  diangkat::date )) || ' hari 'as 
			 masakerja,
			 date_part('year', age(akhkontrak::date,  diangkat::date ))  as
			 masakerja_tahun,
			 date_part('month', age(akhkontrak::date,  diangkat::date ))  as
			 masakerja_bulan,
			 date_part('day', age(akhkontrak::date,  diangkat::date ))  as
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
			pesangon.pasal_pengali_pesangon as pasal,
			pesangon.uang_pesangon as pesangon,
			pesangon.upmk as up,
			cuti.sisa_cuti as cuti,
			pesangon.uang_ganti_rugi as rugi,
			concat (pesangon.pasal_pengali_pesangon,' X ',pesangon.uang_pesangon, ' GP ') as pengali ,
			concat(pesangon.upmk,' X GP') as upmk,
			concat (pesangon.uang_ganti_rugi,'% (UANG PESANGON + UANG PMK)') as gantirugi,
			concat(cuti.sisa_cuti,' hari ')as sisacuti,
			concat(cuti.sisa_cuti,' GP/30 ')as sisacutihari
							from 		hrd_khs.tpribadi as pri
							join    hrd_khs.t_pesangon as tpes on pri.noind=tpes.noinduk
							join 	hrd_khs.tseksi as tseksi on tseksi.kodesie=pri.kodesie
							left join    hrd_khs.t_alasan_pesangon alasan on alasan.alasan_master_pekerja=pri.sebabklr 
							left join    \"Presensi\".tdatacuti as cuti on pri.noind=cuti.noind
							left join 	hrd_khs.tpekerjaan as tpekerjaan on tpekerjaan.kdpekerjaan=pri.kd_pkj
							join hrd_khs.t_master_pesangon as pesangon on pesangon.alasan_keluar=pri.sebabklr 
							and (extract(year from pri.tglkeluar) - extract(year from pri.diangkat)) >= pesangon.batas_tahun_kerja_awal 
							and (extract(year from pri.tglkeluar) - extract(year from pri.diangkat)) < pesangon.batas_tahun_kerja_akhir
							join 	hrd_khs.tlokasi_kerja as lokker on 	lokker.id_=pri.lokasi_kerja
							where 		tpes.id_pesangon='$id' and cuti.periode=extract(year from current_date)::varchar";
	 		$query 	=	$this->personalia->query($cetak);
			return $query->result_array();
        }
};
