<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_settingmpk extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getSeksi()
    {
    	$sql = "select * from hrd_khs.tseksi where rtrim(seksi) != '-'";
    	return $this->personalia->query($sql)->result_array();
    }

    public function updateSeksi($arr, $kodesie)
    {
    	$this->personalia->where('kodesie', $kodesie);
    	$this->personalia->update('hrd_khs.tseksi', $arr);
    }

    public function insertLog($kodesie, $user, $status, $noind_baru)
    {
    	$sql = "insert into hrd_khs.tlog (wkt, menu, ket, noind, jenis,program, noind_baru) 
                                       values (now()
                                        ,'Master Pekerja -> Setting -> Seksi','KODESIE hrd_khs.tseksi -> $kodesie -> $status','$user','UPDATE','QUICK_ERP', '$noind_baru')";
        $this->personalia->query($sql);
    }

    public function getNoindNew($noind)
    {
    	$this->personalia->where('noind', $noind);
    	return $this->personalia->get('hrd_khs.tpribadi')->result_array();
    }
}