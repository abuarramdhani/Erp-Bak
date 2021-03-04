<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function selectAllRegisteredUser($years)
    {
        // return $this->db
        //     ->order_by('id', 'ASC')
        //     ->get_where('ap.ap_spt', ['tanggal daftar' =>  $id]
        //     ->result_array();

        $sql = "SELECT * FROM ap.ap_spt WHERE nomor_pendaftaran like '%-$years-%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // public function selectRegisteredUserByFilter($filter, $filter_2)
    // {
    //     return $this->db
    //         ->like($filter)
    //         ->not_like($filter_2)
    //         ->get('ap.ap_spt')
    //         ->result_array();
    // }
    public function selectRegisteredUserByFilter($filter, $filter_2, $filter_3, $years)
    {
        $sql = "SELECT * FROM ap.ap_spt 
        WHERE status_pekerja like'%$filter%' 
        and lokasi_kerja like '%$filter_2%'
        and status_pekerja not like '%$filter_3%'
        and nomor_pendaftaran like '%-$years-%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function selectRegisteredUser($id)
    {
        return $this->db
            ->get_where('ap.ap_spt', ['id' => $id])
            ->result_array();
    }

    public function countAllRegisteredUser($filter, $filter_2)
    {
        return $this->db
            ->like($filter)
            ->like('nomor_pendaftaran', '-21-')
            ->not_like($filter_2)
            ->from('ap.ap_spt')
            ->count_all_results();
    }

    public function updateRegisteredUser($id, $data)
    {
        $this->db
            ->where('id', $id)
            ->update('ap.ap_spt', $data);
    }

    public function deleteRegisteredUser($id)
    {
        $this->db->delete('ap.ap_spt', ['id' => $id]);
    }
}
