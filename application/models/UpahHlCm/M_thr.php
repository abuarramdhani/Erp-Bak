<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_thr extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
	}

	function getPekerjaByLokasi($lokasi){
		$sql = "select noind,nama,lokasi_kerja,masukkerja::date as masuk
				from hrd_khs.tpribadi
				where keluar = '0'
				and left(noind,1) = 'R'
				and lokasi_kerja = ?
				order by lokasi_kerja,noind	";
		return $this->personalia->query($sql,array($lokasi))->result_array();
	}

	function getPekerja($lokasi){
		$sql = "select noind,nama,lokasi_kerja,masukkerja::date as masuk
				from hrd_khs.tpribadi
				where keluar = '0'
				and left(noind,1) = 'R'
				order by lokasi_kerja,noind	";
		return $this->personalia->query($sql,array($lokasi))->result_array();
	}

	function getAverageGPByNoindAwalAkhir($noind,$awal,$akhir){
		$sql = "select noind,avg(gp::numeric) as rata,sum(gp::numeric) as total, count(*) as jumlah	
				from hlcm.hlcm_proses hp 
				where hp.noind = ?
				and to_date(hp.periode,'YYYYMM') between to_date(?,'Month YYYY') and to_date(?,'Month YYYY')
				group by hp.noind";
		return $this->erp->query($sql,array($noind,$awal,$akhir))->result_array();
	}

	function insertTHRHistory($data){
		$this->erp->insert('hlcm.hlcm_thr_history',$data);
	}

	function insertTHR($data){
		$this->erp->insert('hlcm.hlcm_thr',$data);
		return $this->erp->insert_id();
	}
	
	function updateTHRByID($id,$data){
		$this->erp->where('id_thr',$id);
		$this->erp->update('hlcm.hlcm_thr',$data);
	}
	
	function getTHRByIdulFitriNoind($tanggal,$noind){
		$sql = "select *
			from hlcm.hlcm_thr
			where tgl_idul_fitri = ?
			and noind = ?";
		return $this->erp->query($sql,array($tanggal,$noind))->result_array();
	}

	function insertBulanTHRHistory($data){
		$this->erp->insert('hlcm.hlcm_thr_bulan_history',$data);
	}

	function insertBulanTHR($data){
		$this->erp->insert('hlcm.hlcm_thr_bulan',$data);
		return $this->erp->insert_id();
	}

	function updateBulanTHRByID($id,$data){
		$this->erp->where('id_bulan_thr',$id);
		$this->erp->update('hlcm.hlcm_thr_bulan',$data);
	}

	function getBulanTHRByIdulFitriNoind($tanggal,$noind){
		$sql = "select *
			from hlcm.hlcm_thr_bulan
			where tgl_idul_fitri = ?
			and noind = ?";
		return $this->erp->query($sql,array($tanggal,$noind))->result_array();
	}

	function getBulanTHRByTanggalLokasi($tanggal,$lokasi){
		$sql = "select t1.*,t2.nama as employee_name,t3.location_name,t4.pekerjaan,t2.lokasi_kerja
				from hlcm.hlcm_thr_bulan t1 
				inner join hlcm.hlcm_datapekerja t2 
				on t1.noind = t2.noind
				inner join er.er_location t3 
				on t2.lokasi_kerja = t3.location_code
				left join hlcm.hlcm_datagaji t4 
				on t2.kode_pekerjaan = t4.kode_pekerjaan
				and t2.lokasi_kerja = t4.lokasi_kerja
				where t1.tgl_idul_fitri = ?
				and t2.lokasi_kerja = ?
				order by t2.lokasi_kerja,t1.noind";
		return $this->erp->query($sql,array($tanggal,$lokasi))->result_array();
	}

	function getTHRByTanggalLokasi($tanggal,$lokasi){
		$sql = "select t1.*,t2.nama as employee_name,t3.location_name,t4.pekerjaan,t2.lokasi_kerja
				from hlcm.hlcm_thr t1 
				inner join hlcm.hlcm_datapekerja t2 
				on t1.noind = t2.noind
				inner join er.er_location t3 
				on t2.lokasi_kerja = t3.location_code
				left join hlcm.hlcm_datagaji t4 
				on t2.kode_pekerjaan = t4.kode_pekerjaan
				and t2.lokasi_kerja = t4.lokasi_kerja
				where t1.tgl_idul_fitri = ?
				and t2.lokasi_kerja = ?
				order by t2.lokasi_kerja,t1.noind";
		return $this->erp->query($sql,array($tanggal,$lokasi))->result_array();
	}

	function getBulanTHRByTanggal($tanggal){
		$sql = "select t1.*,t2.nama as employee_name,t3.location_name,t4.pekerjaan,t2.lokasi_kerja
				from hlcm.hlcm_thr_bulan t1 
				inner join hlcm.hlcm_datapekerja t2 
				on t1.noind = t2.noind
				inner join er.er_location t3 
				on t2.lokasi_kerja = t3.location_code
				left join hlcm.hlcm_datagaji t4 
				on t2.kode_pekerjaan = t4.kode_pekerjaan
				and t2.lokasi_kerja = t4.lokasi_kerja
				where t1.tgl_idul_fitri = ?
				order by t2.lokasi_kerja,t1.noind";
		return $this->erp->query($sql,array($tanggal))->result_array();
	}

	function getTHRByTanggal($tanggal){
		$sql = "select t1.*,t2.nama as employee_name,t3.location_name,t4.pekerjaan,t2.lokasi_kerja
				from hlcm.hlcm_thr t1 
				inner join hlcm.hlcm_datapekerja t2 
				on t1.noind = t2.noind
				inner join er.er_location t3 
				on t2.lokasi_kerja = t3.location_code
				left join hlcm.hlcm_datagaji t4 
				on t2.kode_pekerjaan = t4.kode_pekerjaan
				and t2.lokasi_kerja = t4.lokasi_kerja
				where t1.tgl_idul_fitri = ?
				order by t2.lokasi_kerja,t1.noind";
		return $this->erp->query($sql,array($tanggal))->result_array();
	}

	function getBulanTHRAll(){
		$sql = "select t1.tgl_idul_fitri,count(*) as jumlah,
					(
						select count(*)
						from hlcm.hlcm_thr_bulan t2
						inner join er.er_employee_all t3 
						on t2.noind = t3.employee_code
						where t1.tgl_idul_fitri = t2.tgl_idul_fitri
						and t3.location_code = '01'
					) as ygy,
					(
						select count(*)
						from hlcm.hlcm_thr_bulan t2
						inner join er.er_employee_all t3 
						on t2.noind = t3.employee_code
						where t1.tgl_idul_fitri = t2.tgl_idul_fitri
						and t3.location_code = '02'
					) as tks
				from hlcm.hlcm_thr_bulan t1 
				group by t1.tgl_idul_fitri";
		return $this->erp->query($sql)->result_array();
	}

	function getTHRAll(){
		$sql = "select t1.tgl_idul_fitri,count(*) as jumlah,
					(
						select count(*)
						from hlcm.hlcm_thr t2
						inner join er.er_employee_all t3 
						on t2.noind = t3.employee_code
						where t1.tgl_idul_fitri = t2.tgl_idul_fitri
						and t3.location_code = '01'
					) as ygy,
					(
						select count(*)
						from hlcm.hlcm_thr t2
						inner join er.er_employee_all t3 
						on t2.noind = t3.employee_code
						where t1.tgl_idul_fitri = t2.tgl_idul_fitri
						and t3.location_code = '02'
					) as tks
				from hlcm.hlcm_thr t1 
				group by t1.tgl_idul_fitri";
		return $this->erp->query($sql)->result_array();
	}

	function deleteBulanTHRByTanggalLokasi($tanggal,$lokasi){
		$sql = "delete from hlcm.hlcm_thr_bulan
				where tgl_idul_fitri = ?
				and noind in (
					select employee_code 
					from er.er_employee_all
					where location_code = ?
				)";
		$this->erp->query($sql,array($tanggal,$lokasi));
	}

	function deleteBulanTHRByTanggal($tanggal){
		$sql = "delete from hlcm.hlcm_thr_bulan
				where tgl_idul_fitri = ?";
		$this->erp->query($sql,array($tanggal));
	}

	function deleteBulanTHRByTanggalNoind($tanggal,$noind){
		$sql = "delete from hlcm.hlcm_thr_bulan
				where tgl_idul_fitri = ?
				and noind = ?";
		$this->erp->query($sql,array($tanggal,$noind));
	}

	function deleteTHRByTanggalLokasi($tanggal,$lokasi){
		$sql = "delete from hlcm.hlcm_thr
				where tgl_idul_fitri = ?
				and noind in (
					select employee_code 
					from er.er_employee_all
					where location_code = ?
				)";
		$this->erp->query($sql,array($tanggal,$lokasi));
	}

	function deleteTHRByTanggal($tanggal){
		$sql = "delete from hlcm.hlcm_thr
				where tgl_idul_fitri = ?";
		$this->erp->query($sql,array($tanggal));
	}

	function deleteBTHRByTanggalNoind($tanggal,$noind){
		$sql = "delete from hlcm.hlcm_thr
				where tgl_idul_fitri = ?
				and noind = ?";
		$this->erp->query($sql,array($tanggal,$noind));
	}

	function getPengembalianTHR(){
		$sql = "select t1.tgl_idul_fitri,t1.noind,t2.employee_name,t1.masa_kerja,t2.resign_date,t1.nominal_thr,t3.note,t3.tgl_kembali,t1.id_thr
				from hlcm.hlcm_thr t1 
				inner join er.er_employee_all t2 
				on t1.noind = t2.employee_code
				left join hlcm.hlcm_thr_pengembalian t3
				on t1.id_thr = t3.id_thr
				where t2.resign = '1'
				and t2.resign_date <= t1.tgl_idul_fitri ";
		return $this->erp->query($sql)->result_array();
	}

	function getPengembalianTHRByIdTHR($id){
		$sql = "select t1.tgl_idul_fitri,t1.noind,t2.employee_name,t1.masa_kerja,t2.resign_date,t1.nominal_thr,t3.note,t3.tgl_kembali,t1.id_thr
				from hlcm.hlcm_thr t1 
				inner join er.er_employee_all t2 
				on t1.noind = t2.employee_code
				left join hlcm.hlcm_thr_pengembalian t3
				on t1.id_thr = t3.id_thr
				where t1.id_thr = ? ";
		return $this->erp->query($sql,array($id))->result_array();
	}

	function insertPengembalianTHR($data){
		$this->erp->insert('hlcm.hlcm_thr_pengembalian',$data);
	}

	public function getPekerjaByKey($key){
		$sql = "select employee_code as noind,trim(employee_name) as nama
				from er.er_employee_all
				where (
					employee_code like upper(concat('%',?,'%'))
					or employee_name like upper(concat('%',?,'%'))
					)
				and resign = '0'";
		return $this->erp->query($sql,array($key,$key))->result_array();
	}

	public function getPekerjaJabatanByNoind($noind){
		$sql = "select noind,trim(nama) as nama,trim(jabatan) as jabatan
				from hrd_khs.tpribadi
				where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	public function getApproval($jenis){
		$sql = "select c.posisi,a.noind,trim(a.nama) as nama,a.jabatan,a.id_status,a.lokasi_kerja 
				from hlcm.hlcm_approval a 
				inner join hlcm.hlcm_document b 
				on a.document_id = b.id_document
				inner join hlcm.hlcm_posisi c 
				on a.id_status = c.id_status
				where b.nama_document = '$jenis'";
		return $this->erp->query($sql)->result_array();
	}
}

?>