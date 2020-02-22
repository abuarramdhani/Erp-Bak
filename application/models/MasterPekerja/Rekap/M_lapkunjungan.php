<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lapkunjungan extends CI_Model {
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

    public function getDataLapkun(){
		$sql = "SELECT tl.id_laporan, tl.tanggal_laporan, tl.no_surat, tl.noinduk_pekerja,
				(SELECT trim(nama) FROM hrd_khs.tpribadi where noind = tl.noinduk_pekerja) as nama_pekerja,
				(SELECT trim(ts.seksi) FROM hrd_khs.tpribadi tp join hrd_khs.tseksi ts on ts.kodesie = tp.kodesie where noind = tl.noinduk_pekerja) as seksi_pekerja,
				(SELECT concat(tl.noinduk_petugas, ' - ', nama) from hrd_khs.tpribadi where noind = tl.noinduk_petugas) as petugas
				FROM \"Surat\".t_lapkun tl order by tl.tanggal_laporan desc";
        return $this->personalia->query($sql)->result_array();
    }

	public function informasiPekerja($keyword){
        $sql = "select * from sys.vi_sys_user where user_name like '%$keyword%' or upper(employee_name) like '%$keyword%' order by user_id asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getInfoPekerja($keyword){
    	$sql ="SELECT tp.noind,rtrim(tp.nama) as nama,rtrim(alamat) as alamat, ts.seksi as seksi ,ts.unit as unit, tr.jabatan as jabatan FROM hrd_khs.tpribadi tp LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie INNER JOIN hrd_khs.trefjabatan tr ON tp.noind = tr.noind WHERE tp.noind LIKE '%$keyword%' or UPPER(tp.nama) LIKE '%$keyword%' AND tp.keluar = false;";
    	return $this->personalia->query($sql)->result_array();
    }

    public function getMaxNoSurat($bulanLaporan){
        $sql = "SELECT MAX(no_surat) as max_no_surat FROM \"Surat\".t_lapkun WHERE substr(TO_CHAR(tanggal_laporan,'YYYY-MM-DD'), 1, 7) = '$bulanLaporan'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getNomorSurat($bulanLaporan){
    	$sql 	= "SELECT * from \"Surat\".t_lapkun WHERE substr(TO_CHAR(tanggal_laporan,'YYYY-MM-DD'), 1, 7) = '$bulanLaporan' ";
    	$query  = $this->personalia->query($sql);
    	return $query->num_rows();
    }

    public function saveLaporan($data){
        $this->personalia->insert('Surat.t_lapkun',$data);
    }

    public function getDataPDF($id_laporan){
        $this->personalia->where('id_laporan',$id_laporan);
        return $this->personalia->get('Surat.t_lapkun')->result_array();
    }

    public function getLapkunPeriode($tanggal_awal,$tanggal_akhir){
        $sql = "SELECT tl.id_laporan, tl.tanggal_laporan, tl.no_surat, tl.noinduk_pekerja,
				(SELECT trim(nama) FROM hrd_khs.tpribadi where noind = tl.noinduk_pekerja) as nama_pekerja,
				(SELECT trim(ts.seksi) FROM hrd_khs.tpribadi tp join hrd_khs.tseksi ts on ts.kodesie = tp.kodesie where noind = tl.noinduk_pekerja) as seksi_pekerja,
				(SELECT concat(tl.noinduk_petugas, ' - ', nama) from hrd_khs.tpribadi where noind = tl.noinduk_petugas) as petugas
				from \"Surat\".t_lapkun tl WHERE tl.tanggal_laporan BETWEEN '$tanggal_awal' and '$tanggal_akhir' order by tl.no_surat asc";
        $query = $this->personalia->query($sql);
        return $query->result_array();

    }

    public function updateLaporanKunjungan($id_laporan,$data){
        $this->personalia->where('id_laporan',$id_laporan);
        $this->personalia->update('Surat.t_lapkun',$data);
    }

    public function deleteLaporan($id_laporan){
        $this->personalia->where('id_laporan',$id_laporan);
        $this->personalia->delete('Surat.t_lapkun');
    }

	public function getDataPribadi($noind)
	{
		$sql = "SELECT tp.noind, trim(tp.nama) as nama, tp.alamat, (SELECT jabatan from hrd_khs.trefjabatan where kodesie = tp.kodesie and noind = tp.noind and kd_jabatan = tp.kd_jabatan) as jabatan,
				(SELECT seksi from hrd_khs.tseksi where kodesie = tp.kodesie) as seksi
				FROM hrd_khs.tpribadi tp
				WHERE noind = '$noind'";
		return $this->personalia->query($sql)->result_array();
	}

};
