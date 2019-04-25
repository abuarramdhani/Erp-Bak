<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_overtime extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getTanggal($prd1,$prd2){
		$sql = "select dates::date tanggal, 
				(select count(*)
				from generate_series('$prd1','$prd2', interval '1 day') as date1
				where extract(month from date1) = extract(month from dates)) jmlhari,
				to_char(dates,'Month YYYY') bulan,
				to_char(dates,'dd') tgl
				from generate_series('$prd1','$prd2', interval '1 day') as dates";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPekerja(){
		$sql = "select noind,nama,lok.lokasi_kerja 
				from hrd_khs.tpribadi pri
				inner join hrd_khs.tlokasi_kerja lok
				on pri.lokasi_kerja = lok.id_
				where left(pri.noind,1) = 'R'
				and keluar = '0'
				order by pri.lokasi_kerja,pri.noind;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getOvertime($tanggal,$noind){
		$sql = "select 	tps.tanggal::date,
						tps.noind,
						case when tsp.kd_shift isnull then 
							case when extract(epoch from max(tps.waktu::time) - min(waktu::time))/3600 < 0 then 
								0
							else 
								extract(epoch from max(tps.waktu::time) - min(waktu::time))/3600
							end
						else 
							case when extract(epoch from max(tps.waktu::time) - tsp.jam_plg::time)/3600 < 0 then 
								0
							else 
								extract(epoch from max(tps.waktu::time) - tsp.jam_plg::time)/3600
							end
						end overtime
				from \"Presensi\".tprs_shift tps
				left join \"Presensi\".tshiftpekerja tsp
				on tps.tanggal = tsp.tanggal
				and tps.noind = tsp.noind
				where tps.noind = '$noind'
				and tps.tanggal = '$tanggal'
				group by tps.tanggal,tps.noind,tsp.kd_shift,tsp.jam_plg";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
}
?>