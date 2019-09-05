<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class M_lelayu extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database('personalia',TRUE);
  }

//---------------------Model Utama Untuk Tambah Data------------------------//
  public function getData()
  {
    $sql = "SELECT * FROM hr.hr_uang_duka_perusahaan";
    return $this->db->query($sql);
  }

  public function getPekerja()
  {
    $sql = "SELECT noind, nama FROM hrd_khs.tpribadi WHERE keluar = '0' AND (noind like 'A%' OR noind like 'B%')
            ORDER BY noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getSPSI()
  {
    $sql1 = "SELECT count(noind) as noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '01' AND '09') AND (noind like 'A%' OR noind like 'B%')";
    return $this->personalia->query($sql1)->result_array();
  }

  public function getNominal()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '1' AND '9' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getSPSI1()
  {
    $sql1 = "SELECT count(noind) as noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '10' AND '11') AND (noind like 'A%' OR noind like 'B%')";
    return $this->personalia->query($sql1)->result_array();
  }

  public function getNominal1()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '10' AND '11' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getSPSI2()
  {
    $sql1 = "SELECT count(noind) as noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '12' AND '13') AND (noind like 'A%' OR noind like 'B%')";
    return $this->personalia->query($sql1)->result_array();
  }

  public function getNominal2()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '12' AND '13' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getSPSI3()
  {
    $sql1 = "SELECT count(noind) as noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '14' AND '15') AND (noind like 'A%' OR noind like 'B%')";
    return $this->personalia->query($sql1)->result_array();
  }

  public function getNominal3()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '14' AND '15' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getNoindAll()
  {
    $sql = "SELECT DISTINCT noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '01' AND '09') AND (noind like 'A%' OR noind like 'B%') order by noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getNoindAll1()
  {
    $sql = "SELECT DISTINCT noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '10' AND '11') AND (noind like 'A%' OR noind like 'B%') order by noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getNoindAll2()
  {
    $sql = "SELECT DISTINCT noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '12' AND '13') AND (noind like 'A%' OR noind like 'B%') order by noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getNoindAll3()
  {
    $sql = "SELECT DISTINCT noind FROM hrd_khs.tpribadi WHERE keluar='0' AND (kd_jabatan BETWEEN '14' AND '15') AND (noind like 'A%' OR noind like 'B%') order by noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function insertAll($array)
  {
    $this->db->insert("hr.hr_lelayu",$array);
    return;
  }

  public function getID()
  {
    return $this->db->query("SELECT max(lelayu_id) new FROM hr.hr_lelayu")->row()->new;
  }

  public function insertID($array1)
  {
    $this->db->query("insert into hr.hr_pekerja_dipotong(lelayu_id,noind,nominal)
                      values(".$array1['lelayu_id'].",'".$array1['noind']."',".$array1['nominal'].")");
    return;
  }

//--------------------Model Utama Untuk List Data----------------------//
  public function getDataList()
  {
    return $this->db->query("SELECT * from hr.hr_lelayu")->result_array();
  }

  public function getDataPDF($id)
  {
    $sql = "SELECT *, (select employee_name from er.er_employee_all where employee_code = tong.noind ) as nama,
              (select sex from er.er_employee_all where employee_code = tong.noind ) as jk,
              (select section_name from er.er_section b inner join er.er_employee_all a on a.section_code = b.section_code where a.employee_code = tong.noind) as seksi
            from hr.hr_lelayu tong
            WHERE lelayu_id = '$id'";
    return $this->db->query($sql)->result_array();
  }

  public function delete($id)
  {
    $sql = "delete from hr.hr_lelayu where lelayu_id = '$id'";
    $this->db->query($sql);
  }

  public function deletePekerjaPotong($id)
  {
    $sql = "delete from hr.hr_pekerja_dipotong where lelayu_id = '$id'";
    $this->db->query($sql);
  }

  public function getDetailList($id)
  {
    $sql = "SELECT *, coalesce(kain_kafan_perusahaan,0) + coalesce(uang_duka_perusahaan,0) as perusahaan,
            coalesce(spsi_askanit_nominal,0) + coalesce(spsi_kasie_nominal,0) + coalesce(spsi_spv_nominal,0) + coalesce(spsi_nonmanajerial_nominal,0) as spsi,
              (select employee_name from er.er_employee_all where employee_code = lel.noind ) as nama FROM hr.hr_lelayu lel WHERE lelayu_id = '$id'";
    return $this->db->query($sql)->result_array();
  }

  public function getDataListExcel()
  {
    $sql = "SELECT *, coalesce(kain_kafan_perusahaan,0) + coalesce(uang_duka_perusahaan,0) as perusahaan,
            coalesce(spsi_askanit_nominal,0) + coalesce(spsi_kasie_nominal,0) + coalesce(spsi_spv_nominal,0) + coalesce(spsi_nonmanajerial_nominal,0) as spsi,
              (select employee_name from er.er_employee_all where employee_code = lel.noind ) as nama FROM hr.hr_lelayu lel";
    return $this->db->query($sql)->result_array();
  }

  public function getPekerjaTerpotong($id)
  {

    $selectNom = $this->db->query("select distinct nominal from hr.hr_pekerja_dipotong where lelayu_id = '$id'")->result_array();
    sort($selectNom);
    $newArr = array();
    foreach ($selectNom as $key) {
      $nominal = $key['nominal'];
      $pg = "SELECT *, (select employee_name from er.er_employee_all where employee_code = tong.noind ) as nama from hr.hr_pekerja_dipotong tong WHERE lelayu_id = '$id' and nominal = '$nominal'";
      $pg = $this->db->query($pg)->result_array();

      for ($i=0; $i < count($pg) ; $i++) {
        array_push($newArr, $pg[$i]);
      }
    }
    return $newArr;
  }

  public function namaUser($noind)
  {
    $sql = "SELECT employee_name from er.er_employee_all where employee_code = '$noind'";
    return $this->db->query($sql)->row()->employee_name;
  }

  public function getAtasan()
  {
    $sql = "SELECT nama, jabatan from hrd_khs.tpribadi where kodesie in ('401010000')";
    return $this->personalia->query($sql)->result_array();
  }

  public function getTertandaKasbon()
  {
    $sql = "SELECT noind, nama FROM hrd_khs.tpribadi WHERE keluar = '0' ORDER BY noind";
    return $this->personalia->query($sql)->result_array();
  }



//-------------Model Utama Untuk Setup Duka Perusahaan---------------//

  public function getDukaPerusahaan()
  {
    return $this->db->query("SELECT * FROM hr.hr_uang_duka_perusahaan")->result_array();
  }

//-------------Model Utama Untuk Setup Duka SPSI---------------//

  public function getDukaSPSI()
  {
    return $this->db->query("SELECT * FROM hr.hr_uang_duka_spsi")->result_array();
  }

}

 ?>
