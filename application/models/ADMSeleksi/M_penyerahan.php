<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penyerahan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
		$this->mysql		=	$this->load->database('recruitment', TRUE);
	}

	public function getKodesie($kodesie = FALSE)
	{
		if ($kodesie != FALSE) {
			$param = "WHERE kodesie = '$kodesie'";
		} else {
			$param = '';
		}
		$sql = "SELECT * FROM hrd_khs.tseksi $param";
		return $this->personalia->query($sql)->result_array();
	}

	public function getSeksiCoallesce($kodesie)
	{
		$sql = "SELECT coalesce(seksi , unit, bidang, dept) as sie from hrd_khs.tseksi where kodesie = '$kodesie'";
		return $this->personalia->query($sql)->row()->sie;
	}

	public function getMaxNoindBaru()
	{
		return $this->personalia->query('SELECT max(noind_baru)::int as no_baru from hrd_khs.tpribadi')->row()->no_baru;
	}

	public function getJenisPenyerahan($kode)
	{
		$sql = "SELECT jenis FROM \"Surat\".tnoind_penyerahan where no_jenis = '$kode'";
		return $this->personalia->query($sql)->row()->jenis;
	}

	public function getDataShift($kode, $num)
	{
		$sql = "SELECT * FROM \"Presensi\".tjamshift where kd_shift = '$kode' and numhari = '$num'";
		return $this->personalia->query($sql)->result_array();
	}

	public function cekPekerjaDalamShift($tanggal, $noind, $kodesie)
	{
		$sql = "SELECT * from \"Presensi\".tshiftpekerja where tanggal::date = '$tanggal' and noind = '$noind' and kodesie = '$kodesie'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerjaan($kode)
	{
		$sql = "SELECT * FROM hrd_khs.tpekerjaan where kdpekerjaan like '$kode%' order by pekerjaan";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPemborong()
	{
		$sql = "SELECT * FROM hrd_khs.tasaloutsourcing order by asal_outsourcing";
		return $this->personalia->query($sql)->result_array();
	}

	public function getKebutuhan($kode, $trigger_tahun)
	{
		$tgl = date('Y');
		$sql = "SELECT distinct a.* FROM hrd_khs.tseksi a
				LEFT JOIN \"Adm_Seleksi\".tkebutuhan b on b.kodesie = a.kodesie
				LEFT JOIN \"Adm_Seleksi\".tberkas c on b.kodekebutuhan = c.kodekebutuhan
				where b.noind = '$kode' and c.kodekebutuhan not in ('', '-', 'x') and b.periode_butuh >= '$trigger_tahun'
				order by a.seksi";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataPekerjaBaruSP($kode, $text = false, $trigger_tahun)
	{
		if ($text == true) {
			$plus = "and (a.nama like '%$text%' or a.kodelamaran like '%$text%')";
		} else {
			$plus = "";
		}
		$tgl = date('Y');
		$sql = "SELECT a.kodelamaran, a.nama FROM \"Adm_Seleksi\".tberkas a
		 		LEFT JOIN \"Adm_Seleksi\".tkebutuhan b on trim(a.kodekebutuhan) = trim(b.kodekebutuhan) where b.kodesie = '$kode' $plus
				and b.periode_butuh >= '$trigger_tahun'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataPekerjaSP($text)
	{
		$sql = "SELECT distinct noind, trim(nama) as nama FROM hrd_khs.tpribadi where keluar = '1' and (nama like '%$text%' or noind like '%$text%') order by noind, nama";
		return $this->personalia->query($sql)->result_array();
	}

	public function getNoindMax($kode)
	{
		$sql = "SELECT
					 noind,
					 '$kode' || case when length((substring(noind, 2)::int + 1)::varchar(255)) = 5
					 then lpad((substring(noind, 2)::int + 1)::varchar(255),5,'0')
					 else
					 lpad((substring(noind, 2)::int + 1)::varchar(255),4,'0') end new
					from
					 hrd_khs.tpribadi tp
					where
					 left(noind, 1) = '$kode'
					 and noind not in (
					  select *
					 from
					  hrd_khs.tnoind_acak)
					order by
					 noind desc
					limit 1";
		return $this->personalia->query($sql)->result_array();
	}

	public function getNoindMaxC($kode)
	{
		$sql = "SELECT
					max(tp.noind) as new
				from
					hrd_khs.tpribadi tp
				where
					left(tp.noind, 3) = '$kode'
					and noind not in (
					select *
					from
					hrd_khs.tnoind_acak)";
		return $this->personalia->query($sql)->row()->new;
	}

	public function cekNoind($noind)
	{
		$sql = "SELECT trim(noind) from hrd_khs.tpribadi where noind in ('$noind')";
		return $this->personalia->query($sql)->result_array();
	}

	public function ambilDataAll($kodesie, $tanggal, $jenis, $ruangLingkup)
	{
		$sql = "SELECT  trim(b.noind) as noind,
						trim(b.noind)||' - '||trim(b.nama) as pekerja,
						a.kode,
						trim(b.nama) as nama,
						trim(a.kodesie) as kodesie,
						trim(c.seksi) as seksi,
						trim(a.noind_baru) as noind_baru
				FROM \"Surat\".tsurat_penyerahan a
				LEFT JOIN hrd_khs.tpribadi b on b.noind = a.noind
				LEFT JOIN hrd_khs.tseksi c on a.kodesie = c.kodesie
				where a.noind in (b.noind) AND a.kodesie = '$kodesie' AND a.tgl_masuk::date = '$tanggal' AND a.ruang_lingkup = '$ruangLingkup' AND (jenis_pkj = '$jenis' OR jenis_pkj is null)
				order by a.noind";
		return $this->personalia->query($sql)->result_array();
	}

	// public function ambilDataSudahDiserahkan($kode, $lingkup, $kodesie)
	// {
	// 	$sql = "SELECT distinct trim(b.tempat) as tempat,
	// 					trim(b.kodelamaran) as kd_lamaran,
	// 					trim(a.noind) as noind,
	// 					trim(a.nama) as nama,
	// 					trim(a.templahir) as templahir,
	// 					a.tgllahir,
	// 					trim(a.agama) as agama,
	// 					trim(a.jenkel) as jenkel,
	// 					trim(a.alamat) as alamat,
	// 					trim(a.kodepos) as kodepos,
	// 					trim(a.desa) as desa,
	// 					trim(a.kec) as kec,
	// 					trim(a.kab) as kab,
	// 					trim(a.prop) as prop,
	// 					trim(a.telepon) as telepon,
	// 					trim(a.nohp) as nohp,
	// 					trim(a.pendidikan) as pendidikan,
	// 					trim(a.jurusan) as jurusan,
	// 					trim(a.sekolah) as sekolah,
	// 					trim(upper(a.statnikah)) as statnikah,
	// 					trim(a.kodesie) as kodesie,
	// 					trim(a.tempat_makan) as tempat_makan,
	// 					trim(a.ruang) as ruang,
	// 					trim(a.kantor_asal) as kantor_asal,
	// 					trim(a.lokasi_kerja) as lokasi_kerja,
	// 					trim(a.nik) as nik,
	// 					trim(a.no_kk) as no_kk,
	// 					trim(a.nokeb) as nokeb
	// 			FROM hrd_khs.tpribadi a
	// 			LEFT JOIN \"Surat\".tsurat_penyerahan b on a.noind = b.noind and a.kodesie = b.kodesie and a.nama = b.nama
	// 			WHERE substr(b.noind, 1, 1) = '$kode' and b.kodesie = '$kodesie' and b.ruang_lingkup = '$lingkup' order by noind desc";
	// 	return $this->personalia->query($sql)->result_array();
	// }

	public function getShift()
	{
		$sql = "SELECT trim(kd_shift) as kd_shift, trim(shift) as shift FROM \"Presensi\".tshift order by kd_shift::int";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDetailBerkas($kodeLam)
	{
		$sql = "SELECT *, substr(jnskelamin, 1, 1)as jenkel FROM \"Adm_Seleksi\".tberkas where kodelamaran = '$kodeLam'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDetailPKJKHS($noind)
	{
		$sql = "SELECT trim(a.noind) as noind,
						trim(a.nama) as nama,
						trim(a.templahir) as templahir,
						a.tgllahir,
						trim(a.agama) as agama,
						trim(a.jenkel) as jenkel,
						trim(a.alamat) as alamat,
						trim(a.kodepos) as kodepos,
						trim(a.desa) as desa,
						trim(a.kec) as kec,
						trim(a.kab) as kab,
						trim(a.prop) as prop,
						trim(a.telepon) as telepon,
						trim(a.nohp) as nohp,
						trim(a.pendidikan) as pendidikan,
						trim(a.jurusan) as jurusan,
						trim(a.sekolah) as sekolah,
						trim(upper(a.statnikah)) as statnikah,
						trim(a.kodesie) as kodesie,
						trim(a.tempat_makan) as tempat_makan,
						trim(a.ruang) as ruang,
						trim(a.kantor_asal) as kantor_asal,
						trim(a.lokasi_kerja) as lokasi_kerja,
						trim(a.nik) as nik,
						trim(a.no_kk) as no_kk,
						trim(a.nokeb) as nokeb,
						b.kodelamaran,
						(SELECT pola_kombinasi from \"Presensi\".tpolapernoind d where d.noind = a.noind and d.kodesie = a.kodesie) as pola_shift FROM hrd_khs.tpribadi a
				LEFT JOIN \"Adm_Seleksi\".tberkas b on a.nik = b.nik or a.nama = b.nama
				LEFT JOIN \"Presensi\".tshiftpekerja c on a.noind = c.noind where a.keluar = '1' and a.noind = '$noind' order by a.noind ASC";
		return $this->personalia->query($sql)->result_array();
	}

	public function getKdJabatan($data)
	{
		$sql = "SELECT min(a.kd_jabatan) as kd_jabatan from hrd_khs.tpribadi a
				LEFT JOIN \"Surat\".tsurat_penyerahan b on a.noind = b.noind and a.kodesie = b.kodesie
				where b.kode in ('$data')";
		return $this->personalia->query($sql)->row()->kd_jabatan;
	}

	public function getKepada($kodesie, $kd_jabatan, $jenis)
	{
		if ($kd_jabatan >= '13') {
			$kd_jabatan = '13';
		}

		if ($jenis == '1') {
			$where = "and a.kd_jabatan <= '07'";
		} else if ($jenis == '6') {
			$where = "and a.kd_jabatan < '10'";
		} else {
			$where = "and a.kd_jabatan < '$kd_jabatan'";
		}
		$sql = "SELECT distinct a.kodesie, a.kd_jabatan, a.jabatan
				FROM hrd_khs.trefjabatan a
				left join hrd_khs.tpribadi b on a.noind in (b.noind) and b.kd_jabatan = a.kd_jabatan
				where a.jabatan is not NULL and a.kd_jabatan not in ('','-') and a.jabatan != '-' $where and b.keluar = '0' and (b.kodesie like '$kodesie[0]%' or b.kodesie = '$kodesie[1]')
				order by a.kd_jabatan desc, a.jabatan";
		return $this->personalia->query($sql)->result_array();
	}

	public function getAtasanDetail($kd_jabatan, $kodesie)
	{
		$sql = "SELECT t.jabatan 
				from hrd_khs.trefjabatan t
				where t.kd_jabatan = '$kd_jabatan' and t.kodesie = '$kodesie' and t.noind in (
					SELECT a.noind from hrd_khs.tpribadi a where t.noind = a.noind and a.keluar = '0' and t.kodesie = a.kodesie
				) limit 1";
		return $this->personalia->query($sql)->row()->jabatan;
	}

	public function getJabatanPreview($kodesie)
	{
		$sql = "SELECT case when trim(seksi) = '-' then case when trim(unit) = '-' then case when trim(bidang) = '-' then dept else bidang end else unit end else seksi end nama from hrd_khs.tseksi where kodesie = '$kodesie'";
		return $this->personalia->query($sql)->row()->nama;
	}

	public function getApproval()
	{
		$sql = "SELECT * from hrd_khs.tpribadi where keluar = '0' and kd_jabatan <= '13' and kd_jabatan != '' order by noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getTempatMakan()
	{
		$sql = "SELECT * from \"Catering\".ttempat_makan";
		return $this->personalia->query($sql)->result_array();
	}

	public function getLokasi()
	{
		$sql = "SELECT trim(id_) as id_ , trim(lokasi_kerja) as lokasi_kerja from hrd_khs.tlokasi_kerja order by id_::int";
		return $this->personalia->query($sql)->result_array();
	}

	public function getKantor()
	{
		$sql = "SELECT trim(id_) as id_, trim(kantor_asal) as kantor_asal from hrd_khs.tkantor_asal order by id_::int";
		return $this->personalia->query($sql)->result_array();
	}

	public function getjurusan()
	{
		$sql = "SELECT * FROM tb_jurusan2 order by id";
		return $this->mysql->query($sql)->result_array();
	}

	public function getSkul()
	{
		$sql = "SELECT kd_sek as id, sekolah as nama_univ from hrd_khs.tsekolah
				order by id";
		return $this->personalia->query($sql)->result_array();
	}
	public function getUniv()
	{
		$sql = "SELECT * FROM tb_univ
				order by id";
		return $this->mysql->query($sql)->result_array();
	}

	//get kode max
	public function getMaxCode()
	{
		return $this->personalia->query("SELECT max(kode)::int+1 as kode from \"Surat\".tsurat_penyerahan")->row()->kode;
	}

	//get no_surat
	public function cekNo_Sp($kode, $bulan)
	{
		$sql = "SELECT coalesce(no_surat, null) as surat from \"Surat\".tsurat_penyerahan where kode in ('$kode') and bulan = '$bulan' limit 1";
		return $this->personalia->query($sql)->row()->surat;
	}

	public function cekNo_Surat($bulanan, $kepada, $noind, $kode)
	{
		$sql = "SELECT b.no_surat as no_surat from \"Surat\".tsurat_penyerahan b
				where no_surat in (select no_surat from \"Surat\".tsurat a where hal_surat = 'PS' and kd_surat = 'KI-C' and a.bulan = b.bulan and tujuan = '$kepada' and a.no_surat = b.no_surat) and b.bulan = '$bulanan' and jenis_pkj = '$noind' and kode in ('$kode') limit 1";
		return $this->personalia->query($sql)->result_array();
	}

	public function getNoSurat2($bulan)
	{
		$sql = "SELECT case when no_surat is not null then 
					max(no_surat)::int + 1
				when no_surat = '000' then 
					'001'
				else
					'001'
				end as no_surat
				from \"Surat\".tsurat a where a.bulan = '$bulan' and a.kd_surat = 'KI-C' and a.hal_surat = 'PS'
				group by no_surat
				order by no_surat desc
				limit 1";
		return $this->personalia->query($sql)->row()->no_surat;
	}

	//get data preview pdf
	public function getDetailPreview($kode)
	{
		$sql = "SELECT distinct a.noind,
						trim(a.templahir) templahir,
						a.tgllahir,
						a.akhkontrak,
						a.diangkat,
						a.sekolah,
						a.asal_outsourcing,
						(select kantor_asal from hrd_khs.tkantor_asal where id_=a.kantor_asal) as kantor_asal,
						(select lokasi_kerja from hrd_khs.tlokasi_kerja where id_=a.lokasi_kerja) as lokasi_kerja,
						trim(a.nama) nama,
						trim(c.dept) dept,
						trim(c.unit) unit,
						trim(c.seksi) seksi,
						b.tgl_mulaiik,
						b.ruang_lingkup,
						b.jenis_pkj,
						b.lama_trainee,
						a.nokeb,
						trim(b.gol) as gol,
						d.tgl_masuk
				FROM hrd_khs.tpribadi a
				LEFT JOIN \"Surat\".tsurat_penyerahan b on b.noind = a.noind and b.kodesie = a.kodesie
				INNER JOIN hrd_khs.tseksi c on a.kodesie = c.kodesie
				LEFT JOIN \"Adm_Seleksi\".tb_pekerja_diangkat_versi_seleksi d on d.noind = a.noind and a.masukkerja::date = d.tgl_masuk::date
				where b.kode in ('$kode')
				ORDER BY a.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataLampiran($nokeb, $noind)
	{
		$sql = "SELECT a.noind, trim(a.nama) nama,
				a.nokeb,
				b.job_desk,
				b.alasan_pemenuhan
				from hrd_khs.tpribadi a
				LEFT JOIN \"Adm_Seleksi\".tkebutuhan b on b.kodekebutuhan = a.nokeb and b.kodesie = a.kodesie
				where a.nokeb in ('$nokeb') and a.noind in ('$noind')";
		return $this->personalia->query($sql)->result_array();
	}

	public function getStatusJabatan($kode)
	{
		$sql = "SELECT kd_hubker, (select trim(nama_status) from hrd_khs.tb_master_stat where kd_status = kd_hubker and tgl_tberlaku = '9999-12-31 00:00:00' limit 1) as status from hrd_khs.tset_jabatan where kode_induk = '$kode' order by kd_hubker limit 1";
		return $this->personalia->query($sql)->result_array();
	}

	public function getJabatanUpah($kode)
	{
		$sql = "SELECT kd_upah, trim(nama_jabatan) as nama_jabatan from hrd_khs.tset_jabatan a
				inner join hrd_khs.tb_master_jab b on kd_upah = kd_jabatan where kode_induk = '$kode' and tgl_tberlaku = '9999-12-31 00:00:00' order by kd_upah";
		return $this->personalia->query($sql)->result_array();
	}

	//Get data untuk edit
	public function getDataEdit($kode, $noind, $tanggal_cetak, $noind_baru)
	{
		$sql = "SELECT  trim(a.noind) as noind,
						trim(a.nama) as nama,
						trim(a.templahir) as templahir,
						a.tgllahir::date,
						trim(a.npwp) as npwp,
						trim(a.kd_jabatan) as kd_jabatan,
						trim(a.jabatan) as jabatan,
						trim(a.agama) as agama,
						trim(a.jenkel) as jenkel,
						trim(a.alamat) as alamat,
						trim(a.kodepos) as kodepos,
						trim(a.desa) as desa,
						trim(a.kec) as kec,
						trim(a.kab) as kab,
						trim(a.prop) as prop,
						trim(a.telepon) as telepon,
						trim(a.nohp) as nohp,
						trim(a.pendidikan) as pendidikan,
						trim(a.jurusan) as jurusan,
						trim(a.sekolah) as sekolah,
						trim(upper(a.statnikah)) as statnikah,
						trim(a.kodesie) as kodesie,
						trim(a.tempat_makan) as tempat_makan,
						trim(a.ruang) as ruang,
						trim(a.kantor_asal) as kantor_asal,
						trim(a.lokasi_kerja) as lokasi_kerja,
						trim(a.nik) as nik,
						trim(a.no_kk) as no_kk,
						trim(a.nokeb) as nokeb,
						trim(e.ruang_lingkup) as ruang_lingkup,
						b.kodelamaran,
						e.lama_trainee,
						e.lama_kontrak,
						e.tgl_mulaiik::date,
						e.tgl_masuk::date,
						e.jenis_pkj,
						(SELECT lama_orientasi from \"Adm_Seleksi\".tb_pekerja_diangkat_versi_seleksi where tgl_masuk = e.tgl_masuk and noind = e.noind and tgl_masuk::date = '$tanggal_cetak') as lama_orientasi,
						(SELECT tgl_diangkat::date from \"Adm_Seleksi\".tb_pekerja_diangkat_versi_seleksi where tgl_masuk = e.tgl_masuk and noind = e.noind and tgl_masuk::date = '$tanggal_cetak') as tgl_diangkat,
						(SELECT trim(kd_status) from hrd_khs.tb_status_jabatan where a.noind = noind and a.noind_baru = noind_baru and status_data = '02') as kd_status,
						(SELECT trim(nama_status) from hrd_khs.tb_status_jabatan where a.noind = noind and a.noind_baru = noind_baru and status_data = '02') as nama_status,
						(SELECT trim(kd_jabatan) from hrd_khs.tb_status_jabatan where a.noind = noind and a.noind_baru = noind_baru and status_data = '02') as jab_upah,
						f.*,
						case when a.kd_pkj != '' then (SELECT pekerjaan from hrd_khs.tpekerjaan where kdpekerjaan = a.kd_pkj) else '' end as pekerjaan,
						(SELECT trim(pola_kombinasi) from \"Presensi\".tpolapernoind d where d.noind = a.noind and d.kodesie = a.kodesie and d.noind_baru = '$noind_baru') as pola_shift
				FROM hrd_khs.tpribadi a
				LEFT JOIN \"Adm_Seleksi\".tberkas b on a.nik = b.nik or a.nama = b.nama
				LEFT JOIN \"Surat\".tsurat_penyerahan e on e.kodelamaran = b.kodelamaran
				LEFT JOIN hrd_khs.tseksi f on f.kodesie = a.kodesie
				where e.kode = '$kode' and a.noind = '$noind' order by a.noind ASC";
		return $this->personalia->query($sql)->result_array();
	}

	//untuk update
	public function updateStatusjabatan($stat_jab_upah, $noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tb_status_jabatan', $stat_jab_upah);
	}

	public function updateTpribadi($pribadi, $noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tpribadi', $pribadi);
	}

	public function updateTSuratPenyerahan($surat_penyerahan, $noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->update('"Surat".tsurat_penyerahan', $surat_penyerahan);
	}

	public function updatePolaNoind($noind, $shift, $kodesie)
	{
		$sql = "UPDATE \"Presensi\".tpolapernoind set pola_kombinasi = '$shift' where noind = '$noind' and kodesie = '$kodesie'";
		return $this->personalia->query($sql);
	}

	public function updateNoSurat($no_surat, $noind)
	{
		$sql = "UPDATE \"Surat\".tsurat_penyerahan set no_surat = '$no_surat' where kode in ('$noind')";
		return $this->personalia->query($sql);
	}

	//untuk insert
	public function insertTshiftPekerja($data)
	{
		$this->personalia->insert('"Presensi".tshiftpekerja', $data);
		return;
	}

	public function insertTtmpPribadi($data)
	{
		$this->personalia->insert('"FrontPresensi".ttmppribadi', $data);
		return;
	}

	public function insertTrefjabatan($data)
	{
		$this->personalia->insert('hrd_khs.trefjabatan', $data);
		return;
	}

	public function insertTpola($data)
	{
		$this->personalia->insert('"Presensi".tpolapernoind', $data);
		return;
	}

	public function insertPribadi($data)
	{
		$this->personalia->insert('hrd_khs.tpribadi', $data);
		return;
	}

	public function insertPekerjaVersiSeleksi($data)
	{
		$this->personalia->insert('"Adm_Seleksi".tb_pekerja_diangkat_versi_seleksi', $data);
		return;
	}

	public function insertTSuratPenyerahan($data)
	{
		$this->personalia->insert('"Surat".tsurat_penyerahan', $data);
		return;
	}

	public function insertToStatusJabatan($data)
	{
		$this->personalia->insert('hrd_khs.tb_status_jabatan', $data);
		return;
	}

	public function insertNomorSurat($data)
	{
		$this->personalia->insert('"Surat".tsurat', $data);
		return;
	}
}
