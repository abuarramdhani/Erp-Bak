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

    public function dataKarpetSajadah() {
        $query = $this->db->query("select * from sm.sm_jadwal where id_kategori='5' and id_kategori_detail='7' order by tanggal_jadwal");
        return $query->result_array();
    }

    public function deleteDataSiteManagement($id) {
        $this->db->where('id_jadwal', $id);
        $this->db->delete('sm.sm_jadwal');
    }

    public function sampah()
    {
        $sql = 'select * from sm.sm_timbangan_sampah order by tgl_timbangan desc';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function dataSampah($id)
    {
        $this->db->select('*');
        $this->db->from('sm.sm_timbangan_sampah');
        $this->db->where('id_sampah=', $id);

        return $this->db->get()->result_array();
    }

    public function SimpanTimbanganSampah($inputSampah)
    {
        $this->db->insert('sm.sm_timbangan_sampah', $inputSampah);
    }

    public function UpdateTimbanganSampah($inputSampah,$id)
    {
        $this->db->where('id_sampah=', $id);
        $this->db->update('sm.sm_timbangan_sampah', $inputSampah);
    }

    public function DeleteTimbanganSampah($id)
    {
        $this->db->where('id_sampah=', $id);
        $this->db->delete('sm.sm_timbangan_sampah');
    }
//----------------------------------------------------------------------
    public function dataWc()
    {
        $this->db->select('*');
        $this->db->from('sm.sm_sedot_wc');
        $this->db->order_by('tanggal','desc');

        return $this->db->get()->result_array();
    }

    public function SimpanJasaSedotWC($inputJasa)
    {
        $this->db->insert('sm.sm_sedot_wc', $inputJasa);
    }

    public function editWc($id)
    {
        $this->db->select('*');
        $this->db->from('sm.sm_sedot_wc');
        $this->db->where('id=', $id);

        return $this->db->get()->result_array();
    }

    public function UpdateJasaSedotWC($inputJasa,$id)
    {
        $this->db->where('id=', $id);
        $this->db->update('sm.sm_sedot_wc', $inputJasa);
    }

    public function DeleteJasaSedotWC($id)
    {
        $this->db->where('id=', $id);
        $this->db->delete('sm.sm_sedot_wc');
    }
}