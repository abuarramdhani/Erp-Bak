<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_qualitycontrol extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getQualityControl()
    {
        $sql = "SELECT * FROM mo.mo_quality_control ORDER BY extract(month from checking_date) desc, extract(year from checking_date) desc, extract(day from checking_date), shift, employee";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getQualityControlbyId($id)
    {
        $sql = "SELECT * FROM mo.mo_quality_control WHERE quality_control_id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getEditQualityControl($id)
    {
        $sql = "SELECT * FROM mo.mo_quality_control WHERE quality_control_id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getSelep()
    {
        $sql = "SELECT * FROM mo.mo_selep WHERE check_qc = FALSE AND delete_info is null ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getQualityControlDetail($id)
    {
        $sql = "SELECT *, (selep_quantity-scrap_quantity) checking_ok FROM mo.mo_selep WHERE selep_id = '$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function setQualityControl($data)
    {
        return $this->db->insert('mo.mo_quality_control', $data);
    }

    public function updateQualityControl($data, $id)
    {
        $this->db->where('quality_control_id', $id);
        $this->db->update('mo.mo_quality_control', $data);
    }

    public function deleteQualityControl($id, $sid)
    {
        $sql = "DELETE FROM mo.mo_quality_control WHERE quality_control_id = '$id';
                UPDATE mo.mo_selep SET check_qc = FALSE, qc_qty_ok = NULL, qc_qty_not_ok = NULL WHERE selep_id = '$sid';";
        $this->db->query($sql);
    }

    public function selectByDate1($dateQCUp2l)
    {
        $sql = "SELECT * FROM mo.mo_selep WHERE selep_date = '$dateQCUp2l' AND check_qc = FALSE ORDER BY extract(month from selep_date) desc, extract(year from selep_date) desc, extract(day from selep_date), shift, job_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function selectByDate2($dateQCUp2l)
    {
        $sql = "SELECT * FROM mo.mo_quality_control WHERE checking_date = '$dateQCUp2l' ORDER BY extract(month from checking_date) desc, extract(year from checking_date) desc, extract(day from checking_date), shift";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_qty_qc($qty, $id)
    {
        $sql = "UPDATE mo.mo_selep SET qc_qty_ok = '$qty' WHERE selep_id = '$id';";
        $this->db->query($sql);
    }

}
