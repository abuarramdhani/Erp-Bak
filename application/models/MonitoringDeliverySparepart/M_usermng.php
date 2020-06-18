<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_usermng extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function dataUser(){
      $sql = "select * from mds.mds_user_management";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekData($seksi, $no_induk){
      $sql = "select * from mds.mds_user_management 
              where seksi = '$seksi' 
              and no_induk = '$no_induk'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function saveUser($seksi, $no_induk, $dept, $hak_akses){
      $sql = "insert into mds.mds_user_management (seksi, no_induk, deptclass, hak_akses)
              values('$seksi', '$no_induk', '$dept', '$hak_akses')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
  }

public function deleteUser($id, $no_induk){
      $sql = "delete from mds.mds_user_management
              where id = '$id'
              and no_induk = '$no_induk'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
  }

  public function getUser($id){
    $sql = "select * from mds.mds_user_management
            where id = '$id'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function cariNama($no_induk){
    $oracle = $this->load->database('oracle',true);
    $sql = "select ppf.FIRST_NAME||' '||ppf.MIDDLE_NAMES||' '||ppf.LAST_NAME username
            from PER_PEOPLE_F ppf 
            where ppf.NATIONAL_IDENTIFIER = '$no_induk' 
            and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
            order by ppf.NATIONAL_IDENTIFIER desc";
    $query = $oracle->query($sql);
    return $query->result_array();
  }

  public function seksi($user){
    $oracle = $this->load->database('personalia',true);
    $sql = " SELECT ts.seksi, ts.unit
            FROM hrd_khs.tpribadi tp, hrd_khs.tseksi ts 
            WHERE ts.kodesie = tp.kodesie
            and tp.keluar = '0'
            and tp.noind = '$user'";
            $query = $oracle->query($sql);
            return $query->result_array();
}

public function deptclass($term){
  $oracle = $this->load->database('oracle',true);
  $sql = "select distinct DEPARTMENT_CLASS_CODE 
          from bom_departments 
          where DEPARTMENT_CLASS_CODE LIKE '%$term%'";
  $query = $oracle->query($sql);
  return $query->result_array();
}

public function cekHak($user){
  $sql = "select hak_akses from mds.mds_user_management 
          where no_induk = '$user'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function updateUser($hak_akses, $dept, $id){
    $sql = "update mds.mds_user_management set hak_akses = '$hak_akses', deptclass = '$dept' where id = '$id'";
    $query = $this->db->query($sql);
    $query2 = $this->db->query('commit');
  }
}
