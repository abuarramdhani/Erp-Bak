<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_list extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
    }


    public function getDataAndroid(){
    	$query = $this->db->query("
			select a.*,
                 case when a.validation = '0' then 'New'
                 when a.validation = '1' then concat('Approved by Personalia')
                 when a.validation = '2' then concat('Rejected by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '2'),')')
                 when a.validation = '3' then concat('Request Remove by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '3'),')')
                 when a.validation = '4' then concat('Approved by Atasan (',(select string_agg(concat(approver,' - ',(select employee_name from er.er_employee_all d where c.approver = d.employee_code)),', ') from sys.sys_android_approve_atasan c where a.gadget_id = c.gadget_id and c.status = '1'),')')
                 end as status_approve
                 from sys.sys_android a
			");
		return $query->result_array();
    }

    public function getDataAndroidById($id){
        $query = $this->db->query("SELECT * FROM sys.sys_android WHERE gadget_id=$id");
        return $query->result_array();
    }

    public function getDataAndroidById1($id){
        $query = $this->db->query("SELECT info_1 FROM sys.sys_android WHERE gadget_id=$id");
        return $query->result_array();
    }

    public function getDataAndroidByNama($nama){
        $query = $this->db->query("SELECT * FROM sys.sys_android WHERE info_1='".$nama."'");
        return $query->result_array();
    }

    public function tabel(){
        $sql = "select * from sys.vi_sys_user";
        $this->db->query($sql);
        return $query->result_array();
    }

    public function delete($id){
        $this->db->where('gadget_id',$id);
        $this->db->delete('sys.sys_android');
    }

    public function listPekerja($id,$keyword){
        $sql = "select * from hrd_khs.tpribadi where keluar=false and (nama like '%$keyword%' or upper(nama) like '%$keyword%' or noind like '%$keyword%') order by noind asc";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }   

    public function updateData($id,$data){
        $this->db->where('gadget_id', $id);
        $this->db->update('sys.sys_android' , $data);
    }

    public function getAkhirKontrak($noind){
        $sql = "SELECT * FROM hrd_khs.tpribadi WHERE noind='$noind' ";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

     public function getDetail($usr)
        {
          $sql = "  select  su.*,
                            er.section_code,
                            er.employee_name
                    from    sys.sys_user as su
                            join    er.er_employee_all as er
                                    on  er.employee_id=su.employee_id
                    where   user_name = '" . $usr . "'";
          $query = $this->db->query($sql);
          return $query->result_array();
        }

    public function tambahData($data){
            $this->db->insert('sys.sys_android',$data);
    }

    public function getEmailICT(){
        $sql = "SELECT * FROM er.er_employee_all WHERE section_code='101030100'";
        $query = $this->db->query($sql);
        return $query->result_array();      
    } 

    public function getEmployeeEmailByNoinduk($noinduk){
        $sql = "SELECT * FROM er.er_employee_all WHERE employee_code='$noinduk'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }   

    // public function getValidUntil($id){
    //     $query = "select valid_until from sys.sys_android WHERE gadget_id=$id";
    //     $this->db->query($query);
    //     return $query->result_array();
    // }

    // public function expired($id){
    //     $query = "INSERT INTO sys.sys_android (validation) VALUES ('3') WHERE gadget_id=$id"
    //     $this->db->query($query);
    // }
}