<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_deklarasi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    function insDeklarasi($data)
    {
        $this->personalia->insert('hrd_khs.deklarasi_sehat', $data);
        return $this->personalia->affected_rows();
    }

    function getDeklaraibyNoind($noind)
    {
        $this->personalia->where('noind', $noind);
        return $this->personalia->get('hrd_khs.deklarasi_sehat')->result_array();
    }

    function getDeklaraibyID($id)
    {
        $this->personalia->where('id_deklarasi', $id);
        return $this->personalia->get('hrd_khs.deklarasi_sehat')->result_array();
    }

    function updDeklarasi($data, $id)
    {
        $this->personalia->where('id_deklarasi', $id);
        $this->personalia->update('hrd_khs.deklarasi_sehat', $data);
        return $this->personalia->affected_rows();
    }

    function delDeklarasi($id)
    {
        $this->personalia->where('id_deklarasi', $id);
        $this->personalia->delete('hrd_khs.deklarasi_sehat');
        return $this->personalia->affected_rows();
    }

    function getAllPernyataan()
    {
        return $this->personalia->get('hrd_khs.deklarasi_sehat_pertanyaan')->result_array();
    }
}
