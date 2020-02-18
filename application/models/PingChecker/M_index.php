<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		date_default_timezone_set("Asia/Bangkok");
    }

    public function checkStatusAction($ip)
    {
        $query = $this->db->query("SELECT * from si.network_monitoring where ip ='$ip' and creation_date > NOW() - INTERVAL '17 minutes'
        order by creation_date
        DESC LIMIT 1");

        return $query->result_array();
    }

    public function setStatus($stat)
    {
        $this->db->insert('si.network_monitoring',$stat);
    }

    public function getDataIPDown()
    {
        $this->db->order_by("creation_date", "DESC");
        $query = $this->db->get('si.network_monitoring');
        return $query->result_array();
    }

    public function getNamaCreator($actBy)
    {
        $this->db->where('employee_code',$actBy);
        $query = $this->db->get('er.er_employee_all');
        return $query->result_array();
    }

    public function UpdateData($id,$up)
    {
        $this->db->where('id',$id);
        $this->db->update('si.network_monitoring',$up);
        
    }

}