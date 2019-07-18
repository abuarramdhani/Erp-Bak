<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// ini_set('memory_limit', '256M');
class M_masterlokasi extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
	}

	public function getLokasi(){
		$sql = "select * from hrd_khs.tlokasi_kerja order by id_ ASC";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getMaxLokasi(){
		$sql = "select max(id_::int)+1 kode from hrd_khs.tlokasi_kerja;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertMasterLokasi($arrdata){
		$this->personalia->insert("hrd_khs.tlokasi_kerja",$arrdata);
	}

	public function getMasterLokasiByKd($kd){
		$sql = "select * from hrd_khs.tlokasi_kerja where id_ = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function updateMasterLokasi($data,$where){
		$this->personalia->where('id_',$where['id_']);
		$this->personalia->where('lokasi_kerja',$where['lokasi_kerja']);
		$this->personalia->update("hrd_khs.tlokasi_kerja",$data);
	}


	public function insertLog($user,$kodeLokasi,$masterLokasi)
 {
   $query4 = "INSERT INTO hrd_khs.tlog
             (wkt, menu, ket, noind, jenis, program, noind_baru)
            VALUES
            (now(),
            'MASTER PEKERJA',
             'TAMBAH LOKASI id_ = $kodeLokasi  -> lokasi_kerja = $masterLokasi',
             '$user',
            'TAMBAH LOKASI KERJA',
            'QUICK_ERP',
            ''
          ) ;";

   return $this->personalia->query($query4);
 }

 public function insertLoga($user,$kodeLokasi,$kodeLokasi1,$masterLokasi,$masterLokasi1)
{
	$query4 = "INSERT INTO hrd_khs.tlog
						(wkt, menu, ket, noind, jenis, program, noind_baru)
					 VALUES
					 (now(),
					 'MASTER PEKERJA',
						'DARI id_ = $kodeLokasi1 lokasi_kerja = $masterLokasi1 -> id_ = $kodeLokasi lokasi_kerja = $masterLokasi',
						'$user',
					 'EDIT LOKASI KERJA',
					 'QUICK_ERP',
					 ''
				 ) ;";

	return $this->personalia->query($query4);
}

} ?>
