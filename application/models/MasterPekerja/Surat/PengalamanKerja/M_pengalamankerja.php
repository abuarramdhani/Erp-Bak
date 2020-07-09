<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_pengalamankerja extends CI_Model{
    	
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



	    public function detailPekerja($noind)
	 	{
	 		$getDetailPekerja 		= "select noind, nama, kd_jabatan, masukkerja::date,akhkontrak::date, alamat,desa,kec,kab,nik,
	 		                           dept, bidang, unit, seksi
					                    from hrd_khs.tpribadi a
					                    inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
					                   where noind = '$noind'";

			$query 	=	$this->personalia->query($getDetailPekerja);
			return $query->result_array();
			 //return $DetailPekerjaan;

		}

		public function getSuratPengalamanKerjaAll(){
	    	$sql = "select 
				    	ts.kd_surat,
				    	no_surat,
				    	concat(tp.noind,' - ',trim(tp.nama)) as pekerja,
				    	ts.isi_surat,
				    	ts.tgl_kena::date,
				        ts.kodesie,
				    	ts.tgl_cetak::date,
				    	ts.tgl_surat::date,
				    	ts.cetak,
				    	ts.alamat
					from \"Surat\".tsurat_pengalaman ts
					left join hrd_khs.tpribadi tp 
					on ts.noind = tp.noind
					order by ts.tgl_kena desc ";
			return $this->personalia->query($sql)->result_array();
	    }	

	}

?>