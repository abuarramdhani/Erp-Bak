<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_deleteup2l extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function mo($month, $year)
    {
        $sql = "SELECT moulding_id FROM mo.mo_moulding
                WHERE extract(month from production_date) = '$month' 
                AND extract(year from production_date) = '$year'";
        return $this->db->query($sql)->result_array();
    }

    public function bongkarScrapEmployeeOfMoulding($id)
    {
        $sql = "DELETE FROM mo.mo_moulding_bongkar
                WHERE moulding_id = '$id';
                -- Bongkar
                DELETE FROM mo.mo_moulding_scrap
                WHERE moulding_id = '$id';
                -- Scrap
                DELETE FROM mo.mo_moulding_employee
                WHERE moulding_id = '$id';
                -- Employee";
        $this->db->query($sql);
    }

    public function deleteAll($month, $year)
    {
        $sql = "DELETE FROM mo.mo_moulding 
                WHERE extract(month from production_date) = '$month' 
                AND extract(year from production_date) = '$year'";
        $this->db->query($sql);
        $sql = "DELETE FROM mo.mo_core
                WHERE extract(month from production_date) = '$month' 
                AND extract(year from production_date) = '$year'";
        $this->db->query($sql);
        $sql = "DELETE FROM mo.mo_mixing
                WHERE extract(month from production_date) = '$month' 
                AND extract(year from production_date) = '$year'";
        $this->db->query($sql);
        $sql = "DELETE FROM mo.mo_ott
                WHERE extract(month from otttgl) = '$month' 
                AND extract(year from otttgl) = '$year'";
        $this->db->query($sql);
        $sql = "DELETE FROM mo.mo_absensi
                WHERE extract(month from created_date) = '$month' 
                AND extract(year from created_date) = '$year'";
        $this->db->query($sql);
        $sql = "DELETE FROM mo.mo_selep
                WHERE extract(month from selep_date) = '$month' 
                AND extract(year from selep_date) = '$year'";
        $this->db->query($sql);
        $sql = "DELETE FROM mo.mo_quality_control
                WHERE extract(month from checking_date) = '$month' 
                AND extract(year from checking_date) = '$year'";
        $this->db->query($sql);
    }

}