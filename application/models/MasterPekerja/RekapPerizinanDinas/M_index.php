<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);    
    }
    
   public function GetIzin($no_induk)
	{
		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE atasan_aproval LIKE '%$no_induk%' order by status";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function GetPekerjaIzin($no_induk)
	{
		$sql = "SELECT noind FROM \"Surat\".tperizinan WHERE atasan_aproval LIKE '%$no_induk%' order by status";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinApprove($periodeRekap)
	{
		if (!empty($periodeRekap)) {
			$where = "AND TO_CHAR(created_date, 'yyyy-mm') LIKE '$periodeRekap'";
		}else{
			$where = "";
		}
		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE status = '1' $where order by created_date DESC ";
                // echo $sql;exit();

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function update($status, $idizin)
    {
        $sql = "update \"Surat\".tperizinan
                set status ='$status'
                WHERE izin_id ='$idizin'";
                // echo $sql;exit();
        $query = $this->personalia->query($sql);
        // return $query->result_array();
    }

    public function pekerja($noind)
    {
    	$sql = "SELECT rtrim(nama) nama FROM hrd_khs.tpribadi WHERE keluar = '0' and noind = '$noind'";
    	// echo $sql;exit();
        return $this->personalia->query($sql)->row()->nama;
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

} ?>