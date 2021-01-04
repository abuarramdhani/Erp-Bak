<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_monitoringcovid extends CI_Model {
	
	function __construct() {
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
		$this->erp = $this->load->database('erp_db', true);
	}

	function getPekerjaBykey($key){
		$sql = "select noind,trim(nama) as nama
				from hrd_khs.tpribadi
				where (
					noind like upper(concat('%',?,'%'))
					or nama like upper(concat('%',?,'%'))
				) 
				and keluar = '0';";
		return $this->personalia->query($sql,array($key,$key))->result_array();
	}

	function getpekerjaDetailByNoind($noind){
		$sql = "select trim(b.dept) as dept, trim(b.seksi) as seksi
				from hrd_khs.tpribadi a
				inner join hrd_khs.tseksi b 
				on a.kodesie = b.kodesie
				where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	function insertPekerja($data){
		$this->erp->insert('cvd.cvd_pekerja',$data);
		return $this->erp->insert_id();
	}

	function getStatusKondisi(){
		$sql = "select *,
					(
						select count(*)
						from cvd.cvd_pekerja b
						where a.status_kondisi_id = b.status_kondisi_id
					) as jumlah
				from cvd.cvd_status_kondisi a
				order by 1 ";
		return $this->erp->query($sql)->result_array();
	}

	function getPekerjaAll(){
		$sql = "select
					tes.jns,
					tes.hsl,
					a.cvd_pekerja_id,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept, 
					a.status_kondisi_id, 
					a.tgl_interaksi, 
					a.kasus, 
					a.keterangan, 
					a.mulai_isolasi, 
					a.selesai_isolasi,
					a.pic_followup,
					(select employee_name from er.er_employee_all eea where eea.employee_code = a.pic_followup) nama_pic,
					jml_hari as lama_isolasi,
					(
						select concat(employee_code,' - ',employee_name)
						from er.er_employee_all d
						where d.employee_code = a.created_by
					) as created_by,
					a.isolasi_id
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				left join (select cvd_pekerja_id, string_agg(jenis_tes,',') jns, string_agg(coalesce(hasil_tes::text, '0'),',') hsl from cvd.cvd_hasil_tes cht group by cht.cvd_pekerja_id) tes
				on a.cvd_pekerja_id = tes.cvd_pekerja_id
				order by a.status_kondisi_id ";
				// echo $sql;exit();
		return $this->erp->query($sql)->result_array();
	}

	function getPekerjaByStatus($status){
		$sql = "select a.cvd_pekerja_id,
					tes.jns,
					tes.hsl,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept, 
					a.status_kondisi_id, 
					a.tgl_interaksi, 
					a.kasus, 
					a.pic_followup,
					(select employee_name from er.er_employee_all eea where eea.employee_code = a.pic_followup) nama_pic,
					a.keterangan, 
					a.mulai_isolasi, 
					a.selesai_isolasi,
					jml_hari as lama_isolasi,
					(
						select concat(employee_code,' - ',employee_name)
						from er.er_employee_all d
						where d.employee_code = a.created_by
					) as created_by,
					a.isolasi_id
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				left join (select cvd_pekerja_id, string_agg(jenis_tes,',') jns, string_agg(coalesce(hasil_tes::text, '0'),',') hsl from cvd.cvd_hasil_tes cht group by cht.cvd_pekerja_id) tes on a.cvd_pekerja_id = tes.cvd_pekerja_id
				where a.status_kondisi_id = ?
				order by a.status_kondisi_id ";
		return $this->erp->query($sql,array($status))->result_array();
	}

	function deletePekerjaById($id){
		$this->erp->where('cvd_pekerja_id',$id);
		$this->erp->delete('cvd.cvd_pekerja');
	}

	function updateStatusPekerjaById($status,$id){
		$data = array(
			'status_kondisi_id' => $status
		);
		$this->erp->where('cvd_pekerja_id',$id);
		$this->erp->update('cvd.cvd_pekerja',$data);
	}

	function getWawancaraIsolasiByPekerjaId($id){
		$sql = "select *
				from cvd.cvd_wawancara a
				where cvd_pekerja_id = ?
				and jenis = 1";
				// echo $id;exit();
		return $this->erp->query($sql,array($id))->row();
	}

	function getWawancaraMasukByPekerjaId($id){
		$sql = "select *
				from cvd.cvd_wawancara a
				where cvd_pekerja_id = ?
				and jenis = 2";
		return $this->erp->query($sql,array($id))->row();
	}

	function getLampiranByPekerjaId($id){
		$sql = "select b.*
				from cvd.cvd_wawancara a 
				inner join cvd.cvd_wawancara_lampiran b 
				on a.wawancara_id = b.wawancara_id
				where a.cvd_pekerja_id = ?";
		return $this->erp->query($sql,array($id))->result_array();
	}

	function getLampiranByWawancaraId($id){
		$sql = "select *
				from cvd.cvd_wawancara_lampiran
				where wawancara_id = ?";
		return $this->erp->query($sql,array($id))->result_array();
	}

	function updateWawancaraById($data,$id){
		$this->erp->where('wawancara_id', $id);
		$this->erp->update('cvd.cvd_wawancara', $data);
	}

	function insertWawancara($data){
		$this->erp->insert('cvd.cvd_wawancara', $data);
		return $this->erp->insert_id();
	}

	function updateKeputusanByWawancaraId($data,$id){
		$this->erp->where('wawancara_id', $id);
		$this->erp->update('cvd.cvd_keputusan', $data);
	}

	function insertKeputusan($data){
		$this->erp->insert('cvd.cvd_keputusan',$data);
	}

	function insertLampiran($data){
		$this->erp->insert('cvd.cvd_wawancara_lampiran', $data);
	}

	function getPekerjaById($id){
		$sql = "select a.cvd_pekerja_id,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept, 
					a.status_kondisi_id, 
					a.tgl_interaksi, 
					a.kasus, 
					a.keterangan, 
					a.mulai_isolasi, 
					a.selesai_isolasi,
					a.keterangan,
					a.created_by,
					a.atasan,
					a.isolasi_id,
					a.pic_followup,
					a.range_tgl_interaksi
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				where cvd_pekerja_id::text = ?";
		return $this->erp->query($sql,array($id))->row();
	}

	function updatePekerjaById($data,$id){
		$this->erp->where('cvd_pekerja_id',$id);
		$this->erp->update('cvd.cvd_pekerja',$data);
	}

	function getKeputusanByWawancaraId($id){
		$sql = "select *
				from cvd.cvd_keputusan
				where wawancara_id = ?";
		return $this->erp->query($sql,array($id))->row();
	}

	function getMemoIsolasiMandiriByPekerjaid($id){
		$sql = "select isi_surat
			from \"Surat\".tsurat_isolasi_mandiri
			where id_isolasi_mandiri = ? ";
		return $this->personalia->query($sql, array($id))->row();
	}

	function getDetailcvdPekerja($id)
	{
		$this->db->where('cvd_pekerja_id', $id);
		return $this->db->get('cvd.cvd_pekerja')->row_array();
	}

	function getSuratIs($id)
	{
		$sql = "select *
			from \"Surat\".tsurat_isolasi_mandiri
			where id_isolasi_mandiri = ? ";
		return $this->personalia->query($sql, array($id))->row_array();
	}

	function getAbsenIs($noind, $status, $mulai, $selesai)
	{
		$sql = "select
					*
				from
					\"Presensi\".tinput_edit_presensi tep
				where
					noind = '$noind'
					and kd_ket = '$status'
					and tanggal1 >= '$mulai'
					and tanggal1 <= '$selesai'";
		return $this->personalia->query($sql)->result_array();
	}

	function delSuratIs($noind, $status, $awal, $akhir)
	{
		$sql = "DELETE from \"Presensi\".tinput_edit_presensi where noind = '$noind' and kd_ket in ('PRM','PSK')
				and tanggal1 >= '$awal' and tanggal1 <= '$akhir'";
		$this->personalia->query($sql);
		return $this->personalia->affected_rows();
	}

	function delSuratIs2($noind, $status, $awal, $akhir)
	{
		$sql = "DELETE from \"Presensi\".tdatapresensi where noind = '$noind' and kd_ket in ('PRM','PSK')
				and tanggal >= '$awal' and tanggal <= '$akhir'";
		$this->personalia->query($sql);
		return $this->personalia->affected_rows();
	}

	function delAttchcvd($id)
	{
		$this->db->where('lampiran_id', $id);
		$this->db->delete('cvd.cvd_wawancara_lampiran');
		return $this->db->affected_rows();
	}

	function delwktIs($isID)
	{
		$this->db->where('isolasi_id', $isID);
		$this->db->delete('cvd.cvd_waktu_isolasi');
	}

	public function insertDiriSendiri($paramnya, $yanglogin)
	{
		$sql = "INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			tgl_interaksi,
			range_tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_interaksi]',
			'$paramnya[tgl_kejadian]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)";
		$this->db->query($sql);
		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				('$id_before',
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");

			if ($this->db->affected_rows() == 1) {
				return $this->db->insert_id();
			}else {
				die('Gagal Insert :(');
			}
		}else {
			die('Gagal Insert :(');
		}

	}

	public function insertAnggotaKeluarga($paramnya, $yanglogin)
	{
		$statusnya_anggota = $paramnya['status_anggota']."<br>".$paramnya['keterangan'];
		
		$this->db->query("insert into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$statusnya_anggota',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				('$id_before',
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");

			if ($this->db->affected_rows() == 1) {
				return $this->db->insert_id();
			}else {
				die('Gagal Insert :(');
			}
		}else {
			die('Gagal Insert :(');
		}
	}

	public function insertKedatanganTamu($paramnya, $yanglogin)
	{
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)");
		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				('$id_before',
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");

			if ($this->db->affected_rows() == 1) {
				return $this->db->insert_id();
			}else {
				die('Gagal Insert :(');
			}
		}else {
			die('Gagal Insert :(');
		}
	}

	public function insertMelaksanakanAcara($paramnya, $yanglogin)
	{
		$sql = "INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)";
			// echo $sql;exit();
		$this->db->query($sql);

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				($id_before,
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");
			if ($this->db->affected_rows() == 1) {
				$id_before2 = $this->db->insert_id();
				return $this->db->insert_id();
			}else {
				return 0;
			}
		}else {
			return 0;
		}
	}

	public function insertmenghadiriAcara($paramnya, $yanglogin)
	{
		$sql = "INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)";
			// echo $sql;exit();
		$this->db->query($sql);

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				($id_before,
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");
			if ($this->db->affected_rows() == 1) {
				$id_before2 = $this->db->insert_id();
				return $id_before2;
			}else {
				return 0;
			}
		}else {
			return 0;
		}
	}

	public function kontakSatuRumah($paramnya, $yanglogin)
	{
		// echo $wawancara;exit();
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				($id_before,
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");
			if ($this->db->affected_rows() == 1) {
				$id_before2 = $this->db->insert_id();
				return $id_before2;
			}else {
				return 0;
			}
		}else {
			return 0;
		}
	}

	public function kontakBedaRumah($paramnya, $yanglogin)
	{
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				($id_before,
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");
			if ($this->db->affected_rows() == 1) {
				$id_before2 = $this->db->insert_id();
				return $id_before2;
			}else {
				return 0;
			}
		}else {
			return 0;
		}
	}

	public function kontakProblaby($paramnya, $yanglogin)
	{
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			updated_date,
			atasan,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'$paramnya[kasus]',
			'$paramnya[keterangan]',
			current_timestamp,
			current_timestamp,
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				updated_date,
				jenis
				)
				values
				($id_before,
				'$paramnya[wawancara]',
				current_timestamp,
				current_timestamp,
				'1'
				)");
			if ($this->db->affected_rows() == 1) {
				$id_before2 = $this->db->insert_id();
				return $id_before2;
			}else {
				return 0;
			}
		}else {
			return 0;
		}
	}

	public function insertLampiran21($paramnya, $yanglogin)
	{
		$sql = "INSERT into cvd.cvd_wawancara_lampiran
			(wawancara_id,
			lampiran_nama,
			created_date,
			updated_date,
			lampiran_path
			)
			values
			('$paramnya[wawancara_id]',
			'$paramnya[lampiran_nama]',
			current_timestamp,
			current_timestamp,
			'$paramnya[lampiran_path]')";
			// echo $sql;
		$this->db->query($sql);

		if ($this->db->affected_rows() == 1) {
			return 1;
		}else {
			return 0;
		}
	}

	public function getApprover($noind)
	{
		$sql = "SELECT
					distinct tp.noind,
					trim(tp.nama) nama,
					tp.email_internal,
					tp.kd_jabatan
				from
					hrd_khs.trefjabatan tj,
					hrd_khs.tpribadi tp,
					(
					select
						tp2.*
					from
						hrd_khs.tpribadi tp2
					where
						tp2.noind = '$noind' ) tpp
				where
					tj.noind = tp.noind
					and tp.keluar = '0'
					and substring(tp.kodesie, 1, 1) = substring(tpp.kodesie, 1, 1)
					and tp.kd_jabatan <= '11'
					and tj.noind <> tpp.noind
				order by
					tp.kd_jabatan desc,
					tp.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDetailPekerja($noind)
	{
		$this->personalia->where('noind', $noind);
		return $this->personalia->get('hrd_khs.tpribadi')->row_array();
	}

	public function getHasilTest($id)
	{
		$this->db->where('cvd_pekerja_id', $id);
		$this->db->order_by('tgl_tes', 'ASC');
		return $this->db->get('cvd.cvd_hasil_tes')->result_array();
	}

	public function addHasilTest($data)
	{
		$this->db->insert('cvd.cvd_hasil_tes', $data);
		return $this->db->affected_rows();
	}

	public function delHasilTest($id)
	{
		$this->db->where('id_hasil_tes', $id);
		$this->db->delete('cvd.cvd_hasil_tes');
		return $this->db->affected_rows();
	}

	public function updHasilTest($data, $id)
	{
		$this->db->where('id_hasil_tes', $id);
		$this->db->update('cvd.cvd_hasil_tes', $data);
		return $this->db->affected_rows();
	}

	public function monitoringlist()
	{
		$sql = "select
					cp.*, trim(eea.employee_name) nama 
				from
					cvd.cvd_pekerja cp
				left join er.er_employee_all eea on eea.employee_code = cp.noind
				where
					isolasi_id is not null
				order by created_date";
		return $this->db->query($sql)->result_array();
	}
	public function monitoringlist2($min, $max)
	{
		$sql = "select
					cp.*, trim(eea.employee_name) nama , csk.status_kondisi_id, csk.status_kondisi, csk.background_color, csk.text_color
				from
					cvd.cvd_pekerja cp
				left join er.er_employee_all eea on eea.employee_code = cp.noind
				left join cvd.cvd_status_kondisi csk on csk.status_kondisi_id = cp.status_kondisi_id
				where
					isolasi_id is not null
				and (cp.mulai_isolasi between '$min' and '$max' or cp.selesai_isolasi between '$min' and '$max')
				order by cp.created_date";
		return $this->db->query($sql)->result_array();
	}

	public function getDataPres($noind, $mulai, $selesai)
	{
		// $noind = 'H8891';
		$sql = "select
					tanggal,
					string_agg(kd_ket, '/') kd_ket,
					string_agg(alasan, '/') alasan
				from
					\"Presensi\".tdatapresensi t
				where
					noind = '$noind'
					and tanggal between '$mulai' and '$selesai'
				group by
					tanggal
				order by
					tanggal";
					// echo $sql;exit();
		return $this->personalia->query($sql)->result_array();
	}
	
	public function getMulaiInteraksi($id)
	{
		$sql = "select
					range_tgl_interaksi,
					tgl_interaksi,
					kasus,
					cw.hasil_wawancara
				from
					cvd.cvd_pekerja cp
				left join cvd.cvd_wawancara cw on
					cw.cvd_pekerja_id = cp.cvd_pekerja_id
				where
					kasus like '%Kontak dengan Probable/Konfirmasi Covid 19%'
					and cp.cvd_pekerja_id = $id";
		return $this->db->query($sql)->row_array();			
	}

	public function getTotalIsolasiWFO($lokasi_kerja, $tgl = null)
	{
		if ($tgl == null) {
			$tgl = date('Y-m-d');
		}
		$sql = "select
					*
				from
					\"Presensi\".tdatapresensi t
					left join hrd_khs.tpribadi t2 on t2.noind = t.noind 
				where
					alasan like '%WFO%'
					and kd_ket = 'PRM'
					and tanggal = '$tgl'
					and t2.lokasi_kerja = '$lokasi_kerja'";
		return $this->personalia->query($sql)->result_array();;
	}

	public function getTotalIsolasiWFH($lokasi_kerja, $tgl = null)
	{
		if ($tgl == null) {
			$tgl = date('Y-m-d');
		}
		$sql = "select
					*
				from
					\"Presensi\".tdatapresensi t
					left join hrd_khs.tpribadi t2 on t2.noind = t.noind 
				where
					alasan not like '%WFO%'
					and kd_ket = 'PRM'
					and tanggal = '$tgl'
					and t2.lokasi_kerja = '$lokasi_kerja'";
					// echo $sql;exit();
		return $this->personalia->query($sql)->result_array();;
	}

	public function pekerjaAkanSelesaiIS($tgl = null)
	{
		if ($tgl == null) {
			$tgl = date('Y-m-d');
		}
		$sql = "select
					*
				from
					cvd.cvd_pekerja cp
					left join er.er_employee_all es on es.employee_code = cp.noind
				where
					selesai_isolasi > '$tgl'
					and selesai_isolasi <= '$tgl'::date + interval '2 days'";
		return $this->db->query($sql)->result_array();
	}

	public function getLiburKhs($min, $max)
	{
		$sql = "select
					distinct(substring(tanggal::text,0,11)) tanggal
				from
					\"Dinas_Luar\".tlibur t
				where
					tanggal >= '$min'
					and tanggal <= '$max'";
		return $this->personalia->query($sql)->result_array();
	}
}