<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pekerjatidakmakan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getpekerjaByKey($key){
    	$sql = "select noind,trim(nama) as nama
    			from hrd_khs.tpribadi 
    			where (
    				upper(trim(nama)) like upper(trim(concat('%',?,'%')))
    				or upper(trim(noind)) like upper(trim(concat(?,'%'))) 
    			)
    			and keluar = '0'";
    	return $this->personalia->query($sql,array($key,$key))->result_array();
    }

    public function insertPekerjaTidakMakan($data){
    	$this->personalia->insert('"Catering".t_permintaan_tidak_makan', $data);
    }

    public function getPekerjaTidakMakanAll(){
    	$sql = "select t1.*,trim(t2.nama) as nama
				from \"Catering\".t_permintaan_tidak_makan t1 
				left join hrd_khs.tpribadi t2
				on t1.pekerja = t2.noind
				order by t1.dari desc, t1.sampai desc, t1.pekerja";
    	return $this->personalia->query($sql)->result_array();
    }

    public function deletePekerjaTidakMakanById($id){
    	$this->personalia->where('permintaan_id', $id);
    	$this->personalia->delete('"Catering".t_permintaan_tidak_makan');
    }

    public function getPekerjaTidakMakanById($id){
    	$sql = "select t1.*,trim(t2.nama) as nama
				from \"Catering\".t_permintaan_tidak_makan t1 
				left join hrd_khs.tpribadi t2
				on t1.pekerja = t2.noind
				where t1.permintaan_id = ?";
    	return $this->personalia->query($sql,array($id))->result_array();
    }

    public function updatePekerjaTidakMakanById($data,$permintaan_id){
    	$this->personalia->where('permintaan_id', $permintaan_id);
    	$this->personalia->update('"Catering".t_permintaan_tidak_makan', $data);
    }

} ?>