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
}
