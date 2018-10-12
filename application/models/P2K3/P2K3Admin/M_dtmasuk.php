<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Dtmasuk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
    }

    public function daftar_seksi($tgl, $tahun){
    	$query = "select distinct left(kb.kodesie, 7) kodesie, es.section_name seksi from k3.k3_kebutuhan kb
					join er.er_section es on es.section_code = kb.kodesie
					where extract(month from kb.create_timestamp) = '$tgl' 
					and extract (year from kb.create_timestamp) = '$tahun'
					order by es.section_name asc";
		// echo $query;
		// exit();
    	$result = $this->db->query($query);
    	return $result->result_array();
    }

    public function daftar_apd($seksi, $tgl, $tahun)
    {	
    	// print_r($seksi);
    	// exit();
		$query = "select km.*, 
	";

		$k = '1';
		foreach ($seksi as $row) {
			$no = $row['kodesie'];
			// $k = 1;
			$query = $query."(select sum(kd1.ttl_order) from k3.k3_kebutuhan k1 
		inner join k3.k3_kebutuhan_detail kd1 on k1.id_kebutuhan = kd1.id_kebutuhan 
		where km.kode_item = kd1.kode_item 
		and extract(month from kd1.create_date) = '$tgl' 
		and extract (year from kd1.create_date) = '$tahun'
		and k1.kodesie like '$no%') a$k, ";
		$k++;
		}
		$query = $query." (select sum(kd.ttl_order) 
		from k3.k3_kebutuhan_detail kd 
		where km.kode_item = kd.kode_item
		and extract(month from kd.create_date) = '$tgl' 
		and extract (year from kd.create_date) = '$tahun') jumlah_total from k3.k3_master_item km
		order by km.item asc";
		// echo $query;
		// exit();
    	$result = $this->db->query($query);
    	return $result->result_array();
    }

}