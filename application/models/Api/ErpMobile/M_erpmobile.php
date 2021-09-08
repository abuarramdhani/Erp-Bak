<?php

class M_erpmobile extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    function getNoindErp($noind)
    {
    	$sql = "SELECT
                    *
                from
                    sys.sys_user su
                inner join er.er_employee_all eea on
                    eea.employee_id = su.employee_id
                where
                    su.user_name = '$noind' limit 1";

    	return $this->db->query($sql)->row_array();
    }

    function getPwdErpLog($noind)
    {	
    $sql = "SELECT
				*
			from
				hrd_khs.tlog t
			where
				noind = '$noind' and
				menu = 'Cronjob Ganti Password'
			order by
				wkt desc
			limit 1";
	return $this->personalia->query($sql)->row_array();
    }

    function saveEmail($arr, $noind)
    {
        $this->db->where('employee_code', $noind);
        $this->db->update('er.er_employee_all', $arr);
        return $this->db->affected_rows();
    }

    function changePassword($noind, $pass)
    {
        $this->db->where('user_name', $noind);
        $this->db->update('sys.sys_user', ['user_password'=>$pass]);
        return $this->db->affected_rows();
    }

    function getinfoPKJ($noind)
    {
        $this->personalia->where('noind', $noind);
        return $this->personalia->get('hrd_khs.tpribadi')->row_array();
    }

    function save_smslog($data)
    {
        $this->db->insert('si.si_sent_sms', $data);
        return $this->db->affected_rows();
    }
}