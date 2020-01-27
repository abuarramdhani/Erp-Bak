<?php 
Defined('BASEPATH') or exit('No Direct Sekrip Access Allowed');

class M_absenatasan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
	}

	public function getListAbsenById($id){
		$query = $this->db->query("SELECT absen.*,jenis.*,approval.approver FROM at.at_absen absen INNER JOIN at.at_jenis_absen jenis ON absen.jenis_absen_id = jenis.jenis_absen_id INNER JOIN at.at_absen_approval approval ON absen.absen_id = approval.absen_id WHERE absen.absen_id='$id' AND absen.jenis_absen_id = jenis.jenis_absen_id");
        return $query->result_array();
	}

	
	public function getList($approver){
		// print_r($approver);exit();	
		$sql = "SELECT approval.approver, absen.*,jenis.* FROM at.at_absen_approval approval, at.at_absen absen,at.at_jenis_absen jenis WHERE approval.approver='$approver' AND approval.absen_id = absen.absen_id AND absen.jenis_absen_id = jenis.jenis_absen_id ORDER BY approval.status desc";
		$query = $this->db->query($sql);
		// print_r($sql);exit();
		return $query->result_array();
	}

	public function getJenisAbsen(){
		$sql = "SELECT aa.*, ja.* FROM at.at_absen aa LEFT JOIN at.at_jenis_absen ja ON aa.jenis_absen_id = ja.jenis_absen_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmployeeInfo($noinduk){
		$sql = "SELECT a.*,b.section_name,b.unit_name,b.field_name,b.department_name FROM er.er_employee_all a INNER JOIN er.er_section b ON a.section_code = b.section_code WHERE a.section_code = b.section_code AND a.employee_code = '$noinduk'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getAtasan($absen_id){
		$sql 	= "SELECT approver FROM at.at_absen_approval WHERE absen_id='$absen_id'";
		$query 	= $this->db->query($sql);

		return $query->result_array();
	}

	public function approveAbsenApproval($id,$data1){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen_approval',$data1);
	}

	public function approveAbsen($id,$data2){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen',$data2);
	}

	public function rejectAbsenApproval($id,$data1){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen_approval',$data1);
	}
	public function rejectAbsen($id,$data2){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen',$data2);
	}

	public function getEmployeeEmail($noinduk){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_code='$noinduk'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmployeeEmailByNama($nama){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_name='$nama'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmailPersonalia(){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_code IN ('B0697','B0696','B0720','J1260','J1237') ";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}

	public function getAtasanApprover($noind , $jabatan,$KdJabatan) {
		$this->load->model('SystemIntegration/M_submit');
		$data = array();
		$kodesie = $this->session->kodesie;
		if(!empty($kodesie)){
			$kodesie = $kodesie;
		}else{
			$kodesie = $this->personalia->query("select * from hrd_khs.trefjabatan where noind='$noind'")->result_array()[0]['kodesie'];
		}
		$kodesie_subs = substr($kodesie, 0, 4);
		$kodesie_5 = substr($kodesie,0,5);
			
		$personalia = $this->load->database('personalia',true);
		$sql1 = "SELECT kd_jabatan FROM hrd_khs.tpribadi WHERE noind = '$noind'";
		$query1 = $personalia->query($sql1);
		$result1 = $query1->result_array();
		$jabatan_user = $result1[0]['kd_jabatan'];
		
		if($jabatan == '1') {
			$jabatan2 = str_pad($jabatan_user - 1, 2, "0", STR_PAD_LEFT);
			$where = "c.kd_jabatan between '01' and '$jabatan2'";
		} else if($jabatan == '2') {
			$jabatan2 = str_pad($jabatan_user - 2, 2, "0", STR_PAD_LEFT);
			$where = "c.kd_jabatan between '01' and '$jabatan2'";
		} else if($jabatan == '3') { // 3 untuk level department
			$where = "c.kd_jabatan in ('02','03','04')";
		} else if($jabatan == '4') {
			$where = "c.kd_jabatan = '01'";
		}
		
		if ($jabatan == '1') {
			$sql2 = "SELECT 
						a.noind employee_code, a.nama employee_name
					FROM hrd_khs.tpribadi a 
						INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
						INNER JOIN hrd_khs.torganisasi c on a.kd_jabatan=c.kd_jabatan
					WHERE
						$where
						and substring(a.kodesie, 1, 4) = (
							SELECT substring( kodesie, 1, 4 )
							FROM hrd_khs.tpribadi d
							WHERE d.noind = '$noind'
								and d.keluar = '0'
						)
						and a.keluar ='0'
					ORDER BY a.noind,a.nama";
			$query2 = $personalia->query($sql2);
			$result2 = $query2->result_array();
		} else if ($jabatan == '2') {
			$sql2 = "SELECT 
						a.noind employee_code, a.nama employee_name
					FROM hrd_khs.tpribadi a 
						INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
						INNER JOIN hrd_khs.torganisasi c on a.kd_jabatan=c.kd_jabatan
					WHERE
						$where
						and substring(a.kodesie, 1, 4) = (
							SELECT substring( kodesie, 1, 4 )
							FROM hrd_khs.tpribadi d
							WHERE d.noind = '$noind'
								and d.keluar = '0'
						)
						and a.keluar ='0'
					ORDER BY a.noind,a.nama";
			$result2 = $personalia->query($sql2)->result_array();
			$sql3 = "SELECT su.user_name employee_code, su.employee_name FROM si.si_approver_khusus ak 
					LEFT JOIN sys.vi_sys_user su ON su.user_name =  ak.no_induk
					WHERE ak.kodesie = '$kodesie_subs'";
			$result3 = $this->db->query($sql3)->result_array();

			$sqlPosShowroom = "select * from hrd_khs.trefjabatan where substr(kodesie,1,3) = '209' and kd_jabatan = '11' and substr(kodesie,7,1) != '1' order by substr(kodesie,7,1)";
			$resultPosSR	 = $this->personalia->query($sqlPosShowroom)->result_array();

			$arrPosSR = array();
			foreach ($resultPosSR as $key => $dt) {
				$arrPosSR[] = $dt['kodesie'];
			}

			if(in_array($kodesie, $arrPosSR)){
				$sql4 = "select a.noind as employee_code ,a.nama as employee_name from hrd_khs.tpribadi a INNER JOIN hrd_khs.trefjabatan b ON a.noind = b.noind WHERE a.noind!='$noind' and a.keluar=false and b.kd_jabatan = '11' and substr(a.kodesie,1,5) = '$kodesie_5'";
				$result4 = $this->personalia->query($sql4)->result_array();
				$result2 = array_merge(array_values($result2),array_values($result3),array_values($result4));
			}else{
				$result2 = array_merge(array_values($result2),array_values($result3));
			}

		} else if ($jabatan == '3') {
			$sql4 = "SELECT 
						a.noind employee_code, a.nama employee_name
					FROM hrd_khs.tpribadi a 
						INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
						INNER JOIN hrd_khs.torganisasi c on a.kd_jabatan=c.kd_jabatan
					WHERE $where
						and substring( a.kodesie, 1, 2 ) = (
							SELECT substring( kodesie, 1, 2 )
							FROM hrd_khs.tpribadi d
							WHERE d.noind = '$noind'
								and d.keluar = '0'
						)
						and a.keluar ='0'
					ORDER BY a.noind,a.nama";
			$query4 = $personalia->query($sql4);
			$result4 = $query4->result_array();
			$result2 = $result4;
		} elseif ($jabatan == '4') {
			$sql5 = "SELECT
						a.noind employee_code, a.nama employee_name
					FROM hrd_khs.tpribadi a 
						INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
						INNER JOIN hrd_khs.torganisasi c on a.kd_jabatan=c.kd_jabatan
					WHERE $where
						and substring( a.kodesie, 0, 1 ) = (
							SELECT substring( kodesie, 0, 1 )
							FROM hrd_khs.tpribadi d
							WHERE d.noind = '$noind'
								and d.keluar = '0'
						)
						and a.keluar ='0'
					ORDER BY a.noind,a.nama";
			$query5 = $personalia->query($sql5);
			$result5 = $query5->result_array();
			$result2 = $result5;
		}

		$allAtasan = $this->M_submit->getAllUser();
		foreach ($allAtasan as $key => $value) {
			$arrayUser[] = $value['user_name'];
		}

		foreach ($result2 as $key => $value) {
			if (in_array($value['employee_code'], $arrayUser) === true) {
				$data[] = $value;
			}
		}

		return $data;
	}

	public function getAbsenCRONJ(){
		$sql = "
			select a.employee_code as noind , 
				rtrim(a.employee_name) as nama ,
				a.new_employee_code as noind_baru , 
				a.section_code as kodesie , 
				b.tgl, 
				b.lokasi,
				b.longitude,
				b.latitude,
				b.waktu::time as wkt,
				c.jenis_absen,
				d.approver,
				d.tgl_approval
							FROM er.er_employee_all a INNER JOIN at.at_absen B ON a.employee_code = b.noind 
							INNER JOIN at.at_jenis_absen c ON b.jenis_absen_id = c.jenis_absen_id  
				                        INNER JOIN at.at_absen_approval d ON b.absen_id = d.absen_id
							WHERE b.status = 1 AND b.tgl >= now() - INTERVAL '10 DAY' AND b.tgl <= now() AND b.jenis_absen_id BETWEEN 1 AND 4 order by b.waktu
			";
			// b.status = 1 and
		return $this->db->query($sql)->result_array();
	}

	public function insert_presensi($table_schema, $table_name, $insert){
    	$this->personalia->insert($table_schema.".".$table_name, $insert);
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

	public function deleteTrial($table_schema, $table_name){
		$this->personalia->where('user_ =','ABSON');
		$this->personalia->delete($table_schema.".".$table_name);
	}


	

}


?>