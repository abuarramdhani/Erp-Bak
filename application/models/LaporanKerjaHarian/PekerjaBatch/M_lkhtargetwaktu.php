<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_lkhtargetwaktu extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->erp = $this->load->database('erp_db', TRUE);
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getSessionKodeSie() {
		return ($this->session->kodesie) ? substr($this->session->kodesie, 0, 6) : '';
	}

	var $table = 'er.er_employee_all'; 
	var	$column_order = array('employee_code', 'employee_name', 'employee_code');
	var	$column_search = array('employee_name', 'employee_code');
	var $order = array('employee_code' => 'asc');

	public function getListQuery($pekerja) {
		if(empty($pekerja)) {
			$this->erp
					->from($this->table)
					->like('section_code', $this->getSessionKodeSie(), 'after')
					->where_in('worker_status_code', array('H', 'A', 'P', "K"))
					->where('resign', 0);
		} else {
			$this->erp
					->from($this->table)
					->like('section_code', $this->getSessionKodeSie(), 'after')
					->where_in('worker_status_code', array('H', 'A', 'P', "K"))
					->where_in('employee_code', $pekerja)
					->where('resign', 0);
		}
		$i = 0;
		if($_POST['search']['value']) {
			foreach($this->column_search as $item) {
				if($i === 0) {
					$this->erp->group_start();
					$this->erp->like($item, strtoupper($_POST['search']['value']));
				} else {
					$this->erp->or_like($item, strtoupper($_POST['search']['value']));
				}
				if(count($this->column_search) - 1 == $i) {
					$this->erp->group_end();
				}
				$i++;
			}
		}
		if(isset($_POST['order'])) {
			$this->erp->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->erp->order_by('employee_code');
		}
	}

	public function getList($pekerja) {
		$this->getListQuery($pekerja);
		if($_POST['length'] != -1) {
			if(empty($pekerja)) {
				$query = $this->erp
								->like('section_code', $this->getSessionKodeSie(), 'after')
								->where_in('worker_status_code', array('H', 'A', 'P', "K"))
								->where('resign', 0)
								->limit($_POST['length'], $_POST['start'])
								->get();
			} else {
				$query = $this->erp
								->like('section_code', $this->getSessionKodeSie(), 'after')
								->where_in('worker_status_code', array('H', 'A', 'P', "K"))
								->where_in('employee_code', $pekerja)
								->where('resign', 0)
								->limit($_POST['length'], $_POST['start'])
								->get();
			}
			return $query->result();
		}
	}

	public function getListCountFiltered($pekerja) {
		$this->getListQuery($pekerja);
		return $this->erp->get()->num_rows();
	}

	public function getListCountAll($pekerja) {
		if(empty($pekerja)) {
			return $this->erp
						->from($this->table)
						->like('section_code', $this->getSessionKodeSie(), 'after')
						->where_in('worker_status_code', array('H', 'A', 'P', "K"))
						->where('resign', 0)
						->get()
						->num_rows();
		} else {
			return $this->erp
						->from($this->table)
						->like('section_code', $this->getSessionKodeSie(), 'after')
						->where_in('worker_status_code', array('H', 'A', 'P', "K"))
						->where_in('employee_code', $pekerja)
						->where('resign', 0)
						->get()
						->num_rows();
		}
	}

	public function getRecordPekerjaan($periode, $pekerja) {
		if(isset($periode) && isset($pekerja)) {
			$query = "select concat('Jml Data ', count(noind), ' - ',
					array_to_string(
					array(
					select concat(count(noind), '@', case when aktual >= target or target = '0' then '100%' else concat(((aktual::float/target::float)*100)::int, '%') end) as nilai
					from lkh.lkh_target_waktu
					where noind = ltw.noind and extract(month from tgl_lkh) = '".$periode[0]."' and extract(year from tgl_lkh) = '".$periode[1]."'
					group by noind, case when aktual >= target or target = '0' then '100%' else concat(((aktual::float/target::float)*100)::int, '%') end
					order by case when aktual >= target or target = '0' then '100%' else concat(((aktual::float/target::float)*100)::int, '%') end
					), ', ')) as hasil
					from lkh.lkh_target_waktu ltw
					where extract(month from tgl_lkh) = '".$periode[0]."'
					and extract(year from tgl_lkh) = '".$periode[1]."'
					and noind = '".$pekerja."'
					group by noind;";
				$result = $this->erp->query($query)->row();
			return ($result) ? $result->hasil : 'Jml Data 0';
		}
		return 'Jml Data 0';
	}

	public function getRecordPekerjaanDetailLkh($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return ''; }
		$periode = explode('/', $periode);
		$query = "select concat(count(noind), ' Kegiatan - ',
				array_to_string(
				array(
				select concat(count(noind), '@', case when aktual >= target or target = '0' then '100%' else concat(((aktual::float/target::float)*100)::int, '%') end) as nilai
				from lkh.lkh_target_waktu
				where noind = ltw.noind and extract(month from tgl_lkh) = '".$periode[0]."' and extract(year from tgl_lkh) = '".$periode[1]."'
				group by noind, case when aktual >= target or target = '0' then '100%' else concat(((aktual::float/target::float)*100)::int, '%') end
				order by case when aktual >= target or target = '0' then '100%' else concat(((aktual::float/target::float)*100)::int, '%') end
				), ', ')) as hasil
				from lkh.lkh_target_waktu ltw
				where extract(month from tgl_lkh) = '".$periode[0]."'
				and extract(year from tgl_lkh) = '".$periode[1]."'
				and noind = '".$pekerja."'
				group by noind;";
		$result = $this->erp->query($query)->row();
		return ($result) ? $result->hasil : '';
	}

	public function getNilaiInsentifKondite($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return null; }
		$query = "select
					array_to_string(
						array(
							select concat(count(lgk.nilai), '@',lgk.nilai) as nilai
							from lkh.lkh_target_waktu as ltw_b
							inner join lkh.lkh_gol_kondite as lgk
							on ltw_b.gol_kondite between lgk.batas_bawah and lgk.batas_atas
							where ltw_b.noind = ltw.noind
							and extract(month from tgl_lkh) = '".$periode[0]."'
							and extract(year from tgl_lkh) = '".$periode[1]."'
							group by lgk.nilai
							order by lgk.nilai
						),
						', '
					) as hasil
				from lkh.lkh_target_waktu as ltw
				where extract(month from tgl_lkh) = '".$periode[0]."'
				and extract(year from tgl_lkh) = '".$periode[1]."'
				and noind = '".$pekerja."'
				group by noind";
		$result = $this->erp->query($query)->row();
		return ($result) ? $result->hasil : null;
	}

	public function getNilaiInsentifKonditeDetailLkh($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return ''; }
		$periode = explode('/', $periode);
		$query = "select
					array_to_string(
						array(
							select concat(count(lgk.nilai), '@',lgk.nilai) as nilai
							from lkh.lkh_target_waktu as ltw_b
							inner join lkh.lkh_gol_kondite as lgk
							on ltw_b.gol_kondite between lgk.batas_bawah and lgk.batas_atas
							where ltw_b.noind = ltw.noind
							and extract(month from tgl_lkh) = '".$periode[0]."'
							and extract(year from tgl_lkh) = '".$periode[1]."'
							group by lgk.nilai
							order by lgk.nilai
						),
						', '
					) as hasil
				from lkh.lkh_target_waktu as ltw
				where extract(month from tgl_lkh) = '".$periode[0]."'
				and extract(year from tgl_lkh) = '".$periode[1]."'
				and noind = '".$pekerja."'
				group by noind";
		$result = $this->erp->query($query)->row();
		return ($result) ? $result->hasil : '';
	}

	public function getApproval($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return null; }
		$data = $this->erp->where('periode', implode('/', $periode))->where('noind', $pekerja)->order_by('approval_id')->limit(1)->get('lkh.lkh_approval')->row();
		return (empty($data->status)) ? 'Draft' : $this->getApprovalStatusName($data->status);
	}

	public function getWarningSpDetailLkh($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return ''; }
		$periode = explode('/', $periode);
		return '';
	}

	public function getApprovalStatusName($type) {
		switch($type) {
			case 1:
				return 'Unapproved';
			case 2:
				return 'Approved';
			case 3:
				return 'Rejected';
			default:
				return 'Draft';
		}
	}

	public function getLkhData($lkhId) {
		$query = $this->erp->where('lkh_id', $lkhId)->limit(1)->get('lkh.lkh_target_waktu')->row();
		return ($query) ? $query : '';
	}

	public function getEmployeeName($employeeCode) {
		$query = $this->personalia->where('noind', $employeeCode)->limit(1)->get('hrd_khs.tpribadi')->row();
		return ($query) ? $query->nama : '';
	}

	public function getLkhDetailDataList($periode, $pekerja) {
		$periode = explode('/', $periode);
		$query = 'select
						lkh_id,
						tgl_lkh as "date",
						uraian_pekerjaan,
						status_target,
						target,
						aktual,
						concat((aktual / target * 100), \'%\') as "aktual_persen",
						kondite_mk,
						kondite_i,
						kondite_bk,
						kondite_tk,
						kondite_kp,
						kondite_ks,
						kondite_kk,
						kondite_pk,
						coalesce((select lgk.nilai
						from lkh.lkh_gol_kondite as lgk
						where ltw.gol_kondite between lgk.batas_bawah and lgk.batas_atas), \'-\')
						as gol_kondite
				from lkh.lkh_target_waktu as ltw
				where noind = \''.$pekerja.'\' and
				extract(month from tgl_lkh) = \''.$periode[0].'\' and
				extract(year from tgl_lkh) = \''.$periode[1].'\'
				order by tgl_lkh';
		$result = $this->erp->query($query)->result_array();
		return ($result) ? $result : '';
	}

	public function getDataLkhDetailCell($lkh_id, $column, $value) {
		if(empty($lkh_id) || empty($column)) { return false; }
		if(empty($value)) { $value = null; }
		switch($column) {
			case 'kondite_mk': case 'kondite_i': case 'kondite_bk': case 'kondite_tk': case 'kondite_kp': case 'kondite_ks': case 'kondite_kk': case 'kondite_pk':
				if($this->updateGolKonditeLkhDetailCell($lkh_id, $column, ($value) ? strtoupper($value) : null)) { return ($this->erp->where('lkh_id', $lkh_id)->update('lkh.lkh_target_waktu', array($column => $value)) === TRUE); }
				return false;
			default:
				return ($this->erp->where('lkh_id', $lkh_id)->update('lkh.lkh_target_waktu', array($column => $value)) === TRUE);
		}
	}

	public function updateGolKonditeLkhDetailCell($lkh_id, $column, $value) {
		if(empty($lkh_id) || empty($column)) { return false; }
		$query = 'update lkh.lkh_target_waktu as ltw
				set gol_kondite = gol_kondite - coalesce((select kondite.value_angka from lkh.lkh_nilai_'.$column.' as kondite where nilai = ltw.'.$column.'), 0) + coalesce((select kondite.value_angka from lkh.lkh_nilai_'.$column.' as kondite where nilai = \''.$value.'\'), 0)
				where lkh_id = \''.$lkh_id.'\'';
		return ($this->erp->query($query) === TRUE);
	}

	public function getGolKonditeLkhDetailCell($lkh_id) {
		if(empty($lkh_id)) return '';
		$query = 'select (select kondite.nilai from lkh.lkh_gol_kondite as kondite where ltw.gol_kondite between kondite.batas_bawah and kondite.batas_atas) as gol_kondite
					from lkh.lkh_target_waktu as ltw
					where lkh_id = \''.$lkh_id.'\'';
		$result = $this->erp->query($query)->row()->gol_kondite;
		return ($result) ? $result : '';
	}

	public function getShiftDateList($periode, $pekerja) {
		$periode = explode('/', $periode);
		$query = 'select date(tanggal) as "date", extract(day from tanggal) as "day", extract(month from tanggal) as "month", extract(year from tanggal) as "year"
				from "Presensi".tshiftpekerja
				where noind = \''.$pekerja.'\' and
				extract(month from tanggal) = \''.$periode[0].'\' and
				extract(year from tanggal) = \''.$periode[1].'\'
				order by tanggal';
		$result = $this->personalia->query($query)->result_array();
		if($result) { for($i = 0; $i < count($result); $i++) { $result[$i]['formatted_date'] = $this->getFormattedDate($result[$i]['day'], $result[$i]['month'], $result[$i]['year']); } }
		return ($result) ? $result : null;
	}

	public function getFormattedDate($days, $month, $year) {
		if(empty($days) || empty($month) || empty($year)) return '-';
		if(strlen((string) $days) < 2) { $days = '0'.$days; }
		$getMonthID = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		return (string) $days.' '.$getMonthID[$month - 1].' '.$year;
	}
}