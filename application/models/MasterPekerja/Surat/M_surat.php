<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
// ini_set('memory_limit', '256M');
class M_surat extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->quick 	=	$this->load->database('quick', TRUE);

	}

	public function kode_surat( $jenis_surat = FALSE, $status_staf = FALSE )
	{
		$this->personalia->select('*');
		$this->personalia->from('"Surat".tkode_surat');

		if( $jenis_surat !== FALSE )
		{
			$this->personalia->like('jenis_surat', $jenis_surat);
			$this->personalia->where('staf', $status_staf);
		}

		$this->personalia->order_by('	jenis_surat,
			staf');
		return $this->personalia->get()->result_array();

	}

	public function nomor_surat( $kode_surat = FALSE, $aggregate_function = FALSE, $tahun_surat = FALSE, $bulan_surat = FALSE )
	{
		if( $aggregate_function !== FALSE )
		{
			if ( strpos(strtoupper($aggregate_function), 'MAX') !== FALSE )
			{
				$this->personalia->select_max('nomor_surat', 'hitung');
			}
		}
		else
		{
			$this->personalia->select('*');
		}

		$this->personalia->from('"Surat".t_arsip_nomor_surat');

		if( $kode_surat !== FALSE AND $tahun_surat !== FALSE AND $bulan_surat !== FALSE )
		{
			$this->personalia->where('kode_surat =', $kode_surat);
			$this->personalia->where('tahun_surat =', $tahun_surat);
			$this->personalia->where('bulan_surat =', $bulan_surat);
		}

		$this->personalia->group_by('	tahun_surat,
			bulan_surat,
			kode_surat,
			nomor_surat');
		$this->personalia->order_by('	tahun_surat,
			bulan_surat,
			kode_surat,
			nomor_surat');
		return $this->personalia->get()->result_array();
	}

	public function format_surat( $jenis_surat = FALSE, $status_staf = FALSE )
	{
		$this->personalia->select('*');
		$this->personalia->from('"Surat".tisi_surat');

		if( $jenis_surat !== FALSE )
		{
			$this->personalia->like('jenis_surat', $jenis_surat);
			$this->personalia->where('staf', $status_staf);
		}

		$this->personalia->order_by('	jenis_surat,
			staf');
		return $this->personalia->get()->result_array();
	}

	    // 	General
	    // 	{
	public function pekerja( $parameter_pekerja = FALSE, $keluar = FALSE )
	{
		$parameterPekerja 			=	"";
		$parameterKeluar 			=	"";

		if ( $keluar !== FALSE AND isset($keluar) )
		{
			$parameterKeluar 	=	"	and 	pri.keluar=false";
		}

		if($parameter_pekerja !== FALSE)
		{
			$parameterPekerja		= "	and		(
			pri.noind like '%$parameter_pekerja%'
			or 	pri.nama like '%$parameter_pekerja%'
			)";
		}

		$pekerja 				= "	select 		pri.noind,
		pri.nama,
		pri.nik
		from 		hrd_khs.v_hrd_khs_tpribadi as pri
		where 		(
		pri.nik is not null
		and 	pri.nik not in ('', '-')
		)
		$parameterPekerja
		$parameterKeluar
		order by 	pri.kodesie,
		pri.kd_jabatan,
		pri.noind;";
		$query 					=	$this->personalia->query($pekerja);
		return $query->result_array();
	}
	
	public function pekerjaSP3($filter) {
		$query = $this->personalia->query("select list.noind, list.nama from(
			select p.noind as noind, p.nama as nama, sp.no_surat, sp.berlaku as berlaku_mulai, (date_trunc('month', sp.berlaku) + '6month'::interval - '1day'::interval)::date as berlaku_selesai
			from hrd_khs.tpribadi p inner join
			(select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp union
			select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp_nonabsen union
			select no_surat, noind, sp_ke, (left(berlaku, 4) || '-' || right(berlaku, 2) || '-01')::date as berlaku  from \"Surat\".tsp_prestasi) sp on p.noind=sp.noind
			where p.keluar='0' and sp.sp_ke='3' and (p.noind like '%$filter%' or p.nama like '%$filter%')
			order by sp.berlaku desc) as list
			group by list.noind, list.nama
			order by 1");
		return $query->result_array();
	}

	public function pekerja_staf($keyword)
	{
		$pekerja = "select * from hrd_khs.v_hrd_khs_tpribadi where
		(
		nama like '%$keyword%' or noind like '%$keyword%') and
		(noind like 'D%' or noind like 'J%')
		and (
		nik is not null
		and 	nik not in ('', '-')
		) and keluar = '0'";
		$query 					=	$this->personalia->query($pekerja);
		return $query->result_array();
	}

	public function pekerja_non_staf($keyword)
	{
		$pekerja = "select * from hrd_khs.v_hrd_khs_tpribadi where
		(
		nama like '%$keyword%' or noind like '%$keyword%') and
		(noind like 'E%')
		and (
		nik is not null
		and 	nik not in ('', '-')
		) and keluar = '0'";
		$query 					=	$this->personalia->query($pekerja);
		return $query->result_array();
	}

	public function detail_pekerja( $noind )
	{
		$status_aktif = '02';
		$detail_pekerja		= "	select 		pri.noind as noind,
		pri.nama as nama,
		pri.kodesie as kodesie,
		pri.jabatan as nama_jabatan,
		pri.kd_jbt_dl as jabatan_dl,
		tseksi.dept,
		tseksi.bidang,
		tseksi.unit,
		tseksi.seksi,
		pri.golkerja,
		(
		concat
		(
		(
		case 	when 	tseksi.seksi='-'
		then	(
		case 	when 	tseksi.unit='-'
		then 	(
		case 	when 	tseksi.bidang='-'
		then 	'Departemen ' || tseksi.dept
		else 	'Bidang ' || tseksi.bidang
			end
		)
		else 	'Unit ' || tseksi.unit
			end
		)
		else	'Seksi ' || tseksi.seksi
			end
		),
		(
		case 	when 	tseksi.pekerjaan is not null
		and 	tseksi.pekerjaan not in ('-')
		then 	' - ' || tseksi.pekerjaan
		end
		)
		)
		) as posisi,
		pri.kd_jabatan as kode_jabatan,
		rtrim(torganisasi.jabatan) as jenis_jabatan,
		pri.kd_pkj as kode_pekerjaan,
		coalesce(tpekerjaan.pekerjaan,'') as nama_pekerjaan,
		tlokasi_kerja.id_ as kode_lokasi_kerja,
		tlokasi_kerja.lokasi_kerja as nama_lokasi_kerja,
		pri.tempat_makan1,
		pri.tempat_makan2,
		(
		case 	when 	pri.kd_jabatan::int between 1 and 14
		or 	pri.kd_jabatan::int in (16, 19, 25)
		then 	'STAF'
		else 	'NON STAF'
			end
		) as status_staf,
		pri.alamat,
		coalesce(tb_status_jabatan.kd_status,'') as kd_status,
		coalesce(tb_status_jabatan.nama_status,'') as nama_status,
		concat(tb_status_jabatan.kd_jabatan, ' - ' ,coalesce(tb_status_jabatan.nama_jabatan,'-')) as nama_jabatan_upah
		from 		hrd_khs.v_hrd_khs_tpribadi as pri
		left join 	hrd_khs.v_hrd_khs_tseksi as tseksi
		on 	tseksi.kodesie=pri.kodesie
		left join 	hrd_khs.torganisasi as torganisasi
		on 	torganisasi.kd_jabatan=pri.kd_jabatan
		left join 	hrd_khs.tpekerjaan as tpekerjaan
		on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
		left join 	hrd_khs.tlokasi_kerja as tlokasi_kerja
		on 	tlokasi_kerja.id_=pri.lokasi_kerja
		left join hrd_khs.tb_status_jabatan as tb_status_jabatan 
		on tb_status_jabatan.noind = pri.noind
		where pri.noind='$noind' and tb_status_jabatan.status_data = '$status_aktif'
		order by tb_status_jabatan.tgl_berlaku desc limit 1;";
		// echo $detail_pekerja;exit();
		$query 				=	$this->personalia->query($detail_pekerja);
		return $query->result_array();
	}

	public function tseksi( $keyword = FALSE )
	{
		$parameter_keyword 	=	"";
		if($keyword !== FALSE)
		{
			$parameter_keyword 		= "	and 	(
			tseksi.kodesie like '$keyword%'
			or 	tseksi.dept like '%$keyword%'
			or 	tseksi.bidang like '%$keyword%'
			or 	tseksi.unit like '%$keyword%'
			or 	tseksi.seksi like '%$keyword%'
			)";
		}

		$tseksi 		= "	select 		tseksi.kodesie,
		tseksi.dept,
		tseksi.bidang,
		tseksi.unit,
		tseksi.seksi,
		tseksi.pekerjaan,
		(
		concat
		(
		tseksi.kodesie,
		' - ',
		(
		case 	when 	tseksi.seksi='-'
		then	(
		case 	when 	tseksi.unit='-'
		then 	(
		case 	when 	tseksi.bidang='-'
		then 	'Departemen ' || tseksi.dept
		else 	'Bidang ' || tseksi.bidang
			end
		)
		else 	'Unit ' || tseksi.unit
			end
		)
		else	'Seksi ' || tseksi.seksi
			end
		),
		(
		case 	when 	tseksi.pekerjaan is not null
		and 	tseksi.pekerjaan not in ('-')
		then 	' - ' || tseksi.pekerjaan
		end
		)
		)
		) as daftar_tseksi
		from 		hrd_khs.v_hrd_khs_tseksi as tseksi
		where 		tseksi.kodesie!='-'
		$parameter_keyword;";
		$query 			=	$this->personalia->query($tseksi);
		return $query->result_array();
	}

	public function golongan_pekerjaan( $kode_status_kerja, $keyword = FALSE )
	{
		$this->personalia->select('	kode_status_kerja,
			golkerja');
		$this->personalia->from('hrd_khs.v_hrd_khs_tpribadi');
		$this->personalia->where('kode_status_kerja=', $kode_status_kerja);
		$this->personalia->where('golkerja!=', '-');

		if( $keyword !== FALSE )
		{
			$this->personalia->like('golkerja', $keyword);
		}

		$this->personalia->group_by('	kode_status_kerja,
			golkerja');
		$this->personalia->order_by('	kode_status_kerja,
			golkerja');
		return $this->personalia->get()->result_array();
	}

	public function lokasi_kerja( $keyword = FALSE )
	{
		$this->personalia->select('*');
		$this->personalia->from('hrd_khs.tlokasi_kerja');

		if( $keyword !== FALSE )
		{
			$this->personalia->like('lokasi_kerja', $keyword);
			$this->personalia->or_like('id_', $keyword);
		}

		$this->personalia->order_by('id_');
		return $this->personalia->get()->result_array();
	}

	public function kode_jabatan_kerja( $keyword = FALSE )
	{
		$this->personalia->select('	trim(kd_jabatan) kd_jabatan,
			rtrim(jabatan) jabatan');
		$this->personalia->from('hrd_khs.torganisasi');

		if( $keyword !== FALSE )
		{
			$this->personalia->like('jabatan', $keyword);
			$this->personalia->or_like('kd_jabatan', $keyword);
		}

		$this->personalia->order_by('kd_jabatan');
		return $this->personalia->get()->result_array();
	}

	public function tempat_makan( $keyword = FALSE )
	{
		$this->personalia->select('fs_tempat_makan');
		$this->personalia->from('"Catering".ttempat_makan');

		if( $keyword !== FALSE )
		{
			$this->personalia->like('fs_tempat_makan', $keyword);
		}

		$this->personalia->order_by('	fs_tempat,
			fs_tempat_makan');
		return $this->personalia->get()->result_array();
	}

	public function pekerjaan( $keyword = FALSE )
	{
		$this->personalia->select('*');
		$this->personalia->from('hrd_khs.tpekerjaan');

		if( $keyword !== FALSE )
		{
			$this->personalia->like('kdpekerjaan', $keyword);
			$this->personalia->or_like('pekerjaan', $keyword);
		}

		$this->personalia->order_by('kdpekerjaan');
		return $this->personalia->get()->result_array();
	}

	public function deleteSuratMutasi($tanggal,$kode,$no_surat_decode)
	{
		$no_surat = $no_surat_decode;
		$waktu = date("Y/m/d",$tanggal);
					// echo $waktu;
	    			 // echo $no_surat;
	    			 // echo $tanggal;
	    			 // echo $kode;
	    			 // exit();
		$this->personalia->where('no_surat=',$no_surat);
		$this->personalia->where('tanggal_cetak', $waktu);
		$this->personalia->where('kode=', $kode);
		$this->personalia->delete('"Surat".tsurat_mutasi');
	    			//$this->personalia->and('');
		header('Location: '.$_SERVER['REQUEST_URI']);
	}

	public function getNamaNoindBaru($nomor_induk)
	{
		$this->personalia->select('nama, noind_baru');
		$this->personalia->from('hrd_khs.tpribadi');
		$this->personalia->where('noind=', $nomor_induk);
		return $this->personalia->get()->result_array();

	}

	public function inputSuratMutasi($inputSuratMutasi)
	{
		$this->personalia->insert('"Surat".tsurat_mutasi', $inputSuratMutasi);
	}
//<------------------------------------------------------Update------------------------------------------------>
	public function editSuratMutasi($tanggal,$kode,$no_surat_decode)
	{
		date_default_timezone_set("Asia/Bangkok");
		$waktu = "'".date("Y/m/d",$tanggal)."'";
		$kode = "'".$kode."'";
		$no_surat_decode = "'".$no_surat_decode."'";
	    			// echo $waktu; exit();

	    			// $this->personalia->select('*, ts1.seksi seksi2, tp1.pekerjaan pekerjaan2');
	    			// $this->personalia->from('"Surat".tsurat_mutasi');
	    			// $this->personalia->join('hrd_khs.tseksi as ts2','ts2.kodesie = tsurat_mutasi.kodesie_baru', 'left');
	    			// $this->personalia->join('hrd_khs.tseksi as ts1','ts1.kodesie = tsurat_mutasi.kodesie_lama', 'left');
	    			// $this->personalia->join('hrd_khs.tlokasi_kerja','tlokasi_kerja.id_ = tsurat_mutasi.lokasi_kerja_lama');
	    			// $this->personalia->join('hrd_khs.tpekerjaan tp1','tp1.kdpekerjaan = tsurat_mutasi.kd_pkj_baru');
	    			// $this->personalia->join('hrd_khs.tpekerjaan tp2','tp2.kdpekerjaan = tsurat_mutasi.kd_pkj_lama');
	    			// $this->personalia->join('hrd_khs.trefjabatan tj1','tj1.kd_jabatan = tsurat_mutasi.kd_jabatan_baru');
	    			// $this->personalia->join('hrd_khs.trefjabatan tj2','tj2.kd_jabatan = tsurat_mutasi.kd_jabatan_lama');
	    			// $this->personalia->where('tanggal_cetak=', $waktu);
	    			// $this->personalia->where('kode=', $kode);
	    			// $this->personalia->where('no_surat=', $no_surat_decode);
	    			// return $this->personalia->get()->result_array();
		$sql = "select tm.* , ts.seksi, case when left(ts2.seksi,1) = '-' then
		case when left(ts2.unit,1) = '-' then
		case when left(ts2.bidang,1) = '-' then
		case when left(ts2.dept,1) = '-' then
		'-'
		else
			ts2.dept
		end
		else
			ts2.bidang
		end
		else
			ts2.unit
		end
		else 
			ts2.seksi
		end seksi2, tp1.pekerjaan, tp2.pekerjaan pekerjaan2, tk.lokasi_kerja, tk2.lokasi_kerja lokasi2,tr.jabatan, tr2.jabatan jabatan2 from \"Surat\".tsurat_mutasi tm
		left join hrd_khs.tseksi ts on tm.kodesie_lama = ts.kodesie
		left join hrd_khs.tseksi ts2 on tm.kodesie_baru = ts2.kodesie
		left join hrd_khs.tpekerjaan tp1 on tm.kd_pkj_lama = tp1.kdpekerjaan
		left join hrd_khs.tpekerjaan tp2 on tm.kd_pkj_baru = tp2.kdpekerjaan
		left join hrd_khs.tlokasi_kerja tk on tm.lokasi_kerja_lama = tk.id_
		left join hrd_khs.tlokasi_kerja tk2 on tm.lokasi_kerja_baru = tk2.id_
		left join hrd_khs.torganisasi tr on tm.kd_jabatan_lama = tr.kd_jabatan
		left join hrd_khs.torganisasi tr2 on tm.kd_jabatan_baru = tr2.kd_jabatan
		where tm.tanggal_cetak = $waktu and tm.kode = $kode and no_surat = $no_surat_decode";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function editSuratMutasai($no_surat_decode)
	{
		$editSuratMutasi 		= "	select 		mutasi.kode,
		mutasi.no_surat,
		mutasi.hal_surat,
		mutasi.nama,
		mutasi.noind,
		mutasi.kodesie_lama,
		mutasi.kodesie_baru,
		concat_ws
		(
		' - ',
		mutasi.kodesie_lama,
		(			
		select 		case 	when 	rtrim(seksi)!='-'
		then 	'Seksi ' || rtrim(seksi)
		else	(
			case 	when 	rtrim(unit)!='-'
		then 	'Unit ' || rtrim(unit)
		else 	(
			case 	when 	rtrim(bidang)!='-'
		then 	'Bidang ' || rtrim(bidang)
		else 	'Departemen ' || rtrim(dept)
			end
		)
		end
		)
		end
		from	 	hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=mutasi.kodesie_lama
		),
		(
		select		case 	when 	rtrim(pekerjaan)!='-'
		then 	rtrim(pekerjaan)
		end
		from 		hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=mutasi.kodesie_lama
		)
		) as seksi_lama,
		concat_ws
		(
		' - ',
		mutasi.kodesie_baru,
		(			
		select 		case 	when 	rtrim(seksi)!='-'
		then 	'Seksi ' || rtrim(seksi)
		else	(
			case 	when 	rtrim(unit)!='-'
		then 	'Unit ' || rtrim(unit)
		else 	(
			case 	when 	rtrim(bidang)!='-'
		then 	'Bidang ' || rtrim(bidang)
		else 	'Departemen ' || rtrim(dept)
			end
		)
		end
		)
		end
		from	 	hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=mutasi.kodesie_baru
		),
		(
		select		case 	when 	rtrim(pekerjaan)!='-'
		then 	rtrim(pekerjaan)
		end
		from 		hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=mutasi.kodesie_baru
		)
		) as seksi_baru,
		mutasi.tempat_makan_1_lama,
		mutasi.tempat_makan_1_baru,
		mutasi.lokasi_kerja_lama,
		mutasi.lokasi_kerja_baru,
		concat_ws
		(
		' - ',
		mutasi.lokasi_kerja_lama,
		(
		select 		lokker.lokasi_kerja
		from 		hrd_khs.tlokasi_kerja as lokker
		where 		lokker.id_=mutasi.lokasi_kerja_lama
		)
		) as lokasi_lama,
		concat_ws
		(
		' - ',
		mutasi.lokasi_kerja_baru,
		(
		select 		lokker.lokasi_kerja
		from 		hrd_khs.tlokasi_kerja as lokker
		where 		lokker.id_=mutasi.lokasi_kerja_baru
		)
		) as lokasi_baru,
		mutasi.golkerja_lama,
		mutasi.golkerja_baru,
		mutasi.kd_jabatan_lama,
		mutasi.kd_jabatan_baru,
		mutasi.tanggal_berlaku,
		mutasi.isi_surat,
		mutasi.cetak,
		mutasi.tanggal_cetak,
		mutasi.noind_baru,
		mutasi.jabatan_lama,
		mutasi.jabatan_baru,
		(select jabatan
		from hrd_khs.torganisasi as torg
		where torg.kd_jabatan=mutasi.kd_jabatan_baru
		)as jabatann,
		mutasi.tempat_makan_2_lama,
		mutasi.tempat_makan_2_baru,
		mutasi.kd_pkj_lama,
		mutasi.kd_pkj_baru,
		(select pekerjaan
		from hrd_khs.tpekerjaan as pek
		where pek.kdpekerjaan=mutasi.kd_pkj_lama
		)as pekerjaan_lama,
		(select pekerjaan
		from hrd_khs.tpekerjaan as pek
		where pek.kdpekerjaan=mutasi.kd_pkj_baru
		)as pekerjaan_baru,
		(
		case 	when 	mutasi.kd_jabatan_lama::numeric<17
		then 	'STAF'
		else 	'NONSTAF'
			end
		) as status_staf
		from 		\"Surat\".tsurat_mutasi as mutasi
		where 		concat
		(
		mutasi.no_surat,
		'/' || mutasi.kode || '/',
		to_char(mutasi.tanggal_cetak, 'MM'),
		'/',
		to_char(mutasi.tanggal_cetak, 'yy')
		)
		=
		'$no_surat_decode';";
		$query 			=	$this->personalia->query($editSuratMutasi);
		return $query->result_array();
	}

	public function updateSuratMutasi($updateSuratMutasi, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
	    			// echo "$updateSuratMutasi<br>";
	    			// echo "$nomor_surat<br>";
	    			// echo "$kodeSurat<br>";
		$this->personalia->where('tanggal_cetak', $tanggal_cetak);
		$this->personalia->where('no_surat', $nomor_surat);
		$this->personalia->where('kode', $kodeSurat);
		$this->personalia->update('"Surat".tsurat_mutasi', $updateSuratMutasi);
	}

	public function DetailGolongan(/*$tanggal,$kode,$no_surat_decode*/)
	{
	    			// $waktu = date("Y/m/d",$tanggal);

	    			// $this->personalia->select('*');
	    			// $this->personalia->from('"Surat".tsurat_mutasi');
	    			// $this->personalia->where('tanggal_cetak=', $waktu);
	    			// $this->personalia->where('kode=', $kode);
	    			// $this->personalia->where('no_surat=', $no_surat_decode);
	    			// return $this->personalia->get()->result_array();
		$DetailGolongan= "select DISTINCT golkerja from hrd_khs.tpribadi where keluar='0'order by golkerja";

		$query 	=	$this->personalia->query($DetailGolongan);
		return $query->result_array();	
	}

	public function DetailLokasiKerja(/*$tanggal,$kode,$no_surat_decode*/)
	{
	    			// $waktu = date("Y/m/d",$tanggal);

	    			// $this->personalia->select('*');
	    			// $this->personalia->from('"Surat".tsurat_mutasi');
	    			// $this->personalia->where('tanggal_cetak=', $waktu);
	    			// $this->personalia->where('kode=', $kode);
	    			// $this->personalia->where('no_surat=', $no_surat_decode);
	    			// return $this->personalia->get()->result_array();
		$DetailLokasiKerja= "select id_ as kode_lokasi, lokasi_kerja as nama_lokasi,concat_ws(' - ', id_, lokasi_kerja) as lokasi  from hrd_khs.tlokasi_kerja order by id_";

		$query 	=	$this->personalia->query($DetailLokasiKerja);
		return $query->result_array();
	}

	public function DetailKdJabatan(/*$tanggal,$kode,$no_surat_decode*/)
	{
	    			// $waktu = date("Y/m/d",$tanggal);

	    			// $this->personalia->select('*');
	    			// $this->personalia->from('"Surat".tsurat_mutasi');
	    			// $this->personalia->where('tanggal_cetak=', $waktu);
	    			// $this->personalia->where('kode=', $kode);
	    			// $this->personalia->where('no_surat=', $no_surat_decode);
	    			// return $this->personalia->get()->result_array();
		$DetailKdJabatan= "select kd_jabatan as kd_jabatan , jabatan as jabatan from hrd_khs.torganisasi";
		$query 	=	$this->personalia->query($DetailKdJabatan);
		return $query->result_array();
	}

	public function DetailTempatMakan1(/*$tanggal,$kode,$no_surat_decode*/)
	{
	    			// $waktu = date("Y/m/d",$tanggal);

	    			// $this->personalia->select('*');
	    			// $this->personalia->from('"Surat".tsurat_mutasi');
	    			// $this->personalia->where('tanggal_cetak=', $waktu);
	    			// $this->personalia->where('kode=', $kode);
	    			// $this->personalia->where('no_surat=', $no_surat_decode);
	    			// return $this->personalia->get()->result_array();
		$DetailTempatMakan1= "select distinct tempat_makan1 as tempat_makan1 from hrd_khs.tpribadi where keluar='false'";
		$query 	=	$this->personalia->query($DetailTempatMakan1);
		return $query->result_array();	
	}

	public function DetailTempatMakan2(/*$tanggal,$kode,$no_surat_decode*/)
	{
	    			// $waktu = date("Y/m/d",$tanggal);

	    			// $this->personalia->select('*');
	    			// $this->personalia->from('"Surat".tsurat_mutasi');
	    			// $this->personalia->where('tanggal_cetak=', $waktu);
	    			// $this->personalia->where('kode=', $kode);
	    			// $this->personalia->where('no_surat=', $no_surat_decode);
	    			// return $this->personalia->get()->result_array();
		$DetailTempatMakan2= "select distinct tempat_makan2 as tempat_makan2 from hrd_khs.tpribadi where keluar='false'";
		$query 	=	$this->personalia->query($DetailTempatMakan2);
		return $query->result_array();	
	}

	    		//<--------------------------Preview----------------------->
	public function ambilLayoutSuratPerbantuan()
	{
		$this->personalia->select('isi_surat');
		$this->personalia->from('"Surat".tisi_surat"');
		$this->personalia->where('jenis_surat=', 'PERBANTUAN');

		return $this->personalia->get()->result_array();
	}

	public function ambilIsiSuratMutasi($tanggal,$kode,$no_surat_decode)
	{
		$waktu = date("Y/m/d",$tanggal);

		$this->personalia->select('*');
		$this->personalia->from('"Surat".tsurat_mutasi');
		$this->personalia->where('tanggal_cetak=', $waktu);
		$this->personalia->where('kode=', $kode);
		$this->personalia->where('no_surat=', $no_surat_decode);
		return $this->personalia->get()->result_array();
	}

	public function ambilIsiSuratPerbantuan($tanggal,$kode,$no_surat_decode)
	{
		$waktu = date("Y/m/d",$tanggal);

		$this->personalia->select('*');
		$this->personalia->from('"Surat".tsurat_mutasi');
		$this->personalia->where('tanggal_cetak=', $waktu);
		$this->personalia->where('kode=', $kode);
		$this->personalia->where('no_surat=', $no_surat_decode);
		return $this->personalia->get()->result_array();
	}

	public function testweb()
	{
		$a = "'101030104'";
		$sl = $this->personalia->query('select *, ts2.seksi seksi2 from "Surat".tsurat_mutasi tm
			inner join hrd_khs.tseksi ts on tm.kodesie_lama = ts.kodesie
			inner join hrd_khs.tseksi ts2 on tm.kodesie_baru = ts2.kodesie
			inner join hrd_khs.tlokasi_kerja tk on tm.lokasi_kerja_lama = tk.id_
			where tm.kodesie_lama = '.$a);
		return $sl->result_array();
	}

	public function inputNomorSurat($inputNomorSurat)
	{
		$this->personalia->insert('"Surat".t_arsip_nomor_surat', $inputNomorSurat);
	}

	public function deleteArsipSuratMutasi($bulan_surat, $kode_surat, $no_surat)
	{
		$this->personalia->where('bulan_surat', $bulan_surat);
		$this->personalia->where('kode_surat', $kode_surat);
		$this->personalia->where('nomor_surat', $no_surat);
		$this->personalia->delete('"Surat".t_arsip_nomor_surat');
	}
		//	}
	public function ambilDaftarSuratPerbantuan()
	{
		$ambilDaftarSuratPerbantuan 		= "	select 		concat
		(
		perbantuan.no_surat, 
		'/'||perbantuan.kode||'/', 
		to_char(perbantuan.tanggal_cetak, 'MM'), 
		'/', 
		to_char(perbantuan.tanggal_cetak, 'YY')
		) as no_surat,
		perbantuan.tanggal_mulai_perbantuan::date as tanggal_mulai_perbantuan,
		perbantuan.tanggal_selesai_perbantuan::date as tanggal_selesai_perbantuan,
		perbantuan.noind,
		perbantuan.nama,
		concat_ws
		(
		' - ',
		perbantuan.kodesie_lama,
		(			
		select 		case 	when 	rtrim(seksi)!='-'
		then 	'Seksi ' || rtrim(seksi)
		else	(
			case 	when 	rtrim(unit)!='-'
		then 	'Unit ' || rtrim(unit)
		else 	(
			case 	when 	rtrim(bidang)!='-'
		then 	'Bidang ' || rtrim(bidang)
		else 	'Departemen ' || rtrim(dept)
			end
		)
		end
		)
		end
		from	 	hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=perbantuan.kodesie_lama
		),
		(
		select		case 	when 	rtrim(pekerjaan)!='-'
		then 	rtrim(pekerjaan)
		end
		from 		hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=perbantuan.kodesie_lama
		)
		) as seksi_lama,
		concat_ws
		(
		' - ',
		perbantuan.kodesie_baru,
		(			
		select 		case 	when 	rtrim(seksi)!='-'
		then 	'Seksi ' || rtrim(seksi)
		else	(
			case 	when 	rtrim(unit)!='-'
		then 	'Unit ' || rtrim(unit)
		else 	(
			case 	when 	rtrim(bidang)!='-'
		then 	'Bidang ' || rtrim(bidang)
		else 	'Departemen ' || rtrim(dept)
			end
		)
		end
		)
		end
		from	 	hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=perbantuan.kodesie_baru
		),
		(
		select		case 	when 	rtrim(pekerjaan)!='-'
		then 	rtrim(pekerjaan)
		end
		from 		hrd_khs.tseksi as tseksi
		where 		tseksi.kodesie=perbantuan.kodesie_baru
		)
		) as seksi_baru,
		concat_ws
		(
		' - ',
		perbantuan.lokasi_kerja_lama,
		(
		select 		lokker.lokasi_kerja
		from 		hrd_khs.tlokasi_kerja as lokker
		where 		lokker.id_=perbantuan.lokasi_kerja_lama
		)
		) as lokasi_kerja_lama,
		concat_ws
		(
		' - ',
		perbantuan.lokasi_kerja_baru,
		(
		select 		lokker.lokasi_kerja
		from 		hrd_khs.tlokasi_kerja as lokker
		where 		lokker.id_=perbantuan.lokasi_kerja_baru
		)
		) as lokasi_kerja_baru,
		perbantuan.tanggal_cetak::date,
		perbantuan.cetak
		from 		\"Surat\".tsurat_perbantuan as perbantuan";
		$query 					=	$this->personalia->query($ambilDaftarSuratPerbantuan);
		return $query->result_array();
	}

	public function deleteSuratPerbantuan($no_surat_decode)
	{
		$explode_no_surat_decode = explode('/', $no_surat_decode);
			 		// print_r($explode_no_surat_decode); exit();
		$no_surat_int = intval($explode_no_surat_decode[0]);
		$no_surat = $explode_no_surat_decode;
			 		// echo $no_surat; exit();
		$kode_surat = $explode_no_surat_decode[1].'/'.$explode_no_surat_decode[2];
		$bulan_surat = $explode_no_surat_decode[3];
		$tahun_surat = $explode_no_surat_decode[4];
			 		// echo  $kode_surat.$bulan_surat.$tahun_surat;
		$this->personalia->where('kode', $kode_surat);
		$this->personalia->where('no_surat', $kode_surat);
		$this->personalia->delete('"Surat".tsurat_mutasi');

	}public function deleteArsipSuratPerbantuan($no_surat_decode)
	{
		$explode_no_surat_decode = explode('/', $no_surat_decode);
			 		// print_r($explode_no_surat_decode); exit();
		$no_surat_int = intval($explode_no_surat_decode[0]);
		$no_surat = $explode_no_surat_decode;
			 		// echo $no_surat; exit();
		$kode_surat = $explode_no_surat_decode[1].'/'.$explode_no_surat_decode[2];
		$bulan_surat = intval($explode_no_surat_decode[3]);
		$tahun_surat = '20'.$explode_no_surat_decode[4];
			 		// echo  $kode_surat.$bulan_surat.$tahun_surat;
		$this->personalia->where('kode', $kode_surat);
		$this->personalia->where('no_surat', $kode_surat);
		$this->personalia->where('tahun_surat', $tahun_surat);
		$this->personalia->where('bulan_surat', $bulan_surat);
		$this->personalia->delete('"Surat".t_arsip_nomor_surat');

	}
	public function cekStaf($nomor_induk)
	{
		$cekStaf 		= "	select 		(
		case 	when 	(
		pri.kd_jabatan::int between 1 and 14
		or 	pri.kd_jabatan::int in (16, 19, 25)
		)
		then 	'STAF'
		else 	'NONSTAF'
			end
		) as status
		from 		hrd_khs.v_hrd_khs_tpribadi as pri
		where 		pri.noind='$nomor_induk'";
		$query 			=	$this->personalia->query($cekStaf);
		return $query->result_array();
	}

	public function ambilLayoutSuratMutasi($staff)
	{
		$this->personalia->where('jenis_surat=', 'MUTASI');
		$this->personalia->where('staf', $staff);
		$this->personalia->select('isi_surat');
		$this->personalia->from('"Surat".tisi_surat"');

		return $this->personalia->get()->result_array();
	}

	public function cariTSeksi($seksi_lama)
	{
		$cariTSeksi 		= "	select 		rtrim(tseksi.dept) as dept,
		rtrim(tseksi.bidang) as bidang,
		rtrim(tseksi.unit) as unit,
		rtrim(tseksi.seksi) as seksi
		from 		hrd_khs.tseksi as tseksi
		where 		kodesie='$seksi_lama'";
		$query 				=	$this->personalia->query($cariTSeksi);
		return $query->result_array();
	}

	public function cekJabatanSurat($nomor_induk)
	{
		$cekJabatanSurat 		= "	select 		master.nama,
		master.noind,
		(
		case 	when 	(
		master.kd_jabatan::int between 1 and 14
		or 	master.kd_jabatan::int in (16, 19, 25)
		)
		then 	concat_ws(' ', master.jabatan, master.lingkup, 'KHS', master.nama_lokasi_kerja)
		else 	concat_ws(' ', 'Seksi', master.seksi, 'KHS', master.nama_lokasi_kerja)
			end
		) as jabatan_surat
		from		(
		select		pri.nama,
		pri.noind,
		pri.kode_status_kerja,
		pri.golkerja,
		pri.kd_jabatan,
		rtrim(torganisasi.jabatan) as jabatan,
		tseksi.dept,
		tseksi.bidang,
		tseksi.unit,
		tseksi.seksi,
		tseksi.pekerjaan,
		(
		case 	when 	tseksi.seksi='-'
		then 	(
		case 	when 	tseksi.unit='-'
		then 	(
		case 	when 	tseksi.bidang='-'
		then 	tseksi.dept
		else 	tseksi.bidang
			end
		)
		else 	tseksi.unit
			end
		)
		else 	tseksi.seksi
			end
		) as lingkup,
		pri.kd_pkj,
		tpekerjaan.kdpekerjaan as kode_pekerjaan,
		pri.lokasi_kerja as kode_lokasi_kerja,
		tlokasi_kerja.lokasi_kerja as nama_lokasi_kerja
		from 		hrd_khs.v_hrd_khs_tpribadi as pri
		join 		hrd_khs.v_hrd_khs_tseksi as tseksi
		on 	tseksi.kodesie=pri.kodesie
		left join 	hrd_khs.tpekerjaan as tpekerjaan
		on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
		join 		hrd_khs.torganisasi as torganisasi
		on 	torganisasi.kd_jabatan=pri.kd_jabatan
		join 		hrd_khs.tlokasi_kerja as tlokasi_kerja
		on 	tlokasi_kerja.id_=pri.lokasi_kerja
		where 		pri.noind='$nomor_induk'
		) as master";
		$query 							=	$this->personalia->query($cekJabatanSurat);
		return $query->result_array();
	}

	public function ambilPosisi($nomor_induk)
	{
		$ambilPosisi 	= "	select 		master.nama,
		master.noind,
		(
		case 	when 	(
		master.kd_jabatan::int between 1 and 14
		or 	master.kd_jabatan::int in (16, 19, 25)
		)
		then 	concat_ws(' ', master.jabatan, master.lingkup)
		else 	concat
			(
		master.pekerjaan,
		' / ',
		'Golongan ',
		master.golkerja,
		' / ',
		'Seksi ',
		master.seksi,
		' / ',
		'Unit ',
		master.unit,
		' / ',
		'Departemen ',
		master.dept
		)
		end
		) as posisi
		from 		(
		select		pri.nama,
		pri.noind,
		pri.kode_status_kerja,
		pri.golkerja,
		pri.kd_jabatan,
		rtrim(torganisasi.jabatan) as jabatan,
		tseksi.dept,
		tseksi.bidang,
		tseksi.unit,
		tseksi.seksi,
		tpekerjaan.pekerjaan,
		(
		case 	when 	tseksi.seksi='-'
		then 	(
		case 	when 	tseksi.unit='-'
		then 	(
		case 	when 	tseksi.bidang='-'
		then 	tseksi.dept
		else 	tseksi.bidang
			end
		)
		else 	tseksi.unit
			end
		)
		else 	tseksi.seksi
			end
		) as lingkup,
		pri.kd_pkj,
		tpekerjaan.kdpekerjaan as kode_pekerjaan,
		pri.lokasi_kerja as kode_lokasi_kerja,
		tlokasi_kerja.lokasi_kerja as nama_lokasi_kerja
		from 		hrd_khs.v_hrd_khs_tpribadi as pri
		join 		hrd_khs.v_hrd_khs_tseksi as tseksi
		on 	tseksi.kodesie=pri.kodesie
		left join 	hrd_khs.tpekerjaan as tpekerjaan
		on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
		join 		hrd_khs.torganisasi as torganisasi
		on 	torganisasi.kd_jabatan=pri.kd_jabatan
		join 		hrd_khs.tlokasi_kerja as tlokasi_kerja
		on 	tlokasi_kerja.id_=pri.lokasi_kerja
		where 		pri.noind='$nomor_induk'
		) as master;";
		// echo $ambilPosisi;exit();
		$query 			=	$this->personalia->query($ambilPosisi);
		return $query->result_array();
	}

	public function cekPekerjaan($pekerjaan_baru)
	{
		$this->personalia->select('pekerjaan');
		$this->personalia->from('hrd_khs.tpekerjaan');
		$this->personalia->where('kdpekerjaan=', $pekerjaan_baru);
		return $this->personalia->get()->result_array();
	}

	public function ambilNomorSuratTerakhir($tahun, $bulan, $kodeSurat)
	{
		$ambilNomorSuratMutasiTerakhir 		= "	select max(nomor_surat) jumlah from \"Surat\".t_arsip_nomor_surat where kode_surat = '$kodeSurat'
and tahun_surat = '$tahun' and bulan_surat = '$bulan'";
		$query 		= 	$this->personalia->query($ambilNomorSuratMutasiTerakhir);
		return $query->result_array();
	}
	public function kolom()
	{
		$sql = "select t.table_schema,
		t.table_name
		from information_schema.tables t
		inner join information_schema.columns c on c.table_name = t.table_name 
		and c.table_schema = t.table_schema
		where c.column_name = 'kodesie'
		order by table_schema asc";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function allt($sc,$tb)
	{
		$sql = "SELECT column_name
		FROM information_schema.columns
		WHERE table_schema = '$sc'
		AND table_name   = '$tb'";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}
	public function cekMutasi($now)
	{
		$sql = "select * from \"Surat\".tsurat_mutasi WHERE tanggal_berlaku = '$now' limit 1";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function updateMutasi($noind, $kodesie, $kodesie_lama, $jabatan, $jabatan_lama, $lokasi, $lokasi_lama, $golker, $golker_lama, $tmakan_1 , $tmakan_1_lama, $tmakan_2, $tmakan_2_lama, $kd_pkj, $kd_pkj_lama, $kd_jabatan_baru, $kd_jabatan_lama, $action_date, $tgl_berlaku, $action)
	{
		$sql = "update hrd_khs.trefjabatan set kodesie = '$kodesie', jabatan = '$jabatan' where noind = '$noind';";

		//tpribadi
		$sql .= "update hrd_khs.tpribadi set kodesie = '$kodesie', golkerja = '$golker', jabatan = '$jabatan',
		tempat_makan = '$tmakan_1', tempat_makan1 = '$tmakan_1', tempat_makan2 = '$tmakan_2',
		kd_pkj = '$kd_pkj', lokasi_kerja = '$lokasi', last_action = '$action', last_action_date = '$action_date' where noind = '$noind';";

				//v_hrd_khs_tpribadi
		// $sql .= "update hrd_khs.v_hrd_khs_tpribadi set kodesie = '$kodesie', golkerja = '$golker', jabatan = '$jabatan',
		// 		tempat_makan = '$tmakan_1', tempat_makan1 = '$tmakan_1', tempat_makan2 = '$tmakan_2',
		// 		last_action = '$action', last_action_date = '$action_date' where noind = '$noind';";

		//tnilaipkl
		$sql .= "update \"PKL\".tnilaipkl set kodesie = '$kodesie' where noind = '$noind';";

		//tdatapkl
		$sql .= "update \"PKL\".tdatapkl set kodesie = '$kodesie', golpkl = '$golker',
		tempat_makan = '$tmakan_1' where noind = '$noind';";

		//t_pkl
		$sql .= "update \"PKL\".t_pkl set kodesie = '$kodesie' where noind = '$noind';";

		//insert tmutasi
		$sql .= "INSERT INTO hrd_khs.tmutasi (noind, kodesielm, golkerjalm, tempat_makan1lm, tempat_makan2lm, kodesiebr, golkerjabr, tempat_makan1br, tempat_makan2br, tglberlaku, status, kd_jabatanlm, jabatanlm, kd_jabatanbr, jabatanbr, lokasilm, lokasibr) VALUES ('$noind', '$kodesie_lama', '$golker_lama', '$tmakan_1_lama', '$tmakan_2_lama', '$kodesie', '$golker', '$tmakan_1', '$tmakan_2', '$tgl_berlaku', '1', '$kd_jabatan_lama', '$jabatan_lama', '$kd_jabatan_baru', '$jabatan', '$lokasi_lama', '$lokasi');";

		//insert tlog
		$sql .= "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program) VALUES ('$action_date', 'SURAT MUTASI', 'UPDATE DI SCHEMA HRD_KHS DAN PKL', '$noind' , 'UPDATE -> DATA PEKERJA', 'SURAT');";

		//update tpindahmakan
		$sql .= "update \"Catering\".tpindahmakan set kodesie='$kodesie', fs_tempat_makan1_lm = '$tmakan_1_lama', fs_tempat_makan2_lm = '$tmakan_2_lama', fs_tempat_makan1_br = '$tmakan_1', fs_tempat_makan2_br = '$tmakan_2', golkerja = '$golker_lama', golkerja1 = '$golker' where fs_noind = '$noind';";
		$query = $this->dev->query($sql);
	}

	public function cekPerbantuan($now)
	{
		$sql = "select * from \"Surat\".tsurat_perbantuan WHERE tanggal_mulai_perbantuan = '$now' limit 1";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function updatePerbantuan($noind, $kodesie, $kodesie_lama, $jabatan, $jabatan_lama, $lokasi, $lokasi_lama, $golker, $golker_lama, $tmakan_1, $tmakan_1_lama, $tmakan_2, $tmakan_2_lama, $kd_pkj, $kd_pkj_lama, $kd_jabatan_baru, $kd_jabatan_lama, $action_date, $tgl_mulai, $tgl_selesai)
	{
		$sql = "update hrd_khs.tpribadi set tempat_makan='$tmakan_1', tempat_makan1='$tmakan_1', tempat_makan2='$tmakan_2' where noind = '$noind';";

			//insert tpindahmakan
		$sql .= "INSERT INTO \"Catering\".tpindahmakan (fd_tgl_mulai, fd_tgl_selesai, fs_noind, fs_tempat_makan1_lm, fs_tempat_makan2_lm, fs_tempat_makan1_br, fs_tempat_makan2_br, kodesie, golkerja, golkerja1, ket, berlaku, status) VALUES ('$tgl_mulai', '$tgl_selesai', '$noind', '$tmakan_1_lama', '$tmakan_2_lama', '$tmakan_1', '$tmakan_2', $kodesie, '$golker_lama', '$golker', 'PERBANTUAN', '1', '1');";	
			//insert tlog
		$sql .= "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program) VALUES ('$action_date', 'SURAT PERBANTUAN', 'UPDATE DI SCHEMA HRD_KHS', '$noind' , 'UPDATE -> DATA TEMPAT MAKAN', 'SURAT');";	
		$query = $this->dev->query($sql);
	}

	public function selesaiPerbantuan()
	{
		$sql = "select * from \"Catering\".tpindahmakan where fd_tgl_selesai = '$now'";
		$query = $this->dev->query($sql);
		return $query->result_array();
	}
	public function updateSelesai($noind, $tmakan_1_lama, $tmakan_2_lama)
	{
		$sql = "update hrd_khs.tpribadi set tempat_makan = '$tmakan_1_lama', tempat_makan1 = '$tmakan_1_lama', tempat_makan2 = '$tmakan_2_lama' where noind = '$noind';";
			//insert tlog
		$sql .= "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program) VALUES ('$action_date', 'SURAT PERBANTUAN', 'UPDATE DI SCHEMA HRD_KHS', '$noind' , 'UPDATE -> DATA TEMPAT MAKAN', 'SURAT');";
		$query = $this->dev->query($sql);
	}

	public function updateSelesaiPerbantuan($yesterday)
	{
		$sql  = "update \"Catering\".tpindahmakan set berlaku = '0' where fd_tgl_selesai = '$yesterday';";
		$query = $this->dev->query($sql);
	}

	public function finger_reference($keyword = FALSE)
    {
    	$this->quick->select('*');
    	$this->quick->from('db_datapresensi.tb_device');

    	if ( $keyword !== FALSE )
    	{
    		$this->quick->group_start();
    			$this->quick->like('device_name', $keyword);
    			$this->quick->or_like('id_lokasi', $keyword);
    		$this->quick->group_end();
    	}

    	$this->quick->order_by('id_lokasi');
    	return $this->quick->get()->result_array();
    }

    function kodefinger($id)
    {
		$sql = "SELECT cc.id_lokasi
				from
					(SELECT case when tc is null
							then '0'
							else bb.tc
							end id_lokasi
							from
								(select distinct aa.*
								from
									(select distinct
										(select nomor_sn
										from 
											(select nomor_sn , count(nomor_sn)  as jumlah , noind
												from \"Presensi\".tpresensi_riil b 
												where a.noind = b.noind
												group by nomor_sn, noind
												) as tbl
										order by jumlah desc 
										limit 1
										) tc, c.noind induk
									FROM \"Presensi\".tpresensi_riil a right join hrd_khs.tpribadi c on a.noind= c.noind
									WHERE c.noind = '$id' 
								)aa
					)bb
				)cc";


		$query = $this->personalia->query($sql);
		// echo "<pre>"; print_r($query); exit();
		return $query->row()->id_lokasi;
	}

	function lokasifinger($id)
    {
		$sql = "SELECT id_lokasi, device_name FROM db_datapresensi.tb_device WHERE device_sn = '$id'";

		$query = $this->quick->query($sql);
		// echo "<pre>"; print_r($query); exit();
		return $query->result_array();
	}

	public function inputFingerMutasi($inputFingerMutasi)
	{
		$this->personalia->insert('"Surat".tpindah_finger', $inputFingerMutasi);
		return $this->personalia->affected_rows();
	}

	public function editFinger($tanggal,$kode,$no_surat_decode)
	{
		date_default_timezone_set("Asia/Bangkok");
		$waktu = "'".date("Y/m/d",$tanggal)."'";
		$kode = "'".$kode."'";
		$no_surat_decode = "'".$no_surat_decode."'";

		$sql = "SELECT * from \"Surat\".tpindah_finger
		where created_date = $waktu and kode = $kode and no_surat = $no_surat_decode";
					// echo "<pre>"; print_r($sql) ;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function updateFingerSuratMutasi($updateFingerSuratMutasi, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
	    			// echo "$updateSuratMutasi<br>";
	    			// echo "$nomor_surat<br>";
	    			// echo "$kodeSurat<br>";
		$this->personalia->where('created_date', $tanggal_cetak);
		$this->personalia->where('no_surat', $nomor_surat);
		$this->personalia->where('kode', $kodeSurat);
		$this->personalia->update('"Surat".tpindah_finger', $updateFingerSuratMutasi);
		return $this->personalia->affected_rows();
	}

	public function deleteFingerSuratMutasi($tanggal,$kode,$no_surat_decode)
	{
		$no_surat = $no_surat_decode;
		$waktu = date("Y-m-d",$tanggal);
					// echo $waktu;
	    			 // echo $no_surat;
	    			 // echo $tanggal;
	    			 // echo $kode;
	    			 // exit();
		$this->personalia->where('no_surat=',$no_surat);
		$this->personalia->where('created_date', $waktu);
		$this->personalia->where('kode=', $kode);
		$this->personalia->delete('"Surat".tpindah_finger');
	    			//$this->personalia->and('');
		header('Location: '.$_SERVER['REQUEST_URI']);
	}
	
	public function getNamaStatus(){
		$sql = "SELECT kd_status,nama_status from hrd_khs.tb_master_stat WHERE nama_status!='' GROUP BY kd_status,nama_status ORDER BY kd_status";
		return $this->personalia->query($sql)->result();
	}

	public function getNamaJabatanUpah(){
		$sql = "SELECT distinct nama_jabatan from hrd_khs.tb_status_jabatan WHERE nama_jabatan!='' order by nama_jabatan";
		return $this->personalia->query($sql)->result();
	}
}	