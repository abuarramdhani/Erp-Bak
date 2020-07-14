<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class M_resign extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	    $this->personalia 	= 	$this->load->database('personalia', TRUE);
	}

	public function getResignMailAll(){
		$sql = "select a.*,b.nama 
				from hrd_khs.t_pengajuan_resign_pekerja a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind
				where deleted_date is null";
		return $this->personalia->query($sql)->result_array();
	}

	public function getResignMailByID($id){
		$sql = "select a.*,b.nama 
				from hrd_khs.t_pengajuan_resign_pekerja a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind
				where a.pengajuan_id = $id";
		return $this->personalia->query($sql)->row();
	}

	public function getPekerjaAktifByParams($key){
		$sql = "select noind,nama from hrd_khs.tpribadi where keluar ='0' and (noind like upper('%$key%') or nama like upper('%$key%'))";
		return $this->personalia->query($sql)->result_array();
	}

	public function insertResignMail($data){
		$this->personalia->insert("hrd_khs.t_pengajuan_resign_pekerja",$data);
	}

	public function getNoindBaru($noind){
		$sql = "select noind_baru from hrd_khs.tpribadi where noind = '$noind'";
		return $this->personalia->query($sql)->row()->noind_baru;
	}

	public function deleteResignMailByID($id){
		$this->personalia->where('pengajuan_id',$id);
		$this->personalia->set('deleted_by',$this->session->user);
		$this->personalia->set('deleted_date', date('Y-m-d H:i:s'));
		$this->personalia->update("hrd_khs.t_pengajuan_resign_pekerja");
	}

	public function updateResignMailByID($data,$id){
		$this->personalia->where('pengajuan_id',$id);
		$this->personalia->update('hrd_khs.t_pengajuan_resign_pekerja',$data);
	}
}

?>