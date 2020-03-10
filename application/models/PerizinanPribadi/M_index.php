<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class M_index extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    public function GetIzin($noind)
    {
        $sql = "SELECT * FROM \"Surat\".tizin_pribadi
                WHERE atasan LIKE '%$noind%'
                Order BY status, id DESC";
        return $this->personalia->query($sql)->result_array();
    }

    public function updatePekerja($status, $idizin)
    {
        $sql = "update \"Surat\".tpekerja_izin
                set status_jalan ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function update($status, $idizin)
    {
        $sql = "update \"Surat\".tizin_pribadi
                set status ='$status'
                WHERE id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function getPekerja($id)
    {
        $sql = "SELECT * from \"Surat\".tizin_pribadi_detail
                Where id = '$id'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getSerahkan($implode, $id)
    {
        $sql = "SELECT diserahkan from \"Surat\".tizin_pribadi_detail
                Where id = '$id' AND noind in ('$implode')";
        return $this->personalia->query($sql)->result_array();
    }

    public function taktual_pribadi($pekerja)
    {
        $this->personalia->insert('Surat.taktual_pribadi',$pekerja);
        return;
    }

    public function getPekerjaEdit($idizin)
    {
        $sql = "SELECT ti.*, (SELECT trim(nama) FROM hrd_khs.tpribadi where noind = ti.noind and keluar = '0') as nama, tper.keperluan, cast(tper.created_date as date), tper.wkt_keluar
                FROM \"Surat\".tizin_pribadi_detail ti
                LEFT JOIN \"Surat\".tizin_pribadi tper ON tper.id = ti.id
                WHERE ti.id = '$idizin'";
        return $this->personalia->query($sql)->result_array();
    }

    public function updatePekerjaBerangkat($noind, $status, $idizin)
    {
        $sql = "UPDATE \"Surat\".tizin_pribadi_detail
                set status ='$status'
                WHERE id ='$idizin' AND noind = '$noind'";
        return $this->personalia->query($sql);
    }

    public function getDataPekerja($a, $b)
    {
        $sql = "SELECT * FROM \"Surat\".tizin_pribadi_detail WHERE id = '$b' AND noind = '$a'";
        return $this->personalia->query($sql)->result_array();
    }

    public function update_tperizinan($noind, $status, $id, $serahkan)
    {
        $sql = "UPDATE \"Surat\".tizin_pribadi
                set status ='$status', noind = '$noind', diserahkan = '$serahkan'
                WHERE id ='$id'";
        return $this->personalia->query($sql);
    }

    public function getAllNama()
    {
      return $this->personalia->query("SELECT DISTINCT noind, trim(nama) as nama FROM hrd_khs.tpribadi")->result_array();
    }

  	public function IzinApprove($periode)
  	{
        if (!empty($periode)) {
            $new = "WHERE $periode";
        }else {
            $new = "";
        }
  		$sql = "SELECT tp.* FROM \"Surat\".tizin_pribadi tp $new order by tp.created_date DESC, tp.status ";

  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

    public function approveAtasan($atasan)
  	{
        $today = date('Y-m-d');
  		$sql = "SELECT * from \"Surat\".tizin_pribadi where atasan = '$atasan' and status = '1' Order BY id DESC, status";

  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

    public function IzinUnApprove($no_induk)
  	{
        $today = date('Y-m-d');
  		$sql = "SELECT * from \"Surat\".tizin_pribadi where atasan = '$no_induk' and status = '0' and created_date::date = '$today' Order BY id DESC, status";

  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

    public function IzinReject($no_induk)
  	{
        $today = date('Y-m-d');
  		$sql = "SELECT * from \"Surat\".tizin_pribadi where atasan = '$no_induk' and (status = '0' and created_date::date < '$today') or status = '5' Order BY id DESC, status";

  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

    public function getPekerjarekap($tanggal)
	{
        if (!empty($tanggal)) {
            $new = "WHERE $tanggal";
        }else {
            $new = "";
        }
		$sql = "SELECT ti.*, (SELECT trim(nama) as nama FROM hrd_khs.tpribadi WHERE noind = ti.noind) as nama, tp.atasan, tp.keperluan, ti.status, tp.created_date
				FROM \"Surat\".tizin_pribadi_detail ti
                LEFT JOIN \"Surat\".tizin_pribadi tp ON tp.id = ti.id::int $new
				ORDER BY ti.id DESC, ti.status, ti.noind";
		return $this->personalia->query($sql)->result_array();
	}

}

 ?>
