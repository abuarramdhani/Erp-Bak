<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Seksi
    function getSeksi()
    {
        $sql = 'SELECT * FROM mfo.mfo_master_seksi order by seksi asc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getSeksi2()
    {
        $sql = 'SELECT seksi FROM mfo.mfo_master_seksi order by seksi asc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function onlySeksi($term)
    {
        $sql = "SELECT seksi FROM mfo.mfo_master_seksi WHERE lower(seksi) LIKE '%".strtolower($term)."%' order by seksi asc";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function setSeksi($newNama)
    {
        $sql    = "INSERT INTO mfo.mfo_master_seksi (seksi) VALUES ('$newNama')";
        $this->db->query($sql);
    }

    function delSeksi($id)
    {
        $sql    = "DELETE FROM mfo.mfo_master_seksi  WHERE id = '$id'";
        $this->db->query($sql);
    }

    function updSeksi($id, $newNama)
    {
        $sql    = "UPDATE mfo.mfo_master_seksi SET seksi = '$newNama' WHERE id = '$id'";
        $this->db->query($sql);
    }

    //Possible Failure
    function getPoss()
    {
        $sql = 'SELECT * FROM mfo.mfo_master_poss_failure order by possible_failure asc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function setPoss($iniPossFail)
    {
        $sql    = "INSERT INTO mfo.mfo_master_poss_failure (possible_failure) VALUES ('$iniPossFail')";
        $this->db->query($sql);
    }

    function delPoss($id)
    {
        $sql    = "DELETE FROM mfo.mfo_master_poss_failure  WHERE id = '$id'";
        $this->db->query($sql);
    }

    function updPoss($id, $iniPoss)
    {
        $sql    = "UPDATE mfo.mfo_master_poss_failure SET possible_failure = '$iniPoss' WHERE id = '$id'";
        $this->db->query($sql);
    }
}
