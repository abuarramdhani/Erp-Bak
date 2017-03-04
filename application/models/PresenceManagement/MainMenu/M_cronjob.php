<?php
class M_cronjob extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		public function getWorker($loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function deleteWorker($loc,$noind){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from hrd_khs.tpribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function checkDuplicateFinger($loc){
			@$loadConPostgres = $this->load->database('my_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "SELECT finger, COUNT(finger) c FROM coba_jari.tb_jari_tks GROUP BY finger HAVING c > 1";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function checkid($loc,$finger){
			@$loadConPostgres = $this->load->database('my_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from coba_jari.tb_jari_tks where finger='$finger'";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function getWorkerSpec($loc,$noind){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return $query;
			}
		}
		
		public function deleteShift($loc,$noind,$date){
			$year	= substr($date,0,4);
			$month	= substr($date,5,2);
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from presensi_local.tshiftpekerja where noind='$noind' and extract(year from tanggal)='$year' and extract(month from tanggal)='$month'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function deleteTmp($loc,$noind){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from frontpresensi.ttmppribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function getSection(){
			$personalia	= $this->load->database('personalia',true);
			$sql				= "select * from hrd_khs.tseksi";
			$query			= $personalia->query($sql);
			return $query->result_array();
		}
		
		public function checkSection($kodesie,$id_loc){
			@$loadConPostgres = $this->load->database('pg_'.$id_loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tseksi where kodesie='$kodesie'";
				$query	= $loadConPostgres->query($sql);
				return $query->num_rows();
			}
		}
		
		public function insertSection($kodesie, $dept, $bidang, $unit, $seksi, $pekerjaan, $golkerja,$id_loc){
			@$loadConPostgres = $this->load->database('pg_'.$id_loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "INSERT INTO hrd_khs.tseksi
								(kodesie, dept, bidang, unit, seksi, pekerjaan, golkerja)
								VALUES('$kodesie', '$dept', '$bidang', '$unit', '$seksi','$pekerjaan', '$golkerja');
								";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function deleteFinger($loc,$noind){
			@$loadConPostgres = $this->load->database('my_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from coba_jari.tb_jari_tks where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function check_out_worker($id){
			$pgPersonalia	= $this->load->database("personalia",true);
			$sql	= "select * from hrd_khs.tpribadi where noind='$id'";
			$query= $pgPersonalia->query($sql);
			return $query->result_array();
		}
		
		public function deletePgHrd(){
			$pgPersonalia	= $this->load->database("personalia",true);
			$sql	= "delete from hrd_khs.tpribadi";
			$query= $pgPersonalia->query($sql);
			return $query->result_array();
		}
		
		public function load_loc(){
			$quickcom	= $this->load->database("quickcom",true);
			$sql				= "select id_lokasi,lokasi from fp_distribusi.tb_lokasi where status_='1'";
			$query			= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function getWorkerAll($loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function insert_log($db,$act,$timeStart,$timeStop,$date,$location){
			$quickcom	= $this->load>database("quickcom",true);
			$sql	= "INSERT INTO fp_distribusi.tb_cronjob
						(database_, act, id_lokasi, date_, time_start, time_stop, duration, status_)
						VALUES('$db', '$act', '$location', '$date', '$timeStart', '$timeStop', (time_to_sec('$time_stop') - time_to_sec('$time_start')), '1')";
			$query	= $quickcom->query($sql);
			return;
		}
		
		public function checkActiveLoc($loc){
			$quickcom	= $this->load>database("quickcom",true);
			$sql	= "select * from fp_distribusi.tb_lokasi where id_lokasi='$loc'";
			$query	= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function changeActive($change,$loc){
			$quickcom	= $this->load>database("quickcom",true);
			$sql	= "update fp_distribusi.tb_lokasi set status_='$change' where id_lokasi='$loc'";
			$query	= $quickcom->query($sql);
			return;
		}
}
?>