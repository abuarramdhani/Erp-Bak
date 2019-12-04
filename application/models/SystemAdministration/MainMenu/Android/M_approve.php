<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_approve extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
    }

    public function getDevice($user){
    	$sql = "select a.*,b.approver,b.status,
				case when a.validation = '0' then 'New'
				when a.validation = '1' then concat('Approved by Personalia')
				when a.validation = '2' then case when (select count(*) from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2') > 0 then concat('Rejected by Atasan (',(select string_agg(approver,', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2'),')') else 'Rejected by Personalia' end
				when a.validation = '3' then concat('Request Remove by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '3'),')')
				when a.validation = '4' then concat('Approved by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '1'),')')
				end as status_approve
				from sys.sys_android a 
				inner join sys.sys_android_approve_atasan b 
				on a.gadget_id = b.gadget_id
				where b.approver = '$user'";
		return $this->db->query($sql)->result_array();
    }

    public function getDevicePersonalia($user){
        $sql = "select a.*,
                case when a.validation = '0' then 'New'
                when a.validation = '1' then concat('Approved by Personalia')
                when a.validation = '2' then case when (select count(*) from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2') > 0 then concat('Rejected by Atasan (',(select string_agg(approver,', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2'),')') else 'Rejected by Personalia' end
                when a.validation = '3' then concat('Request Remove by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '3'),')')
                when a.validation = '4' then concat('Approved by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '1'),')')
                end as status_approve
                from sys.sys_android a ";
        return $this->db->query($sql)->result_array();
    }

    public function getDeviceById($user,$id){
    	$sql = "select a.*,b.approver,b.status,b.reason,
				case when a.validation = '0' then 'New'
				when a.validation = '1' then concat('Approved by Personalia')
				when a.validation = '2' then case when (select count(*) from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2') > 0 then concat('Rejected by Atasan (',(select string_agg(approver,', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2'),')') else 'Rejected by Personalia' end
				when a.validation = '3' then concat('Request Remove by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '3'),')')
				when a.validation = '4' then concat('Approved by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '1'),')')
				end as status_approve
				from sys.sys_android a 
				inner join sys.sys_android_approve_atasan b 
				on a.gadget_id = b.gadget_id
				where b.approver = '$user'
				and a.gadget_id = '$id'";
		return $this->db->query($sql)->result_array();
    }

    public function getDevicePersonaliaById($user,$id){
        $sql = "select a.*,b.approver,b.status,b.reason,
                case when a.validation = '0' then 'New'
                when a.validation = '1' then concat('Approved by Personalia')
                when a.validation = '2' then case when (select count(*) from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2') > 0 then concat('Rejected by Atasan (',(select string_agg(approver,', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2'),')') else 'Rejected by Personalia' end
                when a.validation = '3' then concat('Request Remove by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '3'),')')
                when a.validation = '4' then concat('Approved by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '1'),')')
                end as status_approve
                from sys.sys_android a 
                left join sys.sys_android_approve_atasan b 
                on a.gadget_id = b.gadget_id
                where a.gadget_id = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function rejectAtasanById($user,$id,$ket){
        $sql = "update sys.sys_android set validation = 2 
        		where gadget_id = '$id'
        		and gadget_id in (select gadget_id from sys.sys_android_approve_atasan where gadget_id = '$id' and approver = '$user') ";
        $this->db->query($sql);

        $sql = "update sys.sys_android_approve_atasan set reason ='$ket', status='2',update_timestamp= now()
        		where gadget_id = '$id' and approver = '$user'";
        $this->db->query($sql);

    }

    public function rejectPersonaliaById($user,$id,$ket){
        $sql = "update sys.sys_android set validation = 2
                where gadget_id = '$id'";
        $this->db->query($sql);

    }

    public function approveAtasanById($user,$id,$ket,$noind,$nama){
    	$sql = "update sys.sys_android set info_2 ='$noind', info_1 = '$nama',validation = 4 
        		where gadget_id = '$id'
        		and gadget_id in (select gadget_id from sys.sys_android_approve_atasan where gadget_id = '$id' and approver = '$user') ";
        $this->db->query($sql);

    	$sql = "update sys.sys_android_approve_atasan set reason ='$ket', status='1',update_timestamp= now()
        		where gadget_id = '$id' and approver = '$user'";
        $this->db->query($sql);
    }

    public function approvePersonaliaById($user,$id,$ket,$noind,$nama){
        $sql = "update sys.sys_android set info_2 ='$noind', info_1 = '$nama',validation = 1
                where gadget_id = '$id'";
        $this->db->query($sql);
    }

    public function RequestRemoveById($user,$id,$ket){
    	$sql = "update sys.sys_android set validation = 3
        		where gadget_id = '$id'
        		and gadget_id in (select gadget_id from sys.sys_android_approve_atasan where gadget_id = '$id' and approver = '$user') ";
        $this->db->query($sql);

    	$sql = "update sys.sys_android_approve_atasan set reason ='$ket', status='3',update_timestamp= now()
        		where gadget_id = '$id' and approver = '$user'";
        $this->db->query($sql);
    }

    public function RemoveById($user,$id,$ket){
        $sql = "delete from sys.sys_android
                where gadget_id = '$id'";
        $this->db->query($sql);

        $sql = "delete from sys.sys_android_approve_atasan
                where gadget_id = '$id'";
        $this->db->query($sql);
    }
}

?>