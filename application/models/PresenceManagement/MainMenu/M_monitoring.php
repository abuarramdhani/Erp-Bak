<?php
class M_monitoring extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//===========================
		// 	PRESENCE MANAGEMENT START
		//===========================
		
		//select
		
		public function GetLocationSpot(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT a.id_lokasi,b.sn,c.host,a.lokasi,a.lokasi_kerja ,(d.lokasi_kerja) as kantor
							FROM fp_distribusi.tb_lokasi AS a
							LEFT JOIN fp_distribusi.tb_device AS b ON a.id_lokasi=b.id_lokasi
							LEFT JOIN fp_distribusi.tb_mysql AS c ON a.id_lokasi=c.id_lokasi
							LEFT JOIN frontpresensi.tb_lokasikerja AS d ON a.lokasi_kerja=d.kd_lokasi
							WHERE a.status_='1'
							ORDER BY a.lokasi_kerja,a.id_lokasi";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function getDataLocalComputer($id){
			@$loadConPostgres = $this->load->database('pg_'.$id.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi order by noind";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function checkFinger($id,$loc){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "Select * from coba_jari.tb_jari_tks as a 
								LEFT JOIN coba_jari.tb_jari as b on a.id_finger=b.id_finger where a.noind='$id' order by a.id_finger";
				$query	= $loadConSQL->query($sql);
				return $query->result_array();
			}
		}
		
		public function checkPerson($id,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checkPostgres = $loadConPostgres->initialize();
			if($checkPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi where noind='$id'";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		//select
		public function GetRegisteredPeople($id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT a.*,b.jabatan,(SELECT COUNT(xx.noind) FROM fp_distribusi.tb_jari_tks AS xx WHERE a.noind=xx.noind) AS fp_code 
					FROM fp_distribusi.tb_fppribadi AS a 
					LEFT JOIN hrd_khs.tpribadi AS b ON a.noind=b.noind
					WHERE a.id_lokasi='$id' order by a.noind";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function GetSpesificDeviceList($id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT a.sn,a.ac,a.vc, (b.lokasi_kerja) AS kantor,c.host,a.id_lokasi,b.kd_lokasi,d.lokasi
						FROM fp_distribusi.tb_lokasi AS d
						LEFT JOIN fp_distribusi.tb_device AS a ON a.id_lokasi=d.id_lokasi
						LEFT JOIN frontpresensi.tb_lokasikerja AS b ON d.lokasi_kerja=b.kd_lokasi
						LEFT JOIN fp_distribusi.tb_mysql AS c ON a.id_lokasi=c.id_lokasi
						WHERE a.id_lokasi='$id'";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function DeviceNull(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "select * from fp_distribusi.tb_device where id_lokasi is null";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function GetLocation($id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT * FROM fp_distribusi.tb_lokasi WHERE id_lokasi!='$id' and status_='1' ORDER BY id_lokasi";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function DelRegisteredPerson($loc,$id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "delete from fp_distribusi.tb_fppribadi WHERE noind='$id' AND id_lokasi='$loc'";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function UpdateRegisteredPerson($loc,$id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "UPDATE fp_distribusi.tb_fppribadi SET id_lokasi=NULL WHERE noind='$id' AND id_lokasi='$loc'";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function UpdateNameLocation($loc,$name){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "UPDATE fp_distribusi.tb_lokasi SET lokasi='$name' WHERE id_lokasi='$loc'";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function MutationRegisteredPerson($tgt,$loc,$id){
			echo $tgt." || ".$loc." || ".$id;
		}
		
		public function exclude_person($loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select noind from hrd_khs.tpribadi";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		// public function getPerson($q,$loc){
			// $quickcom	= $this->load->database('quickcom',true);
			// $sql		= "SELECT a.noind,a.nama,a.id_lokasi FROM fp_distribusi.tb_fppribadi AS a 
							// left join fp_distribusi.tb_fppribadi AS b on a.noind=b.noind
							// WHERE (b.id_lokasi<>'$loc' OR a.id_lokasi IS NULL) 
							// AND  a.keluar='0' AND ( a.noind LIKE '%$q%' or a.nama like '%$q%') GROUP BY noind";
			// $query		= $quickcom->query($sql);
			// return $query->result_array();
		// }
		
		public function getPerson($q,$loc){
			$pgPersonalia	= $this->load->database('personalia',true);
			$sql		= "select noind,nama from hrd_khs.tpribadi where keluar='0' and (noind like '$q%' or nama like '$q%')";
			$query		= $pgPersonalia->query($sql);
			return $query->result_array();
		}
		
		public function getSection($q,$loc){
			$pgPersonalia	= $this->load->database('personalia',true);
			$sql		= "select distinct(left(kodesie,7)) as kodesie,seksi from hrd_khs.tseksi where kodesie like '$q%' or seksi like '$q%'";
			$query		= $pgPersonalia->query($sql);
			return $query->result_array();
		}
		
		public function checkloc($id,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select noind from hrd_khs.tpribadi where noind='$id'";
				$query	= $loadConPostgres->query($sql);
				return $query->num_rows();
			}
		}
		
		public function updatePerson($id,$loc){
			$quickcom	= $this->load->database('quickcom',true);
			$sql		= "update fp_distribusi.tb_fppribadi set id_lokasi='$loc' where noind='$id'";
			$query		= $quickcom->query($sql);
			return;
		}
		
		public function insertPerson($id,$loc){
			$quickcom	= $this->load->database('quickcom',true);
			$sql		= "INSERT INTO fp_distribusi.tb_fppribadi (noind,nama,jenkel,alamat,nohp,diangkat,masukkerja,kodesie,keluar,tglkeluar,noind_baru,kode_status_kerja,lokasi_kerja,access,id_lokasi)
							SELECT DISTINCT(noind),nama,jenkel,alamat,nohp,diangkat,masukkerja,kodesie,keluar,tglkeluar,noind_baru,kode_status_kerja,lokasi_kerja,access,'$loc'
							FROM fp_distribusi.tb_fppribadi
							WHERE noind='$id'";
			$query		= $quickcom->query($sql);
			return;
		}
		
		public function GetAccessablePeople(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT a.*,b.jabatan,(SELECT COUNT(xx.noind) FROM ceklembur.tb_jari_tks AS xx WHERE a.noind=xx.noind) AS fp_code 
					FROM fp_distribusi.tb_fppribadi AS a 
					LEFT JOIN hrd_khs.tpribadi AS b ON a.noind=b.noind
					WHERE a.access='1' order by a.noind";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		//------------------------------ MENU ADD DEVICE
		
		public function maxfinger(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT MAX(CAST(SUBSTR(id_lokasi,3) AS UNSIGNED)) as maxfp FROM fp_distribusi.tb_lokasi ORDER BY id_lokasi";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function office(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT * FROM frontpresensi.tb_lokasikerja ORDER BY kd_lokasi";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function checkDevice($sn){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT * FROM fp_distribusi.tb_device WHERE sn='$sn'";
			$query = $quickcom->query($sql);
			return $query->num_rows();
		}
		
		public function inserttblokasi($idloc,$loc,$off){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "INSERT INTO fp_distribusi.tb_lokasi (id_lokasi,lokasi,lokasi_kerja) VALUES ('$idloc','$loc','$off')";
			$query = $quickcom->query($sql);
			return;
		}

		public function inserttbdevice($sn,$vc,$ac,$idloc){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "INSERT INTO fp_distribusi.tb_device (sn,vc,ac,id_lokasi) VALUES ('$sn','$vc','$ac','$idloc')";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function inserttbmysql($idloc,$ip){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "INSERT INTO fp_distribusi.tb_mysql (id_lokasi,host,user,pass,db) VALUES ('$idloc','$ip','$ip','123456','coba_jari')";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function inserttbpostgres($idloc,$ip){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "INSERT INTO fp_distribusi.tb_postgres (id_lokasi,host,port,db,user,pass) VALUES ('$idloc','$ip','5432','presensi','postgres','123456')";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function GetSpesificDevice($id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT a.*,b.*,c.*
					FROM fp_distribusi.tb_device AS a
					LEFT JOIN fp_distribusi.tb_lokasi AS b ON a.id_lokasi=b.id_lokasi
					LEFT JOIN fp_distribusi.tb_mysql AS c ON a.id_lokasi=c.id_lokasi
					WHERE a.sn='$id'";
			$query = $quickcom->query($sql);
			return;
		}
		
		//--------------------------- Menu Registered person
		
		public function GetListPerson(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "select * from fp_distribusi.tb_fppribadi where keluar='0' group by noind order by noind";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function getListLocation(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "select * from fp_distribusi.tb_lokasi order by id_lokasi";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		//=========================
		// 	PRESENCE MANAGEMENT END
		//=========================
		
		public function delete_finger($loc,$noind,$fing){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "delete from coba_jari.tb_jari_tks where id_finger='$fing' and noind='$noind'";
				$query	= $loadConSQL->query($sql);
				return;
			}
		}
		
		public function delete_all_noind($noind,$loc){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "delete from coba_jari.tb_jari_tks where noind='$noind'";
				$query	= $loadConSQL->query($sql);
				return;
			}
		}
		
		public function count_finger($loc,$noind){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "select * from coba_jari.tb_jari_tks where noind='$noind'";
				$query	= $loadConSQL->query($sql);
				return $query->num_rows();
			}
		}
		
		public function delete_person_by_finger($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from hrd_khs.tpribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function checkAllFinger($id,$qfinger){
				$quickcom 	= $this->load->database("quickcom",true);
				$sql	= "select a.id_finger,a.noind,a.finger,b.jari from fp_distribusi.tb_jari_tks as a
							left join fp_distribusi.tb_jari as b on a.id_finger=b.id_finger where a.noind='$id'
							 $qfinger";
				$query	= $quickcom->query($sql);
				return $query->result_array();
		}
		
		public function insert_finger_by_person($finger_code,$loc){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "select * from coba_jari.tb_jari_tks where noind='$noind'";
				$query	= $loadConSQL->query($sql);
				return $query->num_rows();
			}
		}
		
		public function insert_finger($noind,$noind_baru,$var_id_finger,$var_code,$loc){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "insert into coba_jari.tb_jari_tks values ('$var_id_finger','$noind','$var_code','$noind_baru')";
				$query	= $loadConSQL->query($sql);
				return;
			}
		}
		
		public function get_worker_hrd($noind){
			$quickcom = $this->load->database("quickcom",true);
			$sql	= "select * from fp_distribusi.tb_fppribadi where noind='$noind'";
			$query	= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function get_finger($noind,$qfinger){
			$quickcom = $this->load->database("quickcom",true);
			$sql	= "select * from fp_distribusi.tb_jari_tks where noind='$noind' $qfinger";
			$query	= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function insert_hrd($noind,$nama,$jenkel,$alamat,$telepon,$nohp,$diangkat,$masukkerja,$kodesie,$keluar,$tglkeluar,$noind_baru,$kodestatus,$lokasi_kerja,$tgt){
			@$loadConPostgres = $this->load->database('pg_'.$tgt.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "INSERT INTO hrd_khs.tpribadi
								(noind, nama, jenkel, alamat, telepon, nohp, diangkat, masukkerja, kodesie, keluar, tglkeluar, noind_baru, kode_status_kerja, lokasi_kerja)
								VALUES('$noind', '$nama', '$jenkel', '$alamat', '$telepon', '$nohp', '$diangkat', '$masukkerja', '$kodesie', '$keluar', '$tglkeluar', '$noind_baru', '$kodestatus', '$lokasi_kerja');
								";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function delete_hrd_by_finger($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from hrd_khs.tpribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function delete_shift_by_finger($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from presensi_local.tshiftpekerja where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function delete_tmp_by_finger($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from frontpresensi.tpresensilokal where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function get_worker_hrd_local($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function get_worker_shift($noind,$date,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from presensi_local.tshiftpekerja where noind='$noind' and tanggal>='$date'";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function insert_shift($date, $noind, $kd_shift, $kodesie, $tukar, $jam_msk, $jam_akhmsk, $jam_plg, $break_mulai, $break_selesai, $ist_mulai, $ist_selesai, $jam_kerja, $user,$noind_baru,$tgt){
			@$loadConPostgres = $this->load->database('pg_'.$tgt.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "INSERT INTO presensi_local.tshiftpekerja
								(tanggal, noind, kd_shift, kodesie, tukar, jam_msk, jam_akhmsk, jam_plg, break_mulai, break_selesai, ist_mulai, ist_selesai, jam_kerja, user_, noind_baru)
								VALUES('$date', '$noind', '$kd_shift', '$kodesie', '$tukar', '$jam_msk', '$jam_akhmsk', '$jam_plg', '$break_mulai', '$break_selesai', '$ist_mulai', '$ist_selesai', '$jam_kerja', '$user', '$noind_baru');
								";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function get_worker_tmppribadi($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from frontpresensi.ttmppribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return $query->result_array();
			}
		}
		
		public function insert_tmppribadi($noind, $nama,$kodesie, $dept, $seksi, $pekerjaan, $jmlttl, $pointttl, $nonttl, $photo, $path_photo, $noind_baru,$tgt){
			@$loadConPostgres = $this->load->database('pg_'.$tgt.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "INSERT INTO frontpresensi.ttmppribadi
								(noind, nama, kodesie, dept, seksi, pekerjaan, jmlttl, pointttl, nonttl, photo, path_photo, noind_baru)
								VALUES('$noind ', '$nama', '$kodesie', '$dept', '$seksi', '$pekerjaan', '$jmlttl', '$pointttl', '$nonttl', '$photo', '$path_photo', '$noind_baru');
								";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function get_worker_hrd_svr($id){
			$postgres_personalia	= $this->load->database("personalia",true);
			$sql				= "select * from hrd_khs.tpribadi where noind='$id'";
			$query			= $postgres_personalia->query($sql);
			return $query->result_array();
		}
		
		public function get_worker_shift_svr($noind,$date){
			$postgres_personalia	= $this->load->database("personalia",true);
			$sql				= "select * from \"Presensi\".tshiftpekerja where noind='$noind' and tanggal>='$date'";
			$query			= $postgres_personalia->query($sql);
			return $query->result_array();
		}
		
		public function get_worker_tmppribadi_svr($noind,$date){
			$year	= substr($date,0,4);
			$month	= substr($date,5,2);
			$postgres_personalia	= $this->load->database("personalia",true);
			$sql				= "select a.noind,a.nama,a.kodesie,b.dept,b.seksi,b.pekerjaan,
									(select sum(c.point) from \"Presensi\".tdatatim as c where a.Noind=c.noind and extract(year from c.tanggal)='$year' and extract(month from c.tanggal)='$month') as point
									,a.photo,a.path_photo,a.noind_baru 
									from hrd_khs.tpribadi as a 
									left join hrd_khs.tseksi as b on a.Kodesie=b.kodesie 
									where a.noind='$noind'";
			$query			= $postgres_personalia->query($sql);
			return $query->result_array();
		}
		
		public function get_finger_svr($noind){
			$quickcom	= $this->load->database("quickcom",true);
			$sql				= "select * from fp_distribusi.tb_jari_tks where noind='$noind' and id_finger in ('06','07')";
			$query			= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function get_worker_hrd_sec($id){
			$pgPersonalia = $this->load->database("personalia",true);
			$sql	= "select * from hrd_khs.tpribadi where keluar='0' and left(kodesie,7)='$id'";
			$query	=	$pgPersonalia->query($sql);
			return $query->result_array();
		}
		
		public function check_hrd_sec($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from hrd_khs.tpribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return $query->num_rows();
			}
		}
		
		public function check_shift_sec($noind,$tanggal,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from presensi_local.tshiftpekerja where noind='$noind' and tanggal='$tanggal'";
				$query	= $loadConPostgres->query($sql);
				return $query->num_rows();
			}
		}
		
		public function check_tmp_svr($noind,$loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "select * from frontpresensi.ttmppribadi where noind='$noind'";
				$query	= $loadConPostgres->query($sql);
				return $query->num_rows();
			}
		}
		
		public function check_finger_svr($noind,$id_finger,$loc){
			@$loadConSQL = $this->load->database('my_'.$loc.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "select * from coba_jari.tb_jari_tks where noind='$noind' and id_finger='$id_finger'";
				$query	= $loadConSQL->query($sql);
				return $query->num_rows();
			}
		}
		
		public function set_device($id,$device_new){
			$quickcom	= $this->load->database("quickcom",true);
			$sql	= "update fp_distribusi.tb_device set id_lokasi='$id' where sn='$device_new'";
			$query	= $quickcom->query($sql);
			return;
		}
		
		public function set_null_device($device_old){
			$quickcom	= $this->load->database("quickcom",true);
			$sql	= "update fp_distribusi.tb_device set id_lokasi=null where sn='$device_old'";
			$query	= $quickcom->query($sql);
			return;
		}
		
		public function change_host_mysql($id,$host){
			$quickcom	= $this->load->database("quickcom",true);
			$sql	= "update fp_distribusi.tb_mysql set host='$host' where id_lokasi='$id'";
			$query	= $quickcom->query($sql);
			return;
		}
		
		public function change_host_postgres($id,$host){
			$quickcom	= $this->load->database("quickcom",true);
			$sql	= "update fp_distribusi.tb_postgres set host='$host' where id_lokasi='$id'";
			$query	= $quickcom->query($sql);
			return;
		}
		
		public function change_device_comp($id,$sn,$vc,$ac){
			@$loadConSQL = $this->load->database('my_'.$id.'',TRUE);
			@$checkSQL = $loadConSQL->initialize();
			if($checkSQL === FALSE){
				return "failed";
			}else{
				$sql		= "INSERT INTO coba_jari.tb_device
								(device_sn, device_ver, device_act)
								VALUES('$sn', '$vc', '$ac')";
				$query	= $loadConSQL->query($sql);
				return;
			}
		}
		
		public function refresh_db(){
			$quickcom	= $this->load->database("quickcom",true);
			$sql	= "select * from fp_distribusi.tb_cronjob where act='fprefreshhrd'";
			$query	= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function set_to_null($device_old){
			$quickcom	= $this->load->database("quickcom",true);
			$sql	= "update fp_distribusi.tb_device set id_lokasi=null where sn='$device_old'";
			$query	= $quickcom->query($sql);
			return;
		}
		
		public function loadSection(){
			$pgPersonalia = $this->load->database("personalia",true);
			$sql	= "select * from hrd_khs.tseksi";
			$query	=	$pgPersonalia->query($sql);
			return $query->result_array();
		}
		
		public function deleteSection($loc){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "delete from hrd_khs.tseksi";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
		
		public function insertSection($loc,$kodesie,$dept,$bidang,$unit,$seksi,$pekerjaan,$golkerja){
			@$loadConPostgres = $this->load->database('pg_'.$loc.'',TRUE);
			@$checlPostgres = $loadConPostgres->initialize();
			if($checlPostgres === FALSE){
				return "failed";
			}else{
				$sql		= "insert into hrd_khs.tseksi (kodesie,dept,bidang,unit,seksi,pekerjaan,golkerja) values ('$kodesie','$dept','$bidang','$unit','$seksi','$pekerjaan','$golkerja')";
				$query	= $loadConPostgres->query($sql);
				return;
			}
		}
}
?>