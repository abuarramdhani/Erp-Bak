<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rencanalembur extends CI_Model {

	
	public function __construct()
    {
        parent::__construct();
        $this->personalia = $this->load->database('personalia',true);
    }

    public function getRencanaLemburByAtasan($user){
    	$sql = "select *,
					(select trim(nama) from hrd_khs.tpribadi t where trl.noind = t.noind ) as nama_pekerja,
                    (select nama_lembur from \"Presensi\".tjenislembur where kd_lembur::int = trl.jenis_lembur::int) as nama_lembur
				from \"Presensi\".t_rencana_lembur trl 
				where atasan = '$user'
				order by tanggal_lembur";
		return $this->personalia->query($sql)->result_array();
    }

    public function updateRencanaLembur($id,$status){
    	$sql = "update \"Presensi\".t_rencana_lembur 
    			set status_approve = $status, approve_timestamp = now()
    			where id_rencana = $id";
    	$this->personalia->query($sql);
    }

} ?>