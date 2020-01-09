<?php
class M_splseksi extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->spl = $this->load->database('spl_db',true);
		$this->prs = $this->load->database('personalia', true);
		$this->sql = $this->load->database('quick', true);
	}

	public function show_noind(){
		$query = $this->spl->get('hrd_khs.tnoind');
		return $query->result_array();
	}

	public function show_lokasi(){
		$query = $this->spl->get('hrd_khs.tlokasi_kerja');
		return $query->result_array();
	}

	public function show_jenis_lembur(){
		$query = $this->spl->get('splseksi.tjenislembur');
		return $query->result_array();
	}

	public function show_pekerja($filter, $filter2, $akses_sie){
		$x = 0;
		$akses = "";
		if(!empty($akses_sie)){
			foreach($akses_sie as $as){
				if($x == 0){
					$akses = "kodesie like '$as%'";
				}else{
					$akses .= " or kodesie like '$as%'";
				}
				$x++;
			}

			$akses = "and ($akses)";
		}

		$sql = "select noind, nama, kodesie from hrd_khs.tpribadi
			where keluar='0' and (nama like '%$filter%' or noind like '%$filter%') and noind like '$filter2%' $akses order by nama";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_seksi($filter, $filter2, $akses_sie){
		$x = 0;
		$akses = "";
		if(!empty($akses_sie)){
			foreach($akses_sie as $as){
				if($x == 0){
					$akses = "kodesie like '$as%'";
				}else{
					$akses .= " or kodesie like '$as%'";
				}
				$x++;
			}

			$akses = "and ($akses)";
		}

		$sql = "select distinct substring(kodesie, 1, $filter2) as kode,
				(case
					when $filter2=7 then seksi
					when $filter2=5 then unit
					when $filter2=3 then bidang
					when $filter2=1 then dept
					else concat(seksi, ' - ', pekerjaan)
				end) as nama
			from hrd_khs.tseksi
			where (substring(kodesie, 1, $filter2)=substring('$filter', 1, $filter2)
				or (dept like '%$filter%' or bidang like '%$filter%' or unit like '%$filter%' or seksi like '%$filter%'))
				and substring(substring(kodesie, 1, $filter2), -1, 1)<>'0' $akses";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_akses_seksi($filter){
		$this->spl->where('noind', $filter);
		$query = $this->spl->get('takses_seksi');
		return $query->result_array();
	}

	public function show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie){
		$x = 0;
		foreach($akses_sie as $as){
			if($x == 0){
				$akses = "b.kodesie like '$as%'";
			}else{
				$akses .= " or b.kodesie like '$as%'";
			}
			$x++;
		}

		$sql = "select a.*, b.nama, d.kodesie, d.seksi, d.unit, d.dept, e.nama_lembur, c.Deskripsi, (select nama from hrd_khs.tpribadi where noind = a.user_) as user_approve
			from splseksi.tspl a
			inner join hrd_khs.tpribadi b ON a.noind = b.noind
			inner join splseksi.tjenislembur e ON a.kd_lembur = e.kd_lembur
			inner join splseksi.tstatus_spl c ON a.status = c.id_status
			inner join hrd_khs.tseksi d ON b.kodesie = d.kodesie
			where a.status like '%$status%' and a.tgl_lembur between '$dari' AND '$sampai'
					and a.perbantuan='N' and ($akses) and b.noind like '$noind%' and b.lokasi_kerja like '%$lokasi%'
			order by a.tgl_lembur, d.seksi, a.kd_lembur, b.nama, a.jam_mulai_lembur, a.Jam_Akhir_Lembur";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_current_shift($tanggal, $noind){
		$sql = "select *from \"Presensi\".tshiftpekerja where noind='$noind' and tanggal='$tanggal'";
		$query = $this->prs->query($sql);
		return $query->result_array();
	}

	public function show_current_spl($tanggal, $noind, $lembur, $idspl){
		if($idspl == ""){
			$sql = "select *from splseksi.tspl where Noind='$noind' and Tgl_Lembur='$tanggal' and Kd_Lembur='$lembur'";
		}else{
			$sql = "select *,b.nama from splseksi.tspl a inner join hrd_khs.tpribadi b on a.noind=b.noind where id_spl='$idspl'";
		}
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_maxid($table, $col){
		$query = $this->spl->query("select max($col)+1 as id from $table");
		return $query->row();
	}

	public function save_log($data){
		$this->spl->insert('splseksi.tlog',$data);
		return;
	}

	public function save_spl($data){
		$this->spl->insert('splseksi.tspl',$data);
		return;
	}

	public function save_splr($data){
		$this->spl->insert('splseksi.tspl_riwayat',$data);
		return;
	}

	public function drop_spl($filter){
		$this->spl->where('ID_SPL', $filter);
		$this->spl->delete('splseksi.tspl');

		$this->spl->where('ID_SPL', $filter);
		$this->spl->delete('splseksi.tspl_riwayat');
		return;
	}

	public function update_spl($data, $filter){
		$this->spl->where('ID_SPL', $filter);
		$this->spl->update('splseksi.tspl', $data);
		return;
	}

	public function show_rekap($dari, $sampai, $noind, $akses_sie){
		$x = 0;
		foreach($akses_sie as $as){
			if($x == 0){
				$akses = "tlb.kodesie like '$as%'";
			}else{
				$akses .= " or tlb.kodesie like '$as%'";
			}
			$x++;
		}

		$sql = "select tlb.tanggal, tlb.noind, tpr.nama, tlb.jam_msk, tlb.jam_klr, tlb.jml_lembur, jns.nama_lembur, tdp.total_lembur
			from presensi.tlembur tlb
			left join presensi.tdatapresensi tdp on tlb.noind=tdp.noind and tlb.tanggal=tdp.tanggal
			left join hrd_khs.tpribadi tpr on tlb.noind = tpr.noind
			left join presensi.tjenislembur jns on tlb.kd_lembur=jns.kd_lembur
			where tlb.noind like '$noind%' and tlb.tanggal between '$dari' and '$sampai' and ($akses)
			order by tlb.noind, tlb.tanggal";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_email_addres($sie){
		$user = $this->session->user; //untuk trial
		$sql = "select eea.employee_code, eea.employee_name, eea.internal_mail, sugm.user_group_menu_name
			from er.er_employee_all eea
			inner join sys.sys_user su on eea.employee_id=su.employee_id
			inner join sys.sys_user_application sua on su.user_id = sua.user_id
			inner join sys.sys_user_group_menu sugm on sua.user_group_menu_id = sugm.user_group_menu_id
			where eea.resign='0' and eea.section_code like '$sie%' and lower(sugm.user_group_menu_name) like '%lembur%kasie%' ";
				// and su.user_name='$user'"; //untuk trial
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_spl_byid($id){
		$sql = "select 	a.id_spl,
						a.tgl_lembur,
						a.jam_mulai_lembur,
						a.Jam_Akhir_Lembur,
						a.Kd_Lembur,
						a.Pekerjaan,
						a.Break,
						a.Istirahat,
						b.Noind,
						b.nama,
						d.kodesie,
						d.seksi,
						d.unit,
						d.dept,
						e.nama_lembur,
						a.alasan_lembur,
						a.target,
						a.realisasi
				from splseksi.tspl a
				inner join hrd_khs.tpribadi b
					ON a.noind = b.noind
				inner join splseksi.tjenislembur e
					ON a.kd_lembur = e.kd_lembur
				inner join hrd_khs.tseksi d
					ON b.kodesie = d.kodesie
				where a.ID_SPL in ($id)
				order by 	a.tgl_lembur,
							a.jam_mulai_lembur,
							a.Jam_Akhir_Lembur,
							a.Kd_Lembur,
							a.Pekerjaan,
							a.Break,
							a.Istirahat,
							b.nama
				";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function getSexEmployee($user){
		$sql = "select trim(sex) as sex from er.er_employee_all where employee_code = '$user'";
		return $this->db->query($sql)->row()->sex;
	}

	public function getJari($user){
		$sql = "select * from splseksi.tfinger_php tf
				inner join fp_distribusi.tb_jari tj
				on tj.id_finger = tf.kd_finger
				where tf.user_id = $user";
		return $this->spl->query($sql)->result_array();
	}

	public function getRekapSpl($user,$kd){
		$sql = "select left(status, 1) as status, sum(jumlah) as jumlah
				from (
					select Status as status,COUNT(Status) jumlah from splseksi.tspl ts
					inner join hrd_khs.tpribadi tp on ts.Noind = tp.Noind
					where left(tp.kodesie, $kd) = (select left(kodesie,$kd) from hrd_khs.tpribadi where noind = '$user')
					and EXTRACT(year from Tgl_lembur) = EXTRACT(year from now())
					and EXTRACT(month from Tgl_lembur) = EXTRACT(month from now())
					group by Status
				) as tbl
				group by left(status, 1) ;";
		return $this->spl->query($sql)->result_array();
	}

	public function show_spl2($kd,$user){
		$sql = "select a.*, b.nama, d.kodesie, d.seksi, d.unit, d.dept, e.nama_lembur, c.Deskripsi, (select nama from 	hrd_khs.tpribadi where noind = a.user_) as user_approve
				from splseksi.tspl a
				inner join hrd_khs.tpribadi b ON a.noind = b.noind
				inner join splseksi.tjenislembur e ON a.kd_lembur = e.kd_lembur
				inner join splseksi.tstatus_spl c ON a.status = c.id_status
				inner join hrd_khs.tseksi d ON b.kodesie = d.kodesie
				where left(b.kodesie, 7) = (select left(kodesie,7) from hrd_khs.tpribadi where noind = '$user')
				and EXTRACT(year from a.Tgl_lembur) = EXTRACT(year from now())
				and EXTRACT(month from a.Tgl_lembur) = EXTRACT(month from now())
				and a.Status like '$kd'";
		return $this->spl->query($sql)->result_array();
	}

	public function getTim($noind, $tanggal){
		$sql = "select tdt.point as point
				from \"Presensi\".tdatatim tdt
				where tdt.noind = '$noind'
				and tdt.tanggal = '$tanggal'
				and trim(tdt.kd_ket) = 'TM'";
		return $this->prs->query($sql)->result_array();
	}

	public function getPresensi($noind,$tanggal){
		$sql = "select 	tdp.noind,
						tdp.tanggal::date,
						cast(concat(tdp.tanggal::date,' ',tdp.masuk) as timestamp) as masuk,
						case when tdp.keluar::time < tdp.masuk::time then 
							cast(concat((tdp.tanggal::date + interval '1 day')::date,' ',tdp.keluar) as timestamp)
						else 
							cast(concat(tdp.tanggal::date,' ',tdp.keluar) as timestamp)
						end as keluar,
						tdp.kd_ket,
						cast(concat(tdp.tanggal::date,' ',tsp.jam_msk) as timestamp) as jam_msk,
						case when tsp.jam_plg::time < tsp.jam_msk::time then 
							cast(concat((tdp.tanggal::date + interval '1 day')::date,' ',tsp.jam_plg) as timestamp)
						else 
							cast(concat(tdp.tanggal::date,' ',tsp.jam_plg) as timestamp)
						end as jam_plg,
						case when tsp.ist_mulai::time < tsp.jam_msk::time then 
							cast(concat((tdp.tanggal::date + interval '1 day')::date,' ',tsp.ist_mulai) as timestamp)
						else 
							cast(concat(tdp.tanggal::date,' ',tsp.ist_mulai) as timestamp)
						end as ist_mulai ,
						case when tsp.ist_selesai::time < tsp.jam_msk::time then 
							cast(concat((tdp.tanggal::date + interval '1 day')::date,' ',tsp.ist_selesai) as timestamp)
						else 
							cast(concat(tdp.tanggal::date,' ',tsp.ist_selesai) as timestamp)
						end as ist_selesai
				from \"Presensi\".tdatapresensi tdp
				inner join \"Presensi\".tshiftpekerja tsp
				on tsp.tanggal = tdp.tanggal
				and tsp.noind = tdp.noind
				where tdp.noind = '$noind'
				and tdp.tanggal = '$tanggal'
				and trim(tdp.kd_ket) in ('PKJ','PID')";
		return $this->prs->query($sql)->result_array();
	}

	public function getPresensiPusat($noind,$tanggal){
		$sql = "select 	tsp.noind,
						tsp.tanggal::date,
						cast(concat(tsp.tanggal::date,' ',tsp.jam_msk) as timestamp) as jam_msk,
						case when tsp.jam_plg::time < tsp.jam_msk::time then 
							cast(concat((tsp.tanggal::date + interval '1 day')::date,' ',tsp.jam_plg) as timestamp)
						else 
							cast(concat(tsp.tanggal::date,' ',tsp.jam_plg) as timestamp)
						end as jam_plg,
						case when tsp.ist_mulai::time < tsp.jam_msk::time then 
							cast(concat((tsp.tanggal::date + interval '1 day')::date,' ',tsp.ist_mulai) as timestamp)
						else 
							cast(concat(tsp.tanggal::date,' ',tsp.ist_mulai) as timestamp)
						end as ist_mulai ,
						case when tsp.ist_selesai::time < tsp.jam_msk::time then 
							cast(concat((tsp.tanggal::date + interval '1 day')::date,' ',tsp.ist_selesai) as timestamp)
						else 
							cast(concat(tsp.tanggal::date,' ',tsp.ist_selesai) as timestamp)
						end as ist_selesai
				from \"Presensi\".tshiftpekerja tsp
				where tsp.noind = '$noind'
				and tsp.tanggal = '$tanggal'";
		return $this->prs->query($sql)->result_array();
	}

	public function getShiftpekerja($noind,$tanggal){
		$sql = "select * from \"Presensi\".tshiftpekerja where noind = '$noind' and tanggal = '$tanggal'";
		return $this->prs->query($sql)->num_rows();
	}

	public function getDataForMemo($noind,$tanggal){
		$sql = "select a.nama,a.noind,b.seksi,b.unit,
						'$tanggal' as tanggal,
						extract(dow from '$tanggal'::date) as hari,
						extract(day from '$tanggal'::date) as tgl,
						extract(month from '$tanggal'::date) as bln,
						extract(year from '$tanggal'::date) as thn,
						case when now()::date - '$tanggal'::date > 3 then
							1
						else
							0
						end as atasan
				from hrd_khs.tpribadi a
				inner join hrd_khs.tseksi b
				on a.kodesie = b.kodesie
				where a.noind = '$noind'";
		return $this->prs->query($sql)->result_array();
	}

	public function getAlasanMemo(){
		$sql = "select * from splseksi.talasan order by 1";
		return $this->spl->query($sql)->result_array();
	}

	public function show_pekerja2($key){
		$sql = "select noind,nama from hrd_khs.tpribadi where (nama like upper('%$key%') or noind like upper('%$key%')) and keluar = '0'";
		return $this->prs->query($sql)->result_array();
	}

	public function getShiftMemo($key,$tgl){
		$sql = "select distinct a.kd_shift,
				concat(trim(b.shift),' (',a.jam_msk,' - ',a.jam_plg,')') as shift
				from \"Presensi\".tjamshift a
				left join \"Presensi\".tshift b
				on a.kd_shift = b.kd_shift
				where a.numhari = extract(dow from '$tgl'::date)
				and (a.kd_shift like '%$key%' or b.shift like upper('%$key%') or a.jam_msk like '%$key%' or a.jam_plg like '%$key%')";
		return $this->prs->query($sql)->result_array();
	}

	public function insertMemo($data){
		$this->spl->insert('splseksi.tabsen_manual',$data);
		return $this->spl->insert_id();
	}

	public function show_memo($data){
		$this->spl->where('absen_manual_id',$data);
		return $this->spl->get('splseksi.tabsen_manual')->row();
	}

	public function insertAlasanMemo($data){
		$this->spl->insert('splseksi.talasan_absen_manual',$data);
		return $this->spl->insert_id();
	}

	public function show_AlasanMemo($data){
		$this->spl->where('absen_manual_id',$data);
		return $this->spl->get('splseksi.talasan_absen_manual')->result_array();
	}

	public function show_pekerjamemo($noind){
		$sql = "select a.noind, a.nama, a.kodesie, b.seksi, b.unit
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b
				on a.kodesie = b.kodesie
				where a.noind = '$noind'";
		return $this->prs->query($sql)->row();
	}

	public function show_shiftmemo($kd_shift,$tanggal){
		$sql = "select a.kd_shift,
				concat(trim(b.shift),' (',a.jam_msk,' - ',a.jam_plg,')') as shift
				from \"Presensi\".tjamshift a
				left join \"Presensi\".tshift b
				on a.kd_shift = b.kd_shift
				where a.kd_shift = '$kd_shift'
				and a.numhari = extract(dow from '$tanggal'::date) ";
		return $this->prs->query($sql)->row();
	}

	public function show_atasan($noind1,$noind2,$noind3){
		$sql = "select noind,
				case when length(concat(split_part(nama,' ',1),' ',split_part(nama,' ',2),' ',left(split_part(nama,' ',3),1))) > 17 then
									concat(split_part(nama,' ',1),' ',left(split_part(nama,' ',2),1),' ',left(split_part(nama,' ',3),1))
							else
								concat(split_part(nama,' ',1),' ',split_part(nama,' ',2),' ',left(split_part(nama,' ',3),1))
							end nama
				from hrd_khs.tpribadi
				where noind in ('$noind1', '$noind2','$noind3')";
		return $this->prs->query($sql)->result_array();
	}

	public function show_pekerja3($key,$key2,$akses_sie){
		$x = 0;
		$akses = "";
		if(!empty($akses_sie)){
			foreach($akses_sie as $as){
				if($x == 0){
					$akses = "kodesie like '$as%'";
				}else{
					$akses .= " or kodesie like '$as%'";
				}
				$x++;
			}

			$akses = "and ($akses)";
		}
		$sql = "select noind,nama from hrd_khs.tpribadi where (noind like upper('%$key%') or nama like upper('%$key%')) and noind not in ($key2) and keluar = '0' $akses";
		return $this->prs->query($sql)->result_array();
	}

	public function show_pekerja4($key,$key2){
		$kodesie = $this->session->kodesie;
		$sql = "select noind,nama from hrd_khs.tpribadi where (noind like upper('%$key%') or nama like upper('%$key%')) and noind not in ($key2) and keluar = '0' and lefT(kodesie,7) = left('$kodesie',7);";
		return $this->prs->query($sql)->result_array();
	}

	public function gettcodefingerprint(){
		$sql = "select * from splseksi.tcode_fingerprint";
		return $this->spl->query($sql)->result_array();
	}

	public function inserttcodefingerprint($data){
		$this->spl->insert('splseksi.tcode_fingerprint',$data);
	}

	public function updatetcodefingerprint($data,$id){
		$this->spl->where('ID_',$id);
		$this->spl->update('splseksi.tcode_fingerprint',$data);
	}

	public function deletetcodefingerprint($id){
		$this->spl->where('ID_',$id);
		$this->spl->delete('splseksi.tcode_fingerprint');
	}

	public function gettfingerphp(){
		$sql = "select 	a.user_name as noind,
						b.noind_baru,
						b.nama,
						count(a.user_name) as jumlah
				from splseksi.tfinger_php a
				left join hrd_khs.tpribadi b
				on a.user_name = b.Noind
				group by a.user_name,b.Nama
				order by user_id";
		return $this->spl->query($sql)->result_array();
	}

	public function getfingerdata($noind){
		$sql = "select *,
				(select concat(left(finger_data,30),'...')
				from splseksi.tfinger_php b
				where b.user_name = '$noind'
				and a.id_finger = b.kd_finger) as temp
				from fp_distribusi.tb_jari a ";
		return $this->spl->query($sql)->result_array();
	}

	public function getUserfinger($key){
		$sql = "select a.user_name as noind,
				b.employee_name as nama,
				b.new_employee_code as noind_baru
				from sys.sys_user a
				inner join er.er_employee_all b
				on a.user_name = b.employee_code
				where b.employee_code like '%$key%'
				or b.employee_name like '%$key%'
				or b.new_employee_code like '%$key%'
				and b.resign = '0'";
		return $this->db->query($sql)->result_array();
	}

	public function deleteFingertempAll($noind){
		$this->spl->where('user_name',$noind);
		$this->spl->delete('splseksi.tfinger_php');
	}

	public function deleteFingertemp($userid,$kd_finger){
		$this->spl->where('user_id',$userid);
		$this->spl->where('kd_finger',$kd_finger);
		$this->spl->delete('splseksi.tfinger_php');
	}

	public function getAcSnByVc($vc){
		$sql = "select Activation_Code as ac, SN as sn
				from splseksi.tcode_fingerprint
				where Verification_Code = '$vc'";
		return $this->spl->query($sql)->row();
	}

	public function getDeviceBySn($sn){
		$sql = "select Activation_Code as ac, VKEY as vkey
				from splseksi.tcode_fingerprint
				where SN = '$sn' ";
		return $this->spl->query($sql)->row();
	}

	public function getUseridByNoind($noind){
		$sql = "select a.user_id
				from sys.sys_user a
				inner join er.er_employee_all b
				on a.user_name = b.employee_code
				where b.employee_code = '$noind'";
		return $this->db->query($sql)->row()->user_id;
	}

	public function getNoindByUserid($userid){
		$sql = "select b.employee_code as noind
				from sys.sys_user a
				inner join er.er_employee_all b
				on a.user_name = b.employee_code
				where a.user_id = '$userid'";
		return $this->db->query($sql)->row()->noind;
	}

	public function insertFingerTemp($data){
		$this->spl->insert('splseksi.tfinger_php',$data);
	}

	public function getKeteranganJamLembur($noind){
		$sql = "SELECT kodesie FROM hrd_khs.tpribadi WHERE noind = '$noind' and keluar = '0'";
		$a = $this->prs->query($sql)->row()->kodesie;

		if($a == '401010102' || $a == '401010102'){
			return 'SATPAM';
		}

		return 'UMUM';
	}

	public function getJenisHari($tgl, $noind){
		$name_hari = date('D', strtotime($tgl));
		$tanggal = date('Y-m-d', strtotime($tgl));

		//cek minggu
		if($name_hari == 'Sun'){
			//cek shift
			$sql = "SELECT * FROM \"Presensi\".tshiftpekerja WHERE tanggal='$tanggal' and noind ='$noind'";
			$jenis = $this->prs->query($sql)->num_rows() > 0? 'Biasa' : 'Libur';
		}else{
			//cek hari libur
			$sql = "SELECT * FROM \"Dinas_Luar\".tlibur WHERE tanggal = '$tanggal'";
			$jenis =  $this->prs->query($sql)->num_rows() > 0? 'Libur' : 'Biasa';
		}

		return $jenis;
	}

	public function treffjamlembur($KET, $JENIS_HARI, $HARI){
		$sql = "SELECT * FROM presensi.treffjamlembur WHERE keterangan='$KET' AND jenis_hari='$JENIS_HARI' AND hari='$HARI' order by urutan asc";
		return $this->sql->query($sql)->result_array();
	}

	public function checkSPL($noind, $tanggal){
		$sql = "SELECT * FROM splseksi.tspl WHERE Tgl_Lembur ='$tanggal' AND noind='$noind'";
		return $this->spl->query($sql)->num_rows() > 0 ? true : false;
	}

	public function selectShift($noind, $tanggal){
		$tanggal = date('Y-m-d', strtotime($tanggal));
		$sql = "SELECT jam_msk, jam_plg FROM \"Presensi\".tshiftpekerja where noind='$noind' and tanggal='$tanggal'";
		return $this->prs->query($sql)->row();
	}
}