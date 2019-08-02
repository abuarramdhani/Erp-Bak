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
			SELECT * FROM sys.sys_android

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
        $sql = "select * from sys.vi_sys_user where user_name like '%$keyword%' or upper(employee_name) like '%$keyword%' order by user_id asc";

        $query = $this->db->query($sql);
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