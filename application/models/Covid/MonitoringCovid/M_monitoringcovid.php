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
				order by a.status_kondisi_id ";
				// echo $sql;exit();
		return $this->erp->query($sql)->result_array();
	}

	function getPekerjaByStatus($status){
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
					a.isolasi_id
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
		$sql = "DELETE from \"Presensi\".tinput_edit_presensi where noind = '$noind' and kd_ket != 'PKJ'
				and tanggal1 >= '$awal' and tanggal1 <= '$akhir'";
		$this->personalia->query($sql);
		return $this->personalia->affected_rows();
	}

	function delSuratIs2($noind, $status, $awal, $akhir)
	{
		$sql = "DELETE from \"Presensi\".tdatapresensi where noind = '$noind' and kd_ket != 'PKJ'
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
		$wawancara = "<p>Wilayah : ".$paramnya['wilayah'].'<br>'.
		"Transportasi : ".$paramnya['transportasi'].'<br>'.
		"Yang ikut : ".$paramnya['anggota'].'<br>'.
		"Tujuan alasan : ".$paramnya['tujuan<br>alasan'].'<br>'.
		"Aktifitas : ".$paramnya['aktivitas'].'<br>'.
		"Protokol : ".$paramnya['prokes'].'<br>'.
		"Menginap : ".$paramnya['covid_menginap'].','.$paramnya['nbr_jumlah_hari'].'<br>'.
		"Yang dikunjungi sakit : ".$paramnya['covid_sakit'].','.$paramnya['penyakit'].'<br>'.
		"Sakit Setelah kembali : ".$paramnya['covid_sakit_kembali'].','.$paramnya['penyakit_kembali'].'<br>'.
		"Interaksi probable covid : ".$paramnya['covid_interaksi'].','.$paramnya['jenis_interaksi']."</p>";
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			tgl_interaksi,
			range_tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_interaksi]',
			'$paramnya[tgl_kejadian]',
			'DIRI SENDIRI KE LUAR KOTA',
			'$paramnya[keterangan]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");
		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				('$id_before',
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
				'1'
				)");

			if ($this->db->affected_rows() == 1) {
				return $id_before;
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
		$wawancara = "<p>Wilayah : ".$paramnya['wilayah'].'<br>'.
		"Transportasi : ".$paramnya['transportasi'].'<br>'.
		"Yang ikut : ".$paramnya['anggota'].'<br>'.
		"Tujuan alasan : ".$paramnya['tujuan<br>alasan'].'<br>'.
		"Aktifitas : ".$paramnya['aktivitas'].'<br>'.
		"Protokol : ".$paramnya['prokes'].'<br>'.
		"Menginap : ".$paramnya['covid_menginap'].','.$paramnya['nbr_jumlah_hari'].'<br>'.
		"Yang dikunjungi sakit : ".$paramnya['covid_sakit'].','.$paramnya['penyakit'].'<br>'.
		"Sakit Setelah kembali : ".$paramnya['covid_sakit_kembali'].','.$paramnya['penyakit_kembali'].'<br>'.
		"Interaksi probable covid : ".$paramnya['covid_interaksi'].','.$paramnya['jenis_interaksi']."</p>";
		$this->db->query("insert into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'ANGGOTA KELUARGA KE LUAR KOTA',
			'$statusnya_anggota',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				('$id_before',
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
				'1'
				)");

			if ($this->db->affected_rows() == 1) {
				return $id_before;
			}else {
				die('Gagal Insert :(');
			}
		}else {
			die('Gagal Insert :(');
		}
	}

	public function insertKedatanganTamu($paramnya, $yanglogin)
	{
		$wawancara = "<p>Wilayah : ".$paramnya['wilayah'].'<br>'.
		"Transportasi : ".$paramnya['transportasi'].'<br>'.
		"Jumlah tamu : ".$paramnya['jumlah_tamu'].'<br>'.
		"Tujuan alasan : ".$paramnya['tujuan_alasan'].'<br>'.
		"Aktifitas : ".$paramnya['aktivitas'].'<br>'.
		"Protokol : ".$paramnya['prokes'].'<br>'.
		"Menginap : ".$paramnya['covid_menginap'].','.$paramnya['nbr_jumlah_hari'].'<br>'.
		"Tamu yang datang sakit : ".$paramnya['covid_sakit'].','.$paramnya['penyakit'].'<br>'.
		"Interaksi probable covid : ".$paramnya['covid_interaksi'].','.$paramnya['jenis_interaksi']."</p>";

		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'KEDATANGAN TAMU DARI LUAR KOTA',
			'$paramnya[keterangan]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");
		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				('$id_before',
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
				'1'
				)");

			if ($this->db->affected_rows() == 1) {
				return $id_before;
			}else {
				die('Gagal Insert :(');
			}
		}else {
			die('Gagal Insert :(');
		}
	}

	public function insertMelaksanakanAcara($paramnya, $yanglogin)
	{
		$wawancara = "<p>Jenis acara : ".$paramnya['jenis_acara'].'<br>'.
		"Jumlah tamu : ".$paramnya['jumlah_tamu'].'<br>'.
		"Ada tamu luar : ".$paramnya['covid_tamu_luar'].','.$paramnya['asal_tamu'].'<br>'.
		"Waktu dan Run Down : ".$paramnya['waktu_run_down'].'<br>'.
		"Protokol : ".$paramnya['prokes'].'<br>'.
		"Lokasi acara : ".$paramnya['lokasi_acara'].'<br>'.
		"Kapasitas tempat : ".$paramnya['kapasitas_tempat']."</p>";
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'MELAKSANAKAN ACARA',
			'$paramnya[keterangan]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				($id_before,
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
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
		$hasilTest = '';
		if ($paramnya['antibody'] == '1') {
			$hasilTest .= "Tanggal mulai tes Antibody : ".$paramnya['tgl_tes_antibody'].', '.
			"Tanggal Keluar test Antibody : ".$paramnya['tgl_keluar_tes_antibody'].', '.
			"Hasil test Antibody : ".$paramnya['hasil_antibody'].'<br>';
		}
		if ($paramnya['antigen'] == '1') {
			$hasilTest .= "Tanggal mulai tes Antigen : ".$paramnya['tgl_tes_antigen'].', '.
			"Tanggal Keluar test Antigen : ".$paramnya['tgl_keluar_tes_antigen'].', '.
			"Hasil test Antigen : ".$paramnya['hasil_antigen'].'<br>';
		}
		if ($paramnya['pcr'] == '1') {
			$hasilTest .= "Tanggal mulai tes PCR/Swab : ".$paramnya['tgl_tes_pcr'].', '.
			"Tanggal Keluar test PCR/Swab : ".$paramnya['tgl_keluar_tes_pcr'].', '.
			"Hasil test PCR/Swab : ".$paramnya['hasil_pcr'].'<br>';
		}

		$anggotaK = '';
		if ($paramnya['jml_orangtua'] > 0) {
			$anggotaK .= "Jumlah Orang Tua : ".$paramnya['jml_orangtua'].', ';
		}
		if ($paramnya['jml_mertua'] > 0) {
			$anggotaK .= "Jumlah Mertua : ".$paramnya['jml_mertua'].', ';
		}
		if ($paramnya['jml_bojo'] > 0) {
			$anggotaK .= "Jumlah Istri/Suami : ".$paramnya['jml_bojo'].', ';
		}
		if ($paramnya['jml_anak'] > 0) {
			$anggotaK .= "Jumlah Anak : ".$paramnya['jml_anak'].', ';
		}
		if ($paramnya['jml_saudara_kandung'] > 0) {
			$anggotaK .= "Jumlah Saudara Kandung : ".$paramnya['jml_saudara_kandung'].', ';
		}
		if ($paramnya['jml_saudara_tidak_kandung'] > 0) {
			$anggotaK .= "Jumlah Saudara tidak Kandung : ".$paramnya['jml_saudara_tidak_kandung'].', ';
		}
		if ($paramnya['anggota_lainnya'] != '') {
			$anggotaK .= "Anggota keluarga Lainnya : ".$paramnya['anggota_lainnya'].'. ';
		}

		$laporPuskesmas = '';
		if ($paramnya['lapor_puskesmas'] == 'Sudah') {
			$laporPuskesmas .= "Arahan untuk Orang yang terduga/terkonfirmasi Covid 19 : ".$paramnya['arahan_terduga'].'<br>';
			$laporPuskesmas .= "Arahan untuk Orang yang tinggal serumah : ".$paramnya['arahan_serumah'].'<br>';
		}

		$wawancara = "<p>Kontak Dengan : ".$paramnya['yang_kontak'].'<br>'.
		"Hubungan : ".$paramnya['hubungan'].'<br>'.
		"Riwayat Orang Tersebut : ".$paramnya['riwayat'].'<br>'.
		"Gejala Awal : ".$paramnya['gejala'].'<br>'.
		"Tanggal mulai Gejala : ".$paramnya['tgl_gejala'].'<br>'.
		$hasilTest.
		$anggotaK.
		$laporPuskesmas.
		"Fasilitas : ".$paramnya['fasilitas'].'<br>'.
		"Dekontaminasi : ".$paramnya['dekontaminasi']."</p>";
		// echo $wawancara;exit();
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'Kontak dengan Probable/Konfirmasi Covid 19 dalam Satu Rumah',
			'$paramnya[keterangan]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				($id_before,
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
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
		$wawancara = "<p>Yang kontak : ".$paramnya['yang_kontak'].'<br>'.
		"Hubungan : ".$paramnya['hubungan'].'<br>'.
		"Jarak Rumah : ".$paramnya['jarak_rumah'].'<br>'.
		"Jenis Interaksi : ".$paramnya['jenis_interaksi'].'<br>'.
		"Intensitas : ".$paramnya['intensitas'].'<br>'.
		"Durasi : ".$paramnya['durasi'].'<br>'.
		"Protokol : ".$paramnya['protokol'].'<br>'.
		"Arahan : ".$paramnya['arahan']."</p>";
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'Kontak dengan Probable/Konfirmasi Covid 19 - Beda Rumah',
			'$paramnya[keterangan]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				($id_before,
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
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
		$wawancara = "<p>Yang kontak : ".$paramnya['yang_kontak'].'<br>'.
		"Hubungan : ".$paramnya['hubungan'].'<br>'.
		"Jenis Interaksi : ".$paramnya['jenis_interaksi'].'<br>'.
		"Intensitas : ".$paramnya['intensitas'].'<br>'.
		"Durasi : ".$paramnya['durasi'].'<br>'.
		"Protokol : ".$paramnya['protokol'].'<br>'.
		"Arahan : ".$paramnya['arahan']."</p>";
		$this->db->query("INSERT into cvd.cvd_pekerja
			(noind,
			status_kondisi_id,
			range_tgl_interaksi,
			tgl_interaksi,
			kasus,
			keterangan,
			created_date,
			created_by,
			updated_date,
			updated_by,
			pic_followup,
			status_approval)
			values
			(
			'$paramnya[no_induk]',
			'1',
			'$paramnya[tgl_kejadian]',
			'$paramnya[tgl_interaksi]',
			'Kontak dengan Probable/Konfirmasi Covid 19 - Beda Rumah',
			'$paramnya[keterangan]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[atasan]',
			1
			)");

		if ($this->db->affected_rows() == 1) {
			$id_before = $this->db->insert_id();
			$this->db->query("INSERT into cvd.cvd_wawancara
				(cvd_pekerja_id,
				hasil_wawancara,
				created_date,
				created_by,
				updated_date,
				updated_by,
				jenis
				)
				values
				($id_before,
				'$wawancara',
				current_timestamp,
				'$yanglogin',
				current_timestamp,
				'$yanglogin',
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
		$this->db->query("INSERT into cvd.cvd_wawancara_lampiran
			(wawancara_id,
			lampiran_nama,
			created_date,
			created_by,
			updated_date,
			updated_by,
			lampiran_path
			)
			values
			('$paramnya[wawancara_id]',
			'$paramnya[lampiran_nama]',
			current_timestamp,
			'$yanglogin',
			current_timestamp,
			'$yanglogin',
			'$paramnya[lampiran_path]')");

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
}