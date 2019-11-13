<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getAllNama()
    {
      return $this->personalia->query("SELECT DISTINCT noind, trim(nama) as nama FROM hrd_khs.tpribadi")->result_array();
    }

   public function GetIzin($no_induk)
	{
		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE atasan_aproval LIKE '%$no_induk%' order by status";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinApprove($no_induk)
	{
		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE atasan_aproval = '$no_induk' and status = '1' order by created_date DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinUnApprove($no_induk)
	{
		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE atasan_aproval LIKE '%$no_induk%' and status = '0' order by created_date DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinReject($no_induk)
	{
		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE atasan_aproval LIKE '%$no_induk%' and status = '2' order by created_date DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function update($status, $idizin)
    {
        $sql = "update \"Surat\".tperizinan
                set status ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function taktual_izin($pekerja)
    {
         $this->personalia->insert('Surat.taktual_izin',$pekerja);
        return;
    }

    public function cekIzin($idizin)
    {
        $sql = "SELECT * FROM \"Surat\".tperizinan WHERE izin_id::text = '$idizin'";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

     public function deletemakan($idizin)
    {
	    $sql = "DELETE from \"Surat\".tpekerja_izin tpi
	                where tpi.izin_id='$idizin'";
	    $this->personalia->query($sql);
	    return;
    }

    public function getTujuanMakan($idizin)
    {
      $sql = "SELECT * FROM \"Surat\".tpekerja_izin WHERE izin_id = '$idizin'";
      return $this->personalia->query($sql)->result_array();
    }

} ?>
