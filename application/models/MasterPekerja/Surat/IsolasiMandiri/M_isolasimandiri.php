<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_isolasimandiri extends CI_Model{
    	
    	public function __construct(){
	       parent::__construct();
	       $this->personalia = $this->load->database('personalia', TRUE);
	    }

	    public function getPekerjaByKey($key){
	    	$sql = "select noind,trim(nama) as nama
					from hrd_khs.tpribadi
					where keluar = '0'
					and (
						noind like upper(concat('%',?,'%'))
						or nama like upper(concat('%',?,'%'))
						)";
	    	return $this->personalia->query($sql,array($key,$key))->result_array();
	    }

	    public function getDetailPekerjaByNoind($noind){
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
			return $this->personalia->query($sql,array($noind))->result_array();
	    }

	    public function getSuratIsolasiMandiriTemplate(){
	    	$sql = "select isi_surat
					from \"Surat\".tisi_surat
					where lower(jenis_surat) = 'surat isolasi mandiri';";
			return $this->personalia->query($sql)->result_array();
	    }

	    public function insertSuratIsolasiMandiri($data){
	    	$this->personalia->insert("\"Surat\".tsurat_isolasi_mandiri", $data);
	    }

	    public function getSuratIsolasiMandiriAll(){
	    	$sql = "select 
				    	ts.no_surat,
				    	concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
				    	ts.tgl_wawancara,
				    	ts.tgl_cetak,
				    	ts.id_isolasi_mandiri
					from \"Surat\".tsurat_isolasi_mandiri ts
					left join hrd_khs.tpribadi tp 
					on ts.pekerja = tp.noind
					order by ts.created_timestamp desc ";
			return $this->personalia->query($sql)->result_array();
	    }

	    public function getSuratIsolasiMandiriById($id){
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
	    	return $this->personalia->query($sql,array($id))->result_array();
	    }

	    public function deleteSuratIsolasiMandiriByID($id){
	    	$this->personalia->where('id_isolasi_mandiri',$id);
	    	$this->personalia->delete("\"Surat\".tsurat_isolasi_mandiri");
	    }

	    public function getLastNoSuratByTanggalCetak($tanggal){
	    	$sql = "select max(split_part(no_surat,'/',1)::int) as nomor
					from \"Surat\".tsurat_isolasi_mandiri
					where to_char(tgl_cetak,'yyyy-mm') = to_char(?::date,'yyyy-mm')";
	    	return $this->personalia->query($sql,array($tanggal))->result_array();
	    }

	    public function updateSuratIsolasiMandiriByID($data,$id){
	    	$this->personalia->where('id_isolasi_mandiri',$id);
	    	$this->personalia->update("\"Surat\".tsurat_isolasi_mandiri", $data);
	    }

	}

?>