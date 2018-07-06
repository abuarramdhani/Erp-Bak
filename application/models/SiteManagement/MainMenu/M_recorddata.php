<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_recorddata extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function dataCeilingFan() {
    	$query = $this->db->query("select * from sm.sm_jadwal where id_kategori='1' and id_kategori_detail='1' order by tanggal_jadwal");
    	return $query->result_array();
    }

    public function dataLantai() {
    	$query = $this->db->query("select * from sm.sm_jadwal where id_kategori='1' and id_kategori_detail='2' order by tanggal_jadwal");
    	return $query->result_array();
    }

    public function dataLPMaintenance() {
    	$query = $this->db->query("select * from sm.sm_jadwal where id_kategori='2' and id_kategori_detail='3' order by tanggal_jadwal");
    	return $query->result_array();
    }

    public function dataTongSampah() {
    	$query = $this->db->query("select * from sm.sm_jadwal where id_kategori='3' and id_kategori_detail='4' order by tanggal_jadwal");
    	return $query->result_array();
    }

    public function dataLahanKarangwaru() {
    	$query = $this->db->query("select * from sm.sm_jadwal where id_kategori='4' and id_kategori_detail='5' order by tanggal_jadwal");
    	return $query->result_array();
    }

    public function dataLahanPetinggen() {
    	$query = $this->db->query("select * from sm.sm_jadwal where id_kategori='4' and id_kategori_detail='6' order by tanggal_jadwal");
    	return $query->result_array();
    }

    public function deleteDataSiteManagement($id) {
        $this->db->where('id_jadwal', $id);
        $this->db->delete('sm.sm_jadwal');
    }
}