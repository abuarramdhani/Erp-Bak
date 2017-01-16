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
		public function GetDeviceList(){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT a.sn,(SELECT lokasi_kerja FROM frontpresensi.tb_lokasikerja AS xx WHERE xx.kd_lokasi=b.lokasi_kerja) AS lokasi_kerja,c.host,a.id_lokasi,(SELECT COUNT(yy.noind) FROM fp_distribusi.tb_fppribadi AS yy WHERE yy.id_lokasi=a.id_lokasi) AS registered,b.lokasi, IF(c.host IS NOT NULL,'1','0') AS status_
					FROM fp_distribusi.tb_device AS a
					LEFT JOIN fp_distribusi.tb_lokasi AS b ON a.id_lokasi=b.id_lokasi
					LEFT JOIN fp_distribusi.tb_mysql AS c ON a.id_lokasi=c.id_lokasi
					ORDER BY status_ DESC,a.id_lokasi";
			$query = $quickcom->query($sql);
			return $query->result_array();
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
			$sql = "SELECT a.sn,(SELECT lokasi_kerja FROM frontpresensi.tb_lokasikerja AS xx WHERE xx.kd_lokasi=b.lokasi_kerja) AS lokasi_kerja,c.host,a.id_lokasi,(SELECT COUNT(yy.noind) FROM fp_distribusi.tb_fppribadi AS yy WHERE yy.id_lokasi=a.id_lokasi) AS registered,b.lokasi, IF(c.host IS NOT NULL,'1','0') AS status_
					FROM fp_distribusi.tb_device AS a
					INNER JOIN fp_distribusi.tb_lokasi AS b ON a.id_lokasi=b.id_lokasi
					INNER JOIN fp_distribusi.tb_mysql AS c ON a.id_lokasi=c.id_lokasi
					WHERE a.id_lokasi='$id'";
			$query = $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function GetLocation($id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "SELECT * FROM fp_distribusi.tb_lokasi WHERE id_lokasi!='$id' ORDER BY id_lokasi";
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
			$quickcom	= $this->load->database('quickcom',true);
			$sql = "UPDATE fp_distribusi.tb_fppribadi SET id_lokasi='$tgt' WHERE noind='$id' AND id_lokasi='$loc'";
			$query = $quickcom->query($sql);
			return;
		}
		
		public function getPerson($q,$loc){
			$quickcom	= $this->load->database('quickcom',true);
			$sql		= "SELECT a.noind,a.nama,a.id_lokasi FROM fp_distribusi.tb_fppribadi AS a 
							left join fp_distribusi.tb_fppribadi AS b on a.noind=b.noind
							WHERE (b.id_lokasi<>'$loc' OR a.id_lokasi IS NULL) 
							AND  a.keluar='0' AND ( a.noind LIKE '%$q%') GROUP BY noind";
			$query		= $quickcom->query($sql);
			return $query->result_array();
		}
		
		public function checkloc($id){
			$quickcom	= $this->load->database('quickcom',true);
			$sql		= "select * from fp_distribusi.tb_fppribadi where noind='$id'";
			$query		= $quickcom->query($sql);
			return $query;
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
		
}
?>