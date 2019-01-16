<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_tarikfingerspot extends CI_MODEL
{
	
	function __construct()
	{
		parent::__construct();
		$this->finger = $this->load->database('db_fingerspot',TRUE);
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getAttLog($periode){
		$data = array();
		$sql = "select cast(scan_date as date) tanggal, pin noind_baru,cast(scan_date as time) waktu 
		from fin_pro.att_log 
		where cast(scan_date as date) = cast('$periode' as date)
		order by scan_date,pin";
		$resultFinger = $this->finger->query($sql);
		$resFinger = $resultFinger->result_array();
		if (!empty($resFinger)) {
			$a = 0;
			foreach ($resFinger as $key) {
				$sql = "select noind,noind_baru,kodesie 
						from hrd_khs.tpribadi 
						where noind_baru not like '  %'
						and cast(noind_baru as integer) = ".$key['noind_baru']." 
						and keluar = '0'";
				$resultHrd = $this->personalia->query($sql);
				$resHrd = $resultHrd->result_array();
				if (!empty($resHrd)) {
					foreach ($resHrd as $value) {
						$data[$a] = array(
							'tanggal' => $key['tanggal'],
							'waktu' => $key['waktu'],
							'noind' => $value['noind'],
							'kodesie' => $value['kodesie'],
							'noind_baru' => $value['noind_baru'],
							'user_' => 'MNL'
						);
						$a++;
					}
				}
			}
		}
		return $data;
	}

	public function cekPresensi($data){
		$sql = "select * from \"FrontPresensi\".tpresensi 
				where noind = '".$data['noind']."' 
				and tanggal = '".$data['tanggal']."' 
				and waktu = '".$data['waktu']."' ";
		$result = $this->personalia->query($sql);
		$n = $result->num_rows();
		return $n;

	}

	public function insert_presensi($table_schema, $table_name, $insert){
    	$this->personalia->insert($table_schema.".".$table_name, $insert);
    }
}