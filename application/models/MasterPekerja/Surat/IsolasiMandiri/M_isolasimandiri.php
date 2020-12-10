<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_isolasimandiri extends CI_Model
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
					where keluar = '0'
					and (
						noind like upper(concat('%',?,'%'))
						or nama like upper(concat('%',?,'%'))
						)";
		return $this->personalia->query($sql, array($key, $key))->result_array();
	}

	public function getDetailPekerjaByNoind($noind)
	{
		$sql = "select 
				    	noind,
				    	trim(nama) as nama,
				    	lokasi_kerja,
				    	nik,
				    	trim(ts.seksi) as seksi,
				    	jabatan,
				    	trim(ts.unit) as unit
					from hrd_khs.tpribadi tp 
					left join hrd_khs.tseksi ts 
					on tp.kodesie = ts.kodesie
					where noind = ?";
		return $this->personalia->query($sql, array($noind))->result_array();
	}

	public function getSuratIsolasiMandiriTemplate()
	{
		$sql = "select isi_surat
					from \"Surat\".tisi_surat
					where lower(jenis_surat) = 'surat isolasi mandiri';";
		return $this->personalia->query($sql)->result_array();
	}

	public function insertSuratIsolasiMandiri($data)
	{
		$this->personalia->insert("\"Surat\".tsurat_isolasi_mandiri", $data);
		return $this->personalia->insert_id();
	}

	public function getSuratIsolasiMandiriAll()
	{
		$sql = "select 
				    	ts.no_surat,
				    	concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
				    	ts.tgl_wawancara,
				    	ts.tgl_cetak,
				    	ts.id_isolasi_mandiri
					from \"Surat\".tsurat_isolasi_mandiri ts
					left join hrd_khs.tpribadi tp 
					on ts.pekerja = tp.noind
					where deleted_date is null
					order by ts.created_timestamp desc ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getSuratIsolasiMandiriById($id)
	{
		$sql = "select * ,
	    			(
						select trim(nama)
						from hrd_khs.tpribadi tp 
						where sim.pekerja = tp.noind 
					) as pekerja_nama,
					(
						select trim(nama)
						from hrd_khs.tpribadi tp 
						where sim.kepada = tp.noind 
					) as kepada_nama,
					(
						select trim(nama)
						from hrd_khs.tpribadi tp 
						where sim.tembusan = tp.noind 
					) as tembusan_nama,
					(
						select trim(nama)
						from hrd_khs.tpribadi tp 
						where sim.mengetahui = tp.noind 
					) as mengetahui_nama,
					(
						select trim(nama)
						from hrd_khs.tpribadi tp 
						where sim.menyetujui = tp.noind 
					) as menyetujui_nama,
					(
						select trim(nama)
						from hrd_khs.tpribadi tp 
						where sim.dibuat = tp.noind 
					) as dibuat_nama
			    	from \"Surat\".tsurat_isolasi_mandiri sim
			    	where id_isolasi_mandiri = ? ";
		return $this->personalia->query($sql, array($id))->result_array();
	}

	public function deleteSuratIsolasiMandiriByID($id)
	{
		$this->personalia->where('id_isolasi_mandiri', $id);
		$this->personalia->set('deleted_by', $this->session->user);
		$this->personalia->set('deleted_date', date('Y-m-d H:i:s'));
		$this->personalia->update("\"Surat\".tsurat_isolasi_mandiri");
	}

	public function getLastNoSuratByTanggalCetak($tanggal)
	{
		$sql = "select max(split_part(no_surat,'/',1)::int) as nomor
					from \"Surat\".tsurat_isolasi_mandiri
					where to_char(tgl_cetak,'yyyy-mm') = to_char(?::date,'yyyy-mm')";
		return $this->personalia->query($sql, array($tanggal))->result_array();
	}

	public function updateSuratIsolasiMandiriByID($data, $id)
	{
		$this->personalia->where('id_isolasi_mandiri', $id);
		$this->personalia->update("\"Surat\".tsurat_isolasi_mandiri", $data);
	}

	/*
	    	select 
		    	ts.no_surat,
		    	concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
		    	ts.tgl_wawancara,
		    	ts.tgl_cetak,
		    	ts.id_isolasi_mandiri
			from \"Surat\".tsurat_isolasi_mandiri ts
			left join hrd_khs.tpribadi tp 
			on ts.pekerja = tp.noind
			order by ts.created_timestamp desc
		*/

	var $table = '"Surat".tsurat_isolasi_mandiri';
	var	$column_order = array('tsurat_isolasi_mandiri.created_timestamp', 'tsurat_isolasi_mandiri.created_timestamp', 'tsurat_isolasi_mandiri.no_surat', 2, 'tsurat_isolasi_mandiri.tgl_wawancara', 'tsurat_isolasi_mandiri.tgl_cetak');
	var	$column_search = array('tpribadi.noind', 'tpribadi.nama', 'tsurat_isolasi_mandiri.no_surat');
	var $order = array('tsurat_isolasi_mandiri.created_timestamp' => 'asc');
	var $select = "	tsurat_isolasi_mandiri.no_surat,
				    	concat(tpribadi.noind,' - ',trim(tpribadi.nama)) as pekerja,
				    	tsurat_isolasi_mandiri.tgl_wawancara,
				    	tsurat_isolasi_mandiri.tgl_cetak,
				    	tsurat_isolasi_mandiri.id_isolasi_mandiri";

	public function user_table_query()
	{

		$this->personalia->select($this->select);
		$this->personalia->from($this->table);
		$this->personalia->where('deleted_date is null');
		$this->personalia->join('hrd_khs.tpribadi', 'tsurat_isolasi_mandiri.pekerja = tpribadi.noind', 'left');
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->personalia->group_start();
					$this->personalia->like($item, strtoupper($_POST['search']['value']));
				} else {
					$this->personalia->or_like($item, strtoupper($_POST['search']['value']));
				}
				if (count($this->column_search) - 1 == $i) {
					$this->personalia->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->personalia->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} elseif (isset($this->order)) {
			$order = $this->order;
			$this->personalia->order_by(key($order), $order[key($order)]);
		}
	}

	public function user_table()
	{
		$this->user_table_query();
		if ($_POST['length'] != -1) {
			$this->personalia->limit($_POST['length'], $_POST['start']);
			$query = $this->personalia->get();
			return $query->result();
		}
	}

	public function count_filtered()
	{
		$this->user_table_query();
		$query = $this->personalia->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->personalia->select($this->select);
		$this->personalia->from($this->table);
		$this->personalia->join('hrd_khs.tpribadi', 'tsurat_isolasi_mandiri.pekerja = tpribadi.noind', 'left');
		$query = $this->personalia->get();
		return $query->num_rows();
	}

	public function getdPresensi($noind, $tgl)
	{
		$sql = "select
					*
				from
					\"Presensi\".tdatapresensi
				where
					tanggal = '$tgl'
					and noind = '$noind' limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	public function insEditPresensi($data)
	{
		$this->personalia->insert_batch('"Presensi".tinput_edit_presensi', $data);
	}

	public function insTdataPresensi($data)
	{
		$this->personalia->insert_batch('"Presensi".tdatapresensi', $data);
	}

	public function delEditPres($noind, $awal, $akhir, $status)
	{
		$sql = "DELETE from \"Presensi\".tinput_edit_presensi where noind = '$noind' and tanggal1 >= '$awal' and tanggal1 <= '$akhir' and kd_ket = 'PRM'";
		// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $this->personalia->affected_rows();
	}

	public function delTdataPres($noind, $awal, $akhir, $status)
	{
		$sql = "DELETE from \"Presensi\".tdatapresensi where noind = '$noind' and tanggal >= '$awal' and tanggal <= '$akhir' and kd_ket = 'PRM'";
		// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $this->personalia->affected_rows();
	}

	public function getpkjID($isolasi_id)
	{
		$sql = "select
					*
				from
					cvd.cvd_pekerja
				where
					isolasi_id = '$isolasi_id'";
		return $this->db->query($sql)->row()->cvd_pekerja_id;
	}

	public function getAtasanIS($kd_pkj, $kst)
	{
		$sql = "SELECT
					*
				from
					hrd_khs.tpribadi
				where
					kd_jabatan < '$kd_pkj'
					and trim(kd_jabatan) != ''
					and kodesie like '$kst%'
					and keluar = false
					order by kd_jabatan desc";
			// echo $sql;exit();
		return $this->personalia->query($sql)->result_array();
	}

	public function getAtasanIS2($ks)
	{
		$sql = "SELECT * from
					hrd_khs.tpribadi t
				where
					kodesie like '$ks%'
					and keluar = false
					and left(noind, 1) in ('B', 'J', 'D')";
		return $this->personalia->query($sql)->result_array();
	}

	public function getShiftIs($noind, $start, $end)
	{
		$sql = "select
					*
				from
					\"Presensi\".tshiftpekerja
				where
					noind = '$noind'
					and tanggal between '$start' and '$end'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getTimIs($pkj, $awal, $akhir)
	{
		$sql = "select
					*
				from
					\"Presensi\".tdatatim t
				where
					noind = '$pkj'
					and point > 0
					and tanggal >= '$awal'
					and tanggal <= '$akhir'";
		return $this->personalia->query($sql)->result_array();
	}

	public function delTim($tglt, $wkt1, $wkt2, $pekerja)
	{
		$this->personalia->where('tanggal', $tglt);
		$this->personalia->where('masuk', $wkt1);
		$this->personalia->where('keluar', $wkt2);
		$this->personalia->where('noind', $pekerja);
		// echo $this->personalia->get_compiled_delete('"Presensi".tdatatim');
		$this->personalia->delete('"Presensi".tdatatim');
		return $this->personalia->affected_rows();
	}

	public function instoLog($data)
	{
		$this->personalia->insert('hrd_khs.tlog', $data);
	}

	public function getPresensiIs($noind, $mulai, $selesai)
	{
		$sql = "SELECT *, trim(alasan) alasan from \"Presensi\".tinput_edit_presensi
				where noind = '$noind' and tanggal1 between '$mulai' and '$selesai' and kd_ket in ('PRM', 'PSK')";
		return $this->personalia->query($sql)->result_array();
	}

	public function insWktIs($data)
	{
		$this->db->insert_batch('cvd.cvd_waktu_isolasi', $data);
	}

	public function getPresensiIsCvd($isID)
	{
		$this->db->where('isolasi_id', $isID);
		return $this->db->get('cvd.cvd_waktu_isolasi')->result_array();
	}

	public function getDataPresensiIs($pkj, $awal, $akhir)
	{
		$sql = "select
					*
				from
					\"Presensi\".tdatapresensi
				where
					noind = '$pkj'
					and tanggal between '$awal' and '$akhir'
					and kd_ket = 'PKJ'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getTliburIs($mulai, $selesai)
	{
		$sql = "SELECT * from \"Dinas_Luar\".tlibur where tanggal between '$mulai' and '$selesai'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getTembusanD($kst)
	{
		$sql = "select
					*
				from
					hrd_khs.tpribadi t
				where
					kodesie like '$kst%'
					and kd_jabatan < '10'
					and keluar = false
					order by kd_jabatan desc";
		return $this->personalia->query($sql)->result_array();
	}
}