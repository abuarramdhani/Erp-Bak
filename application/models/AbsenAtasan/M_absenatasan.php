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

	
	public function getList($noind,$approver){
		// print_r($approver);exit();	
		$sql = "SELECT approval.approver, absen.*,jenis.* FROM at.at_absen_approval approval, at.at_absen absen,at.at_jenis_absen jenis WHERE (left(approval.approver,5) = '$noind' OR approval.approver LIKE '%$approver%' ) AND approval.absen_id = absen.absen_id AND absen.jenis_absen_id = jenis.jenis_absen_id and absen.noind not in (select noind from at.at_laju) ORDER BY waktu desc";
		$query = $this->db->query($sql);
		// print_r($sql);exit();
		return $query->result_array();
	}

	public function getListabsLaju($noind,$approver){
		// print_r($approver);exit();	
		$sql = "SELECT approval.approver, absen.*,jenis.* FROM at.at_absen_approval approval, at.at_absen absen,at.at_jenis_absen jenis WHERE approval.absen_id = absen.absen_id AND absen.jenis_absen_id = jenis.jenis_absen_id and absen.noind in (select noind from at.at_laju) ORDER BY approval.status desc";
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

	public function getEmployeeEmailByNama($noinduk,$nama){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_code='$noinduk' and resign=0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmailPersonalia(){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_code IN ('B0720','B0898') ";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}

	public function getAtasanApprover($noind , $jabatan,$KdJabatan) {
		$this->load->model('SystemIntegration/M_submit');
		$data = array();
		$kodesie = $this->session->kodesie;
		//cek perbantuan jika ada pakai kodesinya
		$d = date('Y-m-d');
		$sqll = "select
					kodesie_baru
				from
					\"Surat\".tsurat_perbantuan tp
				where
					noind = '$noind'
					and tanggal_selesai_perbantuan > '$d'";
		if($this->personalia->query($sqll)->num_rows() > 0){
			$kodesie = $this->personalia->query($sqll)->row()->kodesie_baru;
		}

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
						INNER join hrd_khs.trefjabatan t on t.noind = a.noind 
					WHERE
						$where
					and substring(t.kodesie, 1, 4) = (
						SELECT substring( '$kodesie', 1, 4 )
					)
					and a.keluar ='0'
					group by a.noind,a.nama
					ORDER BY a.noind,a.nama;";
			$result2 = $personalia->query($sql2)->result_array();
			$sql3 = "SELECT su.user_name employee_code, su.employee_name FROM si.si_approver_khusus ak 
					LEFT JOIN sys.vi_sys_user su ON su.user_name =  ak.no_induk
					WHERE ak.kodesie like '$kodesie_subs%'";

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

			$sql3 = "SELECT su.user_name employee_code, su.employee_name FROM si.si_approver_khusus ak 
					LEFT JOIN sys.vi_sys_user su ON su.user_name =  ak.no_induk
					WHERE ak.kodesie like '$kodesie_subs%'";
			$result3 = $this->db->query($sql3)->result_array();

			$result2 = array_merge(array_values($result4),array_values($result3));
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

	public function getAbsenById($id){
		$sql = "
			select 	a.employee_code as noind , 
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
					d.tgl_approval,
					b.status
			FROM er.er_employee_all a INNER JOIN at.at_absen B ON a.employee_code = b.noind 
			INNER JOIN at.at_jenis_absen c ON b.jenis_absen_id = c.jenis_absen_id  
			INNER JOIN at.at_absen_approval d ON b.absen_id = d.absen_id
			WHERE b.absen_id = ?
			order by b.waktu
			";
			// b.status = 1 and
		return $this->db->query($sql,array($id))->result_array();
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

	function getShiftByNoindTanggal($noind,$tanggal){
		$sqlSelectShift = "select 
					concat(tsp.tanggal::date,' ',tjs.jam_msk) as jam_msk,
					concat(tsp.tanggal::date,' ',tjs.jam_akhmsk) as jam_akhmsk,
					case when tjs.break_mulai::time > tjs.jam_msk::time then 
						concat(tsp.tanggal::date,' ',tjs.break_mulai)
					else 
						concat((tsp.tanggal + interval '1 day')::date,' ',tjs.break_mulai)
					end as break_mulai,
					case when tjs.break_selesai::time > tjs.jam_msk::time then 
						concat(tsp.tanggal::date,' ',tjs.break_selesai)
					else 
						concat((tsp.tanggal + interval '1 day')::date,' ',tjs.break_selesai)
					end as break_selesai,
					case when tjs.ist_mulai::time > tjs.jam_msk::time then 
						concat(tsp.tanggal::date,' ',tjs.ist_mulai)
					else 
						concat((tsp.tanggal + interval '1 day')::date,' ',tjs.ist_mulai)
					end as ist_mulai,
					case when tjs.ist_selesai::time > tjs.jam_msk::time then 
						concat(tsp.tanggal::date,' ',tjs.ist_selesai)
					else 
						concat((tsp.tanggal + interval '1 day')::date,' ',tjs.ist_selesai)
					end as ist_selesai,
					case when tjs.jam_plg::time > tjs.jam_msk::time then 
						concat(tsp.tanggal::date,' ',tjs.jam_plg)
					else 
						concat((tsp.tanggal + interval '1 day')::date,' ',tjs.jam_plg)
					end as jam_plg,
					tjs.jam_kerja,
					tjs.lompat_tgl,
					case when tjs.lompat_tgl = '1' then 
						(tsp.tanggal + interval '1 day')::date
					else 
						tsp.tanggal::date
					end as akhir,
					tsp.tanggal::date as awal
				from \"Presensi\".tshiftpekerja tsp 
				left join \"Presensi\".tjamshift tjs 
				on trim(tsp.kd_shift) = trim(tjs.kd_shift)
				and ( 
					case when extract(isodow from tsp.tanggal) = 1 then 
						'Senin'
					when extract(isodow from tsp.tanggal) = 2 then
						'Selasa'
					when extract(isodow from tsp.tanggal) = 3 then
						'Rabu'
					when extract(isodow from tsp.tanggal) = 4 then
						'Kamis'
					when extract(isodow from tsp.tanggal) = 5 then
						'Jumat'
					when extract(isodow from tsp.tanggal) = 6 then
						'Sabtu'
					when extract(isodow from tsp.tanggal) = 7 then
						'Minggu'
					end
				) = trim(tjs.hari)
				where tsp.noind = '$noind'
				and tsp.tanggal = '$tanggal'
				order by tsp.tanggal";
		return $this->personalia->query($sqlSelectShift)->result_array();
	}

	function getAbsenByNoindTanggal($noind,$awal,$akhir){
		$sqlSelectAbsen = "select concat(tanggal::date,' ',waktu) as waktu
				from \"Presensi\".tprs_shift
				where noind = '$noind'
				and tanggal between '$awal' and '$akhir'
				and transfer = '0'
				order by 1 ";
		return $this->personalia->query($sqlSelectAbsen)->result_array();
	}

	function insertMangkir($noind,$tanggal){
		$sqlInsertMangkir = "insert into \"Presensi\".tdatatim
				(tanggal,noind,kodesie,masuk,keluar,kd_ket,point,user_,noind_baru)
				select '$tanggal',noind,kodesie,'0','0','TM',1,'CRDIS',noind_baru
				from hrd_khs.tpribadi
				where noind ='$noind'";
		$this->personalia->query($sqlInsertMangkir);
	}

	function insertTerlambat($noind,$tanggal,$jam_msk,$abs_masuk){
		$sqlInsertTerlambat = "insert into \"Presensi\".tdatatim
				(tanggal,noind,kodesie,masuk,keluar,kd_ket,point,user_,noind_baru)
				select '$tanggal',noind,kodesie,'$abs_masuk'::time,'$jam_msk'::time,'TT',0.4,'CRDIS',noind_baru
				from hrd_khs.tpribadi
				where noind ='$noind'";
		$this->personalia->query($sqlInsertTerlambat);
	}

	function insertBekerja($noind,$tanggal,$masuk,$keluar){
		$sqlInsertBekerja = "insert into \"Presensi\".tdatapresensi
				(tanggal,noind,kodesie,masuk,keluar,kd_ket,total_lembur,ket,user_,noind_baru)
				select '$tanggal',noind,kodesie,'$masuk'::time,'$keluar'::time,'PKJ',0,'biasa','CRDIS',noind_baru
				from hrd_khs.tpribadi
				where noind ='$noind'";
		$this->personalia->query($sqlInsertBekerja);
	}

	function insertIjinKeluar($noind,$tanggal,$keluar,$masuk,$point){
		$sqlInsertIjinKeluar = "insert into \"Presensi\".tdatatim
				(tanggal,noind,kodesie,masuk,keluar,kd_ket,point,user_,noind_baru)
				select '$tanggal',noind,kodesie,'$masuk'::time,'$keluar'::time,'TIK',$point,'CRDIS',noind_baru
				from hrd_khs.tpribadi
				where noind ='$noind'";
		$this->personalia->query($sqlInsertIjinKeluar);
	}

	function hitungPoint($jam_msk,$jam_plg,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai,$keluar_ijin,$masuk_ijin){
		$point = 0;
		
		if (strtotime($keluar_ijin) < strtotime($jam_msk)) {
			$keluar_ijin = $jam_msk;
		}

		if (strtotime($masuk_ijin) > strtotime($jam_plg)) {
			$masuk_ijin = $jam_plg;
		}

		$sebelum_break = 0;
		$setelah_break = 0;
		$setelah_istirahat = 0;

		if (strtotime($keluar_ijin) < strtotime($break_mulai)) {
			if (strtotime($masuk_ijin < strtotime($break_mulai))) {
				$sebelum_break = strtotime($masuk_ijin) - strtotime($keluar_ijin);
			}else{
				$sebelum_break = strtotime($break_mulai) - strtotime($keluar_ijin);
			}
		}else{
			$sebelum_break = 0;
		}

		if (strtotime($keluar_ijin) < strtotime($ist_mulai) && strtotime($masuk_ijin) > strtotime($break_selesai)) {
			if (strtotime($keluar_ijin) < strtotime($break_selesai)) {
				if (strtotime($masuk_ijin) > strtotime($ist_mulai)) {
					$setelah_break = strtotime($ist_mulai) - strtotime($break_selesai);
				}else{
					$setelah_break = strtotime($masuk_ijin) - strtotime($break_selesai);
				}
			}else{
				if (strtotime($masuk_ijin) > strtotime($ist_mulai)) {
					$setelah_break = strtotime($ist_mulai) - strtotime($keluar_ijin);
				}else{
					$setelah_break = strtotime($masuk_ijin) - strtotime($keluar_ijin);
				}
			}
		}else{
			$setelah_break = 0;
		}

		if (strtotime($masuk_ijin) > strtotime($ist_selesai)) {
			if (strtotime($keluar_ijin > strtotime($ist_selesai))) {
				$setelah_istirahat = strtotime($masuk_ijin) - strtotime($keluar_ijin);
			}else{
				$setelah_istirahat = strtotime($masuk_ijin) - strtotime($ist_selesai);
			}
		}else{
			$setelah_istirahat = 0;
		}

		$point = ($sebelum_break + $setelah_break + $setelah_istirahat)/60;

		$sqlSelectPoint = "select point
				from \"Presensi\".tpoint
				where kd_ket='TIK'
				and $point between waktua and waktub";
		$resultSelectPoint = $this->personalia->query($sqlSelectPoint)->result_array();
		if (!empty($resultSelectPoint)) {
			return $resultSelectPoint['0']['point'];
		}else{
			return '0';
		}
	}

	function updateTransferAbsen($noind,$waktu){
		$sqlupdateTransferAbsen = "update \"Presensi\".tprs_shift
				set transfer = '1'
				where noind = '$noind'
				and tanggal = '$waktu'::date
				and waktu = '$waktu'::time::varchar";
		$this->personalia->query($sqlupdateTransferAbsen);
	}

	function getAbsenMangkirByNoindTanggal($noind,$tanggal){
		$sql = "select *
				from \"Presensi\".tdatatim
				where noind =  ?
				and trim(kd_ket) = 'TM'
				and tanggal = ?";
		return $this->personalia->query($sql,array($noind,$tanggal))->result_array();
	}

	function deleteMangkirByNoindTanggal($noind,$tanggal){
		$sql = "delete from \"Presensi\".tdatatim 
				where noind =  ?
				and trim(kd_ket) = 'TM'
				and tanggal = ?";
		$this->personalia->query($sql,array($noind,$tanggal));
	}
	
	function getPekerjaLaju($noinduk)
	{
		$this->db->where('noind', $noinduk);
		$query = $this->db->get('at.at_laju')->num_rows();
		return $query !== 0;
	}
}


?>