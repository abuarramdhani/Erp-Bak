<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_jadwallayanan extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getTanggalTampilPesanan($bulan_tahun,$lokasi){
		$sql = "select distinct fs_tanggal ,cast((split_part(split_part(fs_tanggal,'/',1),' - ',1)) as int) tanggal1,
				(case when fs_tanggal like '%-%' then split_part(split_part(fs_tanggal,'/',1),' - ',2) else '0' end) tanggal2,
				to_char(cast(concat((split_part(split_part(fs_tanggal,'/',1),' - ',1)),' ".$bulan_tahun."')as date), 'd') hari1,
				(case when fs_tanggal like '%-%' then to_char(cast(concat((split_part(split_part(fs_tanggal,'/',1),' - ',2)),' ".$bulan_tahun."')as date), 'd') else '0' end) hari2
				from \"Catering\".ttampilpesanan 
				where fs_tanggal like (concat('%',to_char(cast('01 ".$bulan_tahun."' as date),'/mm/yyyy'))) 
				and lokasi = '".$lokasi."'
				order by cast((split_part(split_part(fs_tanggal,'/',1),' - ',1)) as int);";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getDataTampilPesanan($tanggal,$lokasi){
		$sql = "select tt.* ,tk.fs_nama_katering
				from \"Catering\".ttampilpesanan tt
				inner join \"Catering\".tkatering tk
				on tt.fs_kd_katering = tk.fs_kd_katering
				where fs_tanggal like '$tanggal' 
				and lokasi = '$lokasi'
				order by fs_kd_katering;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
}
?>