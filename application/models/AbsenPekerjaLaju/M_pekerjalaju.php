<?php 
Defined('BASEPATH') or exit('No Direct Sekrip Access Allowed');

class M_pekerjalaju extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getPekerjaLajuAll(){
		$sql = "select *, (select trim(employee_name) from er.er_employee_all where employee_code = al.user_input) as nama_user from at.at_laju al";
		return $this->db->query($sql)->result_array();
	}

	public function insertPekerjaLaju($data){
		$this->db->insert('at.at_laju',$data);
		return $this->db->last_query();
	}

	public function getPekerjaByKey($key){
		$sql = "select employee_code as noind, trim(employee_name) as nama
				from er.er_employee_all 
				where (
					employee_code like upper(concat('%',?,'%'))
					or employee_name like upper(concat('%',?,'%'))
					)
				and resign = '0'";
		return $this->db->query($sql,array($key,$key))->result_array();
	}

	public function getPekerjaDetailByNoind($noind){
		$sql = "select trim(nama) as nama,
					trim(alamat) as alamat,
					trim(desa) as desa,
					trim(kec) as kecamatan,
					trim(kab) as kabupaten,
					trim(prop) as provinsi
				from hrd_khs.tpribadi
				where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	public function getjenisTransportasi(){
		$sql = "select jenis_transportasi,id_transportasi
				from at.at_jenis_transportasi";
		return $this->db->query($sql)->result_array();
	}

	public function deletePekerjaLajubyID($id){
		$this->db->where('laju_id',$id);
		$this->db->delete('at.at_laju');
		return $this->db->last_query();
	}

	public function getPekerjaLajuByID($id){
		$sql = "select *
				from at.at_laju
				where laju_id = ?";
		return $this->db->query($sql,array($id))->row();
	}

	public function updatePekerjaLaju($data,$id){
		$this->db->where('laju_id',$id);
		$this->db->update('at.at_laju',$data);
		return $this->db->last_query();
	}

	public function getAbsenBarcodeDatang($noind,$waktu){
		$sql = "select concat(tanggal::date,' ',waktu)::timestamp as waktu_barcode
				from \"Presensi\".tprs_shift
				where noind = ?
				and trim(waktu) not in ('__:__:__','0')
				and concat(tanggal::date,' ',waktu)::timestamp > ?
				order by tanggal asc 
				limit 1";
		return $this->personalia->query($sql,array($noind,$waktu))->row();
	}

	public function getAbsenBarcodePulang($noind,$waktu){
		$sql = "select concat(tanggal::date,' ',waktu)::timestamp as waktu_barcode
				from \"Presensi\".tprs_shift
				where noind = ?
				and trim(waktu) not in ('__:__:__','0')
				and concat(tanggal::date,' ',waktu)::timestamp < ?
				order by tanggal desc 
				limit 1";
		return $this->personalia->query($sql,array($noind,$waktu))->row();
	}

	public function getLokasikerjaByNoind($noind){
		$sql = "select lokasi_kerja
				from hrd_khs.tpribadi
				where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	public function getKoordinatByLokasiKerja($koordinat){
		$sql = "select * 
				from at.at_coordinat_lokasi_kerja 
				where lokasi_kerja = ?";
		return $this->db->query($sql,array($koordinat))->row();
	}

	public function insertLog($data_log){
		$this->db->insert('sys.sys_log_activity',$data_log);
	}

	public function getKoordinatRumahByNoind($noind){
		$sql = "select *
				from at.at_laju
				where noind = ?";
		return $this->db->query($sql,array($noind))->row();
	}

	/*
		SELECT at_absen_approval.approver, at_absen.*,at_jenis_absen.* 
		FROM at.at_absen_approval
		left join at.at_absen
		on at_absen_approval.absen_id = at_absen.absen_id 
		left join at.at_jenis_absen 
		on at_absen.jenis_absen_id = at_jenis_absen.jenis_absen_id
		WHERE at_absen.noind in (select noind from at.at_laju) 
		ORDER BY at_absen.waktu desc
	*/

	var $table = 'at.at_absen_approval';
	var	$column_order = array('tsurat_isolasi_mandiri.created_timestamp','tsurat_isolasi_mandiri.created_timestamp','tsurat_isolasi_mandiri.no_surat',2,'tsurat_isolasi_mandiri.tgl_wawancara','tsurat_isolasi_mandiri.tgl_cetak');
	var	$column_search = array('tpribadi.noind','tpribadi.nama','tsurat_isolasi_mandiri.no_surat');
	var $order = array('at_absen.waktu' => 'desc');
	var $select = "	at_absen_approval.approver, 
					at_absen.*,
					at_jenis_absen.* ";
	var $where = "at_absen.noind in (select noind from at.at_laju)";

	public function user_table_query(){

		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('at.at_absen','at_absen_approval.absen_id = at_absen.absen_id','left');
		$this->db->join('at.at_jenis_absen','at_absen.jenis_absen_id = at_jenis_absen.jenis_absen_id','left');
		$this->db->where($this->where);
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i===0) {
					$this->db->group_start();
					$this->db->like($item,strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item,strtoupper($_POST['search']['value']));
				}
				if (count($this->column_search)-1 == $i) {
					$this->db->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		}elseif (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

    public function user_table(){
		$this->user_table_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'],$_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	}

	public function count_filtered(){
		$this->user_table_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all(){
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('at.at_absen','at_absen_approval.absen_id = at_absen.absen_id','left');
		$this->db->join('at.at_jenis_absen','at_absen.jenis_absen_id = at_jenis_absen.jenis_absen_id','left');
		$this->db->where($this->where);
		$query = $this->db->get();
		return $query->num_rows();
	}

}

?>