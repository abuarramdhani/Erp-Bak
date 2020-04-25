<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_tugas extends CI_Model{
    	
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
				    	concat(alamat,', ',desa,', ',kec,', ',kab,', ',prop,', ',kodepos) as alamat, 
				    	case when lokasi_kerja in ('01','03','04') then 'Jl. Magelang 144 Yogyakarta' 
				    	when lokasi_kerja = '02' then 'Tuksono, Sentolo, Kulon Progo' 
				    	else 'tidak diketahui' end as lokasi_kerja_text
					from hrd_khs.tpribadi tp 
					left join hrd_khs.tseksi ts 
					on tp.kodesie = ts.kodesie
					where noind = ?";
			return $this->personalia->query($sql,array($noind))->result_array();
	    }

	    public function getSuratTugasTemplate(){
	    	$sql = "select isi_surat
					from \"Surat\".tisi_surat
					where jenis_surat = 'surat tugas';";
			return $this->personalia->query($sql)->result_array();
	    }

	    public function insertSuratTugas($data){
	    	$this->personalia->insert('"Surat".tsurat_tugas',$data);
	    	return $this->personalia->insert_id();
	    }

	    public function getSuratTugasAll(){
	    	$sql = "select 
				    	ts.no_surat,
				    	concat(ts.noind,' - ',trim(tp.nama)) as pekerja,
				    	ts.tgl_dibuat,
				    	ts.tgl_dicetak,
				    	ts.surat_tugas_id
					from \"Surat\".tsurat_tugas ts
					left join hrd_khs.tpribadi tp 
					on ts.noind = tp.noind
					order by ts.tgl_dibuat desc ";
			return $this->personalia->query($sql)->result_array();
	    }

	    public function getSuratTugasById($id){
	    	$sql = "select isi_surat 
			    	from \"Surat\".tsurat_tugas
			    	where surat_tugas_id = ? ";
	    	return $this->personalia->query($sql,array($id))->result_array();
	    }

	    public function deleteSuratTugasByID($id){
	    	$this->personalia->where('surat_tugas_id',$id);
	    	$this->personalia->delete("\"Surat\".tsurat_tugas");
	    }

	}

?>