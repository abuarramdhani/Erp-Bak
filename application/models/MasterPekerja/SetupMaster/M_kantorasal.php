<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// ini_set('memory_limit', '256M');
class M_kantorasal extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
	}

	public function getKantor(){
		$sql = "select * from hrd_khs.tkantor_asal order by id_ ASC";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getMaxKantor(){
		$sql = "select max(id_::int)+1 kode from hrd_khs.tkantor_asal;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertMasterKantor($arrdata){
		$this->personalia->insert("hrd_khs.tkantor_asal",$arrdata);
	}

	public function getMasterKantorByKd($kd){
		$sql = "select * from hrd_khs.tkantor_asal where id_ = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function updateMasterKantor($data,$where){
		$this->personalia->where('id_',$where['id_']);
		$this->personalia->where('kantor_asal',$where['kantor_asal']);
		$this->personalia->update("hrd_khs.tkantor_asal",$data);
	}

	public function insertLog($user,$kodeKantor,$masterKantor)
 {
   $query4 = "INSERT INTO hrd_khs.tlog
             (wkt, menu, ket, noind, jenis, program, noind_baru)
            VALUES
            (now(),
            'MASTER PEKERJA',
             'TAMBAH id_ = $kodeKantor  -> kantor_asal = $masterKantor',
             '$user',
            'TAMBAH KANTOR ASAL',
            'QUICK_ERP',
            ''
          ) ;";

   return $this->personalia->query($query4);
 }

 public function insertLoga($user,$kodeKantor,$kodeKantor1,$masterKantor,$masterKantor1)
{
	$query4 = "INSERT INTO hrd_khs.tlog
						(wkt, menu, ket, noind, jenis, program, noind_baru)
					 VALUES
					 (now(),
					 'MASTER PEKERJA',
						'DARI id_ = $kodeKantor1 kantor_asal = $masterKantor1 -> id_ = $kodeKantor kantor_asal = $masterKantor',
						'$user',
					 'EDIT KANTOR ASAL',
					 'QUICK_ERP',
					 ''
				 ) ;";

	return $this->personalia->query($query4);
}

} ?>
