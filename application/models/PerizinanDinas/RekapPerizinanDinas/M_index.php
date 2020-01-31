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

  	public function IzinApprove($periode)
  	{
        if (!empty($periode)) {
            $new = "WHERE $periode";
        }else {
            $new = "";
        }
  		$sql = "SELECT ti.* FROM \"Surat\".tperizinan ti $new order by ti.created_date DESC, ti.status ";

  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

    // public function getAktual($id, $noind, $tanggal)
    // {
    //     $sql = "SELECT * FROM \"Surat\".taktual_izin WHERE izin_id = '$id' AND noinduk = '$noind' AND created_date = '$tanggal'";
    //     return $this->personalia->query($sql)->result_array();
    // }

    public function getPekerja($tanggal)
	{
        if (!empty($tanggal)) {
            $new = "WHERE $tanggal";
        }else {
            $new = "";
        }
		$sql = "SELECT ti.*, (SELECT trim(nama) as nama FROM hrd_khs.tpribadi WHERE noind = ti.noind) as nama, tp.jenis_izin, tp.atasan_aproval, tp.keterangan, tp.created_date
				FROM \"Surat\".tpekerja_izin ti
                LEFT JOIN \"Surat\".tperizinan tp ON tp.izin_id = ti.izin_id::int $new
				ORDER BY ti.izin_id DESC, tp.status, ti.noind";
		return $this->personalia->query($sql)->result_array();
	}

} ?>
