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
  		$sql = "SELECT * FROM \"Surat\".tperizinan WHERE status = '1' $periode order by created_date DESC ";

  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

} ?>
