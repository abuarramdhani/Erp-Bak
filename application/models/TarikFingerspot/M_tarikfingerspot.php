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
		$this->finger178 = $this->load->database('db_fingerspot_178',TRUE);
		$this->finger179 = $this->load->database('db_fingerspot_179',TRUE);
		$this->finger207 = $this->load->database('db_fingerspot_207',TRUE);
		$this->personalia = $this->load->database('personalia',TRUE);
		$this->quick = $this->load->database('quick', TRUE);
	}

	public function getAttLog($periode, $status, $device){
		$filterDevice = '';
		if($device != null){
			$filterDevice = "and sn = '$device' ";
		}

		$data = array();
		if ('Transfer'==$status || 'Transfer178'==$status || 'Transfer179'==$status  || 'Transfer207'==$status ){
			$sql = "select cast(scan_date as date) tanggal, pin noind_baru,cast(scan_date as time) waktu, sn
					from fin_pro.att_log
					where cast(scan_date as date) >= cast('$periode' as date)
					order by scan_date,pin";
		}else{
			$sql = "select cast(scan_date as date) tanggal, pin noind_baru,cast(scan_date as time) waktu, sn
					from fin_pro.att_log
					where cast(scan_date as date) = cast('$periode' as date) $filterDevice
					order by scan_date,pin";
		}

		if ('Transfer'==$status){
			$resultFinger = $this->finger->query($sql);
			$resFinger = $resultFinger->result_array();
		} else if('Transfer178'==$status){
			$resultFinger = $this->finger178->query($sql);
			$resFinger = $resultFinger->result_array();
		} else if('Transfer179'==$status){
			$resultFinger = $this->finger179->query($sql);
			$resFinger = $resultFinger->result_array();
		} else if('Transfer207'==$status){
			$resultFinger = $this->finger207->query($sql);
			$resFinger = $resultFinger->result_array();
		} else {
			$a = $this->finger178->query($sql);
			$b = $this->finger179->query($sql);
			$c = $this->finger207->query($sql);
			$d = $this->finger->query($sql);

			$a = $a->result_array();
			$b = $b->result_array();
			$c = $c->result_array();
			$d = $d->result_array();

			$resFinger=array_merge($a,$b,$c,$d);
		}

		if (!empty($resFinger)) {
			$a = 0;
			foreach ($resFinger as $key) {
				$sql = "select noind,noind_baru,kodesie,tempat_makan
						from hrd_khs.tpribadi
						where noind_baru not like '  %'
						and cast(noind_baru as integer) = ".$key['noind_baru']."
						and keluar='0'
					";
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
							'nomor_sn' => $key['sn'],
							'tempat_makan' => $value['tempat_makan']
						);

					}
				}
				else
				{
				    //tarik data pekerja yang sudah keluar dengan menggunakan data nomor induk terakhir.
				   $sql = "select noind,noind_baru,kodesie,tempat_makan
						from hrd_khs.tpribadi
						where noind_baru not like '  %'
						and cast(noind_baru as integer) = ".$key['noind_baru']."
						order by tglkeluar desc limit 1
					";
					$resultHrdkeluar = $this->personalia->query($sql);
					$resHrdkeluar = $resultHrdkeluar->result_array();
					
					if(empty($resHrdkeluar)){
						$data[$a] = array(
							'tanggal' => 'unknown',
							'waktu' => 'unknown',
							'noind' => 'unknown',
							'kodesie' => 'unknown',
							'noind_baru' => $key['noind_baru'],
							'nomor_sn' => 'unknown',
							'tempat_makan' => 'unknown'
						);
					}

			    	foreach ($resHrdkeluar as $value) {
						$data[$a] = array(
							'tanggal' => $key['tanggal'],
							'waktu' => $key['waktu'],
							'noind' => $value['noind'],
							'kodesie' => $value['kodesie'],
							'noind_baru' => $value['noind_baru'],
							'nomor_sn' => $key['sn'],
							'tempat_makan' => $value['tempat_makan']
						);

					}

				}

				$sql = "select *
						from db_datapresensi.tb_device
						where device_sn = '{$key['sn']}' ";
				$resultDev = $this->quick->query($sql);
				$resDev = $resultDev->result_array();
				if (!empty($resDev)) {
					$data[$a]['user_'] = $resDev['0']['inisial_lokasi'];
				}else{
					$data[$a]['user_'] = 'MNL';
				}

				$a++;
			}
		}

		return $data;
	}

	public function cekPresensiL($data){
		$sql = "select * from \"Presensi\".tprs_shift2
				where noind = '".$data['noind']."'
				and tanggal = '".$data['tanggal']."'
				and waktu = '".$data['waktu']."' ";
		$result = $this->personalia->query($sql);
		$n = $result->num_rows();
		return $n;

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

	public function cekPresensiRill($data)
	{
		$sql = "select * from \"Presensi\".tpresensi_riil
				where noind = '".$data['noind']."'
				and tanggal = '".$data['tanggal']."'
				and waktu = '".$data['waktu']."' ";
		$result = $this->personalia->query($sql);
		$n = $result->num_rows();
		return $n;
	}

	public function cekCatering($data){
		$sql = "select * from \"Catering\".tpresensi
				where noind = '".$data['noind']."'
				and tanggal = '".$data['tanggal']."'
				and waktu = '".$data['waktu']."' ";
		$result = $this->personalia->query($sql);
		$n = $result->num_rows();
		return $n;
	}

	public function cekLokasiFinger($inisial){
		$sql = "select * 
				from db_datapresensi.tb_device 
				where inisial_lokasi = '$inisial'";
		$result = $this->quick->query($sql);
		return $result->row()->office;
	}

	public function cekLokasiKerja($noind){
		$sql = "select * from hrd_khs.tpribadi
				where noind = '".$noind."'";
		$result = $this->personalia->query($sql);
		return $result->result_array();

	}

	public function insert_presensi($table_schema, $table_name, $insert){
    	$this->personalia->insert($table_schema.".".$table_name, $insert);
    }

    public function getDevice(){
    	$sql = "select device_name,inisial_lokasi, 0 jumlah, server_ip,lokasi_server_tarik_data from db_datapresensi.tb_device order by 1";
    	$result = $this->quick->query($sql);
		return $result->result_array();
	}
	
	public function fingerspot_device()
	{
		$this->mysql->order_by('office', 'asc');
		$this->mysql->from('db_datapresensi.tb_device');
		return $this->quick->get()->result();
	}
}
