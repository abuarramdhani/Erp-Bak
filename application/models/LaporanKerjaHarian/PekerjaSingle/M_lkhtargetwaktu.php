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

	var $table = 'lkh.vi_lkh_target_waktu_listdata'; 
	var	$column_order = array(3 => 'lower(pekerja)', 4 => 'lower(record_pekerjaan)', 5 => 'lower(record_kondite)', 6 => 'lower(status)');
	var	$column_search = array(3 => 'lower(pekerja)', 4 => 'lower(record_pekerjaan)', 5 => 'lower(record_kondite)', 6 => 'lower(status)');
	var $order = array('pekerja' => 'asc');

	public function getListQuery() {
		$this->erp->from($this->table);
		if($_POST['search']['value']) {
			$i = 0;
			foreach($this->column_search as $item) {
				if($i == 0) {
					$this->erp->group_start();
					$this->erp->like($item, strtolower($_POST['search']['value']));
				} else {
					$this->erp->or_like($item, strtolower($_POST['search']['value']));
				}
				if(count($this->column_search) - 1 == $i) { $this->erp->group_end(); }
				$i++;
			}
		}
		if(isset($_POST['order'])) {
			$this->erp->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->erp->order_by('pekerja');
		}
	}

	public function getList($periode, $type) {
		$this->getListQuery();
		if($_POST['length'] != -1) {
			if($type == 'listdata') {
                $query = $this->erp
                                ->where('resign', 0)
                                ->where('employee_code', $this->session->user)
                                ->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
                                ->limit($_POST['length'], $_POST['start'])
                                ->get();
			} else {
                $query = $this->erp
                                ->where('resign', 0)
                                ->where('employee_code', $this->session->user)
                                ->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
                                ->where('lower(status) = \''.$type.'\'')
                                ->limit($_POST['length'], $_POST['start'])
                                ->get();
			}
			return $query->result();
		}
	}

	public function getListCountFiltered($periode, $type) {
		$this->getListQuery();
		if($type == 'listdata') {
            return $this->erp
                            ->where('resign', 0)
                            ->where('employee_code', $this->session->user)
                            ->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
                            ->get()
                            ->num_rows();
		} else {
            return $this->erp
                            ->where('resign', 0)
                            ->where('employee_code', $this->session->user)
                            ->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
                            ->where('lower(status) = \''.$type.'\'')
                            ->get()
                            ->num_rows();
		}
	}

	public function getListCountAll($periode, $type) {
		if($type == 'listdata') {
            return $this->erp
                            ->from($this->table)
                            ->where('resign', 0)
                            ->where('employee_code', $this->session->user)
                            ->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
                            ->get()
                            ->num_rows();
		} else {
            return $this->erp
                            ->from($this->table)
                            ->where('resign', 0)
                            ->where('employee_code', $this->session->user)
                            ->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
                            ->where('lower(status) = \''.$type.'\'')
                            ->get()
                            ->num_rows();
		}
	}

	public function getLkhStatus($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return ''; }
		$periode = explode('/', $periode);
		return $this->erp->select('status')->where('employee_code', $pekerja)->where('periode', ($periode[1].'-'.$periode[0].'-01'))->get($this->table)->row()->status;
	}

	public function getRecordPekerjaanDetailLkh($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return ''; }
		$periode = explode('/', $periode);
		$result = $this->erp->select('record_pekerjaan')
							->where('employee_code', $pekerja)
							->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
							->get('lkh.vi_lkh_target_waktu_listdata')
							->row()
							->record_pekerjaan;
		return ($result) ? $result : '';
	}

	public function getNilaiInsentifKonditeDetailLkh($periode, $pekerja) {
		if(empty($periode) || empty($pekerja)) { return ''; }
		$periode = explode('/', $periode);
		$result = $this->erp->select('record_kondite')
							->where('employee_code', $pekerja)
							->where('extract(month from periode) = \''.$periode[0].'\' and extract(year from periode) = \''.$periode[1].'\'')
							->get('lkh.vi_lkh_target_waktu_listdata')
							->row()
							->record_kondite;
		return ($result) ? $result : '';
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
						extract(day from tgl_lkh) as "date_day",
						extract(month from tgl_lkh) as "date_month",
						extract(year from tgl_lkh) as "date_year",
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

	public function getEmployeeKdJabatan($employee_code) {
		$query = $this->personalia->select('cast(kd_jabatan as integer)')->where('noind', $employee_code)->get('hrd_khs.tpribadi')->row()->kd_jabatan;
		return ($query) ? $query : null;
	}

	public function getApprover($term, $approver1) {
		$filterKodesie = $this->getSessionKodeSie();
		for($i = 0; $i < 3; $i++) {
			if($term) {
				$result = $this->personalia->query("
					select trim(noind) as noind, trim(nama) as nama
					from hrd_khs.tpribadi
					where (noind ILIKE '%$term%' or nama ILIKE '%$term%')
					and keluar = false
					and kodesie like('".$filterKodesie."%')
					and kd_jabatan != '-'
					and cast(kd_jabatan as integer) < '".$this->getEmployeeKdJabatan((empty($approver1)) ? $this->session->user : $approver1)."'
				");
			} else {
				$result = $this->personalia->query("
					select trim(noind) as noind, trim(nama) as nama
					from hrd_khs.tpribadi
					where keluar = false
					and kodesie like('".$filterKodesie."%')
					and kd_jabatan != '-'
					and cast(kd_jabatan as integer) < '".$this->getEmployeeKdJabatan((empty($approver1)) ? $this->session->user : $approver1)."'
				");
			}
			if(!empty($result->result())) { break; }
			$filterKodesie = substr($filterKodesie, 0, (strlen($filterKodesie) - 2));
		}
		return $result->result();
	}

	public function kirimApproval($periode, $pekerja, $approver1, $approver2) {
		$result['success'] = false;
		if(empty($periode) || empty($pekerja) || empty($approver1) || empty($approver2)) {
			$result['message'] = 'Terjadi kesalahan saat mengirim data [empty_param]';
		} else {
			$periode = array_diff(explode(', ', $periode), array(''));
			$pekerja = array_diff(explode(', ', $pekerja), array(''));
			if(count($periode) == count($pekerja)) {
				$this->erp->trans_start();
				$values = "";
				for($i = 0; $i < count($pekerja); $i++) {
					$getPekerja = $pekerja[$i];
					$getPeriode = $periode[$i];
					$getExplodedPeriode = explode('-', $getPeriode);
					$this->erp->query("update lkh.lkh_target_waktu set \"lkh_status\" = '1' where noind = '".$getPekerja."' and extract(month from tgl_lkh) = '".$getExplodedPeriode[1]."' and extract(year from tgl_lkh) = '".$getExplodedPeriode[0]."'");
					if($i < (count($pekerja) - 1)) {
						$values .= "('".$getPekerja."', '".$getPeriode."', '".$approver1."', '1', '1'), ('".$getPekerja."', '".$getPeriode."', '".$approver2."', '2', '1'),";
					} else {
						$values .= "('".$getPekerja."', '".$getPeriode."', '".$approver1."', '1', '1'), ('".$getPekerja."', '".$getPeriode."', '".$approver2."', '2', '1')";
					}
				}
				$this->erp->query("insert into lkh.lkh_approval (noind, periode, approver, approver_level, approval_status) values ".$values);
				$this->erp->trans_complete();
				if ($this->erp->trans_status() === false) {
					$result['message'] = 'Terjadi kesalahan saat mengirim data';
				} else {
					$result['success'] = true;
					$result['message'] = 'Data approval berhasil dikirim';
				}
			} else {
				$result['message'] = 'Terjadi kesalahan saat mengirim data [arr_mismatch]';
			}
		}
		return $result;
	}

	public function deleteDataKegiatanBatch($periode, $pekerja) {
		$result['success'] = false;
		if(empty($periode) || empty($pekerja)) {
			$result['message'] = 'Terjadi kesalahan saat menghapus data [empty_param]';
		} else {
			$periode = array_diff(explode(', ', $periode), array(''));
			$pekerja = array_diff(explode(', ', $pekerja), array(''));
			if(count($periode) == count($pekerja)) {
				$this->erp->trans_start();
				$values = "";
				for($i = 0; $i < count($pekerja); $i++) {
					$getPekerja = $pekerja[$i];
					$getPeriode = explode('/', $periode[$i]);
					$this->erp->query('update lkh.lkh_target_waktu set "uraian_pekerjaan" = null where noind = \''.$getPekerja.'\' and extract(month from tgl_lkh) = \''.$getPeriode[0].'\' and extract(year from tgl_lkh) = \''.$getPeriode[1].'\'');
				}
				$this->erp->trans_complete();
				if ($this->erp->trans_status() === false) {
					$result['message'] = 'Terjadi kesalahan saat menghapus data';
				} else {
					$result['success'] = true;
					$result['message'] = 'Data kegiatan berhasil dihapus';
				}
			} else {
				$result['message'] = 'Terjadi kesalahan saat menghapus data [arr_mismatch]';
			}
		}
		return $result;
	}

	public function deleteDataKegiatan($periode, $pekerja) {
		$result['success'] = false;
		if(empty($periode) || empty($pekerja)) {
			$result['message'] = 'Terjadi kesalahan saat menghapus data [empty_param]';
		} else {
			$periode = explode('/', $periode);
			if($this->erp->where('extract(month from tgl_lkh) = \''.$periode[0].'\' and extract(year from tgl_lkh) = \''.$periode[1].'\' and noind = \''.$pekerja.'\'')->update('lkh.lkh_target_waktu', array('uraian_pekerjaan' => null))) {
				$result['success'] = true;
				$result['message'] = 'Data kegiatan berhasil dihapus';
			} else {
				$result['message'] = 'Terjadi kesalahan saat menghapus data';
			}
		}
		return $result;
	}
}