<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_tarikdatapekerja extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',true);
	}

	public function getData($hubungan,$kdsie = FALSE){
		if (isset($kdsie) and !empty($kdsie)) {
			$kd = " and a.kodesie like '$kdsie%'";
		}else{
			$kd = '';
		}
		
		$sql = "select a.noind,trim(a.nama)as nama,trim(b.dept)as dept,trim(b.bidang)as bidang,trim(b.unit)as unit,trim(b.seksi)as seksi,
		        trim(a.jabatan)as jabatan,c.lokasi_kerja,to_char(a.diangkat,'DD-MM-YYYY') as diangkat, to_char(a.akhkontrak,'DD-MM-YYYY') as akhkontrak
                from hrd_khs.tpribadi a
                inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
                inner join hrd_khs.tlokasi_kerja c on a.lokasi_kerja=c.id_
                where a.keluar='0' and left(a.noind,1)  in ($hubungan) $kd
                order by b.kodesie, a.noind ";
			
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
}
?>
