<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pekerjakeluar extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->personalia =	$this->load->database('personalia', TRUE);
		$this->erp = $this->load->database('erp_db', TRUE);
		$this->daerah	=	$this->load->database('daerah', TRUE);
	}

	public function getPekerja($keyword, $keluar)
	{
		$not_worker_code = ['M'];

		$query = $this->personalia
			->select('noind, trim(nama) nama')
			->where_not_in('substring(noind, 1, 1)', $not_worker_code)
			->group_start()
			->like('noind', $keyword, 'both')
			->or_like('nama', $keyword, 'both')
			->group_end();

		if ($keluar) {
			$query->where('keluar', $keluar);
		}
		$query->from('hrd_khs.tpribadi');
		// $query->limit(20); if load is too many, remove this

		return $query->get()->result_array();
	}

	public function getKontakPekerja($kontak)
	{
		$data = "select internal_mail,telkomsel_mygroup,external_mail,pidgin_account from er.er_employee_all";
		$query = $this->erp->query($data);
		return $query->result_array();
	}

	public function getPekerjaan($noind)
	{
		$data = "select (case 	when 	pri.kd_pkj is not null
 								then 	pri.kd_pkj || ' - ' || rtrim(tpekerjaan.pekerjaan)
								end
								) as pekerjaan,pri.kd_pkj as kd_pekerjaan,
								tpekerjaan.jenispekerjaan
								from hrd_khs.tpribadi as pri
								left join hrd_khs.tpekerjaan as tpekerjaan
								on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
								where pri.noind='$noind' limit 1";
		$query 	=	$this->personalia->query($data);
		return $query->row();
		// return $data;
	}

	public function getkdPekerja($pekerja, $kd_pekerjaan)
	{
		$kd_pekerjaan = substr($kd_pekerjaan, 0, 7);
		$sql = "select concat_ws(' - ', kdpekerjaan, pekerjaan) as pekerjaan, kdpekerjaan
					from hrd_khs.tpekerjaan as tpekerjaan
				where left(tpekerjaan.kdpekerjaan,7) like '$kd_pekerjaan%' and status='0'
 					order by kdpekerjaan asc";
		$query 	=	$this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataPekerja($noind)
	{
		$sql = "SELECT tp.*, tref.jabatan as jabatanref, tb.no_peserta as nokes, tk.no_peserta as noket,
						case when tf.namafaskes is null then tb.bpu when tf.namafaskes is not null then tf.namafaskes end as faskes
						FROM hrd_khs.tpribadi tp
						LEFT JOIN hrd_khs.trefjabatan tref on tp.noind = tref.noind and tp.kodesie = tref.kodesie
						LEFT JOIN hrd_khs.tbpjskes tb on tb.noind = tp.noind
						LEFT JOIN hrd_khs.tbpjstk tk on tk.noind = tp.noind
						LEFT JOIN hrd_khs.tfaskes tf on tf.kd_faskes=tb.bpu
						WHERE tp.noind = '$noind' limit 1";
		return $this->personalia->query($sql)->row();
	}

	public function kontakPekerja($noind)
	{
		$query = $this->erp
			->select('internal_mail, telkomsel_mygroup, external_mail, pidgin_account')
			->where('employee_code', $noind)
			->get('er.er_employee_all');
		return $query->row();
	}

	public function dataSeksi($kodesie)
	{
		$query = $this->personalia
			->where('kodesie', $kodesie)
			->limit(1)
			->get('hrd_khs.tseksi');
		return $query->row();
	}

	public function updateDataPekerja($data, $noind)
	{
		if (empty($data)) return;

		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tpribadi', $data);
		return;
	}

	public function updatePekerjaan($data, $noind)
	{
		if (empty($data)) return;

		// hrd_khs.tpekerjaan
		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tpekerjaan', $data);
		return;
	}

	public function updateEmployee($data, $noind)
	{
		if (empty($data)) return;

		$this->erp
			->where('employee_code', $noind)
			->update('er.er_employee_all', $data);
	}

	public function historyUpdatePekerja($history)
	{
		$this->personalia->insert('hrd_khs.tpribadi_log', $history);
	}

	public function insertLog($tlog)
	{
		$this->personalia->insert('hrd_khs.tlog', $tlog);
	}

	public function getProvinsi($provinsi)
	{
		$this->daerah->like('nama', $provinsi);
		$query = $this->daerah->get('provinsi');
		return $query->result_array();
	}

	public function getKabupaten($kabupaten, $id_prov)
	{
		$this->daerah->where('id_prov', $id_prov);
		$this->daerah->like('nama', $kabupaten);
		$query = $this->daerah->get('kabupaten');
		return $query->result_array();
	}

	public function getKecamatan($kecamatan, $id_kab)
	{
		$this->daerah->where('id_kab', $id_kab);
		$this->daerah->like('nama', $kecamatan);
		$query = $this->daerah->get('kecamatan');
		return $query->result_array();
	}

	public function getDesa($desa, $id_kec)
	{
		$this->daerah->where('id_kec', $id_kec);
		$this->daerah->like('nama', $desa);
		$query = $this->daerah->get('kelurahan');
		return $query->result_array();
	}

	public function ambilProv($prop)
	{
		$this->daerah->where('id_prov', $prop);
		$query = $this->daerah->get('provinsi');
		$result = $query->row();
		return $result ? $result->nama : '';
	}

	public function ambilKab($kab)
	{
		$this->daerah->where('id_kab', $kab);
		$query = $this->daerah->get('kabupaten');
		$result = $query->row();
		return $result ? $result->nama : '';
	}

	public function ambilKec($kec)
	{
		$this->daerah->where('id_kec', $kec);
		$query = $this->daerah->get('kecamatan');
		$result = $query->row();
		return $result ? $result->nama : '';
	}

	public function ambilDesa($desa)
	{
		$this->daerah->where('id_kel', $desa);
		$query = $this->daerah->get('kelurahan');
		$result = $query->row();
		return $result ? $result->nama : '';
	}

	/**
	 * Cari prov, keb, kec, kel(desa)
	 * @param String { $provinsi }
	 * @param String { $kabupaten }
	 * @param String { $kecamatan }
	 * @param String { $kelurahan }
	 * @return Array { Info daerah }
	 * 
	 * REFACTORING USING CI QUERY BUILDER PLEASE
	 */
	public function findLocation($provinsi, $kabupaten, $kecamatan, $kelurahan)
	{
		$provinsi = trim($provinsi);
		$kabupaten = trim($kabupaten);
		$kecamatan = trim($kecamatan);
		$kelurahan = trim($kelurahan);

		$rawQuery = "
			SELECT 
				prov.id_prov, 
				prov.nama provinsi, 
				kab.id_kab, 
				kab.nama kabupaten,
				kec.id_kec,
				kec.nama kecamatan,
				kel.id_kel,
				kel.nama kelurahan
			FROM 
				provinsi prov
				left join kabupaten kab on prov.id_prov = kab.id_prov
				left join kecamatan kec on kec.id_kab = kab.id_kab
				left join kelurahan kel on kel.id_kec = kec.id_kec
			WHERE 
				prov.nama like '%$provinsi%' and
				kab.nama like '%$kabupaten%' and
				kec.nama like '%$kecamatan%' and
				kel.nama like '%$kelurahan%'
			LIMIT 1
		";

		// return $this->daerah->query($rawQuery)->result_array();

		return $this->daerah
			->select("prov.id_prov, 
								prov.nama provinsi, 
								kab.id_kab, 
								kab.nama kabupaten,
								kec.id_kec,
								kec.nama kecamatan,
								kel.id_kel,
								kel.nama kelurahan")
			->from('provinsi prov')
			->join('kabupaten kab', 'prov.id_prov = kab.id_prov')
			->join('kecamatan kec', 'kec.id_kab = kab.id_kab')
			->join('kelurahan kel', 'kel.id_kec = kec.id_kec')
			->like('prov.nama', $provinsi, 'both')
			->like('kab.nama', $kabupaten, 'both')
			->like('kec.nama', $kecamatan, 'both')
			->like('kel.nama', $kelurahan, 'both')
			->limit(1)
			->get()
			->row();
	}

	public function getStatusJabatan($noind)
	{
		$empty = new stdClass();
		$empty->nama_jabatan = '';
		$empty->nama_status = '';

		$res = $this->personalia
			->select('nama_jabatan, nama_status')
			->where('noind', $noind)
			->get('hrd_khs.tb_status_jabatan');
		return $res->row() ?: $empty;
	}

	public function getLokasiKerja($id = null)
	{
		$query = $this->personalia->order_by('id_', 'ASC')->get('hrd_khs.tlokasi_kerja');
		return $query->result_array();
	}

	public function getSebabKeluar($id = null)
	{
		$query = $this->personalia->order_by('fs_no', 'ASC')->get('hrd_khs.tsebabkeluar');
		return $query->result_array();
	}

	public function getReffJabatan($noind = null)
	{
		$rawQuery = "
			SELECT 
			tj.*,
			coalesce(nullif(ts.seksi, '-'), nullif(ts.unit, '-'), nullif(ts.bidang, '-'), nullif(ts.dept, '-')) as seksi
			FROM hrd_khs.trefjabatan tj
			LEFT JOIN hrd_khs.tseksi ts on tj.kodesie = ts.kodesie
			WHERE tj.noind = '$noind'";

		return $this->personalia->query($rawQuery)->result_array();
	}

	public function getAllSeksi($noind, $param)
	{
		$rawQuery = "
			SELECT
				kodesie, 
				dept, 
				bidang, 
				unit, 
				seksi,
				coalesce(nullif(trim(seksi), '-'), nullif(trim(unit), '-'), nullif(trim(bidang), '-'), nullif(trim(dept), '-')) as seksi_name,
				(select tp.kd_jabatan
					from hrd_khs.tpribadi tp inner join hrd_khs.torganisasi tor on tor.kd_jabatan = tp.kd_jabatan 
					where tp.noind = '$noind') kd_jabatan,
				(select concat(upper(tor.jabatan), ' ', coalesce(nullif(trim(seksi), '-'), nullif(trim(unit), '-'), nullif(trim(bidang), '-'), nullif(trim(dept), '-')))
					from hrd_khs.tpribadi tp inner join hrd_khs.torganisasi tor on tor.kd_jabatan = tp.kd_jabatan 
					where tp.noind = '$noind') jabatan
			FROM hrd_khs.tseksi
			WHERE 
				kodesie like '$param%' or 
				dept like '$param%' or 
				bidang like '$param%' or 
				unit like '$param%' or 
				seksi like '$param%'
			ORDER BY
				kodesie ASC
			LIMIT 10
		";

		return $this->personalia->query($rawQuery)->result_array();
	}

	public function getListPekerja($kodesie)
	{
		$kodesie = substr($kodesie, 0, 7);
		$query = $this->personalia
			->like('kdpekerjaan', $kodesie, 'after')
			->get('hrd_khs.tpekerjaan');

		return $query->result_array();
	}
	// not used @DEPRECATED
	// private function getSeksiName($kodesie) {
	// 	$query =  $this->personalia
	// 		->where('kodesie', $kodesie)
	// 		->get('hrd_khs.tseksi')
	// 		->row()

	// 	return $query ? $query->
	// }
	private function getJabatan($noind, $kodesie)
	{
		$rawQuery = "
		SELECT 
			tp.kd_jbt_dl, 
			tp.kd_jabatan, 
			tp.noind_baru, 
			(select concat(trim(upper(tor.jabatan)), ' ', coalesce(nullif(trim(seksi), '-'), nullif(trim(unit), '-'), nullif(trim(bidang), '-'), nullif(trim(dept), '-'))) 
			from hrd_khs.tseksi t 
			where kodesie = '$kodesie'
			) as jabatan
		FROM 
			hrd_khs.tpribadi tp inner join hrd_khs.torganisasi tor on tor.kd_jabatan = tp.kd_jabatan 
		WHERE 
			tp.noind = '$noind'";

		return $this->personalia->query($rawQuery)->row();
	}

	public function deleteJabatan($noind, $kodesie)
	{
		return $this->personalia
			->where('noind', $noind)
			->where('kodesie', $kodesie)
			->delete('hrd_khs.trefjabatan');
	}

	public function insertJabatan($noind, $kodesie)
	{
		$jabatan = $this->getJabatan($noind, $kodesie);

		$data = array(
			'noind' => $noind,
			'kodesie' => $kodesie,
			'kd_jabatan' => $jabatan->kd_jabatan,
			'jabatan' => $jabatan->jabatan,
			'kd_jbt_dl' => $jabatan->kd_jbt_dl,
			'noind_baru' => $jabatan->noind_baru
		);

		return $this->personalia->insert('hrd_khs.trefjabatan', $data);
	}

	public function updateJabatan($noind, $kodesie_from, $kodesie_to)
	{
		$jabatan = $this->getJabatan($noind, $kodesie_to);

		$data = array(
			'noind' => $noind,
			'kodesie' => $kodesie_to,
			'kd_jabatan' => $jabatan->kd_jabatan,
			'jabatan' => $jabatan->jabatan,
			'kd_jbt_dl' => $jabatan->kd_jbt_dl,
			'noind_baru' => $jabatan->noind_baru
		);

		return $this->personalia
			->where('noind', $noind)
			->where('kodesie', $kodesie_from)
			->update('hrd_khs.trefjabatan', $data);
	}

	public function updateLokasiKerja($noind, $asal, $loker)
	{
		return $this->personalia
			->where('noind', $noind)
			->set('kantor_asal', $asal)
			->set('lokasi_kerja', $loker)
			->update('hrd_khs.tpribadi');
	}

	public function getListJabatanDL()
	{
		return $this->personalia
			->get('DL.tjbt_dl')
			->result_array();
	}

	/**
	 * GET master keluarga, like jenis anggota keluarga
	 * @param null
	 * @return Array { Master Anggota Keluarga }
	 */
	public function getListAnggotaKeluarga()
	{
		return $this->personalia
			->get('hrd_khs.tmasterkel')
			->result_array();
	}

	/**
	 * old function name is getAnggotaKeluarga
	 * GET hrd_khs.tkeluarga
	 * @param String { Noind }
	 * @return Array { Data Anggota Keluarga }
	 */
	public function getFamily($noind)
	{
		return $this->personalia
			->select("
			noind, 
			tk.nokel,
			trim(nama) nama, 
			trim(alamat) alamat, 
			tgllahir, 
			ditanggung, 
			trim(keterangan) keterangan, 
			trim(status) status, 
			trim(noind_baru) noind_baru,
			trim(nik) nik,
			trim(statusbpjs) statusbpjs,
			trim(stattanggunganpajak) stattanggunganpajak,
			trim(jenisanggota) jenisanggota")
			->from('hrd_khs.tkeluarga tk')
			->join('hrd_khs.tmasterkel tm', 'tk.nokel = tm.nokel')
			->where('noind', $noind)
			->order_by('tk.nokel')
			->get()
			->result_array();
	}

	/**
	 * Tambah anggota keluarga
	 * @param Array { new Data anggota keluarga }
	 * @return Object { void }
	 */
	public function insertFamily($data)
	{
		return $this->personalia
			->insert('hrd_khs.tkeluarga', $data);
	}

	/**
	 * Update anggota keluarga
	 * @param String { Noind }
	 * @param String { No Keluarga }
	 * @param Array { New Anggota Keluarga }
	 * @return Boolean
	 */
	public function updateFamily($noind, $nokel, $data)
	{
		// delete && insert
		return $this->deleteFamily($noind, $nokel) && $this->insertFamily($data);
		// or u can change this to update query
	}

	/**
	 * Hapus salah 1 anggota keluarga
	 * @param String { Noind }
	 * @param String { Nomor Anggota Keluarga }
	 * @return Object { void }
	 */
	public function deleteFamily($noind, $nokel)
	{
		return $this->personalia
			->where(array(
				'noind' => $noind,
				'nokel' => $nokel
			))->delete('hrd_khs.tkeluarga');
	}

	/**
	 * Hitung jumlah anak & jumlah saudara
	 * Update tpribadi jumlah anak & jumlah saudara
	 * 
	 * @param String { Noind }
	 * @return Object { Count of child & sibling }
	 */
	public function getFamilyCount($noind)
	{
		// family code
		$childCode = '05';
		$siblingCode = '06';

		// get list of family
		$listOfFamily = $this->getFamily($noind);

		// count family
		$countChilds = array_reduce($listOfFamily, function ($carry, $item) use ($childCode) {
			$carry += substr($item['nokel'], 0, 2) == $childCode ? 1 : 0;
			return $carry;
		});

		$countSiblings = array_reduce($listOfFamily, function ($carry, $item) use ($siblingCode) {
			$carry += substr($item['nokel'], 0, 2) == $siblingCode ? 1 : 0;
			return $carry;
		});

		// return object of value
		return (object) [
			'count_childs' => $countChilds ?: 0,
			'count_siblings' => $countSiblings ?: 0
		];
	}

	/**
	 * Mengupdate jumlah anak & saudara di tpribadi
	 * 
	 * @param String $noind
	 * @return Object of CI Builder
	 */
	public function updateCountFamily($noind)
	{
		// object
		$counter = $this->getFamilyCount($noind);

		return $this->personalia
			->where('noind', $noind)
			->update('hrd_khs.tpribadi', [
				'jumanak' => $counter->count_childs,
				'jumsdr' => $counter->count_siblings
			]);
	}

	/**
	 * @param String { Nomor Induk }
	 * @param String { Memo Ke }
	 * @return Object of Array
	 */
	public function getOneMemoOrientation($noind, $ke)
	{
		$sql = "SELECT 
							a.noind,
							a.nama, 
							b.seksi, 
							b.unit, 
							a.masukkerja::date, 
							a.diangkat::date, 
							a.akhkontrak::date, 
							c.mulai::date, 
							c.akhir::date, 
							a.kodesie, 
							(extract(year from age((c.akhir + interval '1 day'),c.mulai::date)) * 12 + extract(month from age((c.akhir + interval '1 day'), c.mulai::date))) as lama_perpanjangan, 
							(extract(year from age((a.akhkontrak + interval '1 day'), a.diangkat::date)) * 12 + extract(month from age((a.akhkontrak + interval '1 day'),a.diangkat::date))) as lama_kontrak 
						FROM 
							hrd_khs.tpribadi a inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
							left join hrd_khs.tperpanjanganorientasi c on a.noind=c.noind
						WHERE 
							a.noind='$noind' AND c.ke='$ke'
						LIMIT 1;";
		return $this->personalia->query($sql)->row();
	}

	/**
	 * Get kasie
	 * @param String { Kodesie seksi }
	 * @return Array<Array> { Atasan }
	 */
	public function getAtasanSeksi($kodesie = false, $noind = false)
	{
		$kodesie_atasan = substr($kodesie, 0, 7);
		$kd_jabatan = '13';

		$query = $this->personalia
			->distinct()
			->select('tp.noind, tp.nama, tj.jabatan')
			->from('hrd_khs.tpribadi tp')
			->join('hrd_khs.trefjabatan tj', 'tp.noind = tj.noind')
			->where('tp.keluar', '0')
			->like('tj.kodesie', $kodesie_atasan, 'after')
			->where('tp.kd_jabatan <=', $kd_jabatan);

		if ($noind) {
			$query->where('tp.noind', $noind);
			return $query->get()->result_array()[0];
		}

		return $query->get()->result_array();
	}


	/**
	 * Get all kasie seksi hubungan kerja
	 * @param String { Noind atasan }
	 * @return Array { Atasan }
	 */
	public function getAtasanHubker($noind = false)
	{
		$kodesie_atasan = "401010100";
		$kd_jabatan = '13';

		$query = $this->personalia
			->distinct()
			->select('tp.noind, tp.nama, tj.jabatan')
			->from('hrd_khs.tpribadi tp')
			->join('hrd_khs.trefjabatan tj', 'tp.noind = tj.noind');

		if ($noind) {
			$query->where('tp.noind', $noind);
			return $query->get()->result_array()[0];
		} else {
			$query
				->where(array(
					'tp.keluar' => '0',
					'tj.kodesie' => $kodesie_atasan,
				))
				->where('tp.kd_jabatan <=', $kd_jabatan);
			return $query->get()->result_array();
		}
	}

	/**
	 * Get atasan jabatan diatas KASIE UTAMA
	 * 
	 * @param String { noind }
	 * @return Array { Atasan }
	 */
	public function getAtasan3($noind = false)
	{
		$kd_jabatan_kasie_utama = '10';

		$query = $this->personalia
			->distinct()
			->where('tp.kd_jabatan <= ', $kd_jabatan_kasie_utama)
			->where_not_in('tp.kd_jabatan', ['-', '1', '01', ''])
			->where('tp.keluar', '0');

		if ($noind) {
			$query
				->select('tp.noind, tp.nama, to.jabatan')
				->from('hrd_khs.tpribadi tp')
				->join('hrd_khs.torganisasi to', 'tp.kd_jabatan = to.kd_jabatan')
				->where('tp.noind', $noind)
				->limit(1);

			return $query->get()->row();
		} else {
			$query
				->select('tp.noind, tp.nama')
				->from('hrd_khs.tpribadi tp')
				// ->join('hrd_khs.trefjabatan tj', 'tp.noind = tj.noind')
				->where('tp.kd_jabatan <= ', $kd_jabatan_kasie_utama);
		}

		return $query->get()->result_array();
	}

	/**
	 * Get All Perpanjangan memo orientasi by noind
	 * @param String { Noind }
	 * @return Array { Memo }
	 */
	public function getMemoOrientation($noind)
	{
		return $this->personalia
			->where('noind', $noind)
			->order_by('ke', 'ASC')
			->get('hrd_khs.tperpanjanganorientasi')
			->result_array();
	}

	/**
	 * Get jumlah memo perpanjang orientasi pekerja
	 * @param String { Noind }
	 * @return Integer { Jumlah }
	 */
	public function getCountMemoOrientasi($noind)
	{
		return $this->personalia
			->where('noind', $noind)
			->from('hrd_khs.tperpanjanganorientasi')
			->count_all_results();
	}

	/**
	 * INSERT Memo Perpanjangan Orientasi
	 * @param Array { Data }
	 * @return void
	 */
	public function insertMemoOrientasi($data)
	{
		$this->personalia->insert('hrd_khs.tperpanjanganorientasi', $data);
	}

	/**
	 * GET last column id memo perpanjangan orientasi
	 * @param undefined
	 * @return String { id }
	 */
	public function getLastIdMemoOrientasi()
	{
		return $this->personalia
			->order_by('id', 'DESC')
			->limit(1)
			->get('hrd_khs.tperpanjanganorientasi')
			->row()
			->id;
	}

	/**
	 * Update/Insert tabel hrd_khs.tketerangan
	 * @param String { Noind }
	 * @param Boolean { Stat }
	 */
	public function updateTKeterangan($noind, $status)
	{
		/**
		 * Algorthm
		 * Jika ada data maka update, jika tidak ada maka insert
		 */
		$ket = $status ? 1 : 0;
		$sql = "
				UPDATE hrd_khs.keterangan SET ket = '$ket' WHERE noind = '$noind';
				INSERT INTO hrd_khs.keterangan (noind, ket)
					SELECT '$noind', '$ket'
					WHERE NOT EXISTS (SELECT * FROM hrd_khs.keterangan WHERE noind = '$noind');
		";
		return $this->personalia->query($sql);
	}

	/**
	 * Get Keterangan , tabel hrd_khs.keterangan
	 * @param String { Noind }
	 * @return Boolean
	 */
	public function getTKeterangan($noind)
	{
		$query = $this->personalia
			->where('noind', $noind)
			->get('hrd_khs.keterangan')
			->result_array();

		return @($query['0']['ket']) == 1;
	}

	/**
	 * Check is pekerja keluar
	 * @param String { Noind }
	 * @return Boolean
	 */
	public function checkPekerjaKeluar($noind)
	{
		return $this->personalia
			->where('noind', $noind)
			->get('hrd_khs.treffkeluar')
			->result_array() ? true : false;
	}

	/**
	 * Get tgl keluar
	 * @param String { Noind }
	 * @return String { Date }
	 */
	public function getTanggalKeluarPekerja($noind)
	{
		return @$this->personalia
			->select('tglkeluar')
			->where('noind', $noind)
			->get('hrd_khs.tpribadi')
			->row()->tglkeluar ?: '1900-01-01';
	}

	/**
	 * Update/Insert tabel hrd_khs.treffkeluar
	 * @param String { Noind }
	 * @param String { Tanggal hapus }
	 * @param String { Tanggal hapus gaji }
	 */
	public function updatePekerjaKeluar($noind, $tglhapus, $tglhapusgaji)
	{
		$sqlTreffKeluar = "
				UPDATE hrd_khs.treffkeluar SET tanggalhapus = '$tglhapus', tanggalhapusgaji = '$tglhapusgaji' WHERE noind = '$noind';
				INSERT INTO hrd_khs.treffkeluar (noind, tanggalhapus, tanggalhapusgaji)
					SELECT '$noind', '$tglhapus', '$tglhapusgaji'
					WHERE NOT EXISTS (SELECT * FROM hrd_khs.treffkeluar WHERE noind = '$noind');
		";

		$sqlTpekerjaKeluar = "
				INSERT into hrd_khs.tpekerjakeluar
            (
							noind,
							nama,
							lokasi,
							jenkel,
							agama,
							templahir,
							tgllahir,
							goldarah,
							alamat,
							desa,
							kec,
							kab,
							prop,
							kodepos,
							denahrumah,
							statrumah,
							telepon,
							nohp,
							gelard,
							gelarb,
							pendidikan,
							jurusan,
							sekolah,
							statnikah,
							tglnikah,
							jumanak,
							jumsdr,
							diangkat,
							masukkerja,
							kodesie,
							golkerja,
							kd_jabatan,
							jabatan,
							npwp,
							lmkontrak,
							akhkontrak,
							statpajak,
							jtanak,
							jtbknanak,
							tglspsi,
							nospsi,
							tglkop,
							nokoperasi,
							tglkeluar,
							sebabklr,
							photo,
							path_photo,
							tempat_makan,
							tempat_makan1,
							tempat_makan2
						)
          SELECT
						noind,
						nama,
						lokasi,
						jenkel,
						agama,
						templahir,
						tgllahir,
						goldarah,
						alamat,
						desa,
						kec,
						kab,
						prop,
						kodepos,
						denahrumah,
						statrumah,
						telepon,
						nohp,
						gelard,
						gelarb,
						pendidikan,
						jurusan,
						sekolah,
						statnikah,
						tglnikah,
						jumanak,
						jumsdr,
						diangkat,
						masukkerja,
						kodesie,
						golkerja,
						kd_jabatan,
						jabatan,
						npwp,
						lmkontrak,
						akhkontrak,
						statpajak,
						jtanak,
						jtbknanak,
						tglspsi,
						nospsi,
						tglkop,
						nokoperasi,
						tglkeluar,
						sebabklr,
						photo,
						path_photo,
						tempat_makan,
						tempat_makan1,
						tempat_makan2
					FROM hrd_khs.tpribadi
					WHERE noind = '$noind' and NOT EXISTS (SELECT * FROM hrd_khs.tpekerjakeluar WHERE noind = '$noind')";

		return $this->personalia->query($sqlTreffKeluar) && $this->personalia->query($sqlTpekerjaKeluar);
	}

	/**
	 * Ubah data tpribadi menurut data pribadi no ind lain
	 * @param String { noind target }
	 * @param String { noind tujuan }
	 * @return Void
	 */
	public function replacePribadi($from, $to)
	{
		$data_dest = $this->personalia
			->select('lokasi, jenkel, agama, templahir, tgllahir, goldarah, alamat, desa, kec, kab, prop, kodepos, denahrumah, statrumah, telepon, nohp, gelard, gelarb, pendidikan, jurusan, sekolah, statnikah, tglnikah, jumanak, jumsdr, statpajak, jtanak, jtbknanak, statusrekening, almt_kost, kd_pkj, golkerja, npwp, nik, email')
			->from('hrd_khs.tpribadi')
			->where('noind', $to)
			->get()
			->row();

		$replace = $this->personalia
			->where('noind', $from)
			->update('hrd_khs.tpribadi', $data_dest);
	}

	/**
	 * Ubah data keluarga menurut data keluarga noind lain
	 * @param String { noind target }
	 * @param String { noind tujuan }
	 * @return Void
	 */
	public function replaceKeluarga($from, $to)
	{
		$data_dest = (array)$this->personalia
			->get_where('hrd_khs.tkeluarga', ['noind' => $to])
			->result_array();

		$delete = $this->personalia
			->where('noind', $from)
			->delete('hrd_khs.tkeluarga');

		$dataWithNoind = array_map(function ($item) use ($from) {
			$item['noind'] = $from;
			return $item;
		}, $data_dest);

		$insert = $this->personalia
			->insert_batch('hrd_khs.tkeluarga', $dataWithNoind);
	}

	/**
	 * Ubah data jamsostek menurut data jamsostek noind lain
	 * @param String { noind target }
	 * @param String { noind tujuan }
	 * @return Void
	 */
	public function replaceJamsostek($from, $to)
	{
		$data_dest = (array)$this->personalia
			->where('noind', $to)
			->from('hrd_khs.tjamsostek')
			->limit(1)
			->get()
			->row();

		// change the key
		$data_dest['noind'] = $from;
		$data_dest['noind_baru'] = null; // why null?

		$update = $this->personalia
			->where('noind', $from)
			->update('hrd_khs.tjamsostek', $data_dest);
	}

	/**
	 * Ubah data jamsostek menurut data jamsostek noind lain
	 * @param String { noind target }
	 * @param String { noind tujuan }
	 * @return Void
	 */
	public function replaceBPJSKes($from, $to)
	{
		$data_dest = (array)$this->personalia
			->where('noind', $to)
			->from('hrd_khs.tbpjskes')
			->limit(1)
			->get()
			->row();

		// change the key
		$data_dest['noind'] = $from;
		$data_dest['noind_baru'] = $this->personalia
			->where('noind', $to)
			->from('hrd_khs.tpribadi')
			->get()
			->row()
			->noind_baru;

		$update = $this->personalia
			->where('noind', $from)
			->update('hrd_khs.tbpjskes', $data_dest);
	}

	/**
	 * Ubah data jamsostek menurut data jamsostek noind lain
	 * @param String { noind target }
	 * @param String { noind tujuan }
	 * @return Void
	 */
	public function replaceBPJSKet($from, $to)
	{
		$data_dest = (array)$this->personalia
			->where('noind', $to)
			->from('hrd_khs.tbpjstk')
			->limit(1)
			->get()
			->row();

		// change the key
		$data_dest['noind'] = $from;
		$data_dest['noind_baru'] = $this->personalia
			->where('noind', $to)
			->from('hrd_khs.tpribadi')
			->get()
			->row()
			->noind_baru;

		$update = $this->personalia
			->where('noind', $from)
			->update('hrd_khs.tbpjstk', $data_dest);
	}

	public function getLpkwt($noind)
	{
		$this->personalia->where('noind', $noind);
		return $this->personalia->get('hrd_khs.tperpanjangan_pkwt')->result_array();
	}

	public function getLpkwt2($noind)
	{
		$sql = "SELECT * from hrd_khs.tperpanjangan_pkwt where noind = '$noind' order by id_perpanjangan desc limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	public function insPPJ($data)
	{
		$this->personalia->insert('hrd_khs.tperpanjangan_pkwt', $data);
		return $this->personalia->insert_id();
	}

	public function upktkklr($data, $noind)
	{
		$this->personalia->where('noind', $noind);
		$this->personalia->update('hrd_khs.tpribadi', $data);
	}

	public function upPPJ($data, $id)
	{
		$this->personalia->where('id_perpanjangan', $id);
		$this->personalia->update('hrd_khs.tperpanjangan_pkwt', $data);
	}

	public function getMaxtpkwt($noind)
	{
		$sql = "SELECT max(id_perpanjangan) from hrd_khs.tperpanjangan_pkwt tp
				where noind = 'T0007'";
		return $this->personalia->query($sql)->row()->max;
	}

	public function getNoindPPJ($id)
	{
		$sql = "SELECT noind from hrd_khs.tperpanjangan_pkwt where id_perpanjangan = $id";
		return $this->personalia->query($sql)->row()->noind;
	}

	public function delPPJ($id)
	{
		$this->personalia->where('id_perpanjangan', $id);
		$this->personalia->delete('hrd_khs.tperpanjangan_pkwt');
	}
}
